<?php
namespace vlobby\Generic;
class TimeManager{
    public static function mysqlTime(){
        return time() + 18000;
    }
    
    public static function ago($time){
        $periods = array("second", "minute", "hour", "day", "week", "month", "year", "decade");
        $lengths = array("60","60","24","7","4.35","12","10");

        $now = time();
        $difference     = $now - $time;
        $tense         = "ago";

        for($j = 0; $difference >= $lengths[$j] && $j < count($lengths)-1; $j++) {
            $difference /= $lengths[$j];
        }

        $difference = round($difference);

        if($difference != 1) {
            $periods[$j].= "s";
        }

        return "$difference $periods[$j] ago ";
    }
    
    public static function endsAt($time){
        $difference = $time - time();
        
        if($difference <= 0){
            return 'Finished';
        }
        $hour = floor($difference / 3600); // 60
        $min = floor(($difference / 60) - ($hour * 60)); //43
        $sec = floor($difference - ($hour * 3600) - ($min * 60)); //54
        
        if($hour < 10){$hour = "0"+$hour;}
        if($min < 10){$min = "0"+$min;}
        if($sec < 10){$sec = "0"+$sec;}
        return $hour."h ".$min."m ".$sec."s";
    }
}