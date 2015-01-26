<?php
require_once('../private_html/config.php');
$Template = vlobby\getTemplate();
$Template->setPageTitle('Create Giveaway');
$Template->setRequireLogin(true);

if(isset($_POST['action']) && $_POST['action']=='createGiveaway'){
    if(isset($_POST['title'], $_POST['description'], $_POST['expireIn'], $_POST['max_entries'], $_POST['visibility'], $_POST['delivery'], $_POST['itemArray'])){
        \vlobby\Plugins\Giveaways\GiveawaysFactory::createGiveaway($_POST['title'], $_POST['description'], $_POST['expireIn'], $_POST['max_entries'], $_POST['visibility'], $_POST['delivery'], $_POST['itemArray']);
    }
}/**
if(isset($_POST['action']) && $_POST['action']=='deleteSweepstake'){
    if(isset($_POST['sweepstake_id'])){
        \vlobby\play\Sweepstakes\SweepstakesFactory::deleteSweepstake($_POST['sweepstake_id']);
    }
}
**/
$Template->setPageContent('<div class="vlobby-contents font-PoiretOne">
                            <h2 class="text-center nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN.'">Giveaways</a> > Create Giveaway</h2>
                            <div class="padding-top-10">
                                <form id="postgiveaway" role="form" method="post" class="padding-bottom-20">
                                    <div class="row padding-top-10">
                                        <input name="action" type="hidden" value="createGiveaway">
                                        <input name="itemArray" id="itemArray" type="hidden" value="[]">
                                        <div class="col-xs-12 col-sm-6 col-md-6 font-PoiretOne padding-top-30">
                                            <div class="form-group">
                                                <label>Title</label>
                                                <input name="title" type="text" class="form-control font-bold" placeholder="Name the Giveaway" pattern=".{5,30}" title="Title must be more than 5 and up to 30 characters" required>
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
                                            <button type="submit" class="pull-right btn btn-vlobby">Start Giveaway</button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-xs-6 col-sm-3 col-md-3 font-PoiretOne padding-top-30">
                                            <label>Visibility</label>
                                            <div class="radio">
                                                <label><input type="radio" name="visibility" value=0 checked="checked">Public Giveaway</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="visibility" value=1>Private Giveaway</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="visibility" value=2 disabled>Group Giveaway <sup class="color-red">Disabled</sup></label>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3 font-PoiretOne padding-top-30">
                                            <label>Delivery</label>
                                            <div class="radio">
                                                <label><input type="radio" name="delivery" value=0 checked="checked">I will deliver this</label>
                                            </div>
                                            <div class="radio">
                                                <label><input type="radio" name="delivery" value=1 disabled>Automatic <sup class="color-red">Disabled</sup> <span rel="tooltip" data-title="The items will be automaticly given to the winner through our Bots" class="glyphicon glyphicon-question-sign" aria-hidden="true"></span></label>
                                            </div>
                                        </div>
                                        <div class="col-xs-6 col-sm-3 col-md-3 font-PoiretOne padding-top-30">
                                            <div class="form-group">
                                                <label>Max Entries (0 = Unlimited)</label>
                                                <input class="form-control font-bold" type="number" name="max_entries" min="0" max="100000" value="0" required>
                                            </div>
                                        </div>
                                    </div>
                                    <select id="selectInventory" class="form-control font-bold pull-right" style="min-width: 200px; max-width:300px;">
                                        <option value="none" selected="selected">Please Select Inventory</option>
                                        <option value="440">Team Fortress 2</option>
                                        <option value="730">CS:GO</option>
                                        <option value="753">Steam</option>
                                        <option value="570">Dota 2</option>
                                        <option value="238460">BattleBlock Theater</option>
                                        <option value="218620">PAYDAY 2</option>
                                        <option value="221540">Defense Grid 2</option>
                                        <option value="620">Portal 2</option>
                                    </select>
                                    <div id="inventory"></div>
                                </form>
                            </div>
                           </div>');
$Template->addJS('var selectedItems = [];
                 $("body").tooltip({
                    selector: "[rel=tooltip]",
                    html: true,
                    placement: "top",
                    trigger: "hover",
                    title: function () {
                        return $(this).data("title");
                    }
                 });
                 
                 $("#selectInventory").change(function(){
                    var invloader = $(this);
                    if(invloader.val() == "none"){
                        return;
                    }
                    $.ajax({
                        type: "POST",
                        url: "/proxy",
                        data: { loc: "base", path: "/api/VlobbyUser/getUserBackpack/v001/?&steamid='.$_SESSION['STEAM_steamid'].'&appid="+invloader.val() }
                    }).done(function( msg ) {
                        $("#inventory").html( msg );
                        for(var entry in selectedItems){
                            if(selectedItems[entry]["appID"] == invloader.val()){
                                $("div[data-itemid="+selectedItems[entry]["itemID"]+"]").addClass("vlobby-item-selected");
                            }
                        };
                    });
                });
                

                $("body").on("click", ".steam-item.selectable" , function(){
                    var clickedItem = $(this);
                    if(!clickedItem.hasClass("vlobby-item-selected")){
                        clickedItem.addClass("vlobby-item-selected");
                        selectedItems.push({
                            appID : clickedItem.data("appid"), 
                            itemID : clickedItem.data("itemid")
                        });
                    }else{
                        var toRemove;
                        for(var entry in selectedItems){
                            if(selectedItems[entry]["appID"] == clickedItem.data("appid") && selectedItems[entry]["itemID"] == clickedItem.data("itemid")){
                                toRemove = entry;
                            }
                        }
                        selectedItems.splice(toRemove, 1);
                        clickedItem.removeClass("vlobby-item-selected");
                    }
                    $("#itemArray").val(JSON.stringify(selectedItems));
                });
                
                $("#postgiveaway").submit(function( e ) {
                    if(selectedItems.length == 0 || selectedItems == "[]"){
                        $("#errorList").html("Error: No items selected.");
                        return false;
                    }
                    $("#postgiveaway button[type=\"submit\"]").text("Please wait...");
                  });', false);
$Template->designTemplate();
?>