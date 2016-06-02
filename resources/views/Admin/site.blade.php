
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Admin/css/adminSite.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/table.css') }}>
    <script src={{ asset('semantic/transition.js') }}></script>
    @yield('resources')

</head>

<body>

    <div class="menu-box">

        <div class="menu-logo">
            <img src="../Admin/img/logo.png">
        </div>

        <div class="admin-menu-list">
            <li class="menu-selected">
                <img src="../Admin/icon/home-select.png" name="home" style="draggable='false'">
                <span>首页</span>
            </li>
            <li>
                <img src="../Admin/icon/order.png" name="order">
                <span>订单处理</span>
            </li>
            <li>
                <img src="../Admin/icon/roomstatus.png" name="roomstatus">
                <span>房态维护</span>
            </li>
            <li>
                <img src="../Admin/icon/discount.png" name="discount">
                <span>优惠促销</span>
            </li>
            <li>
                <img src="../Admin/icon/menu-setting.png" name="menu-setting">
                <span>菜单设置</span>
            </li>
            <li >
                <img src="../Admin/icon/menu-setting.png" name="menu-setting">
                <span>酒店管理</span>
            </li>
        </div>

        

    </div>

    <div class="second-level-menu-box" one-level="">
        <li>
            <img src="../Admin/icon/todayorder.png" name="todayorder">
            <span>今日订单</span>
        </li>
    </div>

    <div class="breadcrumb">
        <img src="../Admin/icon/home-breadcrumb.png">
        <span>首页</span>
        <span class="breadcrumb-menu">
            
        </span>
    </div>






    <div class="center">
        @yield('content')
            <div class="padding-80">

            </div>

        {{--<div class="admin-copy-right">--}}
            {{--<span>全球精品酒店 版权所有 2016-2028 保留所有权利</span>--}}
            {{--<span>Copyright 2016-2028 Opulun.com All right reserved</span>--}}
        {{--</div>--}}
    </div>



   <!--  <div class="foot-box">

        </div> -->
    

</body>







@yield('script')

<script type="text/javascript">

    $(document).ready(function(){
        var selectimgname = 'home';
        var newimgname = 'home';


        $(".admin-menu-list > li").click(function(){
            var srcPath = '../Admin/icon/';

            selectimgname = $(".admin-menu-list .menu-selected > img").attr('name');
            $(".admin-menu-list .menu-selected > img").attr('src' , srcPath + selectimgname + '.png');
            $(".admin-menu-list .menu-selected").removeClass('menu-selected');

            $(this).addClass('menu-selected');
            newimgname = $(this).children('img').attr('name');
            $(this).children('img').attr('src' , srcPath + newimgname + '-select.png');

            if (newimgname === 'home') {
                $(".breadcrumb-menu").html('');
                $('.second-level-menu-box').transition('hide');
                return false;
            }

            $(".second-level-menu-box").attr('one-level' , $(this).children('span').html());

            if (selectimgname === newimgname) {
                $('.second-level-menu-box').transition('swing right');
            }else{
                $('.second-level-menu-box').transition('hide').transition('swing right');
            }

        })
        

        $(".second-level-menu-box > li").click(function(){
            var oneLevel = $(".second-level-menu-box").attr('one-level');
            var secondLevel = $(this).children('span').html();

            var rightImg = '<img src="../Admin/icon/breadcrumb-right.png" class="breadcrumb-right">';
            var oneLevelDocument = '<a class="breadcrumb-menu-text">'+oneLevel+'</a>';
            var secondLevelDocument = '<a class="breadcrumb-menu-text">'+secondLevel+'</a>';

            $(".breadcrumb-menu").html(rightImg + oneLevelDocument + rightImg + secondLevelDocument);

            $('.second-level-menu-box').transition('hide')

        })

        for(i in document.images)document.images[i].ondragstart=imgdragstart; 
    })


    
    function imgdragstart(){return false;} 
    
</script>

</html>
