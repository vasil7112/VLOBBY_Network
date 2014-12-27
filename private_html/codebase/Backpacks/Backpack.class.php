<?php
namespace vlobby\Backpacks;

class Backpack {
    public $appID;
    public $steamID;
    public function __construct($steamID, $appID){
        $this->appID = $appID;
        $this->steamID = $steamID;
        
        $url = 'http://steamcommunity.com/profiles/'.$steamID.'/inventory/json/'.$appID.'/'.$subID;
        $curl = curl_init();
 
        curl_setopt($curl,CURLOPT_URL,$url);
        curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);
        curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);
 
        curl_setopt($curl, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)');
        curl_setopt($curl, CURLOPT_FAILONERROR, TRUE);
        curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);
        curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);
        curl_setopt($curl, CURLOPT_TIMEOUT, 10);
 
        $exec = curl_exec($curl);
        curl_close($curl);
        $content = json_decode($exec, true);
    }
}
