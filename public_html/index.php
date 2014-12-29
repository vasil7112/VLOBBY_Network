<?php
require_once('../private_html/config.php');
$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageTitle('Home');
$Template->setPageContent('<div class="vlobby-contents">
                            <h2 class="text-center font-PoiretOne nomargin">Welcome to Vlobby,</h2>
                            <h3 class="text-center font-PoiretOne nomargin">The Valve Lobby</h3>
                            <div class="row">
                                <div class="col-xs-12 col-sm-7 col-md-7 font-PoiretOne padding-top-30">
                                    The Vlobby network is a service which allows you to win items that you can use on games such as 
                                    <strong>CS:GO</strong> and <strong>TF2</strong> by playing on different kinds of <strong>events</strong>.
                                    Those events include, but are not limited to <strong>Tournamets</strong>, <strong>Raffles</strong>, 
                                    <strong>Bets</strong> and more. 
                                </div>
                                <div class="col-xs-12 col-sm-5 col-md-5">
                                    <h4 class="text-center font-PoiretOne">COMMUNITY: (Examples...)</h4>
                                    <div class="vlobby-jumbotron jumbotron nopadding">
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
                            <div class="row padding-top-30">
                                <div class="col-xs-12 col-sm-3 col-md-3 margin-top-10">
                                    <div class="center vlobby-jumbotron jumbotron nopadding hoverable" onclick="location.href = \''.\vlobby\THIS_DOMAIN('trade').'\';">
                                        <center><img src="http://placehold.it/90x90&text=TRADE"/></center>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 margin-top-10">
                                    <div class="center vlobby-jumbotron jumbotron nopadding hoverable" onclick="location.href = \''.\vlobby\THIS_DOMAIN('play').'\';">
                                        <center><img src="http://placehold.it/90x90&text=PLAY"/></center>
                                      </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 margin-top-10">
                                    <div class="center vlobby-jumbotron jumbotron nopadding hoverable" onclick="location.href = \'/csgo/weaponbanking\';">
                                        <center><img src="http://placehold.it/90x90&text=BET"/></center>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-3 col-md-3 margin-top-10">
                                    <div class="center vlobby-jumbotron jumbotron nopadding hoverable" onclick="location.href = \'/csgo/weaponbanking\';">
                                        <center><img src="http://placehold.it/90x90&text=TALK"/></center>
                                    </div>
                                </div>
                              </div>
                             </div>');
$Template->designTemplate();
?>