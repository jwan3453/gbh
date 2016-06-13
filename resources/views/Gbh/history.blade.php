@extends('Gbh.site')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sticky.css') }}>

    <script src={{ asset('semantic/sticky.js') }}></script>


    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>

    <script src={{ asset('semantic/transition.js') }}></script>
@stop



@section('content')

    <div>


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
        </div>



        <div class="ui container">

            <div class="about-menu-nav">


                <span>关于我们</span>
                <span>团队介绍</span>
                <a href="/history"><span>团队经历</span></a>
                <a href="/joinUs"><span>加入我们</span></a>
                <span>联系我们</span>

            </div>

            <div class="padding-80"></div>
            <div class="history-box">
                <div class="auto-margin history-img">
                    <img src = 'Gbh/img/头像.jpg' >
                </div>
                <div class="vertical-line auto-margin">
                </div>
                <div class=" history-detail ">
                    <div class="year auto-margin">
                        2015/06
                    </div>
                </div>
            </div>
            <div class="history-box">
                <div class="auto-margin history-img1">
                    <img src = 'Gbh/img/头像.jpg' >
                </div>
            </div>
            <div class="history-box">
                <div class="auto-margin history-img">
                    <img src = 'Gbh/img/头像.jpg' >
                </div>
            </div>


        </div>






    </div>
@stop


@section('script')

    <script type="text/javascript">



        $(document).ready(function(){

            $('.history-img').transition('fly left');
            $('.history-img1').transition('fly right');
        })
    </script>

@stop