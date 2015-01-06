<?php
require_once('../../private_html/config.php');
$Template = vlobby\getTemplate('DEFAULT');
$Template->setRequireLogin(true);
$TradeManager = new \vlobby\trade\TradeManager();
if(isset($_GET['tradeID']) && !empty($_GET['tradeID'])){
    $Template->setPageContent('<div class="vlobby-contents">
                                <h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('TRADE').'">Trade</A> > '.$_GET['tradeID'].'</h2>
                                
                              </div>');
}else{
    $Template->setPageContent('<div class="vlobby-contents">
                                <h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > Trade</h2>
                                <div class="row padding-top-10">
                                    <div class="col-xs-4 col-sm-3 col-md-3 font-PoiretOne padding-top-30">
                                        <ul class="nav nav-pills nav-stacked">
                                            <li data-selecttradetype="all" class="active"><a href="#">All Trades</a></li>
                                            <li data-selecttradetype="csgo"><a href="#">CSGO Trades</a></li>
                                            <li data-selecttradetype="tf2"><a href="#">TF2 Trades</a></li>
                                            <li data-selecttradetype="dota"><a href="#">DOTA Trades</a></li>
                                            <li data-selecttradetype="steamcards"><a href="#">Steam Card Trades</a></li>
                                            <li data-selecttradetype="other"><a href="#">Other Trades</a></li>
                                        </ul>
                                    </div>
                                    <div class="col-xs-8 col-sm-9 col-md-9 font-PoiretOne padding-top-30">
                                        <ul class="nav nav-pills-vlobby pull-right margin-bottom-20" id="tradesTab" role="tablist">
                                            <li role="presentation" class="active"><a href="#getTrades" aria-controls="getTrades" role="tab" data-toggle="tab">Trades</a></li>
                                            <li role="presentation"><a href="#createTrade" aria-controls="createTrade" role="tab" data-toggle="tab">Create Trade</a></li>
                                            <li role="presentation"><a href="#myTrades" aria-controls="myTrades" role="tab" data-toggle="tab">My Trades</a></li>
                                        </ul>
                                        <div class="clear-both"></div>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="getTrades">'.$TradeManager->getTrades().'</div>
                                            <div role="tabpanel" class="tab-pane fade in" id="createTrade">
                                                <span class="pull-left">Left Click -> Change\'s item quality<br>Right Click-> Remove\'s item(If possible)</span>
                                                <form id="postTrade" role="form" method="post" class="padding-bottom-20">
                                                    <div class="row padding-top-10">
                                                        <input name="action" type="hidden" value="createSweepstake">
                                                        <input name="itemArray" id="itemArray" type="hidden" value="[]">
                                                        <!--<div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control font-bold" rows="3" maxlength="100"></textarea>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne padding-top-30">
                                                            <div id="errorList"></div>
                                                            <button type="submit" class="pull-right btn btn-vlobby">Post Sweepstake</button>
                                                        </div>-->
                                                    </div>
                                                </form>
                                                <div class="tab-content">
                                                    <div class="col-xs-12 col-sm-5-5 col-md-5-5 font-PoiretOne">
                                                        <span style="display:block;"><b>I will give:</b></span>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="my-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>  
                                                    </div>
                                                    <div class="hidden-xs col-xs-12 col-sm-1 col-md-1 font-PoiretOne">
                                                        <span class="glyphicon glyphicon-arrow-right" style="font-size: 40px;margin-top:50px;" aria-hidden="true"></span>
                                                    </div>
                                                    <div class="visible-xs col-xs-12 col-sm-1 col-md-1-10per font-PoiretOne">
                                                        <span class="glyphicon glyphicon-arrow-down" style="font-size: 40px;margin-top:30px;" aria-hidden="true"></span>
                                                    </div>
                                                    <div class="col-xs-12 col-sm-5-5 col-md-5-5 font-PoiretOne">
                                                        <span style="display:block;"><b>and i need:</b></span>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                        <div rel="tooltip" class="other-item trade-item img-rounded-container selectable"  height="75" width="75" style="border-color:#000000;color:#0000;"></div>
                                                    </div>
                                                    
                                                    <ul class="nav nav-pills-vlobby pull-left margin-bottom-20" id="My-GameTab" role="tablist">
                                                        <li role="presentation" class="active"><a href="#myInventory" aria-controls="myInventory" role="tab" data-toggle="tab">My Inventory</a></li>
                                                        <li role="presentation"><a href="#gameInventory" aria-controls="gameInventory" role="tab" data-toggle="tab">Game Inventory</a></li>
                                                    </ul>
                                                    <div role="tabpanel" class="tab-pane fade in active" id="myInventory">  
                                                        <ul class="nav nav-pills-vlobby pull-right margin-bottom-20" id="chooseItemsTab" role="tablist">
                                                            <li role="presentation" class="active"><a href="#csgoItems" aria-controls="csgoItems" role="tab" data-toggle="tab">CSGO</a></li>
                                                            <li role="presentation"><a href="#tf2Items" aria-controls="tf2Items" role="tab" data-toggle="tab">TF2</a></li>
                                                            <li role="presentation"><a href="#steamItems" aria-controls="steamItems" role="tab" data-toggle="tab">Steam</a></li>
                                                        </ul>
                                                        <div class="clear-both"></div>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane fade in active" id="csgoItems"><center><button type="submit" class="pull-right btn btn-vlobby invloader margin-top-30" data-appid="730">Load My Inventory</button></center><div class="items"></div></div>
                                                            <div role="tabpanel" class="tab-pane fade in" id="tf2Items"><center><button type="submit" class="pull-right btn btn-vlobby invloader margin-top-30" data-appid="440">Load My Inventory</button></center><div class="items"></div></div>
                                                            <div role="tabpanel" class="tab-pane fade in" id="steamItems"><center><button type="submit" class="pull-right btn btn-vlobby invloader margin-top-30" data-appid="753">Load My Inventory</button></center><div class="items"></div></div>
                                                        </div>
                                                    </div>
                                                    <div role="tabpanel" class="tab-pane fade in" id="gameInventory">
                                                        <ul class="nav nav-pills-vlobby pull-right margin-bottom-20" id="chooseItemsTab" role="tablist">
                                                            <li role="presentation" class="active"><a href="#csgoAllItems" aria-controls="csgoAllItems" role="tab" data-toggle="tab">CSGO</a></li>
                                                            <li role="presentation"><a href="#tf2AllItems" aria-controls="tf2AllItems" role="tab" data-toggle="tab">TF2</a></li>
                                                            <li role="presentation"><a href="#steamAllItems" aria-controls="steamAllItems" role="tab" data-toggle="tab">Steam</a></li>
                                                        </ul>
                                                        <div class="clear-both"></div>
                                                        <div class="tab-content">
                                                            <div role="tabpanel" class="tab-pane fade in active" id="csgoAllItems"><center><button type="submit" class="pull-right btn btn-vlobby gameinvloader margin-top-30" data-appid="730">Load Game Inventory</button></center><div class="items"></div></div>
                                                            <div role="tabpanel" class="tab-pane fade in" id="tf2AllItems"><center><button type="submit" class="pull-right btn btn-vlobby gameinvloader margin-top-30" data-appid="440">Load Game Inventory</button></center><div class="items"></div></div>
                                                            <div role="tabpanel" class="tab-pane fade in" id="steamAllItems"><center><button type="submit" class="pull-right btn btn-vlobby gameinvloader margin-top-30" data-appid="753">Load Game Inventory</button></center><div class="items"></div></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!--<div role="tabpanel" class="tab-pane fade in active" id="myTrades"></div>-->
                                        </div>
                                    </div>
                                </div>
                              </div>');
    $Template->addJS('$("li[data-selecttradetype]").click(function(e){
                        e.preventDefault();
                        $("li[data-selecttradetype]").removeClass("active");
                        $(this).addClass("active");
                        var selecttradetype = $(this).data("selecttradetype");
                        if(selecttradetype != "all"){ $("div[data-tradetype]").addClass("hidden");$("div[data-tradetype="+selecttradetype+"]").removeClass("hidden"); }else{ $("div[data-tradetype]").removeClass("hidden");}
                      });
                      $("div[data-title]").tooltip({
                        html: true,
                        placement: "top",
                        trigger: "hover",
                        title: function () {
                            return $(this).data("title");
                        }
                    });
                    $(document).on("click",".inv-item",function() {
                        var inv_item = $(this);
                        $(".my-item").each(function() {
                            var curr = $(this);
                            if(curr.css("background-image") == "none"){
                                curr.css("background-image", inv_item.css("background-image"));
                                return false;
                            }
                        });
                    });
                    $(document).on("click",".gameinv-item",function() {
                        var inv_item = $(this);
                        $(".other-item").each(function() {
                            var curr = $(this);
                            if(curr.css("background-image") == "none"){
                                curr.css("background-image", inv_item.css("background-image"));
                                return false;
                            }
                        });
                    });
                    $(".trade-item").bind("contextmenu", function(e) {
                        return false;
                    }); 
                    $(".trade-item").mousedown(function(event) {
                        var item = $(this);
                        switch (event.which) {
                            case 1:
                                event.preventDefault();
                                if(item.hasClass("other-item")){
                                    item.css("border-color", "#"+Math.floor(Math.random() * 9)+Math.floor(Math.random() * 9)+Math.floor(Math.random() * 9)+Math.floor(Math.random() * 9)+Math.floor(Math.random() * 9)+Math.floor(Math.random() * 9));
                                    break;
                                }
                                break;
                            case 3:
                                event.preventDefault();
                                item.css("background-image", "");
                            break;
                        }
                    });
                    $(".invloader").click(function(){
                        var invloader = $(this);
                        invloader.html("Loading inventory....");
                        $.ajax({
                            type: "POST",
                            url: "/proxy",
                            data: { loc: "base", path: "/api/VlobbyUser/getUserBackpack/v001/?&steamid='.$_SESSION['STEAM_steamid'].'&appid="+invloader.data("appid") }
                        }).done(function( msg ) {
                            $("#"+invloader.parent().parent().attr("id")+" > .items").html( msg );
                            invloader.html("Reload inventory");
                        });
                    });
                    $(".gameinvloader").click(function(){
                        var invloader = $(this);
                        invloader.html("Loading inventory....");
                        $.ajax({
                            type: "POST",
                            url: "/proxy",
                            data: { loc: "base", path: "/api/SteamInventory/getGameInventory/v001/?&appid="+invloader.data("appid") }
                        }).done(function( msg ) {
                            $("#"+invloader.parent().parent().attr("id")+" > .items").html( msg );
                            invloader.html("Reload inventory");
                        });
                    });', false);
}
$Template->designTemplate();
?>