<?php require_once(__DIR__ . '/../Components/Ready.php'); ?>
<!DOCTYPE html>
<html lang="ja">

<head>
    <?php require_once(__DIR__ . '/../Components/Header.php'); ?>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./Views/Assets/Css/Index.css">
    <title>TwiLove</title>
</head>

<body>
    <div id="app">
        <?php require_once(__DIR__ . '/../Components/PageHeader.php'); ?>
        <div class="card my-3 px-4 py-2 text-center" id="my_card">
            <p class="text-center">ログインユーザ</p>
            <div>
                <?php echo $userInfo['user_name']; ?>
            </div>
            <div class="text-muted small">
                @<?php echo $userInfo['user_display_id']; ?>
            </div>
        </div>
        <div class="text-center">
            <div class="my-3">
                <button class="btn btn-success" @click="location.href='./post'">いいねをリクエスト</button>
            </div>
            <div class="my-3">
                <button class="btn btn-success" @click="location.href='./favorite'">いいねをする</button>
            </div>
        </div>
        <div class="bg-light mx-5 card py-4 px-3">
            <div class="text-center pb-2">使い方</div>
            <ul>
                <li>いいねを10件する</li>
                <li>いいねをリクエスト</li>
                <li>いいねをもらう！</li>
            </ul>
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