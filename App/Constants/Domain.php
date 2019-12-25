<?php 
namespace App\Constants;
class Domain{

    public static $domain = '/TwiLove';
    public static $releaseDomain = '/TwiLove';
    public static function isLocal(){
        return $_SERVER['HTTP_HOST'] == 'localhost';
    }
}

?>