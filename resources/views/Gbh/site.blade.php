
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

    <script src={{ asset('Gbh/js/site.min.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/site.min.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>
    @yield('resources')

</head>

<body >

        <div class="ui sidebar right   mobile-side-bar">
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
        <div class="page pusher" style="min-height:500px;">
            @yield('content')
        </div>



        <div class="foot-box">

            <span class="up">全球精品酒店 版权所有 2016-2028 保留所有权利</span>
            <span class="down">Copyright 2016-2028 Opulun.com All right reserved</span>
            <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259646848'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1259646848%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
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
