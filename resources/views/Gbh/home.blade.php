@extends('Gbh.site')

@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>

@stop

@section('content')


    <div class="pusher">
        <div class="home-page">
            <div class="owl-carousel owl-theme home-slide">
                <div>
                    <div class="slide-caption">
                        <span>有一种酒店,你从未体验</span>
                    </div>
                    <img src = '/Gbh/img/1.JPG'>
                </div>
                <div>
                    <div class="slide-caption">
                        <span>体验从未如此深刻</span>
                    </div>
                    <img src = '/Gbh/img/2.JPG'>
                </div>
                <div>
                    <div class="slide-caption">
                        <span>有一种酒店,你从未体验</span>
                    </div>
                    <img src = '/Gbh/img/3.JPG'>
                </div>
            </div>

            <div class="sub-slogan">
                <h2>不仅仅是酒店</h2>
                <h3>we are more than hotels</h3>
            </div>


            <div class="home-hotel-warp  ui container">
                    <h3>热门推荐</h3>
                    <div class="hotel-warp">
                        <div class="hotel-box">
                            <img src="/Gbh/img/hotel1.jpg">

                            <div class="hotel-box-mask">
                                <a class="anchor-white" href="/hotel/8">广东 - 惠州 - 十字水度假村</a>
                                <span><i class="icon-map-marker"></i>    ￥1800起</span>
                            </div>
                            <div class="hotel-box-mark">

                            </div>
                        </div>
                        <div class="hotel-box">
                            <img src="/Gbh/img/hotel1.jpg">
                            <div class="hotel-box-mask">
                                <a class="anchor-white">我要去度假!</a>
                            </div>
                        </div>
                        <div class="hotel-box">
                            <img src="/Gbh/img/hotel1.jpg">
                            <div class="hotel-box-mask">
                                <a class="anchor-white">我要去度假!</a>
                            </div>
                        </div>
                    </div>


                </div>


                <div class="home-rec-article ui container">
                    <div>
                        <div class="item">
                            <div class="ui small image">
                                <img src="/Gbh/img/hotel1.jpg">
                            </div>
                            <div class="content">
                                <a class="header">Content Header</a>
                                <div class="meta">
                                    <a>Date</a>
                                    <a>Category</a>
                                </div>
                                <div class="description">
                                    A description which may flow for several lines and give context to the content.
                                </div>
                                <div class="extra">
                                    <img src="assets/images/wireframe/square-image.png" class="ui circular avatar image"> Username
                                </div>
                            </div>
                        </div>

                    </div>
                </div>


        <div>

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
                autoplayTimeout:4000,
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
                        $(this).find('img').addClass('blur');
                        $(this).find('.hotel-box-mask').fadeIn(300);
                    },
                    function(){
                        $(this).find('img').removeClass('blur');
                        $(this).find('.hotel-box-mask').fadeOut(100);
                    })
        })

    </script>

@stop