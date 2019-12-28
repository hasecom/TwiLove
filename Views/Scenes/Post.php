<?php 
require_once(__DIR__.'/../Components/Ready.php'); 
require_once(__DIR__.'/../../App/Helpers/TweetHelper.php'); 
use App\Helpers\TweetHelper;
$tweetHelper = new TweetHelper;
$isquota = $tweetHelper->IsQuota($userInfo['user_inner_id']);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php require_once(__DIR__.'/../Components/Header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Views/Assets/Css/Post.css">
    <title>TwiLove</title>
</head>
<body>
    <div id="app">
        <?php require_once(__DIR__.'/../Components/PageHeader.php'); ?>
        <div id="midashi" class="shadow">いいねをリクエスト</div>
        <?php if(!$isquota): ?>
                <div id="block_post">
                    <div id="block_key_wrap" class="">
                        <span class="small">いいねをしてください。</span>
                        <div id="block_key"></div>
                    </div>
                </div>
        <?php endif; ?>
        <div id="tweetWrap" class="px-1 py-3 shadow">
            <div class="tweet border py-2 px-2 my-2 shadow-sm" v-for="val,index in tweet" :key="val" :data-tweet="val" :id="'tweet_'+index"  @click="clickTweet(index)">
                <div class="pb-2">
                    <div class="d-inline-block">{{val.user.name}}</div>
                    <div class="d-inline-block small text-muted">@{{val.user.screen_name}}</div>
                </div>
                <div class="">{{val.text}}</div>
            </div>
        </div>
        <div id="selectBtn">
            <button type="button" id="selectBtnMain" @click="requestClick" class="btn btn-primary rounded-pill disabled shadow">リクエスト</button>
        </div>
    </div>
</body>
<script type="module">
    import * as cookie from  './Views/Assets/Js/Cookie.js'
     var app = new Vue({
        el: "#app",
        data: {
            tweet:[],
            selectId:""
        },
        mounted(){
            this.screenFormat();
            this._mounted();
        },
        methods:{
            _mounted(){
                var this_ = this;
                var callback = function(res){ this_.setTweet(res); };
                var val = cookie.getCookie('Twi-Love-key')
                var AjaxUrl = 'request/user/gettweet';
                let params = new URLSearchParams();
                params.append('COOKIE_KEY', val);
                this.Axios(AjaxUrl,callback,params);
            },
            screenFormat(){
                $('#app').width(window.innerWidth).height(window.innerHeight);
                $('.login_btn').css('top',window.innerHeight/2);
            },
            setTweet(res){
                this.tweet = res['data'];
            },
            clickTweet(id){
                this.selectId = id;
                $('div[id^="tweet_"]').removeClass("select");
                $("#tweet_"+id).addClass("select");
                $("#selectBtnMain").removeClass('disabled')
            },
            requestClick(){
               var id = this.selectId
               var protected_ = this.tweet[id]['user']['protected'];
               var user_inner_id = this.tweet[id]['user']['id_str'];
               var user_display_id = this.tweet[id]['user']['screen_name'];
               var user_icon_path = "";
               var tweet_id = this.tweet[id]['id_str'];
               var tweet_content = this.tweet[id]['text'];
               var this_ = this;
               var callback = function(res){ this_.savedtweet(res); };
               var val = cookie.getCookie('Twi-Love-key')
               var AjaxUrl = 'request/user/savetweet';
               let params = new URLSearchParams();
               params.append('PROTECTED', protected_);
               params.append('USER_INNER_ID', user_inner_id);
               params.append('USER_DISPLAY_ID', user_display_id);
               params.append('TWEET_ID', tweet_id);
               params.append('TWEET_CONTENT', tweet_content);
               params.append('USER_ICON_PATH', user_icon_path);
               this.Axios(AjaxUrl,callback,params);
            },
            savedtweet(){

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