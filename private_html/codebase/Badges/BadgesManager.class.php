<?php
namespace vlobby\Badges;
class BadgesManager {
    public static function getUserBadges($steamID){
        $PDO = \vlobby\Database\Connect::getInstance();
        $STMT = $PDO->prepare('SELECT `badges`.`title`,
                                      `badges`.`image`,
                                      `badges_assigned`.`assigned_at`
                               FROM `badges_assigned`
                                JOIN `badges` ON `badges`.`id` = `badges_assigned`.`badge_id`
                               WHERE `badges_assigned`.`steamID` = :STEAMID');
        $STMT->bindParam(':STEAMID', $steamID, \PDO::PARAM_INT);
        $STMT->execute();
        $HTML = '';
        while($result = $STMT->fetch()){
            $HTML .= '<div data-tooltip data-title="'.$result['title'].'" data-toggle="popover" class="img-rounded-container sweepstake-item" height="75" width="75" style="background-image:url(\''.$result['image'].'\');border-color:#000000;"></div>';
        }
        if(empty($HTML)){
            $HTML = '<h4 class="text-center nomargin">This user has no badges</h4>';
        }
        return $HTML;
    }
    
    public static function assignBadge($badgeID, $steamID){
        $PDO = \vlobby\Database\Connect::getInstance();
        $STMT = $PDO->prepare('INSERT INTO `badges_assigned` (steamID, badge_id)
                               SELECT * FROM (SELECT :STEAMID, :BADGEID) AS tmp
                               WHERE NOT EXISTS (
                                SELECT `steamID` FROM `badges_assigned` WHERE (`steamID` = :STEAMID AND `badge_id` = :BADGEID)
                               ) LIMIT 1;');
        $STMT->bindParam(':STEAMID', $steamID, \PDO::PARAM_INT);
        $STMT->bindParam(':BADGEID', $badgeID, \PDO::PARAM_INT);
        $STMT->execute();
    }
}