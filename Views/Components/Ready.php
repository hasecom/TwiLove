<?php 
require_once(__DIR__.'/../../App/Helpers/CookieHelper.php');
use App\Helpers\CookieHelper;
//クッキーのチェックをします。
$cookieHelper = new CookieHelper;
$userInfo = null;
if($cookieHelper->isSetCookie){
    //ユーザ情報の取得
    $userInfo = $cookieHelper->getUserInfoByCookie();
}
?>