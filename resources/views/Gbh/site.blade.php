
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

    {{--<link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.min.css') }}>--}}

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sidebar.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/popup.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sticky.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/css3nav/styles.css') }}>

    @yield('resources')

</head>

<body >

        {{--<div class="ui sidebar right   mobile-side-bar">--}}
            {{--<a class="" href="/">--}}
               {{--首页--}}
            {{--</a>--}}
            {{--<a class=""  href="/newArticles">--}}
               {{--最新文章--}}
            {{--</a>--}}
            {{--<a class="" href="/aboutUs">--}}
                {{--关于我们--}}
            {{--</a>--}}
            {{--<a href="/booking">--}}
                {{--酒店预定--}}
            {{--</a>--}}
        {{--</div>--}}

        <div style="position:relative" id="contentSection">


            <div class="site-header  ">

                <div class="logo">
                </div>



                <div class="site-menu-nav">

                    <div>
                        <a  href="/">
                            <span>首页</span>
                        </a>
                        <a href="/booking">
                            <span>酒店预定</span>
                        </a>
                        <a href="/newArticles">
                            <span>最新文章</span>
                        </a>

                        <a href="/aboutUs">
                            <span>关于我们</span>
                        </a>

                    </div>

                </div>




                <div class="nav-toggle">
                    <div class="icon"></div>
                </div>

            </div>

            @yield('content')
        </div>
        @yield('extra')


        <div class="footer-box ">

            <ul class="footer-ul auto-margin">

                <li class="social-link">
                    <div class="qr-image" id="qrImage">
                        <img src = "/Gbh/img/wechat_qr.jpg" style="width:160px; height:160px;">
                        <span style="font-size:14px; display: block;width: 100%; text-align: center">微信扫一扫关注</span>
                    </div>
                    <img src ='/Gbh/img/wechat.png' class="footer-icon " id="webchatIcon"   data-html=''  />
                    <img src ='/Gbh/img/weibo.png' class="footer-icon" id="weiboIcon"   data-html=''  />
                </li>
                <li>
                    <span>关于我们</span>
                    <a href="http://www.gbhchina.com/aboutUs">关于联盟</a>
                    <a href="http://www.gbhchina.com/contactUs">联系我们</a>
                    <a href="http://www.gbhchina.com/newArticles">精选文章</a>
                </li>
                <li>
                    <span>关于团队</span>
                    <a href="http://www.gbhchina.com/team">团队介绍</a>
                    <a href="http://www.gbhchina.com/joinUs">加入我们</a>
                </li>

                <li>
                    <span>预定邮箱</span>
                    <a>booking@gbhchina.com</a>
                </li>

                <li>
                    <span>客服电话</span>
                    <a>0592-5657031</a>
                </li>




            </ul>
            <div class="copy-right auto-margin">

                <span class="up">全球精品酒店 版权所有 2016-2028 保留所有权利 gbhchina.com 2016.</span>
                <span class="down"> All rights reserved. 闽ICP备16016886号</span>

            </div>
            <div class="statistic">
                <script type="text/javascript">var cnzz_protocol = (("https:" == document.location.protocol) ? " https://" : " http://");document.write(unescape("%3Cspan id='cnzz_stat_icon_1259646848'%3E%3C/span%3E%3Cscript src='" + cnzz_protocol + "s95.cnzz.com/z_stat.php%3Fid%3D1259646848%26show%3Dpic' type='text/javascript'%3E%3C/script%3E"));</script>
            </div>
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

        var tur = true;
        $(window).scroll(function() {

                //控制滚动时间重复触发
                setTimeout(function(){

                    if($(document).scrollTop() > 0 &&   !$('.site-header').hasClass('site-header-scroll'))
                    {
                        $('.site-header').addClass('site-header-scroll');
                        $('.site-header').removeClass('site-header-scrollTop');
                    }

                    else if($(document).scrollTop() === 0)
                    {
                        $('.site-header').addClass('site-header-scrollTop');
                        $('.site-header').removeClass('site-header-scroll');
                    }
                    tur=true;
                },100);
                tur = false;
        });



        $('#webchatIcon').hover(function () {
                    $(this).attr('src', '/Gbh/img/wechat_green.png');
                    t = setTimeout(function() {
                        $('#qrImage').fadeIn();
                    },200);
                },
                function () {
                    $(this).attr('src', '/Gbh/img/wechat.png');
                    $('#qrImage').fadeOut();
                    clearTimeout(t);
                })

        $('#weiboIcon').hover(function(){
                    $(this).attr('src', '/Gbh/img/weibo_red.png');
                },
                function () {
                    $(this).attr('src', '/Gbh/img/weibo.png');
                })

        $('.nav-toggle').click(function () {
            $('body').toggleClass('nav-open');
        });

    })


</script>

</html>
