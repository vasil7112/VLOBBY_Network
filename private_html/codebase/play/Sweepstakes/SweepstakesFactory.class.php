<?php
namespace vlobby\play\Sweepstakes;
class SweepstakesFactory {
    public static function __callStatic($name, $arguments){
        //if(!\vlobby\WEB_PLAY_ENABLED || )
    }
    
    public static function createSweepstake($title, $description, $end_date, $itemArray){
        if(!is_numeric($end_date)){
            return false;
        }else{
            $end_date = (int) $end_date;
            if($end_date<0 || $end_date>9){ $end_date = 2; }
            switch ($end_date) {
                case 0:
                    $end_date = time()+(60*15);
                    break;
                case 1:
                    $end_date = time()+(60*30);
                    break;
                case 2:
                    $end_date = time()+(60*60);
                    break;
                case 3:
                    $end_date = time()+(60*60*2);
                    break;
                case 4:
                    $end_date = time()+(60*60*4);
                    break;
                case 5:
                    $end_date = time()+(60*60*8);
                    break;
                case 6:
                    $end_date = time()+(60*60*16);
                    break;
                case 7:
                    $end_date = time()+(60*60*24);
                    break;
                case 8:
                    $end_date = time()+(60*60*24*2);
                    break;
                case 9:
                    $end_date = time()+(60*60*24*3);
                    break;
                default:
                    $end_date = time()+(60*60);
                    break;
            }
        }
        $end_date = date('Y-m-d H:i:s', $end_date);
        $title = htmlspecialchars($title, ENT_QUOTES);
        if(strlen($title) < 5 || strlen($title) > 30){
            return false;
        }
        $description = htmlspecialchars($description, ENT_QUOTES);
        if(strlen($description) > 100){
            return false;
        }
        $itemArray = json_decode($itemArray);
        if($itemArray == null){
            return false;
        }
        $appIDs = array('730', '440', '753-1', '753-3', '753-6');
        $inventory = array(730 => \vlobby\Generic\SteamFunctions::getBackpackJSON($_SESSION['STEAM_steamid'], 730),
                           440 => \vlobby\Generic\SteamFunctions::getBackpackJSON($_SESSION['STEAM_steamid'], 440),
                           '753-1' => \vlobby\Generic\SteamFunctions::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 1),
                           '753-3' => \vlobby\Generic\SteamFunctions::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 3),
                           '753-6' => \vlobby\Generic\SteamFunctions::getBackpackJSON($_SESSION['STEAM_steamid'], 753, 6));
        $finalItems = array();
        $PDO = \vlobby\Database\Connect::getInstance();
        $PDO->beginTransaction();
        $STMT = $PDO->prepare('INSERT INTO sweepstakes (steamID, end_date, title, description) 
                                    VALUES (:STEAMID, :END_DATE, :TITLE, :DESCRIPTION);');
        $STMT->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_INT);
        $STMT->bindParam(':END_DATE', $end_date, \PDO::PARAM_INT);
        $STMT->bindParam(':TITLE', $title, \PDO::PARAM_INT);
        $STMT->bindParam(':DESCRIPTION', $description, \PDO::PARAM_INT);
        $STMT->execute();
        $id = $PDO->lastInsertId();
        foreach($itemArray as $itemHash){
            if(strpos($itemHash, '_') !== false){
                $itemHash = explode('_', $itemHash, 2);
                if(in_array($itemHash[0], $appIDs)){
                    (int) $item = $itemHash[1];
                    (int) $appid = $itemHash[0];
                    if(array_key_exists($item, $inventory[$appid]['rgInventory'])){
                        $description = $inventory[$appid]['rgInventory'][$item]['classid'].'_'.$inventory[$appid]['rgInventory'][$item]['instanceid'];
                        $itemDesc = $inventory[$appid]['rgDescriptions'][$description];
                        $market_hash_name = ($itemHash[0] == '753-1' || $itemHash[0] == '753-3' || $itemHash[0] == '753-6' ? $itemDesc['name'] : $itemDesc['market_hash_name']);
                        array_push($finalItems, '(\''.htmlEntities($market_hash_name, ENT_QUOTES).'\', \'http://steamcommunity-a.akamaihd.net/economy/image/'.htmlEntities($itemDesc['icon_url'], ENT_QUOTES).'/96fx96f\', '.$id.')');
                    }
                }
            }
        }
        $finalItems = implode(', ', $finalItems);
        $STMT2 = $PDO->prepare('INSERT INTO sweepstakes_items (item_name, item_image, sweepstakes_id)
                                VALUES
                                    '.$finalItems.';');
        $STMT2->execute();
        $PDO->commit();
        \vlobby\Notifications\NotificationFactory::addNotification($_SESSION['STEAM_steamid'], 'You have made a new sweepstake. <a href="'.\vlobby\THIS_DOMAIN('PLAY').'/sweepstake/'.$id.'">Visit Sweepstake</a>');
        header('Location: '.\vlobby\THIS_DOMAIN('PLAY').'/sweepstake/'.$id);
    }
    
    public static function joinSweepstake($SWEEPSTAKEID){
        $SWEEPSTAKEID = htmlspecialchars($SWEEPSTAKEID, ENT_QUOTES);
        $PDO = \vlobby\Database\Connect::getInstance();
        $PDO->beginTransaction();
        
        $STMT = $PDO->prepare('SELECT steamID FROM `sweepstakes` WHERE (id = :SWEEPSTAKEID AND status = 0 AND end_date > FROM_UNIXTIME('.\vlobby\Generic\TimeManager::mysqlTime().'))');
        $STMT->bindParam(':SWEEPSTAKEID', $SWEEPSTAKEID, \PDO::PARAM_INT);
        $STMT->execute();
        $result = $STMT->fetch();
        $rowCount = $STMT->rowCount();
        
        if($rowCount == 1){
            if($result['steamID'] == $_SESSION['STEAM_steamid']){
                return false;
            }
            $STMT2 = $PDO->prepare('INSERT INTO `sweepstakes_entries` (steamID, sweepstakes_id)
                                    SELECT * FROM (SELECT :STEAMID, :SWEEPSTAKEID) AS tmp
                                    WHERE NOT EXISTS (
                                        SELECT `steamID` FROM `sweepstakes_entries` WHERE (`steamID` = :STEAMID AND `sweepstakes_id` = :SWEEPSTAKEID)
                                    ) LIMIT 1;');
            $STMT2->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_STR);
            $STMT2->bindParam(':SWEEPSTAKEID', $SWEEPSTAKEID, \PDO::PARAM_INT);
            $STMT2->execute();
        }
        $PDO->commit();
    }
    
    public static function deleteSweepstake($SWEEPSTAKEID){
        if($_SESSION['group'] == \vlobby\Authentication\SteamAuth::GROUP_ADMIN){
            $SWEEPSTAKEID = htmlspecialchars($SWEEPSTAKEID, ENT_QUOTES);
            
            $PDO = \vlobby\Database\Connect::getInstance();
            $PDO->beginTransaction();
        
            $STMT = $PDO->prepare('SELECT null FROM `sweepstakes` WHERE id = :SWEEPSTAKEID');
            $STMT->bindParam(':SWEEPSTAKEID', $SWEEPSTAKEID, \PDO::PARAM_INT);
            $STMT->execute();
            $rowCount = $STMT->rowCount();
        
            if($rowCount == 1){
                $STMT2 = $PDO->prepare('UPDATE `sweepstakes`
                                        SET `status` = 2
                                        WHERE `id` = :SWEEPSTAKEID');
                $STMT2->bindParam(':SWEEPSTAKEID', $SWEEPSTAKEID, \PDO::PARAM_INT);
                $STMT2->execute();
            }
            $PDO->commit();
        }
    }
}