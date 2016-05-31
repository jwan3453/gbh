@extends('GbhMobile.site')

@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>

@stop


@section('content')
<div class="pusher">

    <div class="home-page">
        <div class="owl-carousel owl-theme">
                <div>
                    <img src = '../GbhMobile/img/banner.png'>
                </div>

        </div>

        <div class="hotel-search-box">
            <input type="text" readonly id="search" placeholder="搜搜看有没有心仪的酒店...">
            <i class="ui icon  search"></i>
        </div>



        <div class='hotel-cate'>
            <div class="l-side" >
                <div class="hotel-icon auto-margin white-bg" id="hotelCate">
                    <img src="../GbhMobile/img/精品酒店.png">
                    <span>精品酒店</span>
                </div>
            </div>
            <div class="r-side">
                <div class="hotel-icon  auto-margin dark-bg  "  id="bnbCate">
                <img src="../GbhMobile/img/民宿白.png">
                <span>精品酒店</span>
                </div>
            </div>
        </div>


        <div class="hotel-sub-cate" id="hotelSubCate">

            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin   ">
                    <img src="../GbhMobile/img/禅.png">
                    <span>禅修酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/海边.png">
                    <span>海边酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin   ">
                    <img src="../GbhMobile/img/蜜月.png">
                    <span>蜜月酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/饕餮.png">
                    <span>饕餮之行</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/森林.png">
                    <span>森林酒店</span>
                </div>
            </div>            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  " >
                    <img src="../GbhMobile/img/禅.png">
                    <span>温泉酒店</span>
                </div>
            </div>
        </div >

        <div class="hotel-sub-cate none-display" id="bnbSubCate" >

            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin   ">
                    <img src="../GbhMobile/img/人文古厝.png">
                    <span>禅修酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/山水风光.png">
                    <span>海边酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin   ">
                    <img src="../GbhMobile/img/设计师之家.png">
                    <span>蜜月酒店</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/乡村回归.png">
                    <span>饕餮之行</span>
                </div>
            </div>
            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  ">
                    <img src="../GbhMobile/img/森林.png">
                    <span>森林酒店</span>
                </div>
            </div>            <div class="menu-grid ">
                <div class="hotel-sub-icon auto-margin  " >
                    <img src="../GbhMobile/img/禅.png">
                    <span>温泉酒店</span>
                </div>
            </div>
        </div >



        {{--<div >--}}
            {{--<div class="section-header">--}}
                {{--精选主题--}}
            {{--</div>--}}

            {{--<div class="topic-section">--}}
                {{--<div class="topic-box">--}}
                    {{--<div class="center-text-circle">--}}
                        {{--<div  >狂野丛林</div>--}}
                    {{--</div>--}}
                    {{--<img src = '../GbhMobile/img/tu0.png'>--}}
                {{--</div>--}}

                {{--<div class="topic-box">--}}
                    {{--<div class="center-text-circle">--}}
                        {{--<div  >休闲养生</div>--}}
                    {{--</div>--}}
                    {{--<img src = '../GbhMobile/img/tu1.png'>--}}
                {{--</div>--}}

                {{--<div class="topic-box">--}}
                    {{--<div class="center-text-circle">--}}
                        {{--<div  >海边度假</div>--}}
                    {{--</div>--}}
                    {{--<img src = '../GbhMobile/img/tu2.png'>--}}
                {{--</div>--}}
            {{--</div>--}}

        {{--</div>--}}




        <div >
            <div class="section-header">
                精选主题
            </div>

            <div class="topic-section">
                <div class="topic-box">
                    <div class="center-text-topic">
                        <div class="wrap-border">
                            <div class="text" >休闲养生</div>
                        </div>
                    </div>
                    <img src = '../GbhMobile/img/tu0.png'>
                </div>
                <div class="padding-15"></div>
                <div class="topic-box">
                    <div class="center-text-topic">
                         <div class="wrap-border">
                            <div class="text" >休闲养生</div>
                         </div>
                    </div>
                    <img src = '../GbhMobile/img/tu1.png'>
                </div>
                <div class="padding-15"></div>
                <div class="topic-box">
                    <div class="center-text-topic">
                        <div class="wrap-border">
                            <div class="text" >休闲养生</div>
                        </div>
                    </div>
                    <img src = '../GbhMobile/img/tu2.png'>
                </div>
                <div class="padding-15"></div>
            </div>

        </div>


        <div>
            <div class="section-header">
                优惠推荐
            </div>

            <div class='discount-section' >
                <img src = '../GbhMobile/img/tu1.png'>
                <div class="discount-price">
                    <label>￥<span> 666</span></label>
                    <img src = ../GbhMobile/img/特价黑色.png>
                </div>
                <div class="hotel-location">

                        <span class="f-left" > 厦门 - 华悦酒店</span>
                        <s class="f-right">￥999</s>
                </div>
            </div>

            <div class="padding-15"></div>

            <div class='discount-section' >
                <img src = '../GbhMobile/img/tu1.png'>
                <div class="discount-price">
                    <label>￥<span> 666</span></label>
                    <img src = ../GbhMobile/img/特价黑色.png>
                </div>
                <div class="hotel-location">

                    <span class="f-left" > 厦门 - 华悦酒店</span>
                    <s class="f-right">￥999</s>
                </div>
            </div>

            <div class="padding-15"></div>

            <div class='discount-section' >
                <img src = '../GbhMobile/img/tu1.png'>
                <div class="discount-price">
                    <label>￥<span> 666</span></label>
                    <img src = ../GbhMobile/img/特价黑色.png>
                </div>
                <div class="hotel-location">

                    <span class="f-left" > 厦门 - 华悦酒店</span>
                    <s class="f-right">￥999</s>
                </div>
            </div>
            <div class="padding-15"></div>
        </div>


        <div>
            <div class="section-header">
                热门目的地
            </div>


            <div class="destin-section">
                <div class="destin-box">
                    <div class="center-text-destin">
                        <div  ><i class="ui icon marker large"></i><span>厦门</span></div>
                    </div>
                    <img src = '../GbhMobile/img/xiaotu0.png'>

                </div>

                <div class="destin-box">
                    <div class="center-text-destin">
                        <div  ><i class="ui icon marker large"></i><span>巴黎</span></div>
                    </div>
                    <img src = '../GbhMobile/img/xiaotu1.png'>
                </div>

                <div class="destin-box">
                    <div class="center-text-destin">
                        <div  ><i class="ui icon marker large"></i><span>北京</span></div>
                    </div>
                    <img src = '../GbhMobile/img/xiaotu2.png'>
                </div>

                <div class="destin-box">
                    <div class="center-text-destin">
                        <div  ><i class="ui icon marker large"></i><span>九寨沟</span></div>
                    </div>
                    <img src = '../GbhMobile/img/xiaotu3.png'>
                </div>
            </div>
        </div>




    </div>


