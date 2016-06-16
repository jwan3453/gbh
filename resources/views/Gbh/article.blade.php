@extends('Gbh.site')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
@stop

@section('content')


    <div class="pusher">

        <div class="site-header">
            <div class="site-menu-nav">
                <div>
                    <a  href="/">
                        <span>首页</span>
                    </a>
                    <span>最新文章</span>
                    <span>酒店预定</span>
                    <a href="/aboutUs">
                        <span>关于我们</span>
                    </a> <i class="icon user large"></i>
                </div>
            </div>
            <div class="mobile-menu-nav">
                <i class="sidebar icon large"></i>
            </div>
        </div>

        <div class=" article-page">

            <h1>{{ $article->title }}</h1>
            <h5>{{ $article->published_at }}</h5>
            <hr>
            <div >
                {!!  $article->content_raw !!}
            </div>

        </div>
    </div>
@stop

@section('script')

    <script type="text/javascript">
        //        $('.slide-caption').transition('fly left');
        $(window).load(function(){
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