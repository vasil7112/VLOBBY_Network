<?php
namespace vlobby\Generic;

class SteamFunctions {

    public static function steamIDToName($steamID, $limit = null) { // Convert SteamID to SteamName
        $content = json_decode(curl_file_get_contents("http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key=" . STEAM_API_KEY . "&steamids=" . $steamID), true);

        $steamName = $content['response']['players'][0]['personaname'];
        if(empty($steamName)){
            steamIDToName($steamID, $limit);
        }else{
            return ($limit !=null && strlen($steamName) > $limit) ? substr($steamName, 0, $limit) . " . . . " : $steamName;
        }
    }

    public static function getSteamProfile($steamID){ // Return the steam Profile URL
        return 'http://steamcommunity.com/profiles/' . $steamID;
    }
    
    public static function toSteamAvatarMedium($avatarURL){
        $avatar = str_replace('.jpg', '', $avatarURL);
        return $avatar.'_medium.jpg';
    }
    
    public static function toSteamAvatarFull($avatarURL){
        $avatar = str_replace('.jpg', '', $avatarURL);
        return $avatar.'_full.jpg';
    }
    
    public static function getBackpackJSON($steamID, $gameID, $subID = 2){
        $url = 'http://steamcommunity.com/profiles/'.$steamID.'/inventory/json/'.$gameID.'/'.$subID;
        $curl = curl_init();
        $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
 
        curl_setopt($curl,CURLOPT_URL,$url); //The URL to fetch. This can also be set when initializing a session with curl_init().
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE); //TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5); //The number of seconds to wait while trying to connect.	
 
        curl_setopt($curl, CURLOPT_USERAGENT, $userAgent); //The contents of the "User-Agent: " header to be used in a HTTP request.
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE); //To fail silently if the HTTP code returned is greater than or equal to 400.
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE); //To follow any "Location: " header that the server sends as part of the HTTP header.
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE); //To automatically set the Referer: field in requests where it follows a Location: redirect.
        curl_setopt($curl, CURLOPT_TIMEOUT, 10); //The maximum number of seconds to allow cURL functions to execute.	
 
        $content = curl_exec($curl);
        curl_close($curl);
        $content = json_decode($content, true);

        return $content;
    }
    
    public static function getBackpackHTML($steamID, $gameID, $subID = 2, $fakeID = null){
        $HTML = '';
        $gameID = (int) $gameID;
        $content = self::getBackpackJSON($steamID, $gameID, $subID);
        $inventory = $content['rgInventory'];
        $descriptions = $content['rgDescriptions'];
        foreach($inventory as $itemid=>$item){
            $description = $descriptions[$item['classid'].'_'.$item['instanceid']] ;
            if($description['tradable'] == 1){
                $HTML .= '<div rel="tooltip" class="sweepstake-item img-rounded-container selectable" data-appid="'.($fakeID == null ? $gameID : $fakeID).'" data-itemid="'.$itemid.'" data-market_hash_name="'.($gameID != 753 ? $description['market_hash_name'] : $description['name']).'" height="75" width="75" style="background-image:url(\'http://steamcommunity-a.akamaihd.net/economy/image/'.$description['icon_url'].'/96fx96f\');border-color:#000000;color:#0000;"></div>';
            }
        }
        return $HTML;
    }
}
