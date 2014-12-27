<?php
require_once('../../../config.php');
$PDO = \vlobby\Database\Connect::getInstance();
$PDO->beginTransaction();
$STMT = $PDO->prepare('SELECT `id`
                       FROM `sweepstakes`
                       WHERE (`sweepstakes`.`status` = 0 AND `sweepstakes`.`end_date` <= FROM_UNIXTIME('.\vlobby\Generic\TimeManager::mysqlTime().'))');
$STMT->execute();
$idArray = array();
while($result = $STMT->fetch()){
    array_push($idArray, $result['id']);
}
$STMT->closeCursor();
if(!empty($idArray)){
    $selectWinner = '';
    $sendNotification = '';
    foreach($idArray as $id){
        $selectWinner .= 'UPDATE `sweepstakes_entries`
                          SET `winner` = 1
                          WHERE `sweepstakes_id` = '.$id.'
                          ORDER BY RAND()
                          LIMIT 1;';
        $sendNotification .= 'INSERT INTO notifications (steamID, notification, color)
                              SELECT `steamID`, \'You are a winner of a sweepstake! <a href="http://play.vlobby.net/sweepstake/'.$id.'">Visit Sweepstake</a>\', \'005A08\'
                              FROM `sweepstakes_entries`
                              WHERE (`sweepstakes_id` = '.$id.' AND `winner` = 1);';
    }
    $STMT2 = $PDO->prepare('UPDATE `sweepstakes`
                            SET `sweepstakes`.`status` = 1
                            WHERE `id` IN ('.implode(',',$idArray).');'.$selectWinner);
    $STMT2->execute();
    $STMT2->closeCursor();
    
    $STMT3 = $PDO->prepare($sendNotification);
    $STMT3->execute();
    $STMT3->closeCursor();
}
$PDO->commit();
?>