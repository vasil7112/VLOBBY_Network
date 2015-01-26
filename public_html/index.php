<?php
require_once('../private_html/config.php');
$Template = vlobby\getTemplate();
$Template->setPageTitle('Home');
$GiveawaysManager = new \vlobby\Plugins\Giveaways\GiveawaysManager();
$Template->setPageContent('<div class="vlobby-contents font-PoiretOne">
                            <h2 class="text-center nomargin">Welcome to Vlobby,</h2>
                            <h3 class="text-center nomargin">The Valve Lobby</h3>
                            <div class="row">
                                <div class="col-xs-12 col-sm-7 col-md-7 padding-top-30 text-center">
                                    Vlobby Network is expanding, slowly but steady. We are trying to bring you quality content every day and we hope that
                                    you are enjoying it.
                                    
                                    <div class="padding-top-10">
                                        <a href="'.\vlobby\THIS_DOMAIN.'/creategiveaway" class="inline-block pull-left"><h3>Create Giveaway</h3></a>
                                        '.(\vlobby\Authentication\SteamAuth::isLoggedIn() ? '<a href="'.\vlobby\THIS_DOMAIN.'/mygiveaways" class="inline-block pull-right"><h3>My Giveaways</h3></a>' : '').'
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-5">
                                    <h4 class="text-center">Share the Knowledge</h4>
                                    <center><a href="https://github.com/vasil7112/VLOBBY_Network"><img class="img-center" src="/assets/img/btn-Github.png"/></a></center>
                                    
                                    <h4 class="text-center">Or give us a visit at</h4>
                                    <div class="vlobby-jumbotron jumbotron nopadding margin-top-10">
                                        <div id="sponsor-carousel" class="carousel slide" data-ride="carousel" data-interval="2000">
                                            <div class="carousel-inner">
                                                <div class="item active">
                                                    <img src="/assets/img/sponsors/bazaartf.jpg" alt="">
                                                    <div class="carousel-caption"></div>
                                                </div>
                                                <div class="item">
                                                    <img src="/assets/img/sponsors/dispensertf.jpg" alt="">
                                                    <div class="carousel-caption"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="padding-top-30">
                                '.$GiveawaysManager->getGiveaways().'
                            </div>
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