@extends('Gbh.site')

@section('resources')
    <link rel="stylesheet" type="text/css" href="/Gbh/css/css/style.css">
@stop

@section('content')


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

        <div id="hotlinking">

            <script type="text/javascript">showImg('http://mmbiz.qpic.cn/mmbiz/ibbmVK4uC7iacR4KGWnyJHvQxl276DK6eGlZQ10E7BeY7Fw0ZlnPLXOSF8W4qIiaCsNspcEiaicD0McR79qmicfPGntg/0');</script>

        </div>

        <div class=" article-page">


            @if(empty($article->wechat_url))
                <h1>{{ $article->title }}</h1>
                <h5>{{ $article->published_at }}</h5>
                <hr>
                <div >
                    {!!  $article->content_raw !!}
                </div>
            @else

                <div>{!! $article->wechat_content !!}</div>
                {{--<img style="background-image:url('http://mmbiz.qpic.cn/mmbiz/lAoypx8LichjjqgVa8HuHbwKhBSskP2LylMHLm7FAazGvyQf4pAox0p3E1OMqpePjkXCUS0oRlJSEDIVjH3CpCQ/0?wx_fmt=png')">--}}
                {{--<iframe  id="articleFrame"  name="articleFrame" scrolling="no" seamless="seamless"  class="article-frame" src="{{$article->wechat_url}}">--}}

                    {{--<script type="text/javascript">--}}
                        {{--alert('ca');--}}
                    {{--</script>--}}
                {{--</iframe>--}}
            @endif
        </div>

        <div class="article-foot">
            <div class="article-foot-span">阅读量 (  <span class="view-count">{{ $article->view_count }}</span>  )</div>
            @if( !empty($article->wechat_url))
                <div class="article-foot-span ">
                    <img src ='/Gbh/img/wechat.png' class="footer-icon"   data-html='test'/>
                </div>
                <div class="qr-image">
                    {!!  \SimpleSoftwareIO\QrCode\Facades\QrCode::size(200)->generate($article->wechat_url) !!}
                    <p>微信扫一扫，打开微信原文</p>
                </div>
            @endif
            <div class="heart " id="like" rel="like"></div> 
            <div class="likeCount" id="likeCount">{{ $article->praise }}</div>
            <input type="hidden" id="IPdata" value="0.0.0.0" />
            <input type="hidden" id="articleId" value="{{ $article->id }}" />




        </div>

        <!--高速版-->
        <div id="SOHUCS" style="width:800px;"></div>
        <script charset="utf-8" type="text/javascript" src="http://changyan.sohu.com/upload/changyan.js" ></script>
        <script type="text/javascript">
            window.changyan.api.config({
                appid: 'cysapDDLk',
                conf: 'prod_a32b64575fcb80032a6a060281e43884'
            });
        </script>
    </div>
@stop

@section('script')
    <script type="text/javascript">



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

           //加载二维码
            @if( !empty($article->wechat_url))
                $('.footer-icon').attr('data-html',$('.qr-image').html())
                    .popup({
                        position : 'top center'
                    })
            ;
            @endif


//            $('#articleFrame').load(function(){
//                alert('test');
//                var d=$('#articleFrame').contents().find("img").html();
//
//            })
             $('img').each(function(){
                 if($(this).attr('data-src')!=='')
                 {
                     $(this).attr('src',$(this).attr('data-src')).attr('data-src','');
                 }
             })

        })

    </script>

@stop