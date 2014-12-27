<?php
namespace vlobby\Notifications;

class NotificationManager {
    public static $NOTIFICATIONS = array();
    private $steamID;
    public function __construct($steamID = NULL) {
        if($steamID == NULL){
            return false;
        }else{
            $this->steamID = $steamID;
        }
        if(empty(self::$NOTIFICATIONS)){
            $PDO = \vlobby\Database\Connect::getInstance();
            $STMT = $PDO->prepare('SELECT id, notification, time, status, color
                                   FROM notifications
                                   WHERE steamID = :STEAMID
                                   ORDER BY id DESC');
            $STMT->bindParam(':STEAMID', $steamID, \PDO::PARAM_STR);
            $STMT->execute();
            $STMT->setFetchMode(\PDO::FETCH_CLASS, __NAMESPACE__ . '\\Notification');
            while($result = $STMT->fetch(\PDO::FETCH_CLASS)){
                array_push(self::$NOTIFICATIONS, $result);
            }
        }
    }
    
    public function countAllNotifications(){
        return count(self::$NOTIFICATIONS);
    }
    
    public function countUnreadNotifications(){
        $count = 0;
        foreach(self::$NOTIFICATIONS as $notification){
            if($notification->status == 0){
                $count++;
            }
        }
        return $count;
    }
    
    public function getNotificationsHTML(){
        $HTML = '';
        foreach(self::$NOTIFICATIONS as $notification){
            $HTML .= '<tr '.($notification->status==0?'style="background-color:#'.$notification->color.';"':'').'>
                        <td>'.$notification->id.'</td>
                        <td>'.$notification->notification.'</td>
                        <td>'.$notification->time.'</td>
                      </tr>';
        }
        return $HTML;
    }
    
    public function setNotificationsRead(){
        $PDO = \vlobby\Database\Connect::getInstance();
        $STMT = $PDO->prepare('UPDATE notifications
                               SET status = 1 
                               WHERE (steamID = :STEAMID AND status = 0)');
        $STMT->bindParam(':STEAMID', $this->steamID, \PDO::PARAM_STR);
        $STMT->execute();
    }
}
