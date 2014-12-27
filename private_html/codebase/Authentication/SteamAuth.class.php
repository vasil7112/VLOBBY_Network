<?php
namespace vlobby\Authentication;

ob_start();

if(isset($_GET['logout']) && \vlobby\Authentication\SteamAuth::isLoggedIn()){ \vlobby\Authentication\SteamAuth::logout();header('Refresh: 0;');}


class SteamAuth {
    const GROUP_USER = 0;
    const GROUP_TRUSTED = 1;
    const GROUP_PREMIUM = 2;
    const GROUP_PLATINUM = 3;
    const GROUP_BANNED = 254;
    const GROUP_ADMIN = 255;
    
    public static function getGroupName($id, $COLOR = false){
        $id = (int) $id;
        if(is_int($id)){
            $GROUPNAME = '';
            switch ($id) {
                case 0:
                    $GROUPNAME = 'User';
                    $COLOR = false;
                case 1:
                    $GROUPNAME = 'Trusted';
                    $COLOR = false;
                case 2:
                    $GROUPNAME = 'Premium';
                    $COLOR = false;
                case 3:
                    $GROUPNAME = 'Platinum';
                    $COLOR = false;
                case 254:
                    $GROUPNAME = 'Banned';
                    $COLOR = false;
                case 255:
                    $GROUPNAME = 'Administrator';
                    $COLOR = 'B00000';
            }
            if($COLOR == false){
                return $GROUPNAME;
            }else{
                return '<span style="color:#'.$COLOR.';">'.$GROUPNAME.'</span>';
            }
        }
    }
    public static function logout() {
        session_destroy();
    }

    public static function isLoggedIn() { 
        if(isset($_SESSION['STEAM_steamid'])){ return true; }
        return false;
    }
    
    public static function login() { 
        try {
            $openid = new \vlobby\Authentication\LightOpenID((($subdomain = array_shift((explode(".",$_SERVER['HTTP_HOST'])))) != \vlobby\DOMAIN_NAME ? \vlobby\THIS_DOMAIN($subdomain) : \vlobby\THIS_DOMAIN));
            if (!$openid->mode) {
                if(self::isLoggedIn()){ return; }
                if (isset($_GET['login'])) { 
                    $openid->identity = 'http://steamcommunity.com/openid';
                    header('Location: ' . $openid->authUrl());
                }
                return '<form id="loginbtn" action="?login" method="post"><input type="image" src="http://steamcommunity-a.akamaihd.net/public/images/signinthroughsteam/sits_small.png"></form>';
            } elseif ($openid->mode == 'cancel') { 
                echo 'User has canceled authentication!';
            } else {
                if ($openid->validate()) { 
                    $id = $openid->identity;
                    $ptn = "/^http:\/\/steamcommunity\.com\/openid\/id\/(7[0-9]{15,25}+)$/";
                    preg_match($ptn, $id, $matches);

                    $_SESSION['STEAM_steamid'] = $matches[1];
                    
                    $steamAPI = 'http://api.steampowered.com/ISteamUser/GetPlayerSummaries/v0002/?key='.\vlobby\STEAM_API_KEY.'&steamids='.$_SESSION['STEAM_steamid'];
                    $ch = curl_init();
                    curl_setopt($ch, CURLOPT_URL, $steamAPI);
                    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                    $content = curl_exec($ch);
                    curl_close($ch);
                    $content = json_decode($content,true);
                    $player = $content['response']['players'][0];
                    
                    $_SESSION['STEAM_steamid'] = $player['steamid'];
                    $_SESSION['STEAM_communityvisibilitystate'] = $player['communityvisibilitystate'];
                    $_SESSION['STEAM_profilestate'] = $player['profilestate'];
                    $_SESSION['STEAM_personaname'] = $player['personaname'];
                    $_SESSION['STEAM_lastlogoff'] = $player['lastlogoff'];
                    $_SESSION['STEAM_profileurl'] = $player['profileurl'];
                    $_SESSION['STEAM_avatar'] = $player['avatar'];
                    $_SESSION['STEAM_personastate'] = $player['personastate'];
                    //$_SESSION['STEAM_realname'] = $player['realname'];
                    $_SESSION['STEAM_primaryclanid'] = $player['primaryclanid'];
                    $_SESSION['STEAM_timecreated'] = $player['timecreated'];
                    

                    $PDO = \vlobby\Database\Connect::getInstance();
                    $STMT = $PDO->prepare('SELECT `group` FROM user WHERE steamID = :STEAMID LIMIT 1');
                    $STMT->bindParam(':STEAMID', $matches[1], \PDO::PARAM_STR);
                    $STMT->execute();
                    $result = $STMT->fetch();
                    if($result != null || $result != 0){
                        $_SESSION['group'] = $result['group'];
                    }else{
                        $STMT1 = $PDO->prepare('INSERT INTO user (`steamID`) VALUES (:STEAMID);');
                        $STMT1->bindParam(':STEAMID', $matches[1], \PDO::PARAM_STR);
                        $STMT1->execute();
                        
                        $_SESSION['group'] = 0;
                    }
                    
                    $STMT2 = $PDO->prepare('INSERT INTO steamInfo (steamID, personaname, avatar)
                                            VALUES (:STEAMID, :PERSONANAME, :AVATAR)
                                            ON DUPLICATE KEY UPDATE
                                                `personaname` = VALUES(`personaname`),
                                                `avatar` = VALUES(`avatar`)');
                    $STMT2->bindParam(':STEAMID', $matches[1], \PDO::PARAM_STR);
                    $STMT2->bindParam(':PERSONANAME', $player['personaname'], \PDO::PARAM_STR);
                    $STMT2->bindParam(':AVATAR', $player['avatar'], \PDO::PARAM_STR);
                    $STMT2->execute();
                    header('Refresh: 0;');
                    die();
                }
            }
        } catch (ErrorException $e) {
            echo $e->getMessage();
        }
    }
}
