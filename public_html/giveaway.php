<?php
require_once('../private_html/config.php');
$Template = vlobby\getTemplate();
$Template->setPageTitle('Giveaway');
$Template->setRequireLogin(true);

if(!isset($_GET['id']) || !isset($_GET['hash'])){
    header('Location: '.\vlobby\THIS_DOMAIN);
}

if(isset($_POST['action']) && $_POST['action']=='joinGiveaway'){
    if(isset($_POST['giveaway_id'])){
        \vlobby\Plugins\Giveaways\GiveawaysFactory::joinGiveaway($_POST['giveaway_id']);
    }
}

if(isset($_POST['action']) && $_POST['action']=='deletegiveaway'){
    if(isset($_POST['giveaway_id'])){
        \vlobby\Plugins\Giveaways\GiveawaysFactory::deleteGiveaway($_POST['giveaway_id']);
    }
}

$giveawayID = ((int) $_GET['id']);
$GiveawaysManager = new \vlobby\Plugins\Giveaways\GiveawaysManager($giveawayID, $_GET['hash']);
$Template->setPageContent('<div class="vlobby-contents font-PoiretOne">
                            '.$GiveawaysManager->getGiveaway().'
                           </div>');
$Template->addJS('$("body").tooltip({
                    selector: "[rel=tooltip]",
                    html: true,
                    placement: "top",
                    trigger: "hover",
                    title: function () {
                        return $(this).data("title");
                    }
                 });' ,false);
$Template->designTemplate();
?>