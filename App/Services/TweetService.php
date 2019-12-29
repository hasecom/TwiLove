<?php 
namespace App\Services;
require_once(__DIR__.'/../Connection/connection.php');
use App\Connection\Connection;
class TweetService{

    public function saveTweet($param){
        $sql = null;
$sql.= <<< EOM
INSERT INTO 
    request_tweet 
    (
        user_inner_id,
        user_display_id,
        tweet_id,
        tweet_content,
        user_icon_path,
        available,
        favorite_count,
        warn
    ) 
VALUE 
    (
        :USER_INNER_ID,
        :USER_DISPLAY_ID,
        :TWEET_ID,
        :TWEET_CONTENT,
        :USER_ICON_PATH,
        1,
        0,
        0
    )
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param);
    }
    public function isAllPost($param){
        $sql = null;
$sql.= <<< EOM
select
    count(*) as CNT
from 
    request_tweet
where
    user_inner_id = :USER_INNER_ID 
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param)[0];
    }
    public function isAllLikeCnt($param){
        $sql = null;
$sql.= <<< EOM
select
    count(*) as CNT
from 
    favorite
where
    user_inner_id = :USER_INNER_ID 
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param)[0];
    }
    public function favoriteTweet($param){
        $sql = null;
$sql.= <<< EOM
select
    tweet_content,
    tweet_id
from 
  request_tweet
where
  available = 1 AND user_inner_id != :USER_INNER_ID
 order by
 favorite_count
 limit 10
EOM;
    $connection =  new Connection();
    return $connection->con($sql,$param);
    }
}
?>