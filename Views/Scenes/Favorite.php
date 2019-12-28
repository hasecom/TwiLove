<?php require_once(__DIR__ . '/../Components/Ready.php'); ?>
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
      <div>{{tweet.tweet_content}}</div>
    </div>
    <div id="controlWrap" class="my-3">
      <div class="row margin_none">
        <div class="col-6 py-2 px-none">
          <div id="love" class="rounded-circle border bg-light shadow-lg pointer"></div>
        </div>
        <div class="col-6 py-2 px-none">
          <div id="skip" class="rounded-circle border  bg-light shadow-lg pointer"></div>
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
          tweet:[]
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
              this.outputTweets = res['data'];
              this.tweet = res['data'][this.display_cnt];
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