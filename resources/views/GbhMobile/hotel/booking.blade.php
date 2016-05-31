@extends('GbhMobile.site')


@section('resources')


@stop


@section('content')

    <div>
        <div class="nav-header">
            <img src="/GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);" />
            <span class="nav-header-text">厦门美都酒店</span>
        </div>

        <a class="r-detail" href={{url('hotel/1/booking/4')}}>
            <img src = '/GbhMobile/img/tu1.png'>
            <div class="r-info">
                <span class="up">大床房 28-32平方米</span>
                <span class="down">含双早</span>
            </div>


        </a>
    </div>
    <div class="padding-15"></div>

    <div>
        <div class="f-t-detail">

            <div class='f-date'>
                <span class="text">入住</span>
                <span class="date">2015-10-11</span>
            </div>

            <div class='t-date'>
                <span class="text">离店</span>
                <span class="date">2015-10-11</span>
            </div>

        </div>
        <div class="t-days">
            一共<span>7</span>晚
        </div>
    </div>

    <div class="padding-15"></div>

    <div>
        <div class="booking-info" >
            <div class="r-number">
                <span class="text f-left">房间数 </span><span class="price">(单价:￥999 )</span>
                <div class="r-num-count">
                    <i class=" f-left minus large  icon  icon-count "></i>
                    <input class="f-left  big-font quantity" type="text"  value="1"/>
                    <i class="f-left  plus large icon   icon-count"></i>

                </div>
            </div>
            <div class="in-h-time">
                <span class="text f-left">到店时间 </span>
                <span class="time f-right">14:00-15:00 <i class="icon right angle large"></i></span>
            </div>
        </div>
    </div>

    <div class="padding-15"></div>

    <div>
        <div class="cus-detail">
            <div class="cus-line-detail" id="p_1">
                <span class="text f-left" >入住人姓名</span>

                <input type="text" placeholder="请输入入住人姓名" class="f-right">
            </div>
        </div>
    </div>

    <div class="padding-15"></div>

    <div >
        <div class="cus-contact">
            <span class="text f-left" >联系电话</span>

            <input type="text" placeholder="请输入联系号码" class="f-right">
        </div>
    </div>
    <div class="padding-15"></div>

    <div class="confirm-booking" >
        <div class="b-t-amount f-left">
            <span>总金额 :</span> <span class="t-amount">￥20000</span>
        </div>
        <div class="b-confirm-btn f-right">
            确认订单
        </div>
    </div>


@stop


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

            var personCount = 1;

            $('.plus').click(function(){

                if( personCount <=10 )
                {
                    personCount += 1;
                    var person_html = $('#p_1').html();
                    $('.cus-detail').append('<div class="cus-line-detail" id="p_'+personCount+'">'
                            +person_html
                            +'</div>');
                }

            })

            $('.minus').click(function(){

                if(personCount !== 1)
                {
                    $('#p_'+personCount).remove();
                    personCount -= 1;
                }

            })
        })

    </script>


@stop