<?php
require_once('../../private_html/config.php');
$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageTitle('Sweepstakes');
$Template->setRequireLogin(true);

if(isset($_POST['action']) && $_POST['action']=='createSweepstake'){
    if(isset($_POST['title'], $_POST['expireIn'], $_POST['description'], $_POST['itemArray'])){
       \vlobby\play\Sweepstakes\SweepstakesFactory::createSweepstake($_POST['title'], $_POST['description'], $_POST['expireIn'], $_POST['itemArray']);
    }
}
if(isset($_POST['action']) && $_POST['action']=='joinSweepstake'){
    if(isset($_POST['sweepstake_id'])){
        \vlobby\play\Sweepstakes\SweepstakesFactory::joinSweepstake($_POST['sweepstake_id']);
    }
}
if(isset($_POST['action']) && $_POST['action']=='deleteSweepstake'){
    if(isset($_POST['sweepstake_id'])){
        \vlobby\play\Sweepstakes\SweepstakesFactory::deleteSweepstake($_POST['sweepstake_id']);
    }
}

if(isset($_GET['st']) && !empty($_GET['st'])){
    $SweepstakesManager = new \vlobby\play\Sweepstakes\SweepstakesManager($_GET['st']);
    $Template->setPageContent('<div class="vlobby-contents">'.
                                $SweepstakesManager->getSweepstake($_GET['st']).
                              '</div>');
    $Template->addJS('var timeleft = null;
                      $( document ).ready(function(){
                        getTime();
                      });
                      function getTime(){
                        if($("#timelefthidden").length != 0) {
                            timeleft = $("#timelefthidden").text();
                            getTimeLeft();
                        }
                      }
                      function getTimeLeft(){
                        timeleft--;
		
                        if(timeleft >= 0){
                            var hour = Math.floor(timeleft / 3600);
                            var min = Math.floor(timeleft / 60 - hour * 60);
                            var sec = Math.floor(timeleft - hour * 3600 - min * 60);
			
                            if(hour < 10){hour = "0"+hour;}
                            if(min < 10){min = "0"+min;}
                            if(sec < 10){sec = "0"+sec;}
                            $("#timeleft").text(hour+"h "+min+"m "+sec+"s");
                        }else{
                            $("#timeleft").text("Finished");
                        }
		
                        if(timeleft >= 0){
                            setTimeout(function(){getTimeLeft()}, 1000); 
                        }
                      }', false);                    
}else{
    $SweepstakesManager = new \vlobby\play\Sweepstakes\SweepstakesManager();
    $Template->setPageContent('<div class="vlobby-contents">
                                <h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > Sweepstakes</h2>
                                <div class="row padding-top-10">
                                    <div class="col-xs-12 col-sm-12 col-md-12 font-PoiretOne padding-top-30">
                                        <ul class="nav nav-pills-vlobby pull-right margin-bottom-20" id="sweepstakesTab" role="tablist">
                                            <li role="presentation" class="active"><a href="#getSweepstakes" aria-controls="getSweepstakes" role="tab" data-toggle="tab">Sweepstakes</a></li>
                                            <li role="presentation"><a href="#createSweepstakes" aria-controls="createSweepstakes" role="tab" data-toggle="tab">Create Sweepstake</a></li>
                                            <li role="presentation"><a href="#mySweepstakes" aria-controls="mySweepstakes" role="tab" data-toggle="tab">My Sweepstakes</a></li>
                                        </ul>
                                        <div class="clear-both"></div>
                                        <div class="tab-content">
                                            <div role="tabpanel" class="tab-pane fade in active" id="getSweepstakes">'.$SweepstakesManager->getSweepstakes().'</div>
                                            <div role="tabpanel" class="tab-pane fade in" id="createSweepstakes">
                                                <form id="postsweepstake" role="form" method="post" class="padding-bottom-20">
                                                    <div class="row padding-top-10">
                                                        <input name="action" type="hidden" value="createSweepstake">
                                                        <input name="itemArray" id="itemArray" type="hidden" value="[]">
                                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne padding-top-30">
                                                            <div class="form-group">
                                                                <label>Title</label>
                                                                <input name="title" type="text" class="form-control font-bold" placeholder="Name the Sweepstake" pattern=".{5,30}" title="Title must be more than 5 and up to 30 characters" required>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne padding-top-30">
                                                            <div class="form-group">
                                                                <label>Expires in: </label>
                                                                <select name="expireIn" class="form-control font-bold">
                                                                    <option value="0">15 Minutes</option>
                                                                    <option value="1">30 Minutes</option>
                                                                    <option value="2">1 Hour</option>
                                                                    <option value="3">2 Hours</option>
                                                                    <option value="4">4 Hours</option>
                                                                    <option value="5">8 Hours</option>
                                                                    <option value="6">16 Hours</option>
                                                                    <option value="7">1 Day</option>
                                                                    <option value="8">2 Days</option>
                                                                    <option value="9">3 Days</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne">
                                                            <label>Description</label>
                                                            <textarea name="description" class="form-control font-bold" rows="3" maxlength="100"></textarea>
                                                        </div>
                                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne padding-top-30">
                                                            <div id="errorList"></div>
                                                            <button type="submit" class="pull-right btn btn-vlobby">Post Sweepstake</button>
                                                        </div>
                                                    </div>
                                                </form>
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
                                            <div role="tabpanel" class="tab-pane fade in" id="mySweepstakes">
                                                '.\vlobby\play\Sweepstakes\SweepstakesFactory::getUserSweepstakes($_SESSION['STEAM_steamid']).'
                                            </div>
                                        </div>
                                    </div>
                                </div>
                               </div>');
}
$Template->addJS('$( document ).ajaxStop( function() {
                    $(".sweepstake-item").tooltip({
                        html: true,
                        placement: "top",
                        trigger: "hover",
                        title: function () {
                            return $(this).data("market_hash_name");
                        }
                    });
                 });
                 $(".sweepstake-item").tooltip({
                    html: true,
                    placement: "top",
                    trigger: "hover",
                    title: function () {
                        return $(this).data("market_hash_name");
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

                 var selectedItems = [];
                 $("body").on("click", ".sweepstake-item.selectable" , function(){
                    var clickedItem = $(this);
                    if(!clickedItem.hasClass("vlobby-item-selected")){
                        clickedItem.addClass("vlobby-item-selected");
                        selectedItems.push(clickedItem.data("appid")+"_"+clickedItem.data("itemid"));
                    }else{
                        var findItem = selectedItems.indexOf(clickedItem.data("appid")+"_"+clickedItem.data("itemid"));
                        if (findItem > -1) {
                            selectedItems.splice(findItem, 1);
                        }
                        clickedItem.removeClass("vlobby-item-selected");
                    }
                    $("#itemArray").val(JSON.stringify(selectedItems));
                  });
                  $("#postsweepstake").submit(function( e ) {
                    if(selectedItems.length == 0){
                        $("#errorList").html("Error: No items selected.");
                        return false;
                    }
                  });',false);
$Template->designTemplate();