<?php
namespace vlobby{
    date_default_timezone_set('EST');
    if (!session_id()) {
        session_set_cookie_params(0, '/', '.vlobby.net');
        ini_set('session.cookie_domain', '.vlobby.net' );
        session_start();
    }
    
    use Tres\PackageManager\Autoload;
    define('ROOT', dirname(__DIR__));
    require_once(ROOT.'/private_html/codebase/PackageManager/Autoload.php');
    $manifest = require(ROOT.'/private_html/manifest.php');
    $autoload = new Autoload(ROOT.'/', $manifest);

    const STEAM_API_KEY = '';
    const THIS_DOMAIN = 'http://vlobby.net';
    const DOMAIN_NAME = 'vlobby';
    const WEB_TRADE_ENABLED = true;
    const WEB_BET_ENABLED = true;
    const WEB_PLAY_ENABLED = true;
    const WEB_TALK_ENABLED = true;
    const MAINTENANCE_ENABLED = false;
    
    function loadClass($class){
        require_once('codebase/'.$class.'.class.php');
    }
    
    function getTemplate($TemplateType = 'DEFAULT'){
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