@extends('Admin.site')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>
@stop

@section('content')

    @include('Admin.partial.breadcrumbTrail')
    <div class="admin-content">

        <div class="hotel-category">


            @foreach($categories as $category)
            <div class="category">

                <div class="cate-name">
                    {{$category->category_name}}
                </div>
                @foreach($category->secondLevelCategory as $secLelCategory)
                    <div class="sec-lel-cate">
                        <img src = '{{$secLelCategory->icon}}' >
                        <span>{{$secLelCategory->category_name}}</span>
                        <i class="icon remove large" id="{{$secLelCategory->id}}"></i>
                    </div>
                @endforeach

                @if(count($category->secondLevelCategory ) == 0)

                    <div class="no-cate"><i class="warning sign  icon large"></i><span>暂无分类</span></div>
                @endif

            </div>
            @endforeach

            <div class="item-block width-200 border-blue" id="addNewCategory">
                <img src="/Admin/icon/add.png" class="margin-right-20">
                添加分类
            </div>
        </div>
    </div>

    <div class="ui page dimmer add-new-category">


        <div id="addCategoryBox">

            <h3>添加酒店分类</h3>
            <div class="add-new-cate-box">
            <div class="cate-option">
                <span class="active" id="firstLevel">一级分类</span>
                <span id="secondLevel">二级分类</span>
            </div>

            <form class="cate-detail" id="cateDetailForm">

                <input type="hidden" name="cateLevel" id="cateLevel" value="1">

                <div class="cate-line-detail none-display" id="selectLevel">
                    <label>上级分类</label>
                    <select name="parentLevel" id="parentLevel">

                        @foreach($categories as $category)
                            <option style="height:30px;line-height:30px;" value="{{$category->id}}">{{$category->category_name}}</option>
                        @endforeach
                    </select>
                </div>

                <div class="cate-line-detail">
                    <label>分类名称</label>
                    <input type="text" name="cateName" id="cateName" />
                </div>

                <div class="cate-line-detail">
                    <label>分类名称(英文)</label>
                    <input type="text" name="cateNameEng" id="cateNameEng" />
                </div>



                <div class="cate-line-detail">
                    <label>图标</label>
                    <div class="upload-cate-icon-box" id="uploadCateIcon" >
                        <img src="/Admin/img/plus.png" id="cateIcon" >
                    </div>
                </div>
                <input type="file" class="upload-input" id="file" name="file" />
                <input type="hidden" id="code" name="imageType" value="3">

                <div class="confirm-btns">
                    <div class="regular-btn red-btn " id="submit">保存</div>
                    <div class="regular-btn blue-btn " id="cancelAddCate">取消</div>
                </div>
            </form>
        </div>
         </div>


        <div id="confirmDeleteBox">
            <h3>是否删该分类</h3>
            <div class="confirm-btns">
                <div class="regular-btn blue-btn " id="confirmDelete">
                    确定
                    <div class="ui active inline  small  loader" id="loader"></div>
                </div>
                <div class="regular-btn red-btn" id="cancelDelete">取消</div>
            </div>

        </div>

    </div>



@stop

@section('script')
    <script type="text/javascript">

        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file[0]) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file[0]) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file[0]) ;
            }

            return url ;
        }



        $(document).ready(function(){


            var deleteCateId = '';

            $('#addNewCategory').click(function(){
                $('.add-new-category').dimmer('show');
                $('#addCategoryBox').show();
                $('#confirmDeleteBox').hide();
            })

            $('#cancelAddCate').click(function(){
                $('.add-new-category').dimmer('hide');

            })

            $('#uploadCateIcon').click(function(){
                $('#file').click();
            })

            $("#file").on("change",function(){
                var objUrl = getObjectURL(this.files) ;  //获取图片的路径，该路径不是图片在本地的路径

                if (objUrl) {
                    $("#cateIcon").attr("src", objUrl) ;      //将图片路径存入src中，显示出图片
                }
            });

            //切换一级分类 二级分类
            $('#firstLevel').click(function(){
                $('#selectLevel').addClass('none-display');
                $(this).addClass('active').siblings('span').removeClass('active');
                $('#cateLevel').val(1);
            })


            $('#secondLevel').click(function(){
                $('#selectLevel').removeClass('none-display');
                $(this).addClass('active').siblings('span').removeClass('active');
                $('#cateLevel').val(2);

            })

            //提交目的地信息
            $('#submit').click(function(){

                if($('#cateName').val() === '')
                {
                    toastAlert('请输入分类名称',2);
                    return;
                }

                if($('#cateNameEg').val() === '')
                {
                    toastAlert('请输入分类英文名称',2);
                    return;
                }

                $("#cateDetailForm").ajaxSubmit({
                    url: '/admin/system/saveHotelCategory',
                    type: 'post',
                    dataType: 'json',
                    encoding: "UTF-8",


                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){

                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            toastAlert(data.statusMsg,1);
                            $('.add-new-category').dimmer('close');
                            location.reload();
                        }
                        else{
                            toastAlert(data.statusMsg,2);
                            $('.add-new-category').dimmer('close');
                        }
                    },
                    error:function(data){
                    }
                });

            })

            //弹出确定删除框
            $('.remove').click(function(){

                deleteCateId = $(this).attr('id');
                $('.add-new-category').dimmer('show');
                $('#addCategoryBox').hide();
                $('#confirmDeleteBox').show();
            })

            //确认删除
            $('#confirmDelete').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '/admin/system/deleteHotelCategory',
                    data: {categoryId :deleteCateId},
                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            toastAlert(data.statusMsg,1);
                            $('.add-new-category').dimmer('close');
                            location.reload();

                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                        $('.confirm-request').dimmer('hide');
                    }
                })
            })

            $('#cancelDelete').click(function(){
                $('.add-new-category').dimmer('hide');

            })

        })


    </script>
@stop