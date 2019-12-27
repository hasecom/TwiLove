<?php require_once(__DIR__.'/../Components/Ready.php'); ?>
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
        <div id="tweetWrap" class="px-4 py-3 shadow">
            <div class="tweet border py-2 px-2 my-2 shadow-sm" v-for="val,index in tweet" :key="val" :data-tweet="val" :id="'tweet_'+index"  @click="clickTweet(index)">
                <div class="pb-2">
                    <div class="d-inline-block">{{val.user.name}}</div>
                    <div class="d-inline-block small text-muted">@{{val.user.screen_name}}</div>
                </div>
                <div class="">{{val.text}}</div>
            </div>
        </div>
        <div id="selectBtn">
            <button type="button" id="selectBtnMain" @click="requestClick" class="btn btn-primary rounded-pill disabled">リクエスト</button>
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
                this.Axios(AjaxUrl,callback,val);
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
               console.log(this.tweet[id])
            },
            Axios(AjaxUrl,callback,val){
              let params = new URLSearchParams();
              params.append('COOKIE_KEY', val);
              axios.post(AjaxUrl,params)
              .then(res => {
                if(res.data['redirectUrl']){ location.href = res.data['redirectUrl'] }
                callback(res);
              })
            }
        }
     });
</script>
</html>