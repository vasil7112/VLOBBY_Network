<?php
require_once('../private_html/config.php');
$Template = vlobby\getTemplate();
$Template->setPageTitle('My Giveaways');
$Template->setRequireLogin(true);

$Template->setPageContent('<div class="vlobby-contents font-PoiretOne">
                            <h2 class="text-center nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN.'">Giveaways</a> > My Giveaways</h2>
                            <div class="padding-top-10">
                                '.\vlobby\Plugins\Giveaways\GiveawaysFactory::getUserGiveaways($_SESSION['STEAM_steamid']).'
                            </div>
                           </div>');
$Template->designTemplate();
?>