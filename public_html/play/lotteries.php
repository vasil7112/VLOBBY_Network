<?php
require_once('../../private_html/config.php');
$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageTitle('Lottery');
$Template->setRequireLogin(true);

if(isset($_POST['action']) && $_POST['action']=='joinLottery'){
    if(isset($_POST['sweepstake_id'])){
        //\vlobby\play\Sweepstakes\SweepstakesFactory::joinSweepstake($_POST['sweepstake_id']);
    }
}


if(isset($_GET['st']) && !empty($_GET['st'])){
    $Template->setPageContent('<div class="vlobby-contents">'.
                                \vlobby\play\Lotteries\LotteriesManager::getLottery($_GET['st']).
                              '</div>');                  
}else{
    $Template->setPageContent('<div class="vlobby-contents">
                                <h2 class="text-center font-PoiretOne nomargin"><a href="'.\vlobby\THIS_DOMAIN.'">Vlobby</a> > <a href="'.\vlobby\THIS_DOMAIN('PLAY').'">Play</a> > Lotteries</h2>
                                <div class="row padding-top-30">
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/1\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Aluminium Ticket</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/2\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Bronze Ticket</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/3\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Copper Ticket</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/4\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Silver Ticket</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/5\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Gold Ticket</center>
                                        </div>
                                    </div>
                                    <div data-gametype="generic" class="col-xs-12 col-sm-3 col-md-3">
                                        <div class="center vlobby-jumbotron jumbotron nopadding hoverable margin-top-10" onclick="location.href = \'' . \vlobby\THIS_DOMAIN('PLAY') . '/lottery/6\';">
                                            <center><div><img src="https://wiki.teamfortress.com/w/images/thumb/a/a9/Backpack_RIFT_Well_Spun_Hat_Claim_Code.png/250px-Backpack_RIFT_Well_Spun_Hat_Claim_Code.png?t=20130215210442" width="100"/></div>Jackpot</center>
                                        </div>
                                    </div>
                                </div>
                               </div>');
}
$Template->addJS('$(".sweepstake-item").tooltip({
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