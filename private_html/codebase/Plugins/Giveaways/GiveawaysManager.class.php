<?php
namespace vlobby\Plugins\Giveaways;
class GiveawaysManager {
    public static $GIVEAWAYS = array();
    public function __construct($GIVEAWAYID = NULL, $HASH = NULL) {
        if(empty(self::$GIVEAWAYS)){
            $PDO = \vlobby\Database\Connect::getInstance();
            if(($GIVEAWAYID != NULL && $HASH == NULL) || ($HASH != NULL && strlen($HASH) != 6)){ return; }
            $query = ($GIVEAWAYID == NULL ? '`giveaways`.`status` = 0 AND `giveaways`.`visibility` = 0 AND `giveaways`.`end_date` > CURRENT_TIMESTAMP() AND (`giveaways`.`max_entries` = 0 || `giveaways`.`max_entries` > `giveaways`.`entries`)' : '`giveaways`.`id` = :GIVEAWAYID AND `giveaways`.`hash` = :HASH');
            $STMT = $PDO->prepare('SELECT `steam_info`.`personaname`, 
                                          `steam_info`.`avatar`, 
                                          `giveaways`.`id`,
                                          `giveaways`.`hash`,
                                          `giveaways`.`status`,
                                          `giveaways`.`title`, 
                                          `giveaways`.`description`,
                                          `giveaways`.`end_date`,
                                          `giveaways`.`max_entries`,
                                          `giveaways`.`entries`,
                                          `giveaways`.`visibility`,
                                          `giveaways`.`delivery`,
                                          `giveaways`.`created_by`
                                   FROM `giveaways`
                                    JOIN `steam_info` ON `giveaways`.`created_by` = `steam_info`.`steam_id`
                                   WHERE ('.$query.') ORDER BY `giveaways`.`end_date` ASC');
            $STMT->bindParam(':GIVEAWAYID', $GIVEAWAYID, \PDO::PARAM_INT);
            $STMT->bindParam(':HASH', $HASH, \PDO::PARAM_STR);
            $STMT->execute();
            $STMT->setFetchMode(\PDO::FETCH_CLASS, __NAMESPACE__ . '\\Giveaway');
            $KEYSArray = array();
            while($result = $STMT->fetch(\PDO::FETCH_CLASS)){
                self::$GIVEAWAYS[$result->id] = $result;
                array_push($KEYSArray, $result->id);
            }
            if(!empty($KEYSArray)){
                $KEYS = implode(', ', $KEYSArray);
                $STMT = $PDO->prepare('SELECT `id`,
                                              `item_name`,
                                              `item_image`,
                                              `giveaway_id`
                                       FROM `giveaways_items`
                                       WHERE `giveaway_id` IN ('.$KEYS.')');
                $STMT->execute();
                while($result = $STMT->fetch()){
                    $giveaway = self::$GIVEAWAYS[$result['giveaway_id']];
                    array_push($giveaway->ITEMS, $result);
                }
            }else{
                return;
            }
            if(!empty($GIVEAWAYID)){
                $KEYS = implode(', ', $KEYSArray);
                $STMT = $PDO->prepare('SELECT entries.`avatar`,
                                              entries.`personaname`,
                                              `giveaways_entries`.`steam_id`,
                                              `giveaways_entries`.`winner`
                                       FROM `giveaways_entries`
                                       LEFT JOIN `steam_info` entries 
                                        ON `giveaways_entries`.`steam_id` = entries.`steam_id`
                                       WHERE `giveaways_entries`.`giveaway_id` =  '.$GIVEAWAYID);
                $STMT->execute();
                while($result = $STMT->fetch()){
                    $giveaway = self::$GIVEAWAYS[$GIVEAWAYID];
                    array_push($giveaway->ENTRIES, $result);
                }
            }
        }
    }

    public function getGiveaways(){
        if(empty(self::$GIVEAWAYS)){
            return '<h3 class="text-center">No Giveaways Available</h3>';
        }else{
            $HTML = '';
            foreach(self::$GIVEAWAYS as $giveaway){
                $HTML .= '<div class="panel panel-vlobby">
                            <div class="panel-heading"><a href="'.\vlobby\THIS_DOMAIN.'/giveaway/'.$giveaway->id.'/'.$giveaway->hash.'"><span class="font-medium">'.$giveaway->title.'</span></a> <span class="pull-right">by '.$giveaway->personaname.'</span></div>
                            <div style="color:black;" class="panel-body">
                                <div class="col-xs-12 col-sm-8 col-md-9">';
                                    if(count($giveaway->ITEMS) > 8){
                                        for($i=0;$i<8;$i++){
                                            $responsiveClass = '';
                                            if($i == 1 || $i == 2 || $i == 3){
                                                $responsiveClass = 'visible-sm-inline-block visible-md-inline-block visible-lg-inline-block';
                                            }
                                            if($i == 4 || $i == 5){
                                                $responsiveClass = 'visible-md-inline-block visible-lg-inline-block';
                                            }
                                            if($i == 6 || $i == 7){
                                                $responsiveClass = 'visible-lg-inline-block';
                                            }
                                            $item = $giveaway->ITEMS[$i];
                                            
                                            $HTML .='<div rel="tooltip" data-title="'.$item['item_name'].'" class="'.$responsiveClass.' img-rounded-container giveaway-item" style="height:75px;width:75px;background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }
                                        $HTML .='<div rel="tooltip" data-title="and '.(count($giveaway->ITEMS) - 8).' more!" class="visible-lg-inline-block img-rounded-container giveaway-item" style="height:75px;width:75px;border-color:#000000;"><center style="position: relative;top: 50%;transform: translateY(-50%);"><span style="font-weight:bold;cursor: default;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;">'.(count($giveaway->ITEMS) - 8).'</span></center></div>';
                                        $HTML .='<div rel="tooltip" data-title="and '.(count($giveaway->ITEMS) - 8).' more!" class="visible-md-inline-block img-rounded-container giveaway-item" style="height:75px;width:75px;border-color:#000000;"><center style="position: relative;top: 50%;transform: translateY(-50%);"><span style="font-weight:bold;cursor: default;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;">'.(count($giveaway->ITEMS) - 6).'</span></center></div>';
                                        $HTML .='<div rel="tooltip" data-title="and '.(count($giveaway->ITEMS) - 8).' more!" class="visible-sm-inline-block img-rounded-container giveaway-item" style="height:75px;width:75px;border-color:#000000;"><center style="position: relative;top: 50%;transform: translateY(-50%);"><span style="font-weight:bold;cursor: default;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;">'.(count($giveaway->ITEMS) - 3).'</span></center></div>';
                                        $HTML .='<div rel="tooltip" data-title="and '.(count($giveaway->ITEMS) - 8).' more!" class="visible-xs-inline-block img-rounded-container giveaway-item" style="height:75px;width:75px;border-color:#000000;"><center style="position: relative;top: 50%;transform: translateY(-50%);"><span style="font-weight:bold;cursor: default;-webkit-user-select: none;-moz-user-select: none;-ms-user-select: none;-o-user-select: none;user-select: none;">'.(count($giveaway->ITEMS) - 1).'</span></center></div>';
                                    }else{
                                        foreach($giveaway->ITEMS as $item){
                                            $HTML .='<div data-toggle="popover" data-title="'.$item['item_name'].'" class="img-rounded-container giveaway-item" style="height:75px;width:75px;background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }   
                                    }
                $HTML .=       '</div>
                                <div class="col-xs-12 col-sm-4 col-md-3">
                                    <div class="vr"><span>&nbsp;</span></div>
                                    <b>
                                       Open for another: '.\vlobby\Generic\TimeManager::endsAt(strtotime($giveaway->end_date)).'<br>
                                       Entries: '.$giveaway->entries.' / '.$giveaway->getMaxEntries().'<br>
                                       Delivery: '.$giveaway->getDeliveryType().'
                                    </b>
                                    <button type="button" class="btn btn-vlobby btn-j-giveaway" onclick="location.href = \''.\vlobby\THIS_DOMAIN.'/giveaway/'.$giveaway->id.'/'.$giveaway->hash.'\';"><span class="glyphicon glyphicon-share-alt color-white" aria-hidden="true"></span></button>
                               </div>
                            </div>
                          </div>';
            }
            return $HTML;
        }
    }

    public function getGiveaway(){
        if(empty(self::$GIVEAWAYS)){
            return '<h2 class="text-center nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN.'">Giveaways</a> > Not Found</h2>
                    <div class="row padding-top-30">
                        <h3 class="text-center nomargin">This giveaway does not exist.</h3>
                    </div>';
        }else{
            $HTML = '';
            foreach(self::$GIVEAWAYS as $giveaway){
                $entriesHTML = '';
                $winnersHTML = '';
                $hasJoined = 0;
                $mySteamID = $_SESSION['STEAM_steamid'];
                foreach($giveaway->ENTRIES as $entry){
                    if($entry['steam_id'] == $mySteamID){ $hasJoined = 1; }
                    if($entry['winner'] == 1){
                        $winnersHTML .= '<div>
                                            <img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($entry['avatar']).'" width="100" height="100"/>
                                            <span class="font-bold font-big"><a href="'.\vlobby\Generic\SteamFunctions::getSteamProfile($entry['steam_id']).'">'.$entry['personaname'].'</a></span>
                                        </div>';
                    }
                    $entriesHTML .= '<img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($entry['avatar']).'" width="100" height="100"/>';
                }
                            
                $HTML .= '<h2 class="text-center nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN.'">Giveaways</a> > '.$giveaway->id.'</h2>
                          <div class="row padding-top-30">
                            <div class="col-xs-3 col-sm-3 col-md-3">
                                <div class="nopadding vlobby-jumbotron jumbotron relative">
                                    <center>
                                        <img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($giveaway->avatar).'" alt="'.$giveaway->personaname.' avatar" class="img-rounded full-width"/>
                                        <h4 class="full-width text-center">'.$giveaway->personaname.'</h4>
                                        <h4 class="full-width text-left margin-left-10"><a href="'.\vlobby\THIS_DOMAIN.'\account\view\\'.$giveaway->created_by.'"><strong>Vlobby Profile</strong></a></h4>
                                        <h4 class="full-width text-left margin-left-10"><a href="'.\vlobby\Generic\SteamFunctions::getSteamProfile($giveaway->created_by).'"><strong>Steam Profile</strong></a></h4>
                                    </center>
                                </div>
                            </div>
                            <div class="col-xs-9 col-sm-9 col-md-9">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin padding-top-20 nomargin">'.$giveaway->title.'</h3>'
                                    .($giveaway->description!='' ? '<h4 class="nomargin padding-top-20 padding-bottom-20">'.$giveaway->description.'</h4>' : '').
                                   '<h4 class="nomargin">Entries: '.$giveaway->entries.' / '.$giveaway->getMaxEntries().'</h4>
                                    <h4 class="nomargin">Delivery: '.$giveaway->getDeliveryType().'</h4>
                                    <h4 class="nomargin">Visibility: '.$giveaway->getVisibilityType().'</h4>
                                    <h4 class="nomargin">Time Left: <span id="timeleft">'.\vlobby\Generic\TimeManager::endsAt(strtotime($giveaway->end_date)).'</span></h4><span class="font-small">(Ends at: '.$giveaway->end_date.' Server Time)</span>
                                    <h4 class="nomargin color-black">';
                                        foreach($giveaway->ITEMS as $item){
                                            $HTML .='<div rel="tooltip" data-title="'.$item['item_name'].'" class="img-rounded-container giveaway-item" height="75" width="75" style="background-image:url(\''.$item['item_image'].'\');border-color:#000000;"><span>&nbsp;</span></div>';
                                        }
                $HTML .=           '</h4>';
                if($giveaway->status == 2){}else if($_SESSION['group'] == \vlobby\Authentication\SteamAuth::GROUP_ADMIN){$HTML .= '<span class="pull-left" style="padding-right: 20px;margin-top: 7px;">Admin Functions:</span>
                                                                                                  <form role="form" method="post" class="pull-left">
                                                                                                    <input name="action" type="hidden" value="deletegiveaway">
                                                                                                    <input name="giveaway_id" type="hidden" value="'.$giveaway->id.'">
                                                                                                    <button type="submit" class="btn btn-vlobby" onclick="this.innerHTML = \'Please wait...\';">Remove giveaway</button>
                                                                                                  </form>'; }
                if($giveaway->status == 2){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This giveaway has been deleted.</span>'; }else if((strtotime($giveaway->end_date) - time()) <= 0){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This giveaway has ended.</span>'; }else if($giveaway->entries >= $giveaway->getMaxEntries()){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This giveaway is full!</span>'; }else if($giveaway->created_by == $_SESSION['STEAM_steamid']){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">This is your giveaway :) </span>'; }else if($hasJoined == 1){ $HTML .= '<span class="pull-right margin-right-20 margin-bottom-20">You have entered this giveaway.</span>';}else{ $HTML .= '<form role="form" method="post"><input name="action" type="hidden" value="joinGiveaway"><input name="giveaway_id" type="hidden" value="'.$giveaway->id.'"><button type="submit" class="btn btn-vlobby pull-right margin-right-20 margin-bottom-20" onclick="this.innerHTML = \'Please wait...\';">Join Giveaway</button></form>';}
                $HTML .='           <div class="clear-both"></div>
                                    <h4 id="timelefthidden" class="hidden">'.(strtotime($giveaway->end_date) - time()).'</h4>
                                </div>
                            </div>';
                $HTML .= (!empty($winnersHTML) ? 
                            '<div class="col-xs-12 col-sm-12 col-md-12 padding-top-30">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin">Giveaway Winners:</h3>
                                    '.$winnersHTML.'
                                </div>
                            </div>'
                          : '' ).
                            '<div class="col-xs-12 col-sm-12 col-md-12 padding-top-30">
                                <div class="vlobby-jumbotron jumbotron">
                                    <h3 class="nomargin">Who else is here?</h3>'.
                                    (!empty($entriesHTML) ? $entriesHTML : '<center><h3>Noone has yet entered this Giveaway. Go ahead :) Become the NO.1 entry!</h3></center>').
                               '</div>
                            </div>';
                $HTML .= '</div>';
            }
        }
        return $HTML;
    }
}