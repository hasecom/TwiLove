<?php 
namespace Routes;
require_once(__DIR__.'/routes.php');
require_once(__DIR__.'/../App/Constants/Domain.php');
use Routes\Routes;
use App\Constants\Domain;
$Routes =new Routes;
$Domain = Domain::isLocal() ? Domain::$domain : Domain::$releaseDomain;

$Routes->Action("CooperationApp",$Domain.'/request/twitter/req',"TwitterController",$_REQUEST);
$Routes->Action("CallbackApp",$Domain.'/request/twitter/callback',"TwitterController",$_REQUEST);
$Routes->Action("LoginOrRegist",$Domain.'/request/user/setting',"UserController",$_REQUEST);
$Routes->Action("GetTweet",$Domain.'/request/user/gettweet',"UserController",$_REQUEST);
$Routes->Action("SaveTweet",$Domain.'/request/user/savetweet',"UserController",$_REQUEST);
$Routes->Action("GetFavoriteTweet",$Domain.'/request/user/getfavoritetweet',"UserController",$_REQUEST);
?>