@extends('Gbh.site')

@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
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




                <div class="new-articles ">

                    @foreach($newArticles as $newArticle)
                        <a class="header dark-anchor" href="{{url('/article/'.$newArticle->id)}}">
                            <div class="hor-article-line">

                                <div class="image">
                                    <img src = "{{$newArticle->cover_image}}">
                                </div>
                                <div class="content">
                                    <span>{{$newArticle->title}}</span>
                                    <div class="meta">
                                        <span>{{$newArticle->published_at}}</span>
                                        <span>{{$newArticle->category_name}}</span>
                                    </div>
                                    <div class="description">
                                        {{$newArticle->brief}}
                                    </div>

                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>




    </div>
@stop


@section('script')
    <script type="text/javascript">

    </script>
@stop