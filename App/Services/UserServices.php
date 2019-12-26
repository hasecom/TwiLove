<?php 
namespace App\Services;
require_once(__DIR__.'/../Connection/connection.php');
use App\Connection\Connection;
class UserService{
    //会員かどうかの確認
    public function isMember($param){
        $sql = null;
$sql.= <<< EOM
select 
    count(*) as CNT 
from
    users
where
    user_inner_id = :USER_INNER_ID
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param)[0];
    }
    //inner_idからcookie_keyを取得
    public function getCokkieById($param){
        $sql = null;
$sql.= <<< EOM
select
    cookie_key
from 
    users
where
    user_inner_id = :USER_INNER_ID 
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param)[0];
    }
    //ユーザの登録
    public function registUser($param){
        $sql = null;
$sql.= <<< EOM
INSERT INTO 
    users 
    (
        user_inner_id,
        user_display_id,
        user_name,
        access_token,
        access_token_secret,
        cookie_key
    ) 
VALUE 
    (
        :USER_INNER_ID, 
        :USER_DISPLAY_ID, 
        :USER_NAME, 
        :ACCESS_TOKEN, 
        :ACCESS_TOKEN_SECRET,
        :COOKIE_KEY
    )
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param);
    }
}
?>