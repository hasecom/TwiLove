<?php 
namespace App\Helpers;
require_once(__DIR__.'/../Constants/Key.php');
require_once(__DIR__.'/../Services/CookieService.php');
use App\Constants\Key;
use App\Services\CookieService;
class CookieHelper {
    public  $isSetCookie;
    public  $cookieVal;
    public function __construct(){
        $cookieKey = Key::$cookieKeyName;
        if(isset($_COOKIE[$cookieKey])){
            $this->isSetCookie = true;
            $this->cookieVal =  $_COOKIE[$cookieKey];
        }else{
            $this->isSetCookie = false;
        }
    }
    public function getUserInfoByCookie(){
        $cookieService = new CookieService;
        $userInfo = $cookieService->getUserInfoByCookie(['COOKIE_KEY'=>$this->cookieVal]);
        if ($userInfo != null){
            $userInfo = $userInfo[0];
        }
        return $userInfo;
    }
}
?>