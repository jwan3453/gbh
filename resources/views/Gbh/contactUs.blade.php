@extends('Gbh.site')

@section('resources')
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sticky.css') }}>

<script src={{ asset('semantic/sticky.js') }}></script>

<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
@stop



@section('content')
    <div class="pusher">

    <div class="site-header">
        <div class="site-menu-nav">
            <div>
                <a  href="/">
                    <span>首页</span>
                </a>
                <a href="/newArticles">
                    <span>最新文章</span>
                </a>
                <span>酒店预定</span>
                <a href="/aboutUs">
                    <span>关于我们</span>
                </a>
            </div>
        </div>
        <div class="mobile-menu-nav">
            <i class="sidebar icon large"></i>
        </div>
    </div>

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


            <div class="map-box" id="map"></div>

            <div class="detail-box">
                <div class="detail-address">
                    <div class="detail-row">
                        <label><img src="/Gbh/icon/address.png" />详细地址 : </label>
                        <span>七星西路福达里小区凡悦咖啡厅</span>
                    </div>

                    <div class="detail-row">
                        <label><img src="/Gbh/icon/mail.png" />联系邮箱 : </label>
                        <span>gjackie2085@gmail.com</span>
                    </div>

                    <div class="detail-row">
                        <label><img src="/Gbh/icon/call.png" />联系电话 : </label>
                        <span>400-100-5678</span>
                    </div>

                    <div class="detail-row">
                        <label><img src="/Gbh/icon/contacts.png" />联  系  人   : </label>
                        <span>Mr. Jackie</span>
                    </div>
                    
                </div>
            </div>

        </div>

    </div>

</div>
@stop


@section('script')
<script type="text/javascript">

        $(function(){
            var map = new BMap.Map("map");
            var point = new BMap.Point('118.102058', '24.494934');
            map.centerAndZoom(point, 20);

            var marker = new BMap.Marker(point);  // 创建标注

            map.addOverlay(marker);               // 将标注添加到地图中
            marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
            // map.enableScrollWheelZoom(false); //设置鼠标滚轮
            // map.enableScrollWheelZoom(true);
             map.disableDragging();
                
          })
    </script>
@stop