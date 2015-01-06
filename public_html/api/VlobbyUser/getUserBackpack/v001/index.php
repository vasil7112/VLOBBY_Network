<?php
require_once('../../../../../private_html/config.php');
if(!isset($_GET['steamid']) || empty($_GET['steamid'])){
    return;
}
if($_GET['appid'] == '753'){
    $backpack1 = \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 1, '753-1');
    $backpack2 = \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 3, '753-3');
    $backpack3 = \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 6, '753-6');
    $backpack = $backpack1.$backpack2.$backpack3;
    if(empty($backpack)){
        echo '<h4 class="text-center">Couldn\'t fetch your data! Is your inventory public?</h4>';
    }else{
        echo $backpack;
    }
}else{
    $backpack = \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], $_GET['appid']);
    if(!$backpack){
        echo '<h4 class="text-center">Couldn\'t fetch your data! Is your inventory public?</h4>';
        die();
    }else{
        echo $backpack;
    }
}
?>