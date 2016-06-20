@extends('Gbh.site')

@section('resources')
@stop


@section('content')


<div class="pusher">
    <div class="site-header">
        <div class="site-menu-nav">
            <div>
                <a href="/"><span>首页</span></a>
                <a href="/newArticles">
                    <span>最新文章</span>
                </a>
                <span>酒店预定</span>
                <a href="/aboutUs"><span>关于我们</span></a>

            </div>
        </div>
        <div class="mobile-menu-nav">
            <i class="sidebar icon large"></i>
        </div>
    </div>

    <div class="ui container">

        <div class="about-menu-nav">


            <a href="/aboutUs" class="dark-anchor"><span>关于我们</span></a>
            <a href="/team" class="dark-anchor"><span>团队介绍</span></a>
            <a href="/history"  class="dark-anchor"><span>团队经历</span></a>
            <a href="/joinUs"  class="dark-anchor"><span>加入我们</span></a>
            <a href="/contactUs"  class="dark-anchor"><span>联系我们</span></a>
        </div>


                <div class="about-bg">
                    <img src ='Gbh/img/about_bg.jpg' >
                </div>

                <div class="about-content ">
                    <div class="about-line-box what-we-do">
                        <div class="about-text f-right">
                            <div class="header">我们是谁</div>
                            <div class="detail">
                                果壳传媒是一家致力于面向公众倡导科技理念、传播科技内容的企业。2010年11月，公司推出果壳网（Guokr.com） 。在创始人兼CEO姬十三带领的专业团队努力下，果壳传媒已成为国内领先的科技传媒机构，现拥有果壳网（Guokr.com）和果壳阅读两个品牌。果壳传媒还致力于为企业量身打造面向公众的科技品牌传播方案.
                            </div>

                        </div>

                        <div class="about-square about-red-bg f-left" >
                            <div class="about-icon">
                                <img src ='/Gbh/img/about-us-icon.png'>
                            </div>
                        </div>
                        <div class="about-left-triangle about-red-border-bg f-left">

                        </div>
                        {{--<div class="bottom-line about-red-bg">--}}
                        {{--</div>--}}
                    </div>

                    <div class="about-line-box who-we-are">
                        <div class="about-text f-left">
                            <div class="header">我们是谁</div>
                            <div class="detail">
                                果壳传媒是一家致力于面向公众倡导科技理念、传播科技内容的企业。2010年11月，公司推出果壳网（Guokr.com） 。在创始人兼CEO姬十三带领的专业团队努力下，果壳传媒已成为国内领先的科技传媒机构，现拥有果壳网（Guokr.com）和果壳阅读两个品牌。果壳传媒还致力于为企业量身打造面向公众的科技品牌传播方案.
                            </div>

                        </div>

                        <div class="about-square about-blue-bg f-right" >
                            <div class="about-icon">
                                <img src ='/Gbh/img/about-us-icon.png'>
                            </div>
                        </div>
                        <div class="about-right-triangle about-blue-border-bg f-right">

                        </div>
                        {{--<div class="bottom-line about-blue-bg">--}}
                        {{--</div>--}}
                    </div>


                    <div class="about-line-box our-mission">
                        <div class="about-text f-right">
                            <div class="header">我们是谁</div>
                            <div class="detail">
                                果壳传媒是一家致力于面向公众倡导科技理念、传播科技内容的企业。2010年11月，公司推出果壳网（Guokr.com） 。在创始人兼CEO姬十三带领的专业团队努力下，果壳传媒已成为国内领先的科技传媒机构，现拥有果壳网（Guokr.com）和果壳阅读两个品牌。果壳传媒还致力于为企业量身打造面向公众的科技品牌传播方案.
                            </div>

                        </div>

                        <div class="about-square about-yellow-bg f-left" >
                            <div class="about-icon">
                                <img src ='/Gbh/img/about-us-icon.png'>
                            </div>
                        </div>
                        <div class="about-left-triangle about-yellow-border-bg f-left">

                        </div>
                        {{--<div class="bottom-line about-yellow-bg">--}}
                        {{--</div>--}}
                    </div>

                </div>


    </div>

</div>
@stop


@section('script')


    <script type="text/javascript">


        $(document).ready(function(){


            $('.about-bg').transition({animation:'scale',
                duration:1000});

            if($('.about-line-box').css('display') === 'none')
            {


                $('.what-we-do').transition({animation:'scale',
                                                    duration:800});

                $('.who-we-are').transition({animation:'scale',
                    duration:1400});

                $('.our-mission').transition({animation:'scale',
                    duration:2000});
                $('html, body').animate({scrollTop:960}, 'slow');
            }

        })

    </script>


@stop