@extends('GbhMobile.site')


@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/rating.css') }}>
    <script type="text/javascript" src="{{ asset('semantic/rating.js') }}"></script>

@stop


@section('content')

    <div >

        <div class='hotel-img-section' >
            <img  src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);" />
            <img src = '../GbhMobile/img/tu1.png' class="hotel-detail-img">
            <div class="general-price">
                <label><span> 厦门美都酒店</span></label>
                <img src = ../GbhMobile/img/特价黑色.png>
            </div>
            <i class="empty heart  icon large"></i>
        </div>


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
            <div class="geo-detail">
                <i class="icon marker large"></i>
                <span>厦门市思明区官邸大厦</span>
                <i class=" angle right icon big f-right"></i>
            </div>



            <div class="r-type">

                <a class="r-detail" href={{url('hotel/1/booking/4')}}>
                    <img src = '../GbhMobile/img/tu1.png'>
                    <div class="r-info">
                            <span class="up">大床房 28-32平方米</span>
                            <span class="down">含双早</span>
                    </div>
                    <div class="r-price">
                        ￥<span class="pri">999</span>
                    </div>
                </a>

                <div class="r-detail">
                    <img src = '../GbhMobile/img/tu1.png'>
                    <div class="r-info">
                        <span class="up">双床房 28-32平方米</span>
                        <span class="down">含双早</span>
                    </div>
                    <div class="r-price">
                        ￥<span class="pri">999</span>
                    </div>
                </div>



                <div class="r-detail">
                    <img src = '../GbhMobile/img/tu2.png'>
                    <div class="r-info">
                        <span class="up">豪华单间 28-32平方米</span>
                        <span class="down">含双早</span>
                    </div>
                    <div class="r-price">
                        ￥<span class="pri">999</span>
                    </div>
                </div>


                <div class="r-detail">
                    <img src = '../GbhMobile/img/tu2.png'>
                    <div class="r-info">
                        <span class="up">大床房 28-32平方米</span>
                        <span class="down">含双早</span>
                    </div>
                    <div class="r-price">
                        ￥<span class="pri">999</span>
                    </div>
                </div>

            </div>
        </div>
        <div class="padding-15"></div>

        <div>
            <div class="r-fac">
                <div class="r-fac-header">
                    酒店服务
                </div>
                <div class="r-fac-list">
                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>

                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>

                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>

                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>


                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>

                    <div class="r-fac-grid ">
                        <div class="r-fac-icon auto-margin   ">
                            <img src="../GbhMobile/img/停车位.png">
                            <span>停车场</span>
                        </div>
                    </div>

                    <div class="r-fac-more">查看全部<i class="icon angle down large"></i></div>

                </div>
            </div>
        </div>
        <div class="padding-15"></div>

        <div>
            <div class="r-comments">
                <div class="r-point">
                    <span class="ave-point f-left">4.4/5 分</span>
                    <span class="t-point f-right" >100 条评论</span>
                </div>

                <div class="r-com-box">
                    <img src="../GbhMobile/img/user_s.png">
                    <div class="cus-info">
                        <span class="up">18250863109</span>
                        <span class="down">2016-04-05</span>
                    </div>
                    <div class="star-point">
                        <div class="ui star rating" data-rating="4" data-max-rating="5" id="totalScore"></div>
                    </div>

                    <div class="comm-detail">
                        <div class="triangle-up-small"></div>
                        <div class="text">
                         很干净，服务也很好，早产也很好吃，下次还不来，下下次也会来
                        </div>
                    </div>

                </div>

                <div class="r-com-box">
                    <img src="../GbhMobile/img/user_s.png">
                    <div class="cus-info">
                        <span class="up">18250863109</span>
                        <span class="down">2016-04-05</span>
                    </div>
                    <div class="star-point">
                        <div class="ui star rating" data-rating="4" data-max-rating="5" id="totalScore"></div>
                    </div>

                    <div class="comm-detail">
                        <div class="triangle-up-small"></div>
                        <div class="text">
                            很干净，服务也很好，早产也很好吃，下次还不来，下下次也会来
                        </div>
                    </div>

                </div>
                <div class="r-fac-more">查看全部<i class="icon angle down large"></i></div>
            </div>

        </div>

        <div class="padding-15"></div>
        <div >
            <div class="h-policy">
                <div class="h-p-header">
                    酒店政策
                </div>

                <div class="h-p-detail">
                    入住时间: 14:00 以后
                </div>
                <div class="h-p-detail">
                    不可携带宠物
                </div>
                <div class="h-p-detail">
                    接受信用卡
                </div>
                <div class="h-p-detail">
                    接机服务需要收费
                </div>

            </div>
        </div>
    </div>








@stop

@section('script')
    <script type="text/javascript">
        $('#redefineBox').click(function(){
            $('.ui.sidebar')
                    .sidebar('toggle');

        })

        $('.heart').click(function(){
            if($(this).hasClass('empty'))
            {
                $(this).removeClass('empty').css('color','#ff5f76').transition('jiggle');
            }
            else{
                $(this).addClass('empty').css('color','#f8f8f8');
            }
        })
        $('.ui.star.rating').rating('disable');
    </script>


@stop