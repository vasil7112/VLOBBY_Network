<?php
require_once('../../private_html/config.php');

$Template = vlobby\getTemplate('DEFAULT');
$Template->setPageTitle('Notifications');
$Template->setRequireLogin(true);

$NotificationsManager = new \vlobby\Notifications\NotificationManager($_SESSION['STEAM_steamid']);

$Template->setPageContent('<div class="vlobby-contents">
                            <h2 class="text-center font-PoiretOne nomargin"><a href="/account/">Account</a> > Notifications</h2>
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Notification</th>
                                        <th>Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  '.$NotificationsManager->getNotificationsHTML().'
                                </tbody>
                            </table>
                           </div>');
$Template->designTemplate();

$NotificationsManager->setNotificationsRead();

