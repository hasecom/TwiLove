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
$Routes->Action("SettingApp",$Domain.'/request/twitter/setting',"TwitterController",$_REQUEST);
?>