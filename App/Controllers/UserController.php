<?php 
namespace App\Controllers;

require_once(__DIR__.'/../Configuration.php');
require_once(__DIR__.'/../Twitter/TwitterOAuth.php');
require_once(__DIR__.'/../Auth/Session.php');
require_once(__DIR__.'/../Services/UserServices.php');
require_once(__DIR__.'/CookieController.php');
require_once(__DIR__.'/../Constants/Domain.php');

use App\Twitter\Abraham\TwitterOAuth\TwitterOAuth;
use App\Auth\Session;
use App\Configuration;
use App\Services\UserService;
use App\Controllers\CookieController;
use App\Constants\Domain;

//Twitterと連携します。
class UserController{

    public function LoginOrRegist(){
        $CONSUMER_KEY = Configuration::get('CONSUMER_KEY');
        $CONSUMER_SECRET = Configuration::get('CONSUMER_SECRET');

        $twAccessToken = Session::get('twAccessToken');
        $twOauthToken = $twAccessToken['oauth_token'];
        $twOauthTokenSecret = $twAccessToken['oauth_token_secret'];
        $objTwitterConection = new TwitterOAuth
        (
            $CONSUMER_KEY,
            $CONSUMER_SECRET,
            $twOauthToken,
            $twOauthTokenSecret
        );
        $userInfo = $objTwitterConection->get("account/verify_credentials");
        $user_name = $userInfo->name;
        $user_inner_id = $userInfo->id;
        $user_display_id = $userInfo->screen_name;
        $userService = new UserService;
        $setCookieKey = "";
        $cookieController = new CookieController;
        //ユーザ情報が登録されていないか
        if($userService->isMember(['USER_INNER_ID'=>$user_inner_id])['CNT'] == 0){
            //クッキーの生成
            $cookieKey = $cookieController->GenerateCokkie($user_inner_id);
            //ユーザの登録
            $registParam = [
                'USER_INNER_ID'=>$user_inner_id,
                'USER_DISPLAY_ID'=>$user_display_id,
                'USER_NAME'=>$user_name,
                'ACCESS_TOKEN'=>$twOauthToken,
                'ACCESS_TOKEN_SECRET'=>$twOauthTokenSecret,
                'COOKIE_KEY'=>$cookieKey
            ];
            $userService->registUser($registParam);
            $setCookieKey = $cookieKey;
        }else{
            //user_inner_idからクッキーを取得
            $cookieKey = $userService->getCokkieById(['USER_INNER_ID'=>$user_inner_id]);
            $setCookieKey = $cookieKey;
        }
        $cookieController->RegistCookie($setCookieKey['cookie_key']);
        $Domain = Domain::isLocal() ? Domain::$domain : Domain::$releaseDomain;
        header( 'location:'.$Domain.'/post' );
    }
}
?>