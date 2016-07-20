@extends('Gbh.site')

@section('resources')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>

@stop



@section('content')

    <title>联系我们</title>
    <div >
        @include('partial.homeNav')
    <div class="ui container">

        <div class="about-menu-nav">

            <a href="/aboutUs" class="dark-anchor"><span>关于我们</span></a>
            <a href="/team" class="dark-anchor"><span>团队介绍</span></a>
            <a href="/history"  class="dark-anchor"><span>团队经历</span></a>
            <a href="/joinUs"  class="dark-anchor"><span>加入我们</span></a>
            <a href="/contactUs"  class="dark-anchor"><span>联系我们</span></a>
        </div>

        <div class="contactus-box">
            
            <div class="contactus-title">
                <h1>全球精品酒店联盟</h1>
            </div>

            <div class="contactus-small-title-box">
                <div class="contactus-small-title">

                    <div class="contactus-title-img">
                        <img src="/Gbh/icon/jichengma.png">
                    </div>
                    
                    <span>网盟合作</span>
                </div>
                <div class="contactus-small-title">

                    <div class="contactus-title-img">
                        <img src="/Gbh/icon/comments.png">
                    </div>

                    <span>广告投放</span>
                </div>
                <div class="contactus-small-title">

                    <div class="contactus-title-img">
                        <img src="/Gbh/icon/message-square.png">
                    </div>

                    <span>异业合作</span>
                </div>
                <div class="contactus-small-title">

                    <div class="contactus-title-img">
                        <img src="/Gbh/icon/xmfqr.png">
                    </div>

                    <span>品牌合作</span>
                </div>
            </div>

            <div class="find-us">
                <div class="find-us-line"></div>
                <span class="find-us-font">联系我们</span>
            </div>
        </div>
    </div>



        <div class="map-box" id="map"></div>
    </div>
@stop


@section('extra')


    <div class="detail-box " >
        <div class="detail-address" >

            <div class="detail-row address">
                厦门市思明区观音山运营中心12号楼6楼
            </div>



            <div class="detail-row">
                <label>联系邮箱 : </label>
                <span>business@gbhchina.com</span>
            </div>

            <div class="detail-row">
                <label>酒店预定 : </label>
                <span>booking@gbhchina.com</span>
            </div>


            <div class="detail-row">
                <label>商务合作 : </label>
                <span>000-000-000</span>
            </div>

            <div class="detail-row">
                <img src ='/Gbh/img/wechat.png' class="footer-icon wechat-icon"   data-html=''  />
            </div>
            <div class="qr-image">
                <img src = "/Gbh/img/wechat_qr.jpg" style="width:200px; height:200px;">
                <span style="font-size:14px; display: block;width: 100%; text-align: center">微信扫一扫，关注我们的公众号</span>
            </div>

        </div>

        <div class="contact-box">
            <div class="messageForm-mask" id="messageMask">
                <i class="checkmark icon massive green  "></i>
                <span>发送成功</span>
            </div>
            <form action="{{url('/submitMessage')}}" method="post" id="messageFrom">
                <input placeholder="名字/Name "  name="name"/>
                <input placeholder="邮箱/Email" name="email"/>
                <textarea  placeholder="留言/Message" name="message"></textarea>
                <div class="regular-btn submit-Msg">提交留言</div>
            </form>
        </div>

    </div>
    <div style="height:310px;width:100%;visibility: hidden"></div>
@stop


@section('script')
<script type="text/javascript">


        $(document).ready(function() {


            $(function () {
                var map = new BMap.Map("map");
                var point = new BMap.Point('118.201383', '24.494217');
                map.centerAndZoom(point, 20);

                var marker = new BMap.Marker(point);  // 创建标注

                map.addOverlay(marker);               // 将标注添加到地图中
                marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
                // map.enableScrollWheelZoom(false); //设置鼠标滚轮
                // map.enableScrollWheelZoom(true);


            })

            $('.contactus-small-title').hover(function () {
                        $(this).find('.contactus-title-img').addClass('contactus-title-img-hover')
                    },
                    function () {
                        $(this).find('.contactus-title-img').removeClass('contactus-title-img-hover')

                    })

            $('.wechat-icon').hover(function () {
                        $(this).attr('src', '/Gbh/img/wechat_green.png');
                    },
                    function () {
                        $(this).attr('src', '/Gbh/img/wechat.png');
                    })

            $('.footer-icon').attr('data-html', $('.qr-image').html())
                    .popup({
                        position: 'right center'
                    })


            $('.submit-Msg').click(function(){



                var options = {
                    url: '/submitMessage',
                    type: 'post',
                    dataType: 'json',
                    data: $("#messageFrom").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {

                            $('#messageMask').transition({
                                animation:'scale',
                                onComplete: function(){
                                    $('.checkmark').transition('tada')
                                }
                            });

                        }
                    },
                    error:function(data){

                    }
                };
                $.ajax(options);


            })
        });
    </script>
@stop