
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
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
    <script src={{ asset('semantic/transition.js') }}></script>



    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sidebar.css') }}>
    <script src={{ asset('semantic/sidebar.js') }}></script>

    @yield('resources')

</head>

<body>

        <div class="page">
            @yield('content')

            <div class="ui sidebar   mobile-side-bar">
                <a class="" href="/">
                  <i class="icon home large"></i>首页
                </a>
                <a class=""  href="/newArticles">
                    <i class="icon home large"></i>最新文章
                </a>
                <a class="" href="/aboutUs">
                    <i  class="icon home large"></i>关于我们
                </a>
                <a class="">
                    <i class="icon home large"></i>酒店预定
                </a>
            </div>
        </div>
        <div class="foot-box">
            <span class="up">全球精品酒店 版权所有 2016-2028 保留所有权利</span>
            <span>Copyright 2016-2028 Opulun.com All right reserved</span>
        </div>


</body>







@yield('script')

<script type="text/javascript">

    $(document).ready(function(){

        $('.sidebar').click(function(){
            $('.ui.sidebar')
                    .sidebar('toggle')
            ;
        })
    })


</script>

</html>
