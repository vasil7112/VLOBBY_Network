<?php
/*(*
require_once('../../../private_html/config.php');
$PDO = \vlobby\Database\Connect::getInstance();
$STMT = $PDO->prepare('UPDATE `lotteries`
                       SET `lotteries`.`status` = 1
                       WHERE `lotteries`.`status` = 0');
$STMT->execute();
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
if(!empty($idArray)){
    $selectWinner = '';
    foreach($idArray as $id){
        $selectWinner .= 'UPDATE `sweepstakes_entries`
                          SET `winner` = 1
                          WHERE `sweepstakes_id` = '.$id.'
                          ORDER BY RAND()
                          LIMIT 1;';
    }
    $STMT2 = $PDO->prepare('UPDATE `sweepstakes`
                            SET `sweepstakes`.`status` = 1
                            WHERE `id` IN ('.implode(',',$idArray).');'.$selectWinner);
    $STMT2->execute();
}
$PDO->commit();**/
?>