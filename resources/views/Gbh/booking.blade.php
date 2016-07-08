@extends('Gbh.site')

@section('resources')
@stop



@section('content')

    <title>团队介绍</title>
    <div >

        <div class="site-header">
            <div class="site-menu-nav ">
                <div>
                    <a  href="/"><span>首页</span></a>
                    <a href="/newArticles">
                        <span>最新文章</span>
                    </a>
                    <a href="/booking"><span>酒店预定</span></a>
                    <a href="/aboutUs"><span>关于我们</span></a>

                </div>
            </div>
            <div class="mobile-menu-nav">
                <i class="sidebar icon large"></i>
            </div>
        </div>

        <div class="ui container">
            <div class="ucons">
                <h3 >预定平台还未上线，我们程序猿正在紧张加班中.....</h3>
                <img   src="/Gbh/img/underConstruct.gif">
            </div>
        </div>


    </div>
@stop


@section('script')

    <script type="text/javascript">

        $(document).ready(function(){

        })
    </script>

@stop