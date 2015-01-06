<?php
require_once('../../private_html/config.php');
$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageContent('<div class="vlobby-contents">
                            <h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > Play</h2>
                            <div class="row padding-top-10">
                                <div class="col-xs-3 col-sm-3 col-md-3 font-PoiretOne padding-top-30">
                                    <ul class="nav nav-pills nav-stacked">
                                        <li data-selectgametype="all" class="active"><a href="#">All Games</a></li>
                                        <li data-selectgametype="csgo"><a href="#">CSGO Games</a></li>
                                        <li data-selectgametype="tf2"><a href="#">TF2 Games</a></li>
                                        <li data-selectgametype="dota"><a href="#">DOTA Games</a></li>
                                        <li data-selectgametype="gmod"><a href="#">GMOD Games</a></li>
                                        <li data-selectgametype="generic"><a href="#">Other Games</a></li>
                                    </ul>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 font-PoiretOne padding-top-30">
                                    <div data-gametype="generic" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lotteries/\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Lotteries</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/sweepstakes/\';">
                                            <center><div><img src="http://tf2wiki.net/ww/images/thumb/9/97/Carefully_Wrapped_Gift.png/200px-Carefully_Wrapped_Gift.png" width="100"/></div>Sweepstakes</center>
                                        </div>
                                    </div>
                                    <div data-gametype="csgo" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10">
                                            <center>CSGO TDM</center>
                                        </div>
                                    </div>
                                    <div data-gametype="csgo" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10">
                                            <center>CSGO Gun Game</center>
                                        </div>
                                    </div>
                                    <div data-gametype="dota" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10">
                                            <center>DOTA Raffles</center>
                                        </div>
                                    </div>
                                    <div data-gametype="gmod" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10">
                                            <center>GMOD Raffles</center>
                                        </div>
                                    </div>
                                    <div data-gametype="tf2" class="col-xs-12 col-sm-4 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10">
                                            <center>TF2 Raffles</center>
                                        </div>
                                    </div>
                                </div>
                            </div>
                           </div>');
$Template->addJS('$("li[data-selectgametype]").click(function(e){
                    e.preventDefault();
                    $("li[data-selectgametype]").removeClass("active");
                    $(this).addClass("active");
                    var selectgametype = $(this).data("selectgametype");
                    if(selectgametype != "all"){ $("div[data-gametype]").addClass("hidden");$("div[data-gametype="+selectgametype+"]").removeClass("hidden"); }else{ $("div[data-gametype]").removeClass("hidden");}
                  });', false);
$Template->designTemplate();
?>