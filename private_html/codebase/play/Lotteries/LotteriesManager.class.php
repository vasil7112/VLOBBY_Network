<?php
namespace vlobby\play\Lotteries;
class LotteriesManager {
    public static $defaultSettings = [
                                        'description' => 'By paying <strong>@price</strong> coins you are entering a competition to win extra coins. The winner will be randomly picked when the lottery reaches <strong>@max_entries</strong> entries. The winner will recieve the <strong>Potential reward</strong>.'
                                     ];
    public static $LOTTERY = [
                                1 => [
                                        'title' => 'Aluminium',
                                        //'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 10,
                                        'max_entries' => 25
                                     ],
                                2 => [
                                        'title' => 'Bronze',
                                        'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 15,
                                        'max_entries' => 25
                                     ],
                                3 => [
                                        'title' => 'Copper',
                                        'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 20,
                                        'max_entries' => 25
                                     ],
                                4 => [
                                        'title' => 'Silver',
                                        'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 30,
                                        'max_entries' => 25
                                     ],
                                5 => [
                                        'title' => 'Gold',
                                        'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 40,
                                        'max_entries' => 25
                                     ],
                                6 => [
                                        'title' => 'Jackpot',
                                        'description' => 'This is an example <strong>desc</strong> about Lotteries.',
                                        'price' => 5,
                                        'max_entries' => 250
                                     ]
                             ];
    public static function getLottery($ID){
        $HTML = '';
        $PDO = \vlobby\Database\Connect::getInstance();
        $STMT = $PDO->prepare('SELECT id,
                                      status,
                                      type
                               FROM `lotteries`
                               WHERE type = :ID 
                               ORDER BY id DESC
                               LIMIT 1');
        $STMT->bindParam(':ID', $ID, \PDO::PARAM_INT);
        $STMT->execute();
        $result = $STMT->fetch();
        $rowCount = $STMT->rowCount();
        
        if($rowCount != 1){
            return '<h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'/lotteries/">Lotteries</a> > Not Found</h2>
                    <div class="row padding-top-10">
                        <h3 class="text-center font-PoiretOne nomargin">This lottery does not exist.</h3>
                    </div>';
        }
        
        $STMT2 = $PDO->prepare('SELECT entries.`avatar`,
                                       entries.`personaname`,
                                      `lotteries_entries`.`steamID`,
                                      `lotteries_entries`.`winner`
                               FROM `lotteries_entries`
                               LEFT JOIN `steamInfo` entries 
                                 ON `lotteries_entries`.`steamID` = entries.`steamID`
                               WHERE lottery_id = :ID');
        $STMT2->bindParam(':ID', $result['id'], \PDO::PARAM_INT);
        $STMT2->execute();
        $entriesHTML = '';
        $hasJoined = 0;
        $mySteamID = $_SESSION['STEAM_steamid'];
        while($entry = $STMT2->fetch()){
            if($entry['steamID'] == $mySteamID){ $hasJoined++; }
            $entriesHTML .= '<img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($entry['avatar']).'" width="100" height="100"/>';
        }
        $lottery = self::$LOTTERY[$result['type']];
        $HTML .= '<h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'/lotteries/">Lotteries</a> > '.$lottery['title'].' Lottery</h2>
                    <div class="row padding-top-30">
                        <div class="col-xs-12 font-PoiretOne">
                            <div class="vlobby-jumbotron jumbotron">
                                <h3 class="nomargin padding-top-20 nomargin">Buy '.$lottery['title'].' Ticket</h3>
                                <h4 class="nomargin padding-top-20">Price to enter: '.$lottery['price'].' Coins</h4>
                                <h4 class="nomargin padding-top-20">Potential reward: '.($lottery['price'] * ($lottery['max_entries'] - 1)).' Coins</h4>'.
                                (!empty($lottery['description']) ? '<h4 class="nomargin padding-top-20">'.$lottery['description'].'</h4>' : '<h4 class="nomargin padding-top-20">'.preg_replace('/@(\w+)/e', '$lottery["$1"]', self::$defaultSettings['description']).'</h4>');
                                if($hasJoined != 0){
                                    $HTML .= '<form role="form" method="post"><input name="action" type="hidden" value="joinLottery"><input name="lottery_id" type="hidden" value="'.$result['type'].'"><button type="submit" class="btn btn-vlobby pull-right margin-right-20 margin-bottom-20" onclick="this.innerHTML = \'Please wait...\';">You have '.$hasJoined.' '.$lottery['title'].' Tickets</button></form>';}else{
                                    $HTML .= '<form role="form" method="post"><input name="action" type="hidden" value="joinLottery"><input name="lottery_id" type="hidden" value="'.$result['type'].'"><button type="submit" class="btn btn-vlobby pull-right margin-right-20 margin-bottom-20" onclick="this.innerHTML = \'Please wait...\';">Buy '.$lottery['title'].' Ticket</button></form>';}
        $HTML .='               <div class="clear-both"></div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 font-PoiretOne padding-top-30">
                            <div class="vlobby-jumbotron jumbotron">
                                <h3 class="nomargin">Who else is here?</h3>'.
                                (!empty($entriesHTML) ? $entriesHTML : '<center><h3>Noone has yet entered this Lottery. Go ahead :) Become the NO.1 entry!</h3></center>').
                            '</div>
                        </div>
                    </div>';
        return $HTML;
    }
        
    public static function enterLottery($LOTTERYTYPE){
        $LOTTERYTYPES = array('1', '2', '3', '4', '5', '6');
        if(in_array($LOTTERYTYPE, $LOTTERYTYPES)){
            $PDO = \vlobby\Database\Connect::getInstance();
            $PDO->beginTransaction();
            $STMT = $PDO->prepare('SELECT id, type
                                   FROM `lotteries`
                                   WHERE type = :TYPE
                                   ORDER BY id DESC
                                   LIMIT 1');
            $STMT->bindParam(':TYPE', $LOTTERYTYPE, \PDO::PARAM_INT);
            $STMT->execute();
            $result = $STMT->fetch();
            
            $STMT2 = $PDO->prepare('SELECT count(*)
                                    FROM `lotteries_entries`
                                    WHERE lottery_id = :ID');
            $STMT2->bindParam(':ID', $result['id'], \PDO::PARAM_INT);
            $STMT2->execute();
            $result2 = $STMT2->fetch(\PDO::FETCH_NUM);

            if($result2[0] == (self::$LOTTERY[$result['type']]['max_entries'] - 1)){
                $STMT3 = $PDO->prepare('INSERT INTO `lotteries_entries` (steamID, lottery_id) VALUES (:STEAMID, :ID);
                                        UPDATE `lotteries_entries` SET `winner` = 1 WHERE (`lottery_id` = :ID) ORDER BY RAND() LIMIT 1;
                                        UPDATE `lotteries` SET `status` = 1 WHERE `id` = :ID;
                                        INSERT INTO `lotteries` (type) VALUES (:TYPE);');
                $STMT3->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_INT);
                $STMT3->bindParam(':ID', $result['id'], \PDO::PARAM_INT);
                $STMT3->bindParam(':TYPE', $result['type'], \PDO::PARAM_INT);
                $STMT3->execute();
                $STMT3->closeCursor();
            }else{
                $STMT3 = $PDO->prepare('INSERT INTO `lotteries_entries` (steamID, lottery_id) VALUES (:STEAMID, :ID);');
                $STMT3->bindParam(':STEAMID', $_SESSION['STEAM_steamid'], \PDO::PARAM_INT);
                $STMT3->bindParam(':ID', $result['id'], \PDO::PARAM_INT);
                $STMT3->execute();
            }
            $PDO->commit();
        }
    }
}