<?php require_once(__DIR__ . '/../Components/Ready.php');
require_once(__DIR__.'/../../App/Helpers/TweetHelper.php'); 
use App\Helpers\TweetHelper;
$tweetHelper = new TweetHelper;
$isquota = $tweetHelper->IsQuota($userInfo['user_inner_id']);
?>
<!DOCTYPE html>
<html lang="ja">

<head>
  <?php require_once(__DIR__ . '/../Components/Header.php'); ?>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="./Views/Assets/Css/Favorite.css">
  <title>TwiLove</title>
</head>

<body>
  <div id="app">
    <?php require_once(__DIR__ . '/../Components/PageHeader.php'); ?>
    <div id="midashi" class="shadow">いいねをする</div>
    <div id="tweetWrap" class="px-1 py-3 shadow">
      <div class="px-3 py-2">{{tweet.tweet_content}}</div>
    </div>
    <?php if($isquota): ?>
                <div id="block_post">
                    <div id="block_key_wrap" class="">
                        <span class="small">いいねをリクエストできます。</span>
                        <div id="block_key"></div>
                    </div>
                </div>
    <?php endif; ?>
    <div id="controlWrap" class="mt-4">
      <div class="row margin_x_none">
        <div class="col-6 py-2 px-none">
          <button id="love" class="btn rounded-circle border bg-light shadow-lg pointer d-block" @click="loveClick"></button>
        </div>
        <div class="col-6 py-2 px-none">
          <button id="skip" class="btn rounded-circle border  bg-light shadow-lg pointer d-block"  @click="skipClick"></button>
        </div>
      </div>
    </div>
  </div>
</body>
<script type="module">
  import * as cookie from  './Views/Assets/Js/Cookie.js'
     var app = new Vue({
        el: "#app",
        data: {
          outputTweets:[],
          display_cnt:0,
          good_cnt:0,
          tweet:[],
          userInfo:[]
        },
        mounted(){
            this.screenFormat();
            this._mounted();
        },
        methods:{
            _mounted(){
                var this_ = this;
                var callback = function(res){ this_.outputTweet(res); };
                let params = new URLSearchParams();
                var val = cookie.getCookie('Twi-Love-key')
                params.append('COOKIE_KEY',val);
                var AjaxUrl = 'request/user/getfavoritetweet';
                this.Axios(AjaxUrl,callback,params);
            },
            screenFormat(){
                $('#app').width(window.innerWidth).height(window.innerHeight);
            },
            outputTweet(res){
              this.outputTweets = res['data']['TWEET'];
              this.tweet = res['data']['TWEET'][this.display_cnt];
              this.userInfo = res['data']['USER_INFO'];
            },
            loveClick(){
              //ボタンを非活性
              this.disabledBtn();
              if(9 <= this.good_cnt){
                this.finish_favorite();
                return false;
              }
              var this_ = this;
              var callback = function(res){ this_.loveClicked(res); };
              let params = new URLSearchParams();
              params.append('USER_INNER_ID',this.userInfo['user_inner_id']);
              params.append('TWIEET_ID', this.tweet['tweet_id']);
              params.append('COOKIE_KEY', this.userInfo['cookie_key']);
              var AjaxUrl = 'request/user/love';
              this.Axios(AjaxUrl,callback,params);
            },
            skipClick(){
              this.display_cnt = this.display_cnt + 1;
              this.tweet = this.outputTweets[this.display_cnt];
              if(9 <= this.display_cnt){
                this.display_cnt = 0;
                this._mounted();
              }
            },
            loveClicked(){
              this.abledBtn();
              this.display_cnt = this.display_cnt + 1;
              this.good_cnt = this.good_cnt + 1;
              this.tweet = this.outputTweets[this.display_cnt];
            },
            finish_favorite(){
              alert("いいねをリクエストできます。")
              location.reload();
            },
            disabledBtn(){
              $('#love').prop('disabled', true);
              $('#skip').prop('disabled', true);
            },
            abledBtn(){
              $('#love').prop('disabled', false);
              $('#skip').prop('disabled', false);
            },
            GetAxios(AjaxUrl,callback){
              axios.get(AjaxUrl)
              .then(res => {
                if(res.data['redirectUrl']){ location.href = res.data['redirectUrl'] }
                if(res.data['VALIDATION']){ window.alert(res.data['VALIDATION']); }
                callback(res);
              })
            },
            Axios(AjaxUrl,callback,params){
              axios.post(AjaxUrl,params)
              .then(res => {
                if(res.data['redirectUrl']){ location.href = res.data['redirectUrl'] }
                if(res.data['VALIDATION']){ window.alert(res.data['VALIDATION']); }
                callback(res);
              })
            }
        }
     });
</script>

</html>