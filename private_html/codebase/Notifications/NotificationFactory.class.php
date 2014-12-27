<?php
namespace vlobby\Notifications;

class NotificationFactory{
    public static function addNotification($steamid, $message, $color = 762520){
        if(!\vlobby\Authentication\SteamAuth::isLoggedIn()){
            return false;
        }
        $PDO = \vlobby\Database\Connect::getInstance();
        $STMT = $PDO->prepare('INSERT INTO notifications (steamID, notification, color)
                               VALUES (:STEAMID, :MESSAGE, :COLOR)');
        $STMT->bindParam(':STEAMID', $steamid, \PDO::PARAM_STR);
        $STMT->bindParam(':MESSAGE', $message, \PDO::PARAM_STR);
        $STMT->bindParam(':COLOR', $color, \PDO::PARAM_STR);
        $STMT->execute();
    }
}
