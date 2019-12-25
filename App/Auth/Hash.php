<?php 
namespace App\Auth;
require_once(__DIR__.'/../Configuration.php');
use App\Configuration;
class Hash{
    public static function SetPass($val){
        return password_hash($val,PASSWORD_DEFAULT);
    }
    public static function ExistPass($inputpass,$digestPass){
        return password_verify($inputpass,$digestPass);
    }
    public static function Session($val){
        return crypt($val,Configuration::get('SESSION_SALT_KEY'));
    }
    public static function CokkieHash($val){
        return substr($val.rand(),1,6);
    }
    public static function Oauth($val){
         return hash('SHA256',$val);
    }
    //あらゆるテーブルで必要なキーの生成
    public static function AppKey($val){
        return hash('SHA256',$val);
    }
    
}
?>