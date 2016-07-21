@extends('Gbh.site')

@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.min.js') }}></script>
@stop



@section('content')

    <title>团队介绍</title>
    <div >

        @include('partial.homeNav')

        <div class="ui container" style="position:relative">

            <div class="about-menu-nav " >

                <a href="/aboutUs" class="dark-anchor"><span>关于我们</span></a>
                <a href="/team" class="dark-anchor"><span>团队介绍</span></a>
                <a href="/history"  class="dark-anchor"><span>发展历程</span></a>
                <a href="/joinUs"  class="dark-anchor"><span>加入我们</span></a>
                <a href="/contactUs"  class="dark-anchor"><span>联系我们</span></a>

            </div>


            <div class = 'title-text'>
                <div class="up">TEAM</div>
                <div class="down auto-margin">团队</div>
            </div>

            <div class="team-member">

                <div class="mem-left member"  >
                    <img src = 'Gbh/img/shao_center.png'  data-title="jacky 王" data-content="2016年1月加入联盟,毕业于悉尼大学，现在在联盟担任技术合伙人一职位" >
                    <div class="position">shawn 普</div>
                </div>

                <div class="mem-middle member">
                    <img src = 'Gbh/img/ming_center.png' data-content="这个就是小明，嗯">
                    <div class="position">Ben 傅</div>
                </div>

                <div class="mem-right member" >

                </div>

            </div>



        </div>

        <div class="ui page dimmer">

            <div class="team-member-dimmer" >
                <div ><i class="remove icon large teal"></i></div>
                <img src='' id="teamMemberDimmer"/>
                <div class="member-desc" id="memberDesc">
                </div>
            </div>
        </div>


    </div>
@stop


@section('script')

    <script type="text/javascript">

        $(document).ready(function(){
            $('.mem-left,.mem-middle,.mem-right').hover(function(){
                        dimmerAnimation($(this));
                    },
                    function(){

                    })




//            $('.mem-right').hover(function(){
//                        $(this).find('img').transition('tada').attr('src','Gbh/img/w-middle.png');
//
//                    },
//                    function(){
//                        $(this).find('img').attr('src','Gbh/img/w-left.png');
//                    })

//            $('.mem-left,.mem-middle').find('img')
//                    .popup({
//
//                        position : 'bottom center'
//
//                    })
//            ;

            $('.remove').click(function(){
                $('#teamMemberDimmer').transition('fade');
                $('#memberDesc').transition('fade');
                $('.dimmer').dimmer('hide');
            })


            function dimmerAnimation(obj){

                $('#teamMemberDimmer').attr('src',obj.find('img').attr('src'));
                $('#memberDesc').text(obj.find('img').attr('data-content'));
                $('.dimmer')
                        .dimmer({
                            onShow:function(){

                                $('#teamMemberDimmer').transition('fly right');
                                $('#memberDesc').transition('fly left');
                            },
                            opacity:0.95,
                            closable:false
                        }).dimmer('show');
                ;
            }
        })
    </script>

@stop