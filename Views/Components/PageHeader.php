<header class="sticky-top bg-light _header">
    <div class="py-2 text-center row margin_none">
        <div class="col-3"></div>
        <div class="col-6">
            <h2 class="Anton">Twi-Love</h2>
        </div>
        <div class="col-3">
            <div class="d-inline pointer" id="side_bar" onClick='ClickSideBar()'></div>
        </div>
    </div>
</header>
<div id="side_menu_wrap" class="d-none">
    <div id="side_menu" class="text-light">
        <ul class="d-none">
            <li class="py-3 pointer" onClick="location.href='./home'">ホーム</li>
            <li class="py-3 pointer" onClick="location.href='./post'">いいねをリクエスト</li>
            <li class="py-3 pointer">いいねをする</li>
        </ul>
    </div>
</div>
<script>
    var toggle = 0;
    function ClickSideBar(){
        if(toggle == 0){
            $('#side_menu_wrap').removeClass("d-none");
            $("#side_menu").animate({
                "width":"80%",
            },"slow","swing",function(){
                $("#side_menu ul").removeClass('d-none').fadeIn(1000);
            })
            toggle = 1;
        }else{
            $("#side_menu ul").addClass('d-none').fadeOut(1000);
            $("#side_menu").animate({
                "width":"0%",
            },"slow","swing",function(){
                $('#side_menu_wrap').addClass("d-none");
            })
            toggle = 0;
        }
    }
    $(document).on('click','#side_menu_wrap',function(e){
        if($(this)[0] != e.target) return false;
        ClickSideBar();
});
</script>