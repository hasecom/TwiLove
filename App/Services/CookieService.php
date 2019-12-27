<?php 
namespace App\Services;
require_once(__DIR__.'/../Connection/connection.php');
use App\Connection\Connection;
class CookieService{
    //クッキーIDからユーザ情報の取得
    public function getUserInfoByCookie($param){
        $sql = null;
$sql.= <<< EOM
select 
id,
user_inner_id,
user_display_id,
user_name,
cookie_key,
updated_at,
created_at
from
    users
where   
    cookie_key = :COOKIE_KEY
EOM;
        $connection =  new Connection();
        return $connection->con($sql,$param);
    }
    public function getAccessTokenByCookie($param){
        $sql = null;
$sql.= <<< EOM
select 
access_token,
access_token_secret
from
    users
where   
    cookie_key = :COOKIE_KEY
EOM;
        $connection =  new Connection();
        return $connection->con($sql,$param);
    }
}
?>