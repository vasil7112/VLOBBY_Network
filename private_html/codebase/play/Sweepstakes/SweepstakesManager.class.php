<?php
namespace vlobby\play\Sweepstakes;
class SweepstakesManager {
    public static $SWEEPSTAKES = array();
    public function __construct($SWEEPSTAKEID = NULL) {
        if(empty(self::$SWEEPSTAKES)){
            $PDO = \vlobby\Database\Connect::getInstance();
            $query = ($SWEEPSTAKEID == NULL ? '`sweepstakes`.`status` = 0 AND `sweepstakes`.`end_date` > FROM_UNIXTIME('.\vlobby\Generic\TimeManager::mysqlTime().')' : '`sweepstakes`.`id` = :SWEEPSTAKEID');
            $STMT = $PDO->prepare('SELECT `steamInfo`.`personaname`, 
                                          `steamInfo`.`avatar`, 
                                          `sweepstakes`.`steamID`,
                                          `sweepstakes`.`id`, 
                                          `sweepstakes`.`status`,
                                          `sweepstakes`.`title`,
                                          `sweepstakes`.`description`,
                                          `sweepstakes`.`end_date`
                                   FROM `sweepstakes`
                                    JOIN `steamInfo` ON `sweepstakes`.`steamID` = `steamInfo`.`steamID`
                                   WHERE ('.$query.')');
            $STMT->bindParam(':SWEEPSTAKEID', $SWEEPSTAKEID, \PDO::PARAM_INT);
            $STMT->execute();
            $STMT->setFetchMode(\PDO::FETCH_CLASS, __NAMESPACE__ . '\\Sweepstake');
            $KEYSArray = array();
            while($result = $STMT->fetch(\PDO::FETCH_CLASS)){
                self::$SWEEPSTAKES[$result->id] = $result;
                array_push($KEYSArray, $result->id);
            }
            if(!empty($KEYSArray)){
                $KEYS = implode(', ', $KEYSArray);
                $STMT = $PDO->prepare('SELECT `id`,
                                              `item_name`,
                                              `item_image`,
                                              `sweepstakes_id`
                                       FROM `sweepstakes_items`
                                       WHERE `sweepstakes_id` IN ('.$KEYS.')');
                $STMT->execute();
                while($result = $STMT->fetch()){
                    $sweepstake = self::$SWEEPSTAKES[$result['sweepstakes_id']];
                    array_push($sweepstake->ITEMS, $result);
                }
            }
            if(!empty($SWEEPSTAKEID)){
                $KEYS = implode(', ', $KEYSArray);
                $STMT = $PDO->prepare('SELECT entries.`avatar`,
                                              entries.`personaname`,
                                              `sweepstakes_entries`.`steamID`,
                                              `sweepstakes_entries`.`winner`
                                       FROM `sweepstakes_entries`
                                       LEFT JOIN `steamInfo` entries 
                                        ON `sweepstakes_entries`.`steamID` = entries.`steamID`
                                       WHERE `sweepstakes_entries`.`sweepstakes_id` =  '.$SWEEPSTAKEID);
                $STMT->execute();
                while($result = $STMT->fetch()){
                    $sweepstake = self::$SWEEPSTAKES[$SWEEPSTAKEID];
                    array_push($sweepstake->ENTRIES, $result);
                }
            }
        }
    }
    
    public function getSweepstakes(){
        if(empty(self::$SWEEPSTAKES)){
            return '<h3 class="text-center">No Sweepstakes Available</h3>';
        }else{
            $HTML = '';
            foreach(self::$SWEEPSTAKES as $sweepstake){
                $HTML .= '<div class="panel panel-vlobby">
                            <div class="panel-heading">'.$sweepstake->title.' <span class="pull-right">by '.$sweepstake->personaname.'</span></div>
                            <div style="color:black;" class="panel-body">
                                <div class="col-xs-12 col-sm-8 col-md-8 font-PoiretOne">';
                                    if(count($sweepstake->ITEMS) > 5){
                                        for($i=0;$i<5;$i++){
                                            $item = $sweepstake->ITEMS[$i];
                                            $HTML .='<div data-toggle="popover" data-market_hash_name="'.$item['item_name'].'" data-points="2" class="img-rounded-container sweepstake-item" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }
                                        $HTML .='<div data-toggle="popover" data-market_hash_name="and '.(count($sweepstake->ITEMS) - 5).' more!" data-points="2" class="img-rounded-container sweepstake-item" height="75" width="75" style="border-color:#000000;"><center style="position: relative;top: 50%;transform: translateY(-50%);"><span style="font-weight:bold;cursor: default;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;">'.(count($sweepstake->ITEMS) - 5).'</span></center></div>';
                                    }else{
                                        foreach($sweepstake->ITEMS as $item){
                                            $HTML .='<div data-toggle="popover" data-market_hash_name="'.$item['item_name'].'" data-points="2" class="img-rounded-container sweepstake-item" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }   
                                    }
                $HTML .=       '</div>
                                <div class="col-xs-12 col-sm-4 col-md-4">
                                    <button type="button" class="btn btn-vlobby pull-right" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/sweepstake/'.$sweepstake->id.'\';">See Sweepstake</button>
                                </div>
                            </div>
                          </div>';
            }
            return $HTML;
        }
    }
    
    public function getSweepstake(){
        if(empty(self::$SWEEPSTAKES)){
            return '<h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'/sweepstakes/">Sweepstakes</a> > Not Found</h2>
                    <div class="row padding-top-10">
                        <h3 class="text-center font-PoiretOne nomargin">This sweepstake does not exist.</h3>
                    </div>';
        }else{
            $HTML = '';
            foreach(self::$SWEEPSTAKES as $sweepstake){
                $entriesHTML = '';
                $winnersHTML = '';
                $hasJoined = 0;
                $mySteamID = $_SESSION['STEAM_steamid'];
                foreach($sweepstake->ENTRIES as $entry){
                    if($entry['steamID'] == $mySteamID){ $hasJoined = 1; }
                    if($entry['winner'] == 1){
                        $winnersHTML .= '<div>
                                            <img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($entry['avatar']).'" width="100" height="100"/>
                                            <span class="font-bold font-big"><a href="'.\vlobby\Generic\SteamFunctions::getSteamProfile($entry['steamID']).'">'.$entry['personaname'].'</a></span>
                                        </div>';
                    }
                    $entriesHTML .= '<img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($entry['avatar']).'" width="100" height="100"/>';
                }
                            
                $HTML .= '<h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'/sweepstakes/">Sweepstakes</a> > '.$sweepstake->id.'</h2>
                          <div class="row padding-top-30">
                            <div class="col-xs-3 col-sm-3 col-md-3 font-PoiretOne">
                                <div class="nopadding vlobby-jumbotron jumbotron relative">
                                    <center>
                                        <img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($sweepstake->avatar).'" alt="'.$sweepstake->personaname.' avatar" class="img-rounded full-width"/>
                                        <h4 class="full-width text-center">'.$sweepstake->personaname.'</h4>
                                        <h4 class="full-width text-left margin-left-10"><a href="'.\vlobby\THIS_DOMAIN.'\account\view\\'.$sweepstake->steamID.'"><strong>Vlobby Profile</strong></a></h4>
                                        <h4 class="full-width text-left margin-left-10"><a href="'.\vlobby\Generic\SteamFunctions::getSteamProfile($sweepstake->steamID).'"><strong>Steam Profile</strong></a></h4>
                                    </center>
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9 font-PoiretOne">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin padding-top-20 nomargin">'.$sweepstake->title.'</h3>'
                                    .($sweepstake->description!='' ? '<h4 class="nomargin padding-top-20">'.$sweepstake->description.'</h4>' : '').
                                   '<h4 class="nomargin">Time Left: <span id="timeleft">'.\vlobby\Generic\TimeManager::endsAt(strtotime($sweepstake->end_date)).'</span></h4><span class="font-small">(Ends at: '.$sweepstake->end_date.' Server Time)</span>
                                    <h4 class="nomargin color-black">';
                                        foreach($sweepstake->ITEMS as $item){
                                            $HTML .='<div data-toggle="popover" data-market_hash_name="'.$item['item_name'].'" data-points="2" class="img-rounded-container sweepstake-item" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }
                $HTML .=           '</h4>';
                if($sweepstake->status == 2){}else if($_SESSION['group'] == \vlobby\Authentication\SteamAuth::GROUP_ADMIN){$HTML .= '<span class="pull-left" style="padding-right: 20px;margin-top: 7px;">Admin Functions:</span>
                                                                                                  <form role="form" method="post" class="pull-left">
                                                                                                    <input name="action" type="hidden" value="deleteSweepstake">
                                                                                                    <input name="sweepstake_id" type="hidden" value="'.$sweepstake->id.'">
                                                                                                    <button type="submit" class="btn btn-vlobby" onclick="this.innerHTML = \'Please wait...\';">Remove Sweepstake</button>
                                                                                                  </form>'; }
                if($sweepstake->status == 2){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This sweepstake has been deleted.</span>'; }else if((strtotime($sweepstake->end_date) - time()) <= 0){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This sweepstake has ended.</span>'; }else if($sweepstake->steamID == $_SESSION['STEAM_steamid']){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This is your sweepstake :) </span>'; }else if($hasJoined == 1){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">You have entered this sweepstake.</span>';}else{ $HTML .= '<form role="form" method="post"><input name="action" type="hidden" value="joinSweepstake"><input name="sweepstake_id" type="hidden" value="'.$sweepstake->id.'"><button type="submit" class="btn btn-vlobby pull-right margin-right-20 margin-bottom-20" onclick="this.innerHTML = \'Please wait...\';">Join Sweepstake</button></form>';}
                $HTML .='           <div class="clear-both"></div>
                                    <h4 id="timelefthidden" class="hidden">'.(strtotime($sweepstake->end_date) - time()).'</h4>
                                </div>
                            </div>';
                $HTML .= (!empty($winnersHTML) ? 
                            '<div class="col-xs-12 col-sm-12 col-md-12 font-PoiretOne padding-top-30">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin">Sweepstake Winners:</h3>
                                    '.$winnersHTML.'
                                </div>
                            </div>'
                          : '' ).
                            '<div class="col-xs-12 col-sm-12 col-md-12 font-PoiretOne padding-top-30">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin">Who else is here?</h3>'.
                                    (!empty($entriesHTML) ? $entriesHTML : '<center><h3>Noone has yet entered this Sweepstake. Go ahead :) Become the NO.1 entry!</h3></center>').
                               '</div>
                            </div>';
                $HTML .= '</div>';
            }
        }
        return $HTML;
    }
}