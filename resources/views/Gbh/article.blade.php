@extends('Gbh.site')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/item.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/image.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/css/style.css') }}>
@stop

@section('content')


    <div class="pusher">

        <div class="site-header">
            <div class="site-menu-nav">
                <div>
                    <a  href="/">
                        <span>首页</span>
                    </a>
                    <span>最新文章</span>
                    <span>酒店预定</span>
                    <a href="/aboutUs">
                        <span>关于我们</span>
                    </a> <i class="icon user large"></i>
                </div>
            </div>
            <div class="mobile-menu-nav">
                <i class="sidebar icon large"></i>
            </div>
        </div>

        <div class=" article-page">

            <h1>{{ $article->title }}</h1>
            <h5>{{ $article->published_at }}</h5>
            <hr>
            <div >
                {!!  $article->content_raw !!}
            </div>

        </div>

        <div class="article-foot">
            <span class="article-foot-span">阅读量 (  <span class="view-count">{{ $article->view_count }}</span>  )</span>

            <div class="heart " id="like" rel="like"></div> 
            <div class="likeCount" id="likeCount">{{ $article->praise }}</div>
            <input type="hidden" id="IPdata" value="0.0.0.0" />
            <input type="hidden" id="articleId" value="{{ $article->id }}" />
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">

        //        $('.slide-caption').transition('fly left');
        $(window).load(function(){
            $('.owl-carousel').owlCarousel({
                loop:true,
                responsiveClass:true,
                autoplay:true,
                autoplayTimeout:4000,
                autoHeight:true,

                responsive:{
                    0:{
                        items:1,

                        loop:true
                    },
                    600:{
                        items:1,

                        loop:true
                    },
                    1000:{
                        items:1,

                        loop:true
                    }
                }
            })
        })

        $(document).ready(function(){
            var url = 'http://chaxun.1616.net/s.php?type=ip&output=json&callback=?&_='+Math.random();  
            
            $.getJSON(url, function(data){
                $("#IPdata").val(data.Ip);
            });

            setTimeout(function () {
                var articleId = $("#articleId").val();
                if (sessionStorage.getItem("article_"+articleId) != null) {
                    var ip = $("#IPdata").val();
                    console.log(ip);
                    var praiseIp = sessionStorage.getItem("article_"+articleId);
                    console.log(praiseIp);
                    if (praiseIp == ip) {
                        $("#like").addClass("heartAnimation").attr("rel","unlike");
                    }
                }
            }, 1000);

            

            $('.hotel-box').hover(function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').addClass('blur');
                        $(this).find('.hotel-box-mask').fadeIn(300);
                    },
                    function(){
                        $(this).find('img,.h-hotel-name,.h-hotel-brief,.h-article-title').removeClass('blur');
                        $(this).find('.hotel-box-mask').fadeOut(100);
                    })



            $('body').on("click",'.heart',function(){
        
                var articleId = $("#articleId").val();
                var ip = $("#IPdata").val();

                var C=parseInt($("#likeCount").html());
                $(this).css("background-position","")
                var D=$(this).attr("rel");
                if(D === 'like') {    
                    $.ajax({
                        type: 'POST',
                        url: '/gbh/article/praise',
                        data: {articleId : articleId},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success:function(data){
                            if (data.statusCode == 1) {
                                $("#likeCount").html(C+1);
                                sessionStorage.setItem("article_"+articleId, ip);
                                $("#like").addClass("heartAnimation").attr("rel","unlike"); 
                            }else{
                                alert('网络错误');
                            }

                        }
                    }) 


                    
                }
                else{
                    return false;
                }
            });
        })

    </script>

@stop