@extends('Gbh.site')

@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
@stop

@section('content')


    <div class="pusher">
        <div class="home-page">

            <div class="home-site-header">
                <div class="home-menu-nav">
                    <div>
                        <a href="/"><span>首页</span></a>
                        <span>最新文章</span>
                        <a href="/aboutUs"><span>关于我们</span></a>
                        <i class="icon user large"></i>
                    </div>
                </div>

                <div class="mobile-menu-nav">
                    <i class="sidebar icon large"></i>
                </div>



            </div>
            <div class="owl-carousel owl-theme home-slide">
                <div class="slide">
                    <div class="slide-caption">
                        <div class="slide-center-text">
                            <div>
                                <span class="up">温泉和酒店如此完美的结合</span>
                                <img src = '/Gbh/img/横线.png'>
                                <span class="down ">安溪 - 悦泉行馆</span>
                            </div>
                        </div>
                    </div>
                    <img src = '/Gbh/img/banner.png'>
                </div>
                <div class="slide">
                    <div class="slide-caption">
                        <div class="slide-center-text">
                            <div>
                                <span class="up">西湖边上的另一个天堂</span>
                                <img src = '/Gbh/img/横线.png'>
                                <span class="down ">杭州 - 富春山居</span>
                            </div>
                        </div>
                    </div>
                    <img src = '/Gbh/img/banner.png'>
                </div>
                <div class="slide">
                    <div class="slide-caption">
                        <div class="slide-center-text">
                            <div>
                                <span class="up">钢筋水泥的后花园</span>
                                <img src = '/Gbh/img/横线.png'>
                                <span class="down ">安溪 - 悦泉行馆</span>
                            </div>
                        </div>
                    </div>
                    <img src = '/Gbh/img/banner.png'>
                </div>
            </div>

            {{--<div class="sub-slogan">--}}
                {{--<h2>不仅仅是酒店</h2>--}}
                {{--<h3>we are more than hotels</h3>--}}
            {{--</div>--}}


            <div class="home-hotel-warp  ui container">


                    <div class="h-cate-nav">
                        <div class="cate-nav-btn">
                            精品酒店
                        </div>
                        <div class="cate-nav-btn">
                            精品名宿
                        </div>
                        <div class="cate-nav-btn">
                            视频
                        </div>
                        <div class="cate-nav-btn">
                            杂志
                        </div>
                    </div>


                    {{--<h3>热门推荐</h3>--}}
                    <div class="hotel-warp">
                        <div class="hotel-box">
                            <img src="/Gbh/img/banner.png">

                            <div class="hotel-box-mask">
                                <a class="anchor-white" href="/hotel/8">广东 - 惠州 - 十字水度假村</a>
                                <span><i class="icon-map-marker"></i>    ￥1800起</span>
                            </div>
                            <div class="h-article-title">
                                悦泉之旅
                            </div>

                            <div class="h-hotel-brief">
                                安溪悦泉行馆为安溪"世界温泉小镇"首期工程,采用闽南瓦房及结合燕尾脊建筑元素,采用新古典后现代的设计理念,让客人享受最安静的尊贵与最昂贵的品味,内设有别墅、中西....
                            </div>

                            <div class="h-hotel-name">
                               <i class="ui icon marker"> </i> 悦泉行馆
                            </div>
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                        <div class="hotel-box">
                            <img src="/Gbh/img/banner.png">

                            <div class="hotel-box-mask">
                                <a class="anchor-white" href="/hotel/8">广东 - 惠州 - 十字水度假村</a>
                                <span><i class="icon-map-marker"></i>    ￥1800起</span>
                            </div>
                            <div class="h-article-title">
                                悦泉之旅
                            </div>

                            <div class="h-hotel-brief">
                                安溪悦泉行馆为安溪"世界温泉小镇"首期工程,采用闽南瓦房及结合燕尾脊建筑元素,采用新古典后现代的设计理念,让客人享受最安静的尊贵与最昂贵的品味,内设有别墅、中西....
                            </div>

                            <div class="h-hotel-name">
                                悦泉行馆
                            </div>
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                        <div class="hotel-box">
                            <img src="/Gbh/img/banner.png">

                            <div class="hotel-box-mask">
                                <a class="anchor-white" href="/hotel/8">广东 - 惠州 - 十字水度假村</a>
                                <span><i class="icon-map-marker"></i>    ￥1800起</span>
                            </div>
                            <div class="h-article-title">
                                悦泉之旅
                            </div>

                            <div class="h-hotel-brief">
                                安溪悦泉行馆为安溪"世界温泉小镇"首期工程,采用闽南瓦房及结合燕尾脊建筑元素,采用新古典后现代的设计理念,让客人享受最安静的尊贵与最昂贵的品味,内设有别墅、中西....
                            </div>

                            <div class="h-hotel-name">
                                悦泉行馆
                            </div>
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                    </div>


            </div>


                <div class="home-rec-article ui container">

                    <div class="hor-article-line">

                        <div class="image">
                            <img src = "/Gbh/img/hotel1.jpg">
                        </div>
                        <div class="content">
                            <a class="header">哪些呗遗忘的精品酒店</a>
                            <div class="meta">
                                <a>2015-02-23</a>
                                <a>酒店专栏</a>
                            </div>
                            <div class="description">
                                可能有些酒店在建成的那一刻就注定是为一小部分人服务的. 甚至有些时候他们会被人慢慢遗忘
                            </div>

                        </div>

                    </div>

                </div>
            </div>
    </div>
@stop

@section('script')

    <script type="text/javascript">
        $('.slide-caption').transition('fly left');
        $(window).load(function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:6000,
                autoHeight:true,
                animateOut: 'fadeOut',
                animateIn: 'fadeIn',

                responsive:{
                    0:{
                        items:1,

                        loop:true
                    },
                    600:{
                        items:1,

                        loop:true
                    },
                    1000:{
                        items:1,

                        loop:true
                    }
                }
            })
        })

        $(document).ready(function(){


            $('.hotel-box').hover(function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').addClass('blur');
                        $(this).find('.hotel-box-mask').fadeIn(300);
                    },
                    function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').removeClass('blur');
                        $(this).find('.hotel-box-mask').fadeOut(100);
                    })


        })

    </script>

@stop