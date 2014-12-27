<?php
namespace vlobby{
    if (!session_id()) { // MUST-HAVE -> Starts the new Session if it doesn't exist. Stores STEAM DATA & PAGE DATA.
        session_set_cookie_params(0, '/', '.vlobby.net');
        ini_set('session.cookie_domain', '.vlobby.net' );
        session_start();
    }
    
    use Tres\package_manager\Autoload;
    define('ROOT', dirname(__DIR__));
    require_once(ROOT.'/private_html/codebase/package_manager/Autoload.php');
    $manifest = require(ROOT.'/private_html/manifest.php');
    $autoload = new Autoload(ROOT.'/', $manifest);

    const STEAM_API_KEY = ''; // STEAM API KEY used to access STEAM API FUNCTIONS.
    const THIS_DOMAIN = 'http://vlobbys.net';
    const DOMAIN_NAME = 'vlobby';
    const WEB_TRADE_ENABLED = true;
    const WEB_BET_ENABLED = true;
    const WEB_PLAY_ENABLED = true;
    const WEB_TALK_ENABLED = true;
    const MAINTENANCE_ENABLED = true;
    
    function loadClass($class){
        require_once('codebase/'.$class.'.class.php');
    }
    
    function getTemplate($TemplateType){
        if(strtoupper($TemplateType)=='DEFAULT'){
            return new \vlobby\Template\DefaultTemplate();
        }
    }
    
    function THIS_DOMAIN($PREFIX){
        $urlArray = explode('://', THIS_DOMAIN);
        return $urlArray[0].'://'.$PREFIX.'.'.$urlArray[1];
    }
    
    function minify_output($buffer){
        $search = array(
                    '/\>[^\S ]+/s',
                    '/[^\S ]+\</s',
                    '/(\s)+/s'
                 );
        $replace = array(
                    '>',
                    '<',
                    '\\1'
                 );
        if (preg_match("/\<html/i",$buffer) == 1 && preg_match("/\<\/html\>/i",$buffer) == 1) {
            $buffer = preg_replace($search, $replace, $buffer);
        }
        return $buffer;
    }
}
?>