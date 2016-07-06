@extends('Gbh.site')

@section('resources')
@stop



@section('content')

    <title>最新文章</title>
    <div >

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

                    <div class="article-nav">
                        <div class="article-nav-btn " id="0">全部</div>
                        @foreach($newArticles['category'] as $category)
                        <div class="article-nav-btn " id="{{$category->id}}">{{$category->category_name}}</div>

                        @endforeach
                        <div class="nav-under-line"></div>
                    </div>

                    <div id="articleList">

                        @foreach($newArticles['article'] as $newArticle)
                            <a class="header dark-anchor" href="{{url('/article/'.$newArticle->id)}}">
                                <div class="hor-article-line">

                                    <div class="image">
                                        <img src = "{{$newArticle->cover_image}}">
                                    </div>
                                    <div class="content">
                                        <span class="header">{{$newArticle->title}}</span>
                                        <div class="meta">
                                            <span>{{$newArticle->published_at}}</span>
                                            <span>{{$newArticle->category_name}}</span>
                                            <div class="view-like">
                                                <span class="view"> <i class=" unhide  icon "></i>  {{$newArticle->view_count}}</span>
                                                <span class="like"> <i class=" thumbs outline up icon "></i>  {{$newArticle->praise}} </span>
                                            </div>
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






    </div>
@stop


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){


            $('.nav-under-line').width= $('.article-nav-btn').width()+10;

            $('.article-nav-btn').click(function(){

                var index = parseInt($(this).index());
                $(this).addClass('article-nav-btn-selected').siblings('.article-nav-btn').removeClass('article-nav-btn-selected');
                $('.nav-under-line').animate({left:(index * ($('.article-nav-btn').width()+10))},'fast','swing');

                var category  =  $(this).attr('id');

                $.ajax({
                    type: 'POST',
                    url: '/getArticleByCate',
                    data: {category:category},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend : function(){
                        $("#articleList").html("");
                        var s = '';
                        s += '<div class="ui active inverted dimmer order-loading">';
                        s += 	'<div class="ui text loader">Loading</div>';
                        s += '</div>'
                        $("#articleList").html(s);

                        var windowh = $(window).height();
                        var footerh = $(".footer-section").height();
                        var loadingh = windowh - footerh ;
                        $(".order-loading").css('height',loadingh+'px');
                    },
                    success: function(data){

                        $("#articleList").html("");
                        var status = data.statusCode;
                        if(status === 1)
                        {
                            var articles = data.extra;

                            if(articles.length === 0)
                            {
                                var a = "";

                                    a +=   '<div class="error-box">'+
                                                '<img class="auto-margin" src = \'/Gbh/img/noItemFound.png\'>'+
                                                '<span >暂时没有文章</span>'+
                                                '<span>我们的体验师，撰稿员在紧张工作中</span>'+
                                            '</div>';
                                $("#articleList").append(a);
                            }
                            else {
                                for(var i=0; i<articles.length; i++)
                                {
                                    var a = "";
                                    a +=   '<a class="header dark-anchor" href="/article/'+articles[i].id+'">'+
                                            '<div class="hor-article-line">'+

                                            '<div class="image">'+
                                            '<img src = "'+articles[i].cover_image+'">'+
                                            '</div>'+
                                            '<div class="content">'+
                                            '<span class="header">'+articles[i].title+'</span>'+
                                            '<div class="meta">'+
                                            '<span>'+articles[i].published_at+'</span>'+
                                            '<span>'+articles[i].category_name+'</span>'+
                                            '<div class="view-like">'+
                                            '<span class="view"> <i class=" unhide  icon "></i>'+articles[i].view_count+'</span>'+
                                            '<span class="like"> <i class=" thumbs outline up icon "></i>' +articles[i].praise +'</span>'+
                                            '</div>'+
                                            '</div>'+
                                            '<div class="description">'+
                                            articles[i].brief+
                                            '</div>'+
                                            '</div>'+
                                            '</div>'+
                                            '</a>';
                                    $("#articleList").append(a);
                                }
                            }

                        }

//                        for (var i = 0; i < order.length; i++) {
//                            var a = "";
//                            a += '<div class="order-colmun">';
//                            a += 	'<div class="order-number-time">';
//                            a +=		'<span>订单号：'+order[i].orderSN+'</span>';
//                            a +=		'<span class="order-list-time">';
//                            a +=			'<img src="../GbhMobile/img/clock.png">'+order[i].ordertime;
//                            a +=		'</span>';
//                            a +=	'</div>';
//
//                            a +=	'<div class="order-colmun-img-text">';
//                            a +=		'<div class="order-colmun-img">';
//                            a +=			'<img src="../GbhMobile/personnelportrait/order-img.png">';
//                            a +=		'</div>';
//                            a +=		'<div class="order-colmun-text">';
//                            a +=			'<div class="order-colmun-room-name">'+order[i].hotelName+'</div>';
//                            a +=			'<div class="order-colmun-arrive-time">到店时间：'+order[i].arriveTime+'</div>';
//                            a +=		'</div>';
//                            a += 	'</div>';
//
//                            a +=	'<div class="order-colmun-foot">';
//                            a +=		'<span>订单状态：已完成</span>';
//                            a +=		'<div class="order-colmun-rating">';
//                            a +=			'<div class="ui star rating" data-rating="'+order[i].orderRating+'" data-max-rating="5"></div>';
//                            a +=		'</div>';
//                            a +=	'</div>';
//                            a += '</div>';
//
//                            $("#orderList").append(a);
//
//                        }

                    },
                    error: function(xhr, type){
                        alert('Ajax error!')
                    }
                });

            })
        })

    </script>
@stop