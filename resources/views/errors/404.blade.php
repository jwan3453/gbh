@extends('Gbh.site')



@section('resources')


@stop

@section('content')

    <div class="pusher">
        <div class="site-header">
            <div class="site-menu-nav">
                <div>
                    <a href="/"><span>首页</span></a>
                    <span>最新文章</span>
                    <span>酒店预定</span>
                    <a href="/aboutUs"><span>关于我们</span></a>
                    <i class="icon user large"></i>
                </div>
            </div>
            <div class="mobile-menu-nav">
                <i class="sidebar icon large"></i>
            </div>
        </div>


        <div class="error-box">


            <img class="auto-margin" src = '/Gbh/img/doge.png'>
            <span class="giant-font">404 Page Not Found</span>
            <p class="giant-font">页面没找到，小二打酱油去了</p>
            <a href="/"><div class="regular-btn red-btn auto-margin">带我回首页</div></a>

        </div>
    </div>
@stop


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

        })
    </script>

@stop