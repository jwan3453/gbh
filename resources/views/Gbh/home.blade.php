@extends('Gbh.site')

@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>
@stop

@section('content')


    <div>
        <div class="home-page">

            <div class="home-site-header">
                <div class="home-menu-nav">
                    <div>
                        <a href="/"><span>首页</span></a>
                        <a href="/newArticles">
                            <span>最新文章</span>
                        </a>
                        <a href="/booking"><span>酒店预定</span></a>
                        <a href="/aboutUs"><span>关于我们</span></a>

                    </div>
                </div>

                <div class="mobile-menu-nav">
                    <i class="sidebar icon large"></i>
                </div>



            </div>
            <div class="owl-carousel owl-theme home-slide">
                @foreach($slideList as $slide)
                    <a target="_blank" href="{{$slide->slide_link}}"><div class="slide">
                        <div class="slide-caption">
                            <div class="slide-center-text">
                                <div>
                                    <span class="up">{{$slide->slide_desc}}</span>
                                    <img src = '/Gbh/img/横线.png'>
                                    <span class="down ">{{$slide->slide_name}}</span>
                                </div>
                            </div>

                            <div class="slide-left-text">
                                <span class="up">{{$slide->slide_desc}}</span>
                                <span class="down ">{{$slide->slide_name}}</span>
                            </div>
                        </div>
                        <img src = '{{$slide->img_url}}'>
                    </div></a>
                @endforeach
                
            </div>

            {{--<div class="sub-slogan">--}}
                {{--<h2>不仅仅是酒店</h2>--}}
                {{--<h3>we are more than hotels</h3>--}}
            {{--</div>--}}


            <div class="home-hotel-warp  ui container">


                    {{--<div class="h-cate-nav">--}}
                        {{--<div class="cate-nav-btn cate-nav-btn-selected hotel-btn">--}}
                            {{--精品酒店--}}
                        {{--</div>--}}
                        {{--<div class="cate-nav-btn bnb-btn">--}}
                            {{--精品名宿--}}
                        {{--</div>--}}
                        {{--<div class="cate-nav-btn video-btn">--}}
                            {{--视频--}}
                        {{--</div>--}}
                        {{--<div class="cate-nav-btn magazine-btn">--}}
                            {{--杂志--}}
                        {{--</div>--}}
                    {{--</div>--}}


                    {{--<h3>热门推荐</h3>--}}

                    <div class="hotel-warp" id="hotel_article_list" >
                        @foreach($articleList['精品酒店'] as $article)

                            <div class="hotel-box ">
                                <img src="{{$article->cover_image  }}">

                                <div class="hotel-box-mask">
                                    <span class="mark-brief"> {{$article->brief  }}</span>
                                    <a class="anchor-white" href="{{url('/article/'.$article->id)}}"> <span><i class="icon book"></i>  查看全文</span></a>

                                </div>
                                <div class="h-article-title">
                                    {{$article->title  }}
                                </div>

                                <div class="h-hotel-brief">
                                    {{$article->brief  }}
                                </div>

                                {{--<div class="h-hotel-name">--}}
                                   {{--<i class="ui icon marker"> </i> 悦泉行馆--}}
                                {{--</div>--}}
                                {{--<div class="hotel-box-mark">--}}

                                {{--</div>--}}
                            </div>
                    @endforeach
                    </div>


                <div class="hotel-warp none-display" id="bnb_article_list" >
                    @foreach($articleList['精品名宿'] as $article)

                        <div class="hotel-box ">
                            <img src="{{$article->cover_image  }}">

                            <div class="hotel-box-mask">
                                <span class="mark-brief"> {{$article->brief  }}</span>
                                <a class="anchor-white" href="{{url('/article/'.$article->id)}}"> <span><i class="icon book"></i>  查看全文</span></a>

                            </div>
                            <div class="h-article-title">
                                {{$article->title  }}
                            </div>

                            <div class="h-hotel-brief">
                                {{$article->brief  }}
                            </div>

                            {{--<div class="h-hotel-name">--}}
                            {{--<i class="ui icon marker"> </i> 悦泉行馆--}}
                            {{--</div>--}}
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                    @endforeach
                </div>

                <div class="hotel-warp none-display" id="magazine_article_list" >
                    @foreach($articleList['杂志'] as $article)

                        <div class="hotel-box ">
                            <img src="{{$article->cover_image  }}">

                            <div class="hotel-box-mask">
                                <span class="mark-brief"> {{$article->brief  }}</span>
                                <a class="anchor-white" href="{{url('/article/'.$article->id)}}"> <span><i class="icon book"></i>  查看全文</span></a>

                            </div>
                            <div class="h-article-title">
                                {{$article->title  }}
                            </div>

                            <div class="h-hotel-brief">
                                {{$article->brief  }}
                            </div>

                            {{--<div class="h-hotel-name">--}}
                            {{--<i class="ui icon marker"> </i> 悦泉行馆--}}
                            {{--</div>--}}
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                    @endforeach
                </div>

                <div class="hotel-warp none-display" id="video_article_list" >
                    @foreach($articleList['视频'] as $article)

                        <div class="hotel-box ">
                            <img src="{{$article->cover_image  }}">

                            <div class="hotel-box-mask">
                                <span class="mark-brief"> {{$article->brief  }}</span>
                                <a class="anchor-white" href="{{url('/article/'.$article->id)}}"> <span><i class="icon book"></i>  查看全文</span></a>

                            </div>
                            <div class="h-article-title">
                                {{$article->title  }}
                            </div>

                            <div class="h-hotel-brief">
                                {{$article->brief  }}
                            </div>

                            {{--<div class="h-hotel-name">--}}
                            {{--<i class="ui icon marker"> </i> 悦泉行馆--}}
                            {{--</div>--}}
                            {{--<div class="hotel-box-mark">--}}

                            {{--</div>--}}
                        </div>
                    @endforeach
                </div>

            </div>


                {{--<div class="home-rec-article ui container">--}}

                    {{--<div class="hor-article-line">--}}

                        {{--<div class="image">--}}
                            {{--<img src = "/Gbh/img/hotel1.jpg">--}}
                        {{--</div>--}}
                        {{--<div class="content">--}}
                            {{--<a class="header">哪些呗遗忘的精品酒店</a>--}}
                            {{--<div class="meta">--}}
                                {{--<a>2015-02-23</a>--}}
                                {{--<a>酒店专栏</a>--}}
                            {{--</div>--}}
                            {{--<div class="description">--}}
                                {{--可能有些酒店在建成的那一刻就注定是为一小部分人服务的. 甚至有些时候他们会被人慢慢遗忘--}}
                            {{--</div>--}}

                        {{--</div>--}}

                    {{--</div>--}}

                {{--</div>--}}
            </div>
    </div>
