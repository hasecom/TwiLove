<?php 
namespace App\Controllers;
require_once(__DIR__.'/../Auth/Hash.php');
require_once(__DIR__.'/../Constants/Key.php');
require_once(__DIR__.'/../Constants/Domain.php');

use App\Auth\Hash;
use App\Constants\Key;
use App\Constants\Domain;
//Twitterと連携します。
class CookieController{
    //cookieを生成します。
    public function GenerateCokkie($val){
        $cookieKey = Hash::CokkieHash($val);
        return $cookieKey;
    }
    public function RegistCookie($cookieKey){
        //30日クッキーを保存
        $domain = '';
        if(Domain::isLocal()){
            $domain = Domain::$domain;
        }else{
            $domain = Domain::$releaseCookieDomain;
        }
        setcookie(Key::$cookieKeyName,$cookieKey,time()+60*60*24*60,$domain);
    }
}
?>