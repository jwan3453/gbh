
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>

    <script src={{ asset('Gbh/js/site.min.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sidebar.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/container.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/popup.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/sticky.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('PersonalCV/site.css') }}>


</head>

<body >


    <div class="page-header-bg">

    </div>




    <div class="ui container">



        <div class="page-header">
        <div class="basic-info">
            <div class="name">
                <span>J</span>acky 王
            </div>
            <div class="phone">
                <span>1</span>8250863109
            </div>
            <div class="mail">
                <span>J</span>ackyloop@outlook.com
            </div>
        </div>

        <div class="title">
            一只苦逼的程序
            <img src="PersonalCV/monkey.png">
        </div>
        </div>





        <div class="skill-list">
            <div class="header">吃饭的家伙</div>
            <div class="skill">php</div>
            <div class="skill">laravel</div>
            <div class="skill">react</div>
            <div class="skill">.net</div>
            <div class="skill">laravel</div>
            <div class="skill">jquery</div>
            <div class="skill">html/css</div>
        </div>

        <div class="divided"></div>

        <div class="education-list">
            <div class="header">教育背景</div>
            <div class="university">
                <img src="PersonalCV/wollongong.png">

                <div class="up"><span class="u-name">澳洲卧龙岗大学</span><span class="major">Computer Science</span><span class="year">2009-2011</span></div>
                <div class="down"><span class="cap">U</span>niversity Of Wollongong </div>

            </div>

            <div class="university">
                <img src="PersonalCV/sydney.png">

                <div class="up"><span class="u-name">澳洲悉尼大学</span><span class="major">Software Engineer</span><span class="year">2011-2013</span></div>
                <div class="down"><span class="cap">T</span>he University Of Sydney</div>

            </div>
        </div>

        <div class="divided"></div>

        <div class="working-exp">
            <div class="header">工作经历</div>

            <div class="history-box">


                <div class="first-show">

                    <div class=" history-detail ">
                        <div class="year auto-margin">
                            2013/5
                        </div>
                        <div class="desc-right">
                            2013年5月悉尼大学毕业，6月到9月在澳洲lined media 担任web 开发工程师
                        </div>
                    </div>
                </div>

                <div class="vertical-line auto-margin">
                </div>
                <div class=" history-detail ">
                    <div class="year auto-margin">
                        2013/10
                    </div>
                    <div class="desc-left">
                        2013年10月 到 2015年1月 在澳洲 <a href="http://www.dickerdata.com">dicker data</a> 担任web 开发工程师
                    </div>
                </div>

                <div class="vertical-line auto-margin">
                </div>
                <div class=" history-detail ">
                    <div class="year auto-margin">
                        2015/04
                    </div>
                    <div class="desc-right">
                        2015年5月 回到国内,2015年6月 在厦门欧宝软件担任软件工程师
                    </div>
                </div>

                <div class="vertical-line auto-margin">
                </div>
                <div class=" history-detail ">
                    <div class="year auto-margin">
                        2016/01
                    </div>
                    <div class="desc-left">
                        2016年1月 在<a href="http://www.gbhchina.com">全球精品酒店</a> 担任技术合伙人
                    </div>
                </div>

                <div class="vertical-line auto-margin">
                </div>
                <div class=" history-detail ">
                    <div class="join-btn auto-margin">
                            <span class="up">今天</span>
                            <span>我会在哪里</span>
                    </div>
                </div>
            </div>
        </div>


        </div>
        <div class="padding-40"></div>
</body>




<script type="text/javascript">



    $(document).ready(function(){
            $('.university .up,.university .down').transition('fly right');
            $('.university').find('img').transition('fly left');

            $('.basic-info').transition('scale');
            $('.title').transition('scale');

            $('.title').find('img').hover(function(){
                $(this).transition('jiggle');
            },
            function(){

            });

            var time =500;

            $('.skill-list').find('.skill').each(function(){
              var obj= $(this);
                time = time+100;

               setTimeout(function(){
                   obj.addClass('hover-animation');
                   setTimeout(function(){
                       obj.removeClass('hover-animation');
                   },1000)
               },time);

            })

        $('.first-show').find('.history-people,.year ').transition({
            animation : 'scale',
            duration  : 800
        });
        $('.first-show').find('.vertical-line, .desc-right ').transition({
            animation : 'scale',
            duration  : 800

        });

        var timeout;
        $(window).scroll(function() {

            clearTimeout(timeout);
            timeout = setTimeout(function() {



                $('.history-people').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'scale',
                                duration  : 800
                            });
                    }
                })


                $('.vertical-line').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {
                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'scale',
                                duration  : 800
                            });
                    }
                })



                $('.history-detail').find('.year').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'scale',
                                duration  : 800
                            });
                    }
                })

                $('.history-detail').find('.desc-left').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'fly left',
                                duration  : 800
                            });
                    }
                })

                $('.history-detail').find('.desc-right').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'fly right',
                                duration  : 800
                            });
                    }
                })

                $('.history-detail').find('.logo-img').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'scale',
                                duration  : 800
                            });
                    }
                })
                $('.history-detail').find('.join-btn').each(function(){
                    //alert($(window).scrollTop());
                    if( $(window).scrollTop() > $(this).offset().top -600 ) {

                        if($(this).css('visibility') === 'hidden')
                            $(this).transition({
                                animation : 'scale',
                                duration  : 800
                            });
                    }
                })


            }, 50);

        });




    })



</script>

</html>
