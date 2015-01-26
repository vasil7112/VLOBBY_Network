<?php
require_once('../private_html/config.php');
if(!isset($_POST['loc'], $_POST['path'])){
    die();
}
if(in_array(strtolower($_POST['loc']), array('base', 'play'))){
    if($_POST['loc'] == 'base'){
        echo file_get_contents(\vlobby\THIS_DOMAIN.$_POST['path']);
    }else{
        echo file_get_contents(\vlobby\THIS_DOMAIN($_POST['loc']).$_POST['path']);
    }
}else{
    die();
}
?>