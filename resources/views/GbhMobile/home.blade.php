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
            <span class="from-date">入住时间</span>
            至
            <span class="to-date">离开时间</span>
        </div>

        <div class="calendar" id="calendar">

            <div class="select-month">
                <i class="angle left icon f-left big pre-month"></i>
                <span></span>
                <i class="angle right icon f-right big next-month"></i>
            </div>


            <table>
                <tr class="t-header">
                    <th>日</th>
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


   <a href="{{url('/search')}}"> <div class=" regular-btn red-btn auto-margin">搜索</div></a>

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
            currentYear= date.getFullYear(),
            currentMonth = date.getMonth() + 1,
            today = date.getDate(),days = 0;



            var newYear = date.getFullYear(),
                newMonth =date.getMonth() + 1;


            var   selectedDateType= 0; //选择的状态(是选择 1.到店时间 还是 2.离店时间)

            //选择的到店时间的年月日
            var  selectedFromYear = 0;
            var  selectedFromMonth = 0;
            var  selectedFromDay = 0;

            //选择离店时间的年月日
            var  selectedToYear = 0;
            var  selectedToMonth = 0;
            var  selectedToDay = 0;





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



                //显示月份

                $('.select-month').find('span').text(year +'年'+ month + '月');


                //显示日期
                for(var i=0; i<36; i++)
                {
                    $td.eq(i).text('');
                    $td.removeClass('disable-day');
                    $td.removeClass('selected-day')
                }

                var index= 0;
                for(var i = 0;i <days; i++){


                    if(i >= (days))
                    {
                        index = i-(days);
                    }
                    else
                    {

                        if(i<(today-1) && currentMonth === month)
                        {
                            $td.eq( week % 7 +i).addClass('disable-day');
                        }

                       // if(i===(day-1))
                        else if(currentMonth > month )
                        {
                            $td.eq( week % 7 +i).addClass('disable-day');
                        }
//                        if(i==(day-1))
//                        {
//                            $td.eq( week % 7 +i).addClass('selected-days');
//                        }
                        index =i;
                    }

                    //判断是否为今天的day
//                    if(i<27 && i === (day-1))
//                    {
//                        $td.eq( week % 7 +i).text('今天');
//                    }
//                    else{
//
//                    }
                    //是否有选择过到店日期
                    if(selectedFromYear == year && selectedFromMonth == month && selectedFromDay === (i+1) )
                    {
                        $td.eq( week % 7 +i).html('' +
                                '<span class=\'date\'>'+(index+1)+'</span>' +
                                '<span class=\'status\'>入住</span>').find('.date').addClass('selected-day');

                    }
                    //是否有选择过离店日期
                    else if(selectedToYear == year && selectedToMonth == month && selectedToDay === (i+1)  )
                    {
                        $td.eq( week % 7 +i).html('' +
                                '<span class=\'date\'>'+(index+1)+'</span>' +
                                '<span class=\'status\'>离店</span>').find('.date').addClass('selected-day');
                    }
                    //普通日期
                    else{
                        $td.eq( week % 7 +i).html('<span class=\'date\'>'+(index+1)+'</span>');
                    }

                }

                return week;
            }





            var week= initCal(currentYear,currentMonth,today);

            var fromDate = '';//到店日期 string zhuan date
            var toDate =''; //离店日期

            $('.calendar').find('td').click(function(){
                if(!$(this).hasClass('disable-day') && $(this).text()!=='' )
                {
                    var newDay = parseInt($(this).text());



                    //如果没有选择开始日期, 那么把这个日期选为开始日期
                    if(selectedDateType === 1)
                    {
                        selectedFromYear = newYear;
                        selectedFromMonth = newMonth;
                        selectedFromDay = newDay;
                         fromDate =new Date(selectedFromYear +'-'+selectedFromMonth+'-'+selectedFromDay);
                         toDate = new Date(selectedToYear +'-'+selectedToMonth+'-'+selectedToDay) ;

                        if(   fromDate > toDate)
                        {

                            alert('yes');
                        }


                        $('.selected-from-date').html(
                                '<span class=\'date\'>'+
                                    $('.selected-from-date').find('.date').text()+
                                '</span>').removeClass('selected-from-date'); //$(this).);


                        $td.eq( week % 7 +(newDay-1)).html('' +
                                '<span class=\'date\'>'+(newDay)+'</span>' +
                                '<span class=\'status\'>入住</span>').addClass('selected-from-date').find('.date').addClass('selected-day ');
                        //hasSelectedStartDay = true;

                        $('.from-date').text(selectedFromYear+'-'+selectedFromMonth+'-'+newDay);
                        //$('#calendar') .transition('horizontal flip');
                    }
                    //如果没有选择离店日期, 那么把这个日期选为离店日期
                    if(selectedDateType === 2){

                        selectedToYear = newYear;
                        selectedToMonth = newMonth;
                        selectedToDay =  newDay;
                        fromDate =new Date(selectedFromYear +'-'+selectedFromMonth+'-'+selectedFromDay);
                        toDate = new Date(selectedToYear +'-'+selectedToMonth+'-'+selectedToDay) ;

                        if(   fromDate > toDate)
                        {

                            alert('yes');
                        }

                        $('.selected-to-date').html(
                                '<span class=\'date\'>'+
                                $('.selected-to-date').find('.date').text()+
                                '</span>').removeClass('selected-to-date'); //$(this).);


                        $td.eq( week % 7 +(newDay-1)).html('' +
                                '<span class=\'date\'>'+(newDay)+'</span>' +
                                '<span class=\'status\'>离店</span>').addClass('selected-to-date').find('.date').addClass('selected-day ');
                        //hasSelectedStartDay = true;


                        $('.to-date').text(selectedToYear+'-'+selectedToMonth+'-'+newDay);
                    }



                }
            })

            $('.next-month').click(function(){

                //下个月
                newMonth += 1;
                week= initCal(newYear,newMonth,today);

            })
            $('.pre-month').click(function(){
                //上个月
                newMonth -= 1;
                week= initCal(newYear,newMonth,today);

            })

            $('.from-date').click(function(){
                //跳到入住日历
                if(selectedFromDay !== 0 )
                {
                   // alert();
                    week=initCal(selectedFromYear,selectedFromMonth,selectedFromDay);
                    newYear = selectedFromYear;
                    newMonth =  selectedFromMonth;

                }
                selectedDateType =1;
                $('.to-date').removeClass('select-date-click');
                $(this).addClass('select-date-click');
                //日历闪烁动效
                $('.selected-from-date').find('.date').transition('scale').transition('scale');
                if($('#calendar').css('display') === 'none')
                {
                    $('#calendar') .transition('horizontal flip');
                }
                else{
                    $('#calendar') .transition('pulse');
                }

            })

            $('.to-date').click(function(){
                //跳到离店日历
                if(selectedToDay !== 0 )
                {
                    week=initCal(selectedToYear,selectedToMonth,selectedToDay);
                    newYear = selectedToYear;
                    newMonth =  selectedToMonth;
                }
                selectedDateType =2;
                $('.from-date').removeClass('select-date-click');
                //日历闪烁动效
                $('.selected-to-date').find('.date').transition('scale').transition('scale');
                $(this).addClass('select-date-click');
                if($('#calendar').css('display') === 'none')
                {
                    $('#calendar') .transition('horizontal flip');
                }
                else{
                    $('#calendar') .transition('pulse');
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