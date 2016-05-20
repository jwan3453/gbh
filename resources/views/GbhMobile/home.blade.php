@extends('GbhMobile.site')

@section('resources')
    <script src={{ asset('js/swiper/owl.carousel.min.js') }}></script>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.carousel.min.css') }}>
    <link rel="stylesheet" type="text/css" href= {{ asset('js/swiper/owl.theme.default.min.css') }}>

@stop


@section('content')
<div class="pusher">

    <div >
        <div class="owl-carousel owl-theme">
                <div>
                    <img src = '../GbhMobile/img/banner.png'>
                </div>

        </div>

        <div class="hotel-search-box">
            <input type="text" readonly id="search" placeholder="搜搜看有没有心仪的酒店...">
            <i class="ui icon  search"></i>
        </div>

        <div>
            <div class="section-header">
                精选主题
            </div>

            <div class="topic-section">
                <div class="topic-box">
                    <div class="center-text-circle">
                        <div  >狂野丛林</div>
                    </div>
                    <img src = '../GbhMobile/img/tu0.png'>
                </div>

                <div class="topic-box">
                    <div class="center-text-circle">
                        <div  >休闲养生</div>
                    </div>
                    <img src = '../GbhMobile/img/tu1.png'>
                </div>

                <div class="topic-box">
                    <div class="center-text-circle">
                        <div  >海边度假</div>
                    </div>
                    <img src = '../GbhMobile/img/tu2.png'>
                </div>
            </div>

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


@stop




<div class="ui right sidebar   search-sidebar">
    <div class="destination-box ">

        <input class="auto-margin" type="text" placeholder="输入您要搜索的城市"/>
        <i class="ui icon  search"></i>

        <div class="desctin-recommend-box">
            <div class="destin-recommend-text">厦门</div>
            <div class="destin-recommend-text">丽江</div>
            <div class="destin-recommend-text">杭州</div>
            <div class="destin-recommend-text">拉萨</div>
            <div class="destin-recommend-text">柬埔寨</div>
            <div class="destin-recommend-text">日本</div>
            <div class="destin-recommend-text">鼓浪屿</div>
        </div>
    </div>


    <div class="date-box">
        <div class="select-date auto-margin">
            <div class="f-left"><i class="ui icon calendar"></i></div>
            <span class="from-date">2015-5-20</span>
            至
            <span class="to-date">2015-05-27</span>
        </div>

        <div class="calendar">
            <table>
                <tr class="t-header">
                    <th>天</th>
                    <th>一</th>
                    <th>二</th>
                    <th>三</th>
                    <th>四</th>
                    <th>五</th>
                    <th>六</th>
                </tr>
                <tr>
                    <td>21</td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                <tr>
            </table>
        </div>

    </div>

</div>




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

        $(function(){
            var $td= $('.calendar').find('td');

            //获取时间
            var date = new Date(),
            year= date.getFullYear(),
            month = date.getMonth() + 1,
            day = date.getDate(),days =0;


            //初始化日历
            function initCal(year,month,day)
            {
                if(month===2 && year/4 ===0 && year%100!==0)
                {
                    days = 28;
                }
                else if(month===1 || month===3 || month===5 || month ===7||
                        month ===8|| month ===10|| month ===12)
                {
                    days=31;
                }
                else if(month===4 || month===6 || month===9 || month===11)
                {
                    days = 30;
                }
                else
                {
                    days = 29;
                }

                var m = month <3 ?(month ==1 ? 13:14):month;
                year = m >12 ?year-1:year;
                var c = parseInt(year.toString().substring(0,2)),
                    y = parseInt(year.toString().substring(2,4)),
                        d=1;

                //蔡勒公式
                var week = y + parseInt(y/4) + parseInt(c/4) - 2*c + parseInt(26*(m+1)/10) + d - 1;

                week = week < 0 ? (week%7+7)%7 : week%7;



                for(var i=0; i<42; i++)
                {
                    $td.eq(i).text('');
                }

                var index= 0;
                for(var i = 0;i < 42; i++){


                    if(i >= (days))
                    {
                        index = i-(days);
                    }
                    else
                    {
                        if(i<(day-1))
                        {
                            $td.eq( week % 7 +i).addClass('disable-day');
                        }

                        if(i=(day-1))
                        {
                            $td.eq( week % 7 +i).addClass('selected-day');
                        }
                        index =i;
                    }

                    $td.eq( week % 7 +i).text(index+1);
                }


            }
            initCal(year,month,day);



        })

        $(document).ready(function(){
                $('#search').focus(function(){
                    $('.ui.sidebar')
                            .sidebar('toggle');
                    $('#search').blur();
                })
        })
    </script>
@stop