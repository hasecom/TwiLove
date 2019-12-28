<?php 
namespace App\Controllers;

require_once(__DIR__.'/../Configuration.php');
require_once(__DIR__.'/../Twitter/TwitterOAuth.php');
require_once(__DIR__.'/../Auth/Session.php');
require_once(__DIR__.'/../Services/UserServices.php');
require_once(__DIR__.'/../Services/CookieService.php');
require_once(__DIR__.'/../Services/TweetService.php');
require_once(__DIR__.'/CookieController.php');
require_once(__DIR__.'/../Constants/Domain.php');
require_once(__DIR__.'/../Constants/Key.php');

use App\Twitter\Abraham\TwitterOAuth\TwitterOAuth;
use App\Auth\Session;
use App\Configuration;
use App\Services\UserService;
use App\Services\CookieService;
use App\Services\TweetService;
use App\Controllers\CookieController;
use App\Constants\Domain;
use App\Constants\Key;

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
            $setCookieKey = $cookieKey['cookie_key'];
        }
        $cookieController->RegistCookie($setCookieKey);
        $Domain = Domain::isLocal() ? Domain::$domain : Domain::$releaseDomain;
        header( 'location:'.$Domain.'/home' );
    }
    public function GetTweet($request){
        $cookieService = new CookieService;
        $accessArr = $cookieService->getAccessTokenByCookie(['COOKIE_KEY'=>$request['COOKIE_KEY']]);
        //リクエストされたCookieKeyが不正であればトップに返す
        if($accessArr == null) echo json_encode(["redirectUrl"=>"./"]);

        $CONSUMER_KEY = Configuration::get('CONSUMER_KEY');
        $CONSUMER_SECRET = Configuration::get('CONSUMER_SECRET');
        $accessToken = $accessArr[0]['access_token'];
        $accessTokenSecret = $accessArr[0]['access_token_secret'];
        $objTwitterConection = new TwitterOAuth
        (
            $CONSUMER_KEY,
            $CONSUMER_SECRET,
            $accessToken,
            $accessTokenSecret
        );
        $user_params = ['count' => '15'];
        $userInfo = $objTwitterConection->get('statuses/user_timeline', $user_params);
        echo json_encode($userInfo);
    }
    public function SaveTweet($request){
        $tweetService = new TweetService;

        //ノルマいいねを超えているか
        $user_inner_id = $this->h($request['USER_INNER_ID']);
        //自分のリクエストした投稿件数を取得
        $postCnt = $tweetService->isAllPost(['USER_INNER_ID'=>$user_inner_id]);
        //自分がいいねをした件数を取得
        $likeCnt = $tweetService->isAllLikeCnt(['USER_INNER_ID'=>$user_inner_id])['CNT'];
        $quotaCnt = ((int)$postCnt['CNT'])*((int)Key::$QuotaCnt);
        if($quotaCnt >= $likeCnt){
            echo json_encode(['VALIDATION' => 'ノルマいいねが達成されていません。']);
            die; 
        }
        //鍵垢ではないか
        if($this->h($request['PROTECTED'])){
            echo json_encode(['VALIDATION' => '鍵アカウントの投稿はできません。']);
            die;
        }

        //ツイート保存処理
        $params = [
            "USER_INNER_ID"=>$this->h($request['USER_INNER_ID']),
            "USER_DISPLAY_ID"=>$this->h($request['USER_DISPLAY_ID']),
            "TWEET_ID"=>$this->h($request['TWEET_ID']),
            "TWEET_CONTENT"=>$this->h($request['TWEET_CONTENT']),
            "USER_ICON_PATH"=>$this->h($request['USER_ICON_PATH']),
        ];
        
        $tweetService->saveTweet($params); 

    }
    private function h($val){
        return htmlspecialchars($val);
    }
    public function GetFavoriteTweet(){
        $tweetService = new TweetService;
        //言い値の少ない投稿10件数を取得
        //$postCnt = $tweetService->isAllPost();
    }

    
}
?>