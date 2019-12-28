<?php 
namespace App\Helpers;
require_once(__DIR__.'/../Constants/Key.php');
require_once(__DIR__.'/../Services/TweetService.php');
use App\Constants\Key;
use App\Services\TweetService;
class TweetHelper {
   
    public function IsQuota($user_inner_id){
        $tweetService = new TweetService;
        //ノルマいいねを超えているか
        $user_inner_id = $user_inner_id;
        //自分のリクエストした投稿件数を取得
        $postCnt = $tweetService->isAllPost(['USER_INNER_ID'=>$user_inner_id]);
        //自分がいいねをした件数を取得
        $likeCnt = $tweetService->isAllLikeCnt(['USER_INNER_ID'=>$user_inner_id])['CNT'];
        $quotaCnt = ((int)$postCnt['CNT'])*((int)Key::$QuotaCnt);
        if($quotaCnt >= $likeCnt){
            return false;
        }
        return true;
    }
}
?>