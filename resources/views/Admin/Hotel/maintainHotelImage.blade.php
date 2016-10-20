@extends('Admin.Hotel.maintainHotelInfo')


@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/label.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/modal.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
    <script src={{ asset('semantic/transition.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>

    <script src={{ asset('js/webuploader/webuploader.js') }}></script>
    <link rel="stylesheet" type="text/css"  href={{ asset('js/webuploader/webuploader.css') }}>
@stop

@section('infoContent')

    <div class="info-content">

        <div class="hotel-info">
            <div class="header">酒店图片</div>
        </div>

        <div class="section-list" id="sectionList">

        @foreach($sectionListAndImage['sectionList'] as $section)
            <span data-id="{{$section->id}}">{{$section->name}}</span>
        @endforeach

            <div class="ui simple dropdown  room-list" id="roomList"><label>客房</label> <i class="dropdown icon"></i>
                <div class="menu">
                    @foreach($sectionListAndImage['roomList'] as $room)
                        <div data-id="{{$room->id}}" class="room-list-item">{{$room->room_name}}</div>
                    @endforeach

                </div>
            </div>

            <div  class="cover-section" id="coverSectionMenu" data-id="0">外网封面</div>

        </div>

        <div class="hotel-image" id="hotelImage">

            <div class="hotel-image-upload ">


                    <div class="header"><span></span>已经上传图片</div>


                    <div id="imageList" class="image-list">
                        @if(count($sectionListAndImage['image']) == 0)
                            <div style="text-align: center">该区域暂无图片</div>
                        @endif
                        @foreach($sectionListAndImage['image'] as $image)
                            <div  class="file-item thumbnail ui  image uploaded ">
                                <div class="image-mask " id="cover_{{$image->id}}">
                                    <div class="offline  small-btn red-btn">下线</div>

                                @if($image->is_cover == 1 )
                                    <div class="cancel-cover  small-btn red-btn">取消封面</div>
                                </div>
                                    <div class="ui blue ribbon label is-cover  " id="cover_{{$image->id}}">封面</div>
                                @else
                                    <div class="set-cover  small-btn red-btn">设为封面</div>
                                </div>
                                    <div class="ui blue ribbon label cover " id="cover_{{$image->id}}">封面</div>
                                @endif
                                <i class="remove icon large orange "> </i>
                                <img style="width:200px;height:200px" src={{$image->link}} >
                                <div class="info"> {{$image->image_key}}</div>
                                <input type="hidden"  class="image-key" value="{{$image->image_key}}">
                                <input type="hidden" class="image-id" value="{{$image->id}}">
                            </div>
                        @endforeach
                    </div>



                <div class="header"><span></span>准备上传图片</div>
                <div>
                    <!--用来存放item-->
                    <div id="fileList" class="uploader-list" >

                    </div>
                    <div style="clear:both;display:block; ">
                        <div id="filePicker" class="f-left "  style="margin-right:20px;">选择图片</div>
                        <div id="uploadImages" class=" f-left regular-btn red-btn">开始上传</div>
                    </div>
                </div>

            </div>

        </div>
    </div>


    <div class="hotel-cover-image" id="hotelCoverImage">

            <div class="color-divider"></div>

            <div class="header"><span></span>
                封面外网图片
            </div>

            <div class="cover-image-list" id="coverImageList">

            </div>

        </div>
    </div>

    <div class="ui page dimmer chose-cover-image-dimmer">

    </div>


    <div class="ui page dimmer confirm-request">

        <h3>是否删除该图片</h3>
        <div class="confirm-btns">
            <div class="regular-btn blue-btn confirm">
                确定
            </div>
            <div class="regular-btn red-btn cancel">取消</div>
        </div>

    </div>


@stop

<div class="page-loader none-display" id="pageLoader">
    <div class="ui active centered large inline loader    "></div>
</div>

@section('infoScript')
    <script type="text/javascript">

        $(document).ready(function() {



            var imageObj = '';
            var imageKey = '';
            var uploader = WebUploader.create({

                // swf文件路径
                swf: '/js/webuploader/Uploader.swf',

                // 文件接收服务端。
                server: '/admin/manageHotel/hotelInfo/uploadHotelImage',

                // 选择文件的按钮。可选。
                // 内部根据当前运行是创建，可能是input元素，也可能是flash.
                pick: '#filePicker',

                // 不压缩image, 默认如果是jpeg，文件上传前会压缩一把再上传！
                resize: false,
                // 只允许选择图片文件。

                accept: {
                    title: 'Images',
                    extensions: 'gif,jpg,jpeg,bmp,png',
                    mimeTypes: 'image/*'
                },
                'formData': {

                    '_token': '{{ csrf_token() }}',
                    'hotelId':'{{$hotelId}}',
                    //默认区域为酒店封面区域
                    'sectionId':1,
                    //默认为酒店
                    'sectionType':1,
                    //上传的图片类型， 酒店图片 目的地图片
                    'imageType':1
                },
            });


            $('#sectionList').children('span').eq(0).addClass('section-list-selected');

            //点击区域菜单切换图片列表
            $('.section-list>span').click(function(){
                $(this).addClass('section-list-selected').siblings('span').removeClass('section-list-selected');
                uploader.options.formData.sectionId = $(this).attr('data-id');
                uploader.options.formData.sectionType =1;

                //1为加载酒店照片
                reloadImages($(this),1);

            })

            //点击房型图片菜单切换图片列表
            $('.room-list-item').click(function(){

                $('#roomList label ').text($(this).text());


                uploader.options.formData.sectionId = $(this).attr('data-id');
                uploader.options.formData.sectionType =2;
                //2为加载房间照片
                reloadImages($(this),2);
            })


            //点击酒店外网图片菜单
            $('#coverSectionMenu').click(function(){

                uploader.options.formData.sectionId = $(this).attr('data-id');
                uploader.options.formData.sectionType =3;
                //3为加载酒店封面照片
                reloadImages($(this),3);


            })



            //
            function reloadImages(ojb,type){


                //清空图片列表
                $('#imageList').hide().empty();
                $('#fileList').hide().empty();
                //清空临时图片queue队列
                $('#fileList').find('.file-item').each(function(){
                    uploader.removeFile( $(this).attr('id'),true );
                });

                if(type !== 3 ) {
                    $('#hotelImage').show();
                    $('#hotelCoverImage').hide();
                    $.ajax({

                        type: 'POST',
                        async: false,
                        url: '/admin/manageHotel/hotelInfo/getSectionImage',
                        data: {sectionId: ojb.attr('data-id'), hotelId: '{{$hotelId}}', type: type},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#pageLoader').removeClass('none-display');
                        },
                        success: function (data) {

                            $('#pageLoader').addClass('none-display');


                            //成功获取区域图片
                            if (data.statusCode === 1) {


                                var html = '';
                                for (var i = 0; i < data.extra.length; i++) {


                                    var isCoverText = '设为封面';
                                    var iscoverClass= 'cover';
                                    var setCoverClass='set-cover'

                                    if(data.extra[i].is_cover ===1)
                                    {
                                         isCoverText = '取消封面';
                                         iscoverClass = 'is-cover';
                                        setCoverClass = 'cancel-cover';
                                    }


                                    html += '<div class="file-item thumbnail ui  image uploaded ">' +
                                                '<div class="image-mask " id="cover_' + data.extra[i].id + '">' +
                                                    '<div class="offline  small-btn red-btn">下线</div>'+
                                                    '<div class="'+setCoverClass +'  small-btn red-btn">'+isCoverText+'</div>' +
                                                '</div>' +
                                                '<div class="ui blue ribbon label '+iscoverClass+'  " id="cover_' + data.extra[i].id + '">封面</div>'+
                                                '<i class="remove icon large orange "> </i>' +
                                                '<img style="width:200px;height:200px" src=' + data.extra[i].link + ' >' +
                                                '<div class="info"> ' + data.extra[i].image_key + '</div>' +
                                                '<input type="hidden"  class="image-key" value="' + data.extra[i].image_key + '">' +
                                                '<input type="hidden" class="image-id" value="' + data.extra[i].id + '">' +
                                            '</div>';


                                }
                                $('#imageList').append(html);

                            }
                            else if (data.statusCode === 2) {
                                html = '<div style="text-align: center">该区域暂无图片</div>';
                                $('#imageList').append(html);
                            }
                            $('#imageList').fadeIn(500);
                            $('#fileList').fadeIn(500)
                        },
                        error: function (xhr, type) {
                            alert('Ajax error!');
                        }
                    });
                }
                else{
                    //隐藏图片列表
                    //显示被选中外网酒店封面列表

                    $('#hotelImage').hide();
                    $('#hotelCoverImage').show();
                    $('#coverImageList').empty();
                    $.ajax({

                        type: 'POST',
                        async: false,
                        url: '/admin/manageHotel/hotelInfo/getHotelCoverImage',
                        data: { hotelId: '{{$hotelId}}'},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        beforeSend: function () {
                            $('#pageLoader').removeClass('none-display');
                        },
                        success: function (data) {

                            $('#pageLoader').addClass('none-display');


                            //成功获取酒店封面图片
                            if (data.statusCode === 1) {


                                var html = '';
                                var firstImage = '';
                                for (var i = 0; i < data.extra.length; i++)
                                {
                                    if(i === 0)
                                    {
                                        firstImage = '';
                                    }
                                    else {
                                        firstImage = 'first-image';
                                    }
                                    html += '<div class="file-item thumbnail ui  image uploaded ">' +
                                            '<div class="image-mask " id="cover_' + data.extra[i].id + '">' +

                                                '<div class=" set-first-image small-btn red-btn">'+'设为首图'+'</div>' +
                                            '</div>' +
                                            '<div class="ui blue ribbon label  '+firstImage+'  "="cover_' + data.extra[i].id + '">已设置</div>'+
                                            '<img style="width:200px;height:200px" src=' + data.extra[i].link + ' >' +
                                            '<div class="info"> ' + data.extra[i].section_name + '</div>' +
                                            '<input type="hidden"  class="image-key" value="' + data.extra[i].image_key + '">' +
                                            '<input type="hidden" class="image-id" value="' + data.extra[i].id + '">' +
                                            '</div>';


                                }
                                $('#coverImageList').append(html);

                            }
                            else if (data.statusCode === 2) {
                                html = '<div style="text-align: center">该区域暂无图片</div>';
                                $('#coverImageList').append(html);
                            }
//                            $('#imageList').fadeIn(500);
//                            $('#fileList').fadeIn(500)
                        },
                        error: function (xhr, type) {
                            alert('Ajax error!');
                        }
                    });


                }
            }


            // 当有文件添加进来的时候
            uploader.on('fileQueued', function (file) {

                var $li = $(
                                '<div id="' + file.id + '" class="file-item thumbnail ui  image">' +

                                '<div class=" ui  blue   ribbon label upload-success none-display ">上传成功 </div>' +
                                '<div class="ui  red   ribbon label upload-failed none-display">上传失败 </div>' +
                                '<i class="remove icon large orange "> </i>' +
                                '<img>' +
                                '<div class="info">' + file.name + '</div>' +
                                ' <div class="loader-box none-display ">' +
                                '<div class="ui active centered large inline loader   "></div>' +
                                '</div>' +
                                '</div>'
                        ),
                        $img = $li.find('img');


                // $list为容器jQuery实例
                $('#fileList').append($li);

                // 创建缩略图
                // 如果为非图片文件，可以不用调用此方法。
                // thumbnailWidth x thumbnailHeight 为 100 x 100
                uploader.makeThumb(file, function (error, src) {
                    if (error) {
                        $img.replaceWith('<span>不能预览</span>');
                        return;
                    }

                    $img.attr('src', src);
                }, 200, 200);
            });

            // 文件上传过程中创建进度条实时显示。
            uploader.on('uploadProgress', function (file, percentage) {

                var $li = $('#' + file.id),
                        $loader = $li.find('.loader-box');

                // 避免重复创建
                $loader.removeClass('none-display');


            });

            // 文件上传成功，给item添加成功class, 用样式标记上传成功。
            uploader.on('uploadSuccess', function (file, response) {




                if (response.statusCode == 1) {
                    var html ='<div class="image-mask " >'+
                            '<div class="offline  small-btn red-btn">下线</div>'+
                            '<div class="set-cover small-btn red-btn">设为封面</div>'+
                            '</div>'+
                            '<div class="ui blue ribbon label cover " >封面</div>'+
                            '<input type="hidden" class="image-key" value="' + response.extra['key'] + '">'+
                            '<input type="hidden" class="image-id" value="' + response.extra['id'] + '">';

                    //显示上传结果提示框
                    $('#' + file.id).find('.upload-success').removeClass('none-display');
                    $('#' + file.id).append(html);

                }
                else {
                    $('#' + file.id).find('.upload-failed').removeClass('none-display');
                }

            });

            // 文件上传失败，显示上传出错。
            uploader.on('uploadError', function (file) {
                $('#' + file.id).find('.upload-failed').show();
            });


            // 完成上传完了，成功或者失败，先删除进度条。
            uploader.on('uploadComplete', function (file) {

                $('#' + file.id).find('.loader-box').remove();
                $('#' + file.id).find('.remove').removeClass('none-display');
                $('#' + file.id).addClass('upload-complete');
            });


            //批量上传图片
            $('#uploadImages').click(function () {


                $('.file-item.thumbnail').each(function () {

                    if (!$(this).hasClass('upload-complete')) {
                        uploader.upload($(this).attr('id'));
                    }
                })

            })

            //删除图片， 弹出
            $(document).on('click', '.remove', function () {

                var key = $(this).siblings('.image-key').val();
                imageObj = $(this).parent();
                if ( key !== undefined &&  key !== '' ) {

                    imageKey = key;
                    $('.confirm-request')
                            .dimmer('show');
                }
                else
                {
                    uploader.removeFile( imageObj.attr('id'),true );
                    imageObj.fadeOut(1000);
                }

            });

            //确认删除图片
            $('.confirm').click(function () {
                $.ajax({

                    type: 'POST',
                    async: false,
                    url: '/admin/manageHotel/hotelInfo/deleteHotelImage',
                    data: {imageKey: imageKey,type:1},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        $('.confirm-request')
                                .dimmer('hide',{
                                    duration    : {
                                        show : 100,
                                        hide : 100
                                    }
                                });

                        //删除成功
                        if(data.statusCode===1)
                        {

                            toastAlert(data.statusMsg,1);
                            //区别删除的图片是否为后来添加的
                            if(!imageObj.hasClass('uploaded'))
                            {
                                uploader.removeFile( imageObj.attr('id') );
                            }
                            imageObj.fadeOut(1000);

                        }
                        else{

                            toastAlert(data.statusMsg,2);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });

            })
            $('.cancel').click(function () {

                $('.confirm-request')
                        .dimmer('hide');
                ;
            });


//            $('.file-item').hover(
//                    function(){
//                        $(this).find('.image-mask').transition('scale')
//                    },
//                    function(){
//                        $(this).find('.image-mask').transition('scale')
//
//                    }
//            )



            //显示图片选项
            $(document).on('mouseenter ', '.file-item', function(){

                $(this).find('.image-mask').toggle(300);




            })

            //隐藏图片选项
            $(document).on('mouseleave', '.file-item', function(){

                $(this).find('.image-mask').removeClass('visible,transition').hide();
            })

            //设置图像为产品封面
            $(document).on('click', '.set-cover', function(){
                var setCoverObj = $(this);
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '/admin/manageHotel/hotelInfo/setHotelCoverImage',
                    data: {hotelId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},//type: 1,associateId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {

                        if(data.statusCode===1)
                        {

                            //$('.cover').hide();
                            setCoverObj.text('取消封面').addClass('cancel-cover').removeClass('set-cover');
                            setCoverObj.parent().siblings('.cover').addClass('is-cover').removeClass('cover');
                            //隐藏其他标签
                            setCoverObj.parent().siblings('.upload-success').hide();
                            toastAlert(data.statusMsg,1);
                        }
                        else if(data.statusCode===2 || ata.statusCode===3)
                        {
                            toastAlert(data.statusMsg,2);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });
            })

            //取消图像为产品封面
            $(document).on('click', '.cancel-cover', function(){
                var setCoverObj = $(this);
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '/admin/manageHotel/hotelInfo/cancelHotelCoverImage',
                    data: {hotelId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},//type: 1,associateId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {

                        if(data.statusCode===1)
                        {

                            //$('.cover').hide();
                            setCoverObj.text('设置封面').addClass('set-cover').removeClass('cancel-cover ');
                            setCoverObj.parent().siblings('.is-cover').addClass('cover').removeClass('is-cover');
                            toastAlert(data.statusMsg,1);
                        }
                        else if(data.statusCode===2 || ata.statusCode===3)
                        {
                            toastAlert(data.statusMsg,2);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });
            })





            //设置图片为酒店首张图片
            $(document).on('click', '.set-first-image', function(){
                var firstImageObj = $(this);
                $.ajax({
                    type: 'POST',
                    async: false,
                    url: '/admin/manageHotel/hotelInfo/setHotelFirstImage',
                    data: {hotelId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},//type: 1,associateId:'{{$hotelId}}',imageId:$(this).parent().siblings('.image-id').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {

                        if(data.statusCode===1)
                        {


                            firstImageObj.parent().siblings('.first-image').removeClass('first-image');
                            firstImageObj.parents('.file-item').siblings('.file-item').find('.ribbon').addClass('first-image');
                            toastAlert(data.statusMsg,1);
                        }
                        else if(data.statusCode===2 || ata.statusCode===3)
                        {
                            toastAlert(data.statusMsg,2);
                        }
                    },
                    error: function (xhr, type) {
                        alert('Ajax error!');
                    }
                });
            })



            {{--var coverId = 'cover_' + '{{$hotelId}}';--}}

            {{--$('.cover').each(function(){--}}

                {{--if($(this).attr('id') ===coverId)--}}
                {{--{--}}
                    {{--$(this).show();--}}
                {{--}--}}
            {{--})--}}

        })
    </script>


@stop










