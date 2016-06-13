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



            </div>


    </div>
@stop


@section('script')

    <script type="text/javascript">


    </script>

@stop