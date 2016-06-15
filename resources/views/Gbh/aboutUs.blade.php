@extends('Gbh.site')

@section('resources')
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
@stop



@section('content')
<div>

    <div class="site-header">
        <div class="site-menu-nav">
            <div>
                <a href="/">
                    <span>首页</span>
                </a>
                <span>最新文章</span>
                <span>酒店预定</span>
                <a href="/aboutUs">
                    <span>关于我们</span>
                </a> <i class="icon user large"></i>
            </div>
        </div>
    </div>

    <div class="ui container">

        <div class="about-menu-nav">

            <span>关于我们</span>
            <span>团队介绍</span>
            <a href="/history">
                <span>团队经历</span>
            </a>
            <a href="/joinUs">
                <span>加入我们</span>
            </a>
            <span>联系我们</span>

        </div>

        <div class="about-us-img">
            <img src="/Gbh/img/banner.png">
        </div>


        <div class="about-us-desc-box">
            <div class="about-us-title">
                <span>公司简介</span>
            </div>

            <div class="about-us-desc">
                <span>飞鱼科技成立于2014年3月，是国内领先的互联网游戏开发和运营商，由厦门光环信息科技有限公司发展而来，本着“简单有趣”的企业理念，致力于互动娱乐产品的研发与运营。</span>
                
                <span>2013年12月，光环游戏与国内领先的休闲手机游戏研发商“凯罗天下”强强联手，合并成立飞鱼科技。2014年12月5日，飞鱼科技正 式登陆香港联交所上市，股票代码为01022.</span>

                <span>HK，依靠产品和业绩取得了 资本市场广大投资者的认可，上市首年的表现可圈可点。</span>
                <span>飞鱼科技在全国进行战略化布局，分支机构遍布北京、深圳、成都等国内主要城市；公司旗下拥有数款具有良好口碑的游戏，如《神仙道》《保卫 萝卜》《囧西游》《乱世之刃》《三国之刃》《大话神仙》等，凭借优质的产品、服务质量、受欢迎程度高获得多项奖项及公众认可，游戏用户遍及中国大陆及海外 地区。</span>
            </div>
            <div class="about-us-slogan">
                <span>“简单有趣” 是我们对游戏不变的追求</span>
                <span>创造力深植我们的基因，让我们把无限可能都实现。</span>
                <span>飞鱼，守护游戏初衷</span>
                <span>做最纯粹的快乐创造者</span>
            </div>
        </div>

    </div>

</div>
@stop


@section('script')
<script type="text/javascript"></script>
@stop