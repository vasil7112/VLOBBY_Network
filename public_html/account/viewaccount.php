<?php
require_once('../../private_html/config.php');

$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageTitle($_GET['steamID'].'&rsquo;s Account');

/** QUICK FETCH USER INFO FOR THIS **/
$PDO = \vlobby\Database\Connect::getInstance();
$STMT = $PDO->prepare('SELECT `steamInfo`.`personaname`, 
                              `steamInfo`.`avatar`, 
                              `user`.`steamID`,
                              `user`.`group`
                       FROM `user`
                              JOIN `steamInfo` ON `user`.`steamID` = `steamInfo`.`steamID`
                       WHERE `steamInfo`.`steamID` = :STEAMID');
$STMT->bindParam(':STEAMID', $_GET['steamID'], \PDO::PARAM_INT);
$STMT->execute();
$result = $STMT->fetch();
$rowCount = $STMT->rowCount();
$Template->setPageContent('<div class="vlobby-contents">'.
                            ($rowCount == 1 ? '
                            <h2 class="text-center font-PoiretOne nomargin"><a href="/account/">Account</a> > '.$result['personaname'].'&rsquo;s Account</h2>
                            <div class="row padding-top-30">
                                <div class="col-xs-3 col-sm-3 col-md-3 font-PoiretOne">
                                    <div class="nopadding vlobby-jumbotron jumbotron relative">
                                        <center>
                                            <img src="'.\vlobby\Generic\SteamFunctions::toSteamAvatarFull($result['avatar']).'" alt="'.$result['personaname'].' avatar" class="img-rounded full-width"/>
                                        </center>
                                    </div>
                                </div>
                                <div class="col-xs-9 col-sm-9 col-md-9 font-PoiretOne">
                                    <div class="vlobby-jumbotron jumbotron">
                                        <h3 class="padding-top-20 nomargin">'.$result['personaname'].'&rsquo;s Profile</h3>
                                        <h4 class="padding-top-20 nomargin">Vlobby Information:</h4>
                                        <h4 class="padding-top-20 padding-left-10 nomargin">Vlobby Group: <strong>'.\vlobby\Authentication\SteamAuth::getGroupName($result['group'], true).'</strong></h4>
                                        <h4 class="padding-top-20 nomargin">Steam Information:</h4>
                                        <h4 class="padding-top-20 padding-left-10 nomargin">Steam ID (x64): '.$result['steamID'].'</h4>
                                        <h4 class="padding-top-20 padding-left-10 nomargin"><a href="'.\vlobby\Generic\SteamFunctions::getSteamProfile($result['steamID']).'"><strong>Visit Steam Profile</strong></a></h4>
                                        <span data-tooltip data-title="Report '.$result['personaname'].'" class="pull-right glyphicon glyphicon-warning-sign" aria-hidden="true"></span>
                                    </div>
                                </div>
                                <div class="col-xs-12 col-sm-12 col-md-12 font-PoiretOne padding-top-30">
                                    <div class="vlobby-jumbotron jumbotron">
                                        <h3 class="nomargin">Badges:</h3>
                                        '.\vlobby\Badges\BadgesManager::getUserBadges($_GET['steamID']).'
                                    </div>
                                </div>
                            </div>'
                            :
                            '<h2 class="text-center font-PoiretOne nomargin"><a href="/account/">Account</a> > Not Found</h2>
                             <div class="row padding-top-10">
                                <h3 class="text-center font-PoiretOne nomargin">This user does not exist.</h3>
                             </div>'
                            ).'
                           </div>');
$Template->addJS('$("*[data-tooltip]").tooltip({
                    html: true,
                    placement: "top",
                    trigger: "hover",
                    title: function () {
                        return $(this).data("title");
                    }
                  });',false);
$Template->designTemplate();
