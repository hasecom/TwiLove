<?php require_once(__DIR__.'/../Components/Ready.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php require_once(__DIR__.'/../Components/Header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Views/Assets/Css/Favorite.css">
    <title>TwiLove</title>
</head>
<body>
<div id="app">
        <?php require_once(__DIR__.'/../Components/PageHeader.php'); ?>
        <div id="midashi" class="shadow">いいねをする</div>
        <div id="tweetWrap" class="px-1 py-3 shadow"> 
        </div>
    </div>
</body>
<script type="module">
     var app = new Vue({
        el: "#app",
        data: {
            
        },
        mounted(){
            this.screenFormat();
            this._mounted();
        },
        methods:{
            _mounted(){
                var this_ = this;
                var callback = function(res){ this_.outputTweet(res); };
                var AjaxUrl = 'request/user/getfavoritetweet';
                this.GetAxios(AjaxUrl,callback);
            },
            screenFormat(){
                $('#app').width(window.innerWidth).height(window.innerHeight);
            },
            outputTweet(res){
                console.log(res)
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