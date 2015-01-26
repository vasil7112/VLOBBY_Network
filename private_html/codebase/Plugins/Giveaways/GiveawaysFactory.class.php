<?php
namespace vlobby\Plugins\Giveaways;
class GiveawaysFactory {
    public static function __callStatic($name, $arguments){
        //if(!\vlobby\WEB_PLAY_ENABLED || )
    }
    
    public static function createGiveaway($title, $description, $end_date, $max_entries, $visibility, $delivery, $itemArray){
        $title = htmlspecialchars($title, ENT_QUOTES);
        if(strlen($title) < 5 || strlen($title) > 30){
            return false;
        }
        $description = htmlspecialchars($description, ENT_QUOTES);
        if(strlen($description) > 100){
            return false;
        }
        $max_entries = (int) $max_entries;
        if($max_entries < 0){ $max_entries = 0; }
        $visibility = (int) $visibility;
        if($visibility > 2 || $visibility < 0) { $visibility = 0; }
        $delivery = (int) $delivery;
        if($delivery > 1 || $delivery < 0) { $delivery = 0; }
        
        $end_date = (int) $end_date;
        if($end_date<0 || $end_date>9){ $end_date = 2; }
        switch ($end_date) {
            case 0:
                $end_date = (60*15);
                break;
            case 1:
                $end_date = (60*30);
                break;
            case 2:
                $end_date = (60*60);
                break;
            case 3:
                $end_date = (60*60*2);
                break;
            case 4:
                $end_date = (60*60*4);
                break;
            case 5:
                $end_date = (60*60*8);
                break;
            case 6:
                $end_date = (60*60*16);
                break;
            case 7:
                $end_date = (60*60*24);
                break;
            case 8:
                $end_date = (60*60*24*2);
                break;
            case 9:
                $end_date = (60*60*24*3);
                break;
            default:
                $end_date = (60*60);
                break;
        }
        //$end_date = date('Y-m-d H:i:s', $end_date);
        
        $itemArray = json_decode($itemArray, true);
        if($itemArray == null || empty($itemArray)){
            return false;
        }
        
        $allAppIDs = ['440', '570', '620', '730', '753-1', '753-3', '753-6', '238460', '218620', '221540'];
        $appIDs = [];
        $inventory = [];
        $itemGiveawayed = [];
        foreach($itemArray as $_ITEM){
            if(in_array($_ITEM['appID'], $allAppIDs) && !in_array($_ITEM['appID'], $appIDs)){
                if($_ITEM['appID'] == '753-1'){
                    $inventory[$_ITEM['appID']] = \vlobby\Steam\BackpackManager::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 1);
                }else if($_ITEM['appID'] == '753-3'){
                    $inventory[$_ITEM['appID']] = \vlobby\Steam\BackpackManager::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 3);
                }else if($_ITEM['appID'] == '753-6'){
                    $inventory[$_ITEM['appID']] = \vlobby\Steam\BackpackManager::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 6);
                }else{
                    $inventory[$_ITEM['appID']] = \vlobby\Steam\BackpackManager::getBackpackJSON($_SESSION['STEAM_steamid'], $_ITEM['appID']);
                }
                array_push($appIDs, $_ITEM['appID']);
            }
            $item = strval($_ITEM['itemID']);
            $appid = $_ITEM['appID'];
            if(array_key_exists($item, $inventory[$appid]['rgInventory'])){
                $iDesc = $inventory[$appid]['rgInventory'][$item]['classid'].'_'.$inventory[$appid]['rgInventory'][$item]['instanceid'];
                $itemDesc = $inventory[$appid]['rgDescriptions'][$iDesc];
                $market_hash_name = (isset($itemDesc['market_hash_name']) && ((int) $appid != 753) ? $itemDesc['market_hash_name'] : $itemDesc['name']);
                array_push($itemGiveawayed, '(\''.htmlEntities($market_hash_name, ENT_QUOTES).'\', \'http://steamcommunity-a.akamaihd.net/economy/image/'.htmlEntities($itemDesc['icon_url'], ENT_QUOTES).'/96fx96f\', :GIVEAWAYID)');
            }
        }
        
        if(empty($inventory) || empty($itemGiveawayed)){return;}
        $an = "0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ";
        $su = strlen($an) - 1;
        $hash = substr($an, rand(0, $su), 1) . substr($an, rand(0, $su), 1) . substr($an, rand(0, $su), 1) . substr($an, rand(0, $su), 1) . substr($an, rand(0, $su), 1) . substr($an, rand(0, $su), 1);
        $PDO = \vlobby\Database\Connect::getInstance();
        $PDO->beginTransaction();
        $STMT = $PDO->prepare('INSERT INTO giveaways (hash, created_by, end_date, title, description, max_entries, visibility, delivery) 
                                    VALUES (:HASH, :STEAMID, FROM_UNIXTIME(UNIX_TIMESTAMP(CURRENT_TIMESTAMP())+ :END_DATE), :TITLE, :DESCRIPTION, :MAX_ENTRIES, :VISIBILITY, :DELIVERY);
                               UPDATE `user_stats` SET `giveaways_created` = `giveaways_created` + 1 WHERE steam_id = :STEAMID;');
        $STMT->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_INT);
        $STMT->bindParam(':END_DATE', $end_date, \PDO::PARAM_INT);
        $STMT->bindParam(':TITLE', $title, \PDO::PARAM_INT);
        $STMT->bindParam(':DESCRIPTION', $description, \PDO::PARAM_INT);
        $STMT->bindParam(':HASH', $hash, \PDO::PARAM_STR);
        $STMT->bindParam(':MAX_ENTRIES', $max_entries, \PDO::PARAM_INT);
        $STMT->bindParam(':VISIBILITY', $visibility, \PDO::PARAM_INT);
        $STMT->bindParam(':DELIVERY', $delivery, \PDO::PARAM_INT);
        $STMT->execute();
        $id = $PDO->lastInsertId();
        $STMT->closeCursor();
        
        $finalItems = implode(', ', $itemGiveawayed);
        $STMT2 = $PDO->prepare('INSERT INTO giveaways_items (item_name, item_image, giveaway_id)
                                VALUES
                                    '.$finalItems.';');
        $STMT2->bindParam(':GIVEAWAYID', $id, \PDO::PARAM_INT);
        $STMT2->execute();
        $STMT2->closeCursor();
        $PDO->commit();
        \vlobby\Notifications\NotificationFactory::addNotification($_SESSION['STEAM_steamid'], 'You have made a new giveaway. <a href="'.\vlobby\THIS_DOMAIN.'/giveaway/'.$id.'/'.$hash.'">Visit Giveaway</a>');
        header('Location: '.\vlobby\THIS_DOMAIN.'/giveaway/'.$id.'/'.$hash);
    }
    
    public static function joinGiveaway($GIVEAWAYID){
        $GIVEAWAYID = htmlspecialchars($GIVEAWAYID, ENT_QUOTES);
        $PDO = \vlobby\Database\Connect::getInstance();
        $PDO->beginTransaction();
        
        $STMT = $PDO->prepare('SELECT `created_by` FROM `giveaways` WHERE (id = :GIVEAWAYID AND `status` = 0 AND `end_date` > FROM_UNIXTIME('.\vlobby\Generic\TimeManager::mysqlTime().') AND `max_entries` > `entries`)');
        $STMT->bindParam(':GIVEAWAYID', $GIVEAWAYID, \PDO::PARAM_INT);
        $STMT->execute();
        $result = $STMT->fetch();
        $rowCount = $STMT->rowCount();
        
        if($rowCount == 1){
            if($result['created_by'] == $_SESSION['STEAM_steamid']){
                return false;
            }
            $STMT2 = $PDO->prepare('INSERT INTO `giveaways_entries` (steam_id, giveaway_id)
                                    SELECT * FROM (SELECT :STEAMID, :GIVEAWAYID) AS tmp
                                    WHERE NOT EXISTS (
                                        SELECT `steam_id` FROM `giveaways_entries` WHERE (`steam_id` = :STEAMID AND `giveaway_id` = :GIVEAWAYID)
                                    ) LIMIT 1;
                                    UPDATE `giveaways` SET `entries` = `entries`+1
                                    WHERE (id = :GIVEAWAYID);');
            $STMT2->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_STR);
            $STMT2->bindParam(':GIVEAWAYID', $GIVEAWAYID, \PDO::PARAM_INT);
            $STMT2->execute();
            $STMT2->closeCursor();
        }
        $PDO->commit();
    }
    
    public static function deleteGiveaway($GIVEAWAYID){
        if($_SESSION['group'] == \vlobby\Authentication\SteamAuth::GROUP_ADMIN){
            $GIVEAWAYID = htmlspecialchars($GIVEAWAYID, ENT_QUOTES);
            
            $PDO = \vlobby\Database\Connect::getInstance();
            $PDO->beginTransaction();
        
            $STMT = $PDO->prepare('SELECT null FROM `giveaways` WHERE id = :GIVEAWAYID');
            $STMT->bindParam(':GIVEAWAYID', $GIVEAWAYID, \PDO::PARAM_INT);
            $STMT->execute();
            $rowCount = $STMT->rowCount();
        
            if($rowCount == 1){
                $STMT2 = $PDO->prepare('UPDATE `giveaways`
                                        SET `status` = 2
                                        WHERE `id` = :GIVEAWAYID');
                $STMT2->bindParam(':GIVEAWAYID', $GIVEAWAYID, \PDO::PARAM_INT);
                $STMT2->execute();
            }
            $PDO->commit();
        }
    }
    
    public static function getUserGiveaways($STEAMID){
        $HTML = '';
        $PDO = \vlobby\Database\Connect::getInstance();
        $PDO->beginTransaction();
        $STMT = $PDO->prepare('SELECT `id`, `title`, `end_date`, `status` FROM `giveaways` WHERE `created_by` = :STEAMID ORDER BY `id` DESC LIMIT 50;');
        $STMT->bindParam(':STEAMID', $STEAMID, \PDO::PARAM_INT);
        $STMT->execute();
        
        while($giveaway = $STMT->fetch()){
            $HTML .= '<tr '.($giveaway['status']==0?/**'style="background-color:#fff;"'**/'':'').'>
                        <td>'.$giveaway['id'].'</td>
                        <td>'.$giveaway['title'].'</td>
                        <td>'. (\vlobby\Generic\TimeManager::endsAt(strtotime($giveaway['end_date'])) == 'Finished' ? \vlobby\Generic\TimeManager::ago(strtotime($giveaway['end_date'])) : \vlobby\Generic\TimeManager::endsAt(strtotime($giveaway['end_date']))).'</td>
                        <td><a href="'.\vlobby\THIS_DOMAIN.'/giveaways/'.$giveaway['id'].'">Visit Giveaways</a></td>
                      </tr>';
        }
        
        if(empty($HTML)){
            return 'SS';
        }else{
            return '<table class="table">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Giveaway Title</th>
                                <th>End in</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            '.$HTML.'
                       </tbody>
                    </table>';
        }
        $PDO->commit();
    }
}