<?php
require_once('../../../../../private_html/config.php');
if($_GET['appid'] == '753'){
    echo \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 1, '753-1');
    echo \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 3, '753-3');
    echo \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], 753, 6, '753-6');
}else{
    echo \vlobby\Generic\SteamFunctions::getBackpackHTML($_GET['steamid'], $_GET['appid']);
}
?>