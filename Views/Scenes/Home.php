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