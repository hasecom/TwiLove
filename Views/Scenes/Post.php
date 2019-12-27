<?php require_once(__DIR__.'/../Components/Ready.php'); ?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <?php require_once(__DIR__.'/../Components/Header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Views/Assets/Css/Index.css">
    <title>TwiLove</title>
</head>
<body>
    <div id="app">
        <?php require_once(__DIR__.'/../Components/PageHeader.php'); ?>
    </div>
</body>
<script type="module">
    import * as cookie from  './Views/Assets/Js/Cookie.js'
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
                console.log();
                var this_ = this;
                var callback = function(res){ this_.setTweet(); };
                var val = cookie.getCookie('Twi-Love-key')
                var AjaxUrl = 'request/user/gettweet';
                this.Axios(AjaxUrl,callback,val);
            },
            screenFormat(){
                $('#app').width(window.innerWidth).height(window.innerHeight);
                $('.login_btn').css('top',window.innerHeight/2);
            },
            setTweet(){

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