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
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.min.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
    <script src={{ asset('semantic/transition.js') }}></script>
    {{--<link rel="stylesheet" type="text/css" href="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.6/semantic.min.css"/>--}}
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/semantic-ui/1.11.6/semantic.min.js"></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/divider.css') }}>

    @yield('resources')

</head>

<body>

<div class="menu-box" id="menuBox">
    {{--<div class="menu_"></div>--}}
    <div class="menu-logo">
        <img src="/Admin/img/logo.png">

    </div>

    <div class="menu-top">
        <span><img src="/Admin/img/boys.png"></span>
        <p>管理员{{ Session::get('adminusername') }}</p>
    </div>

    <div class="admin-menu-list">

        <ul class="header-menu">

            <li>
                <a href="{{ url('/admin/AdminCenter') }}">
                    <img src="/Admin/icon/menu/home.png" class="home">
                    {{--<i class="home icon"></i>--}}
                    <span>首页</span>
                </a>
            </li>
            @foreach($allMenuList as $firstMenuLists)
                @foreach($firstMenuLists as $firstMenuList)
            <li>
                @if(session('currentPath_') && (session('currentPath_') === $firstMenuList->menu_chaining))
                    <div href="{{url($firstMenuList->menu_chaining)}} " value="{{ count($firstMenuList->secondMenu) }}" redirect="false" class="currentNav currentPath">
                        <span class="pathNav"></span>
                        <img src="{{$firstMenuList->icon_img_1}}">
                        <span>{{$firstMenuList->menu_name}}</span>
                        @if(count($firstMenuList->secondMenu) > 0)
                            <i class="angle left icon"></i>
                        @endif
                    </div>
                @else
                    <div href="{{url($firstMenuList->menu_chaining)}} " value="{{ count($firstMenuList->secondMenu) }}" redirect="false" class="currentNav">
                        <span class="choiceNav"></span>
                        <img src="{{$firstMenuList->icon_img_1}}">
                        <span>{{$firstMenuList->menu_name}}</span>
                        @if(count($firstMenuList->secondMenu) > 0)
                            <i class="angle left icon"></i>
                        @endif
                    </div>
                @endif

                <ul class="subMenu navContent secondMenu">
                    @if(count($firstMenuList->secondMenu) > 0)
                        @foreach($firstMenuList->secondMenu as $key => $secondMenuList)
                            @if(session($secondMenuList->id) == $secondMenuList->id)
                                @if(session('currentPath_') && (session('currentPath_') === $secondMenuList->menu_chaining))
                                    <input type="hidden" name="sessionId" id="sessionId" value="{{session($secondMenuList->id)}}">
                                    <li>
                                        <a href="{{url($secondMenuList->menu_chaining)}}" session="{{ session('currentPath_') }}" class="secondNav Nav_">{{ $secondMenuList->menu_name }}</a>

                                    </li>
                                @else
                                    <li>
                                        <a href="{{url($secondMenuList->menu_chaining)}}" session="#" class="Nav_">{{ $secondMenuList->menu_name }}</a>
                                    </li>
                                @endif
                            @endif
                        @endforeach

                    @endif
                </ul>


            </li>
            @endforeach
            @endforeach

        </ul>

    </div>

</div>


<div class="center" id="centerBox">
    <div class="content-header">
        <ul>
            <li><a href="#">查看日志</a></li>
            <li><a href="#">系统设置</a></li>
            <li class="user-action user-choice">
                <i class="angle right icon"></i>
                <a href="#" class="user-down">用户</a>
                <ul class="user-nav">
                    <li><a href="{{url('/admin/logout')}}">退出</a></li>
                    <li style="margin-top: 4px;"><a href="#">设置</a></li>
                </ul>
            </li>
        </ul>
    </div>
    @yield('content')
    <div class="padding-80">

    </div>

</div>


    <div class="alert-box" id="alertBox"></div>


</body>



@yield('script')

<script type="text/javascript">
    $(document).ready(function() {

        //下拉选中效果
        if ($(".Nav_").hasClass('secondNav')) {
            $(".currentNav").children('i.left').addClass('open-menu');
            $(".secondNav").parent().parent().removeClass('secondMenu');
        }

        //menu下拉
        $(".currentNav").click(function () {

            var secondCount = $(this).attr('value');
            var href_ = $(this).attr('href');

            if (secondCount > 0) {
                $("#menuBox").css('height',900);  //菜单高度变化
                $(this).toggleClass("menu-down").siblings(".currentNav").removeClass("menu-up");  //第一次下拉的样式

                $(this).toggleClass("menu-up").siblings(".currentNav").removeClass("menu-down");  //再次点击的样式
            } else {
                window.location.href = href_;
            }

            //控制箭头样式
            if ($(this).children('i.left').hasClass('open-menu')) {
                $(this).children('i.left').removeClass('open-menu');
            } else {
                $(this).children('i.left').addClass('open-menu');
            }


            $(this).next(".navContent").slideToggle(500).siblings(".navContent").slideUp(500);  //下一级元素下滑速度

        });


        //user
        $(".user-choice").hover(
                function () {
                    $(".user-nav").slideDown(200);
                    $(this).children('i.right').addClass('nav-down');
                },
                function () {
                    $(".user-nav").slideUp(200);
                    $(this).children('i.right').removeClass('nav-down');
                }
        );

        //自适应高度
        function AdjustHeight() {

            var heightContent = document.getElementById('centerBox').offsetHeight;

            var heightMenu = document.getElementById('menuBox').offsetHeight;

            if (heightMenu < heightContent) {

                $('#menuBox').css('height',heightContent+60);

            }

        }

        AdjustHeight();


    });

    function imgdragstart(){return false;}

    function alertBox(check)
    {

        $('.require').each(function(){
            if($(this).val() == '')
            {
                var content = $(this).attr('data-input')+'不能为空';
                $('#alertBox').text(content).fadeIn();
                //$(this).removeClass('wrong-input');
                setTimeout(function () {
                    $('#alertBox').text(content).fadeOut();
                    //$(this).removeClass('wrong-input');
                }, 2000);
                check=false;
                return false;
            }
        })
        return check;
    }

    function toastAlert(Msg,status)
    {

        if(status === 1)
        {
            $('#alertBox').removeClass('success-toast').addClass('success-toast');
        }
        $('#alertBox').text(Msg).fadeIn();

        setTimeout(function () {
            $('#alertBox').fadeOut();
        }, 2000);
    }

</script>

</html>