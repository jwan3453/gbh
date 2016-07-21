@extends('Gbh.site')

@section('resources')
@stop


@section('content')

    <title>关于我们</title>

    <div class="pusher">
        @include('partial.homeNav')

    <div class="ui container">

        <div class="about-menu-nav">

            <a href="/aboutUs" class="dark-anchor"><span>关于我们</span></a>
            <a href="/team" class="dark-anchor"><span>团队介绍</span></a>
            <a href="/history"  class="dark-anchor"><span>团队经历</span></a>
            <a href="/joinUs"  class="dark-anchor"><span>加入我们</span></a>
            <a href="/contactUs"  class="dark-anchor"><span>联系我们</span></a>
        </div>


        <div class = 'title-text'>
            <div class="up">ABOUT US</div>
            <div class="down auto-margin">关于我们</div>
        </div>

                <div class="about-content ">
                    <div class="about-line-box what-we-do">
                        <div class="about-text f-right">
                            <div class="header">我们是谁</div>
                            <div class="detail">
                                全球精品酒店（Global Boutique Hotel）成立于2015年11月，总部设于美丽的海滨城市厦门。我们是一群享受生活，追求工作即是度假的生活方式的年轻人
                            </div>

                        </div>

                        <div class="about-square about-red-bg f-left" >
                            <div class="about-icon">
                                <img src ='/Gbh/icon/about-us-icon.png'>
                            </div>
                        </div>
                        <div class="about-left-triangle about-red-border-bg f-left">

                        </div>
                        {{--<div class="bottom-line about-red-bg">--}}
                        {{--</div>--}}
                    </div>

                    <div class="about-line-box who-we-are">
                        <div class="about-text f-left">
                            <div class="header">我们在做什么</div>
                            <div class="detail">
                                提供全球精品酒店的挖掘，分享精品酒店入住体验；
                                拥有严谨的品牌甄选体系，在各目的地甄选符合标准的精品酒店；
                                提供PC端和移动端的精品酒店预定功能，涉及从预定到退房等各环节的在线服务；
                                引导和支持精品酒店的品牌推广和酒店运营。
                            </div>

                        </div>

                        <div class="about-square about-blue-bg f-right" >
                            <div class="about-icon">
                                <img src ='/Gbh/icon/our-plan-icon.png'>
                            </div>
                        </div>
                        <div class="about-right-triangle about-blue-border-bg f-right">

                        </div>
                        {{--<div class="bottom-line about-blue-bg">--}}
                        {{--</div>--}}
                    </div>


                    <div class="about-line-box our-mission">
                        <div class="about-text f-right">
                            <div class="header">我们目标</div>
                            <div class="detail">
                                挖掘全球优质精品酒店分享给用户！
                            </div>

                        </div>

                        <div class="about-square about-yellow-bg f-left" >
                            <div class="about-icon">
                                <img src ='/Gbh/icon/our-goal-icon.png'>
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
               // $('html, body').animate({scrollTop:960}, 'slow');
            }

        })

    </script>


@stop