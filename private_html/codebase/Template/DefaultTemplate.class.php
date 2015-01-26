<?php
namespace vlobby\Template;

class DefaultTemplate extends \vlobby\Template\Template{
    public function designTemplate(){
        if(\vlobby\Authentication\SteamAuth::isLoggedIn()){
            $NotificationsManager = new \vlobby\Notifications\NotificationManager($_SESSION['STEAM_steamid']);
        }
        
        if(\vlobby\MAINTENANCE_ENABLED && (!\vlobby\Authentication\SteamAuth::isLoggedIn() || (\vlobby\MAINTENANCE_ENABLED && $_SESSION['group'] != \vlobby\Authentication\SteamAuth::GROUP_ADMIN))){
            echo   '<html>
                        <header>
                            <title>Vlobby is under maintenance</title>
                        </header>
                        <body>
                            <center>
                                <h1>Page Under Maintenance.</h1>
                                <h3>We will try to come back as soon as possible!</h3>
                                <hr style="border-top: 1px dotted #000;width:50%;"/>
                                <h2>Are you an admin? Feel free to login.</h2>
                                '.(!\vlobby\Authentication\SteamAuth::isLoggedIn() ? \vlobby\Authentication\SteamAuth::login() : 'You are not an admin! <a href="?logout">Logout</a>').'
                            </center>
                        </body>
                    </html>';
            exit();
        }else{
            echo '<!DOCTYPE html>
                  <html lang "en">
                    <head>
                        <meta charset="utf-8">
                        <meta http-equiv="X-UA-Compatible" content="IE=edge">
                        <meta name="viewport" content="width=device-width, initial-scale=1">
                        <meta name="description" content="' . $this->getPageDescription() . '">
                        <meta name="keywords" content="' . $this->getKeywords() . '">
                        <meta name="author" content="' . /**self::PAGE_AUTHORS .**/ '">
                        <title>' . $this->PAGE_NAME . ' &bull; ' . $this->PAGE_TITLE . '</title>
                        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/css/bootstrap.min.css">
                        <link rel="stylesheet" href="' . \vlobby\THIS_DOMAIN.'/assets/css/vlobby.css">
                        <link rel="shortcut icon" href="' . \vlobby\THIS_DOMAIN.'/assets/img/favicon.png' . '" type="image/x-icon">'./**This is just for testing.**/'
                        ' . $this->getCSS() .'
                        <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
                        <!-- WARNING: Respond.js doesn\'t work if you view the page via file:// -->
                        <!--[if lt IE 9]>
                            <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                            <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                        <![endif]-->
                    </head>
                    <body>
                        <div class="vlobby-container container">
                            <nav class="navbar navbar-vlobby" role="navigation">
                                <div class="container-fluid">
                                    <div class="navbar-header">
                                        <a class="navbar-brand" href="'.\vlobby\THIS_DOMAIN.'">
                                            <img alt="Brand" src="'.\vlobby\THIS_DOMAIN.'/assets/img/logo.png">
                                        </a>
                                        
                                    </div>
                                    <!--<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                                        <ul class="nav navbar-nav">
                                            <li><a href="#"><img alt="Brand" src="'.\vlobby\THIS_DOMAIN.'/assets/img/logo.png"></a></li>
                                        </ul>
                                    </div>-->
                                    '.(!\vlobby\Authentication\SteamAuth::isLoggedIn() ?
                                        '<div class="vlobby-signin">'.
                                            \vlobby\Authentication\SteamAuth::login().
                                        '</div>'
                                      :
                                        '<div class="vlobby-user-menu dropdown" '.($NotificationsManager->countUnreadNotifications() != 0 ? 'style="background-color: rgba(230, 255, 141, 0.3);"' : '').'>
                                           <div class="dropdown-toggle" id="dropdown-greeding" data-toggle="dropdown">
                                               Welcome, '.$_SESSION['STEAM_personaname'].' <span class="caret"></span>
                                           </div>
                                           <ul id="dropdown-greeding-menu" class="dropdown-menu" role="menu" aria-labelledby="dropdown-greeding">
                                                <li role="presentation"><a href="'.\vlobby\THIS_DOMAIN.'/account/notifications"><span class="glyphicon glyphicon-bullhorn" aria-hidden="true"></span> Notifications ('.$NotificationsManager->countUnreadNotifications().')</a></li>
                                                <li role="presentation"><a href="'.\vlobby\THIS_DOMAIN.'/account/view/'.$_SESSION['STEAM_steamid'].'"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> My Account</a></li>
                                                <li role="presentation" class="divider"></li>
                                                <li role="presentation"><a href="?logout"><span class="glyphicon glyphicon-off"></span> Logout</a></li>
                                            </ul>
                                        </div>').
                                '</div>
                            </nav>
                            <div id="main-carousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    <div class="item active">
                                        <img src="'.\vlobby\THIS_DOMAIN.'/assets/img/CS-GO.jpg" alt="">
                                        <div class="carousel-caption"></div>
                                    </div>
                                    <div class="item">
                                        <img src="'.\vlobby\THIS_DOMAIN.'/assets/img/TF2.jpg" alt="">
                                        <div class="carousel-caption"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="vlobby-carousel-seperator"></div>'.
                            (
                                $this->requireLogin && !\vlobby\Authentication\SteamAuth::isLoggedIn() ?
                                    '<div class="vlobby-contents">
                                        <h2 class="text-center font-PoiretOne nomargin">Please Login</h2>
                                        <h3 class="text-center font-PoiretOne nomargin">You need to be logged in to access this content.</h3>
                                        <center class="margin-top-10">'.\vlobby\Authentication\SteamAuth::login().'</center>
                                    </div>'
                                                
                                :
                                    $this->getPageContent()
                            ).
                            '<div class="vlobby-footer text-center">
                                <div class="vlobby-status">
                                    <a href="#">Service Status</a>
                                    <a href="'.\vlobby\THIS_DOMAIN.'/rules/">Rules</a>
                                    <a href="'.\vlobby\THIS_DOMAIN.'/tos/">Terms Of Service</a>
                                    <a href="'.\vlobby\THIS_DOMAIN.'/privacy/">Privacy Policy</a>
                                </div>
                                <div class="clear-both"></div>
                                <div class="vlobby-social">
                                    <span>Become Social:</span>
                                    <a href="http://steamcommunity.com/groups/VlobbyNet">Steam Group</a>
                                    <a href="https://www.facebook.com/VlobbyNet">Facebook</a>
                                    <a href="https://twitter.com/VlobbyNet">Twitter</a>
                                    <a href="#">Twitch</a>
                                </div>
                                <div class="clear-both"></div>
                                &copy; Copyright 2014 Vlobby.net.</br>
                                Any content not taken from Steam Software and/or Valve Software is registered trademark of Vlobby. All other trademarks are property of their respective owners.
                            </div>
                        </div>
                        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
                        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.1/js/bootstrap.min.js"></script>'.
                        $this->getJS().'
                    </body>
                  </html>';
        }
    }
}
?>