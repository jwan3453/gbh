@extends('Gbh.site')

@section('resources')

@stop



@section('content')

    <div >

        <div class="site-header">
            <div class="site-menu-nav">
                <div>
                    <a href="/"><span>首页</span></a>
                    <a href="/newArticles">
                        <span>最新文章</span>
                    </a>
                    <span>酒店预定</span>
                    <a href="/aboutUs"><span>关于我们</span></a>

                </div>
            </div>
            <div class="mobile-menu-nav">
                <i class="sidebar icon large"></i>
            </div>
        </div>

        <div class="ui container">

            <div class="about-menu-nav">


                <a href="/aboutUs" class="dark-anchor"><span>关于我们</span></a>
                <a href="/team" class="dark-anchor"><span>团队介绍</span></a>
                <a href="/history"  class="dark-anchor"><span>团队经历</span></a>
                <a href="/joinUs"  class="dark-anchor"><span>加入我们</span></a>
                <a href="/contactUs"  class="dark-anchor"><span>联系我们</span></a>
            </div>


            <div class="recruit-section" >

                <div class="recruit-title-list ui sticky" id="recruitTitleList">

                        <span id="uiBtn">
                            UI设计师
                        </span>
                        <span id="phpBtn">
                            php程序员
                        </span>
                        <span id= "ooBtn">
                            渠道经理
                        </span>

                    </div>

                <div class="recruit-box-list" id="recruitBoxList">
                    <div class="recruit-box" id="ui">

                        <div class="header">
                            <div >
                                <span class="title">
                                    UI 设计师
                                </span>

                                <span class="depart">
                                    (2人) 开发部
                                </span>
                            </div>

                            <div style="margin-top:10px;">
                                <span class="salary">
                                    5k ~ 8k
                                </span>

                                <span class="brief">
                                    经验1-2年/本科
                                </span>

                                <div class="submit-resume">投递</div>
                            </div>
                        </div>
                        <div class="recruit-detail">
                            <span>工作职责:</span>
                            <div class="padding-10"></div>

                            <span>1.负责后端业务逻辑编写</span>

                            <span>2.根据业务逻辑设计功能模块</span>

                            <span>3.具有良好的编码规范, 良好的沟通表达能力</span>



                            <div class="padding-30"></div>

                            <span>能力要求:</span>
                            <div class="padding-10"></div>
                            <span>1.一年左右php工作经验,能独立开发网站模块；</span>

                            <span>2.熟练掌握laravel,yii,think php 任意一种(最好会laravel)</span>

                            <span>3.熟练掌握jquery,html,css . 熟悉并使用过一些前端框架</span>


                            <div class="padding-30"></div>

                            <span> 招聘人数:3</span>
                        </div>

                    </div>

                    <div class="recruit-box" id="php">

                        <div class="header">
                            <div >
                                <span class="title">
                                    PHP 程序员
                                </span>

                                <span class="depart">
                                    (2人) 开发部
                                </span>
                            </div>

                            <div style="margin-top:10px;">
                                <span class="salary">
                                    5k ~ 8k
                                </span>

                                <span class="brief">
                                    经验1-2年/本科
                                </span>
                                <div class="submit-resume">投递</div>
                            </div>
                        </div>
                        <div class="recruit-detail">
                            <span>工作职责:</span>
                            <div class="padding-10"></div>

                            <span>1.负责后端业务逻辑编写</span>

                            <span>2.根据业务逻辑设计功能模块</span>

                            <span>3.具有良好的编码规范, 良好的沟通表达能力</span>



                            <div class="padding-30"></div>

                            <span>能力要求:</span>
                            <div class="padding-10"></div>
                            <span>1.一年左右php工作经验,能独立开发网站模块；</span>

                            <span>2.熟练掌握laravel,yii,think php 任意一种(最好会laravel)</span>

                            <span>3.熟练掌握jquery,html,css . 熟悉并使用过一些前端框架</span>


                            <div class="padding-30"></div>

                            <span> 招聘人数:3</span>
                        </div>

                    </div>

                    <div class="recruit-box" id="oo">

                        <div class="header">
                            <div >
                                <span class="title">
                                   渠道经理
                                </span>

                                <span class="depart">
                                    (2人) 开发部
                                </span>
                            </div>

                            <div style="margin-top:10px;">
                                <span class="salary">
                                    5k ~ 8k
                                </span>

                                <span class="brief">
                                    经验1-2年/本科
                                </span>

                                <div class="submit-resume">投递</div>
                            </div>
                        </div>
                        <div class="recruit-detail">
                            <span>工作职责:</span>
                            <div class="padding-10"></div>

                            <span>1.负责后端业务逻辑编写</span>

                            <span>2.根据业务逻辑设计功能模块</span>

                            <span>3.具有良好的编码规范, 良好的沟通表达能力</span>



                            <div class="padding-30"></div>

                            <span>能力要求:</span>
                            <div class="padding-10"></div>
                            <span>1.一年左右php工作经验,能独立开发网站模块；</span>

                            <span>2.熟练掌握laravel,yii,think php 任意一种(最好会laravel)</span>

                            <span>3.熟练掌握jquery,html,css . 熟悉并使用过一些前端框架</span>


                            <div class="padding-30"></div>

                            <span> 招聘人数:3</span>
                        </div>

                    </div>

                </div>


            </div>
           
        </div>

    </div>

@stop


@section('script')

    <script type="text/javascript">


        function scrollTo(ele, speed){
            if(!speed) speed = 300;
            if(!ele){
                $("html,body").animate({scrollTop:0},speed);
            }else{

                if(ele.length>0) $("html,body").animate({scrollTop:$(ele).offset().top-200},speed);
            }
            return false;
        }


        $(document).ready(function(){
            $('.ui.sticky')
                    .sticky({
                        context: '#recruitBoxList',
                        pushing: true,
                        onStick : function() {

                            $(this).addClass('recruit-title-list-scroll');
                        },

                        onUnstick : function() {
                            $(this).removeClass('recruit-title-list-scroll');
                        }
                    })
            ;

            $('#uiBtn').click(function(){
                scrollTo('#ui',400);
            })
            $('#phpBtn').click(function(){
                scrollTo('#php',400);
            })
            $('#ooBtn').click(function(){
                scrollTo('#oo',400);
            })
        })
    </script>

@stop