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
        <h2 class="title Anton">Twi-Love</h2>
        <div class="description">- いいねをしあうWebサービス -</div>
        <div class="login_btn pointer">
            <button class="btn btn twitter_btn rounded-pill shadow-lg" @click="callTwitterApp">Twitterで登録・ログインする</button>
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
        },
        methods:{
            screenFormat(){
                $('#app').width(window.innerWidth).height(window.innerHeight);
                $('.login_btn').css('top',window.innerHeight/2);
            },
            callTwitterApp(){
                location.href="request/twitter/req"
            }
        }
     });
</script>
</html>