</div>

@include('GbhMobile.partial.searchSideBar')


@stop







@section('script')

    <script type="text/javascript">
        $(window).load(function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:2000,
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
                        items:3,

                        loop:false
                    }
                }
            })
        })



        $(document).ready(function(){
            $('#search').focus(function(){
                            $('.ui.sidebar')
                                    .sidebar('toggle');
                            $('#search').blur();
                        })


            $('#hotelCate').click(function(){
                if($('#hotelSubCate').css('display') !== 'none')
                {
                    return 0;
                }
                else{
                    $(this).removeClass('dark-bg').addClass('white-bg').find('img').attr('src','../GbhMobile/img/精品酒店.png').transition('pulse');;
                    $('#bnbCate').removeClass('white-bg').addClass('dark-bg').find('img').attr('src','../GbhMobile/img/民宿白.png');

                    $('#bnbSubCate').transition({
                            animation  : 'horizontal flip',
                            duration   : '0.2s',
                            onComplete : function() {
                                $('#hotelSubCate').transition('horizontal flip');
                            }
                    });

                }
            })

            $('#bnbCate').click(function(){

                if($('#bnbSubCate').css('display') !== 'none')
                {
                    return 0;
                }
                else{
                    $('#hotelCate').removeClass('white-bg').addClass('dark-bg').find('img').attr('src','../GbhMobile/img/酒店白.png');
                    $(this).removeClass('dark-bg').addClass('white-bg').find('img').attr('src','../GbhMobile/img/精品民宿.png').transition('pulse');
                    $('#hotelSubCate').transition({
                        animation  : 'horizontal flip',
                        duration   : '0.2s',
                        onComplete : function() {
                            $('#bnbSubCate').transition('horizontal flip ');
                        }
                    });

                }

            })

        })
    </script>
@stop