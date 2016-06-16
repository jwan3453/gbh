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
        <img src="/Admin/img/logo.png">
    </div>

    <div class="admin-menu-list">
        <li href="admin/AdminCenter" name="home" onclick="firstMenuClick(this)">
            <img src="/Admin/icon/home-select.png" name="home" style="draggable='false'">
            <span>首页</span>
        </li>
        <li href="admin/menuSetting" name="menu-setting" onclick="firstMenuClick(this)">
            <img src="/Admin/icon/menu-setting.png" name="menu-setting">
            <span>菜单设置</span>
        </li>
    </div>



</div>

<div class="second-level-menu-box" one-level="">
    <!-- <li onclick="secondMenuClick(this)">
        <img src="/Admin/icon/todayorder.png" name="todayorder">
        <span>今日订单</span>
    </li> -->
</div>

<div class="breadcrumb">
    <img src="/Admin/icon/home-breadcrumb.png">
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



</body>



@yield('script')

<script type="text/javascript">
    $(document).ready(function(){
        if (sessionStorage.getItem("breadcrumb") != null) {
            $(".breadcrumb-menu").html(sessionStorage.getItem("breadcrumb"));
        }
        $.ajax({
            type: 'POST',
            url: '/admin/menuSetting/getFirstMenu',
            data: {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data){
                var menuList = '';
                for (var i = 0; i < data.length; i++) {
                    // console.log(data[i]);
                    menuList += '<li href="'+data[i].menu_chaining+'" name="'+data[i].menu_name_eg+'" onclick="firstMenuClick(this)" menuId="'+data[i].id+'">';
                    menuList += '<img src="'+data[i].icon_img_1+'" name="'+data[i].menu_name_eg+'">';
                    menuList += '<span>'+data[i].menu_name+'</span>';
                    menuList += '</li>';
                }
                $('.admin-menu-list').children().eq(0).after(menuList);
                //------验证本地存储中的菜单名----------
                if (sessionStorage.getItem("clickMenuImgName") != null) {
                    $(".admin-menu-list").find("li[name='"+sessionStorage.getItem("clickMenuImgName")+"']").children("img").attr('src','/Admin/icon/'+sessionStorage.getItem("clickMenuImgName")+'-select.png');
                    $(".admin-menu-list").find("li[name='"+sessionStorage.getItem("clickMenuImgName")+"']").addClass("menu-selected");
                }
            }
        })
        for(i in document.images)document.images[i].ondragstart=imgdragstart;
    })

    var selectimgname = 'home';
    var newimgname = 'home';

    function firstMenuClick(_this) {
        var srcPath = '/Admin/icon/';
        //----将已选中的一级菜单文字颜色及图片切换为未选中的-----
        selectimgname = $(".admin-menu-list .menu-selected > img").attr('name');
        $(".admin-menu-list .menu-selected > img").attr('src' , srcPath + selectimgname + '.png');
        $(".admin-menu-list .menu-selected").removeClass('menu-selected');
        //----将当前选中的一级菜单文字颜色及图片切换为已选中的-------
        $(_this).addClass('menu-selected');
        newimgname = $(_this).children('img').attr('name');
        $(_this).children('img').attr('src' , srcPath + newimgname + '-select.png');
        //-----如果点击的是首页则直接跳转------
        if (newimgname === 'home') {
            // console.log($(_this).attr('href'));
            sessionStorage.removeItem("breadcrumb");
            sessionStorage.setItem("clickMenuImgName", "home");
            location.href = '/'+$(_this).attr('href');
            $(".breadcrumb-menu").html('');
            $('.second-level-menu-box').transition('hide');
            return false;
        }
        //---将一级菜单名称填充入二级菜单dom中--------
        $(".second-level-menu-box").attr('one-level' , $(_this).children('span').html());


        $.ajax({
            type: 'POST',
            url: '/admin/menuSetting/getSecondMenu',
            data: {menuId : $(_this).attr('menuId')},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data){
            var secondMenuList = '';
                for (var i = 0; i < data.getSecondMenu.length; i++) {
                    secondMenuList += '<li href="'+data.getSecondMenu[i].menu_chaining+'" onclick="secondMenuClick(this)">';
                    secondMenuList += '<img src="'+data.getSecondMenu[i].icon_img_1+'" name="todayorder">';
                    secondMenuList += '<span>'+data.getSecondMenu[i].menu_name+'</span>';
                    secondMenuList += '</li>';
                }
                $(".second-level-menu-box").html(secondMenuList);
            }
        })

        if (selectimgname === newimgname) { //--如果选中同一个菜单则收起二级菜单

            if ($(_this).attr('href') == '' || $(_this).attr('href') == 'undefined') {
                $('.second-level-menu-box').transition('swing right');
            }
            else{
                var rightImg = '<img src="/Admin/icon/breadcrumb-right.png" class="breadcrumb-right">';
                var oneLevelDocument = '<a class="breadcrumb-menu-text">'+$(_this).children("span").html()+'</a>';
                sessionStorage.setItem("breadcrumb", rightImg + oneLevelDocument);
                location.href = '/'+$(_this).attr('href');
            }


        }else{
            //------将菜单名存入本地存储-------------
            sessionStorage.setItem("clickMenuImgName", $(_this).attr('name'));
            // console.log($(_this).attr('menuId'));
            
            if ($(_this).attr('href') == '' || $(_this).attr('href') == 'undefined') {
                $('.second-level-menu-box').transition('hide').transition('swing right');
            }
            else{
                var rightImg = '<img src="/Admin/icon/breadcrumb-right.png" class="breadcrumb-right">';
                var oneLevelDocument = '<a class="breadcrumb-menu-text">'+$(_this).children("span").html()+'</a>';
                sessionStorage.setItem("breadcrumb", rightImg + oneLevelDocument);
                location.href = '/'+$(_this).attr('href');
            }
        }
    }

    function secondMenuClick(_this) {
        console.log($(_this).attr('href'));
        var oneLevel = $(".second-level-menu-box").attr('one-level');
        var secondLevel = $(_this).children('span').html();
        var rightImg = '<img src="/Admin/icon/breadcrumb-right.png" class="breadcrumb-right">';
        var oneLevelDocument = '<a class="breadcrumb-menu-text">'+oneLevel+'</a>';
        var secondLevelDocument = '<a class="breadcrumb-menu-text">'+secondLevel+'</a>';
        $(".breadcrumb-menu").html(rightImg + oneLevelDocument + rightImg + secondLevelDocument);
        sessionStorage.setItem("breadcrumb", rightImg + oneLevelDocument + rightImg + secondLevelDocument);
        //-------收起二级菜单------
        $('.second-level-menu-box').transition('hide');
        location.href = '/'+$(_this).attr('href');
    }

    function imgdragstart(){return false;}
</script>

</html>