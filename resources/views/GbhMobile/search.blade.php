@extends('GbhMobile.site')





@section('content')

    <div class="pusher">
        <div class="nav-header">
            <img src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);" />
            <span class="nav-header-text">搜索结果</span>
        </div>

        <div class="redefine-search" id="redefineBox">

            <div class="redefine-date-box f-left">
                <div class="from">
                    <span>2016-05-05</span>起
                </div>
                <div class="to">
                    <span>2016-05-05</span>起
                </div>
                <i class="icon calendar"> </i>
            </div>

            <div class="redefine-destin-box  f-left">

                <span>厦门</span>
                <i class="icon marker large"></i>
            </div>
        </div>

        <div class="filter-box">
            <div class="filter"><span>价格</span><img src="../GbhMobile/img/上.png"></div>
            <div class="filter"><span>价格</span><img src="../GbhMobile/img/上.png"></div>
            <div class="filter"><span>价格</span><img src="../GbhMobile/img/上.png"></div>
            <div class="filter"><span>更多选择</span></div>
        </div>

        <div class='hotel-list-section' >
            <img src = '../GbhMobile/img/tu1.png'>
            <div class="general-price">
                <label>￥<span> 666</span></label>
                <img src = ../GbhMobile/img/特价黑色.png>
            </div>
            <div class="hotel-location">
                <span class="f-left g-info" >     <i class="icon marker "></i>厦门思明区官邸大厦</span>
            </div>

            <div class="hotel-location">
                <span class="f-left p-info" >   厦门美都酒店</span>
                <span class="f-right p-info" >   4.0/5 评分</span>
            </div>


        </div>

        <div class="padding-15"></div>
        <div class='hotel-list-section' >
            <img src = '../GbhMobile/img/tu1.png'>
            <div class="general-price">
                <label>￥<span> 666</span></label>
                <img src = ../GbhMobile/img/特价黑色.png>
            </div>
            <div class="hotel-location">
                <span class="f-left g-info" >     <i class="icon marker "></i>厦门思明区官邸大厦</span>
            </div>

            <div class="hotel-location">
                <span class="f-left p-info" >   厦门美都酒店</span>
                <span class="f-right p-info" >   4.0/5 评分</span>
            </div>


        </div>

        <div class="padding-15"></div>
        <div class='hotel-list-section' >
            <img src = '../GbhMobile/img/tu1.png'>
            <div class="general-price">
                <label>￥<span> 666</span></label>
                <img src = ../GbhMobile/img/特价黑色.png>
            </div>
            <div class="hotel-location">
                <span class="f-left g-info" >     <i class="icon marker "></i>厦门思明区官邸大厦</span>
            </div>

            <div class="hotel-location">
                <span class="f-left p-info" >   厦门美都酒店</span>
                <span class="f-right p-info" >   4.0/5 评分</span>
            </div>


        </div>

        <div class="padding-15"></div>

    </div>

    @include('GbhMobile.partial.searchSideBar')


@stop

@section('script')
    <script type="text/javascript">
        $('#redefineBox').click(function(){
            $('.ui.sidebar')
                    .sidebar('toggle');

        })
    </script>


@stop