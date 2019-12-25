<?php 
namespace App\Controllers;

require_once(__DIR__.'/../Configuration.php');
require_once(__DIR__.'/../Twitter/TwitterOAuth.php');
require_once(__DIR__.'/../Auth/Session.php');
require_once(__DIR__.'/../Constants/Domain.php');
use App\Twitter\Abraham\TwitterOAuth\TwitterOAuth;
use App\Configuration;
use App\Auth\Session;
use App\Constants\Domain;
//Twitterと連携します。
class TwitterController{
    //連携を押したときの処理です。
    public function CooperationApp(){
        $CONSUMER_KEY = Configuration::get('CONSUMER_KEY');
        $CONSUMER_SECRET = Configuration::get('CONSUMER_SECRET');
        $OAUTH_CALLBACK  = Configuration::get('OAUTH_CALLBACK');
    
        //TwitterOAuthクラスをインスタンス化
        $objTwitterConection = new TwitterOAuth($CONSUMER_KEY, $CONSUMER_SECRET);
        
        //oauthリクエストトークンの取得
        $aTwitterRequestToken = $objTwitterConection->oauth('oauth/request_token', array('oauth_callback' => $OAUTH_CALLBACK));
        $oauth_token = $aTwitterRequestToken['oauth_token'];
        $oauth_token_sercret = $aTwitterRequestToken['oauth_token_secret'];
        //oauthリクエストトークンをセッションに格納
        Session::set('twOauthToken',$oauth_token);
        //Twitter認証URLの作成
        $sTwitterRequestUrl = $objTwitterConection->url('oauth/authenticate', array('oauth_token' => $oauth_token));
        //Twitter.com の認証画面へリダイレクト
        header('Location:'.$sTwitterRequestUrl);
    }
    public function CallbackApp(){

        $CONSUMER_KEY = Configuration::get('CONSUMER_KEY');
        $CONSUMER_SECRET = Configuration::get('CONSUMER_SECRET');
   
        // oauthトークン確認
        if(empty(Session::get('twOauthToken')) || empty(Session::get('twOauthTokenSecret')) || empty($_REQUEST['oauth_token']) || empty($_REQUEST['oauth_verifier'])){
            echo 'error token!!';
            exit;
        }
        if(Session::get('twOauthToken') !== $_REQUEST['oauth_token']) {
            echo 'error token incorrect!!';
            exit;
        }
            
        //取得したoauthトークンでTwitterOAuthクラスをインスタンス化
        $objTwitterConection = new TwitterOAuth
            (
            $CONSUMER_KEY,
            $CONSUMER_SECRET,
            Session::get('twOauthToken'),
            Session::get('twOauthTokenSecret')
            );
            
        //アクセストークンの取得
        $accessToken = $objTwitterConection->oauth("oauth/access_token", array("oauth_verifier" => $_REQUEST['oauth_verifier']));
        Session::set('twAccessToken',$accessToken);
        $Domain = Domain::isLocal() ? Domain::$domain : Domain::$releaseDomain;
        //マイページへリダイレクト
        header( 'location:'.$Domain.'/' );
    }
}
?>