@stop

@section('script')

    <script type="text/javascript">
//        $('.slide-caption').transition('fly left');

            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:4000,
                autoHeight:true,

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



        function switchArticles(section)
        {
            section.siblings('.hotel-warp').each(function(){
                if($(this).css('display') !== 'none')
                {
                    $(this)
                            .transition({
                                animation  : 'scale',
                                duration   : '0.5s',
                                onHide : function() {
                                    section .transition({
                                        animation  : 'scale',
                                        duration   : '0.5s'
                                    });
                                }
                            })
                }
            })
        }
        $(document).ready(function(){


            $('.hotel-box').hover(function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').addClass('blur');
                        $(this).find('.hotel-box-mask').fadeIn(300);
                    },
                    function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').removeClass('blur');
                        $(this).find('.hotel-box-mask').fadeOut(100);
                    })



            $('.hotel-btn').click(function(){
                $(this).addClass('cate-nav-btn-selected').siblings('.cate-nav-btn').removeClass('cate-nav-btn-selected');
                switchArticles($('#hotel_article_list'));
            })
            $('.bnb-btn').click(function(){
                $(this).addClass('cate-nav-btn-selected').siblings('.cate-nav-btn').removeClass('cate-nav-btn-selected');
                switchArticles($('#bnb_article_list'));
            })
            $('.video-btn').click(function(){
                $(this).addClass('cate-nav-btn-selected').siblings('.cate-nav-btn').removeClass('cate-nav-btn-selected');
                switchArticles($('#video_article_list'));
            })
            $('.magazine-btn').click(function(){
                $(this).addClass('cate-nav-btn-selected').siblings('.cate-nav-btn').removeClass('cate-nav-btn-selected');
                switchArticles($('#magazine_article_list'));
            })
        })

    </script>

@stop