<?php
require_once('../../../config.php');
$PDO = \vlobby\Database\Connect::getInstance();
$PDO->beginTransaction();
$STMT = $PDO->prepare('SELECT `id`, `hash`
                       FROM `giveaways`
                       WHERE (`giveaways`.`status` = 0 AND `giveaways`.`end_date` <= CURRENT_TIMESTAMP())');
$STMT->execute();
$idArray = array();
$idArrays = array();
while($result = $STMT->fetch()){
    array_push($idArray, array('id'=>$result['id'], 'hash'=>$result['hash']));
    array_push($idArrays, $result['id']);
}
$STMT->closeCursor();
if(!empty($idArray)){
    $selectWinner = '';
    $sendNotification = '';
    foreach($idArray as $id){
        $selectWinner .= 'UPDATE `giveaways_entries`
                          SET `winner` = 1
                          WHERE `giveaways_id` = '.$id['id'].'
                          ORDER BY RAND()
                          LIMIT 1;';
        $sendNotification .= 'INSERT INTO notifications (steamID, notification, color)
                              SELECT `steam_id`, \'You are a winner of a giveaway! <a href="http://vlobbys.net:8082/giveaway/'.$id['id'].'/'.$id['hash'].'/">Visit Giveaway</a>\', \'005A08\'
                              FROM `giveaways_entries`
                              WHERE (`giveaway_id` = '.$id['id'].' AND `winner` = 1);
                                  
                              INSERT INTO notifications (steamID, notification, color)
                              SELECT `created_by`, \'Your giveaway has finished! <a href="http://vlobbys.net:8082/giveaway/'.$id['id'].'/'.$id['hash'].'/">Visit Giveaway</a>\', \'B5AC26\'
                              FROM `giveaways`
                              WHERE (`id` = '.$id['id'].');';
    }
    $STMT2 = $PDO->prepare('UPDATE `giveaways`
                            SET `giveaways`.`status` = 1
                            WHERE `id` IN ('.implode(',',$idArrays).');'.$selectWinner);
    $STMT2->execute();
    $STMT2->closeCursor();
    $STMT3 = $PDO->prepare($sendNotification);
    $STMT3->execute();
    $STMT3->closeCursor();
}
$PDO->commit();
?>