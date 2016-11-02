@extends('Admin.site')


@section('resources')

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
<script src={{ asset('semantic/modal.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
<script src={{ asset('semantic/dimmer.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
<script src={{ asset('semantic/dropdown.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/transition.css') }}>
<script src={{ asset('semantic/transition.js') }}></script>

<script src={{ asset('js/jquery.form.js') }}></script>

<script src={{ asset('webuploader/webuploader.js') }}></script>
<link rel="stylesheet" type="text/css"  href={{ asset('webuploader/webuploader.css') }}>

@stop

@section('content')

@foreach($list as $item)

<div class="classification-box">
	<div class="classification-box-title">
		<span class="width-140">{{$item->section_name}}</span>

		<div class="filePicker" name="filePicker{{$item->section_name_eg}}">
			<img src="/Admin/icon/select-pic.png" />
			选择图片
		</div>

		<input type="hidden" name="hotelId" id="hotelId" value="{{$hotelId}}" />
		<input type="hidden" name="sectionId" id="sectionId" value="{{$item->id}}" />

		<div class="classificationandtag-btn uploadImages" id="uploadImages">
			<img src="/Admin/icon/uploader.png" />
			开始上传
		</div>

		<div class="drop-item-icon"  onclick="transition('{{$item->section_name_eg}}')">
			<span>点击 收起 / 展开</span>
			<img src="/Admin/icon/drop-down.png">
		</div>
	</div>

	<div class="classification-list-box" id="{{$item->section_name_eg}}">

		
		@if ( count($item->piclist) == 0 )
	        <div class="classification-list-row text-align-center empty-data">暂无图片...</div>
	    @else
	    	@foreach($item->piclist as $picitem)
	        	<div class="piclist-image-frame">
	        		<i class="remove icon teal piclist-remove-image"> </i>
	        		@if($picitem->status == 0)
	        		<img src="/Admin/icon/cover-unselect.png" class="hotel-cover" onclick="cover({{$picitem->status}},this)">
	        		@else
	        		<img src="/Admin/icon/cover.png" class="hotel-image-cover">
	        		<img src="/Admin/icon/cover-select.png" class="hotel-cover" onclick="cover({{$picitem->status}},this)">
	        		@endif
	        		<input type="hidden" name="imageId" id="imageId" value="{{$picitem->id}}" />
	        		<img src="{{$picitem->link}}" class="hotel-img-small">
	        		<div class="info">{{$picitem->key}}</div>
	        	</div>
			@endforeach

	    @endif
			
		<div class="image-list-row" id="filePicker{{$item->section_name_eg}}">
		</div>
		
	</div>
</div>

<div class="width-all height-20"></div>

<div class="delete-hotel-img modal ui">
	<div class="edit-add-title">
		<div class="ui radio checkbox first-menu">
			<label>图片删除</label>
		</div>
	</div>

	<div class="edit-add-content delete-hotel-image">
		确定删除 〖 <span id="sectionName"></span> 〗下的图片 <span id="pictureName" class="picture-name"></span> 
		<img src="" class="delete-picture">
	</div>

	<div class="content-button-colmun" id="delete-iamge">
		<input type="hidden" id="hotelImageId" value="" />
		<input type="hidden" id="hotelImagekey" value="" />
		<div class="delete-yes-btu" id="toDelete" >
			<span>确认删除</span>
		</div>

		<div class="delete-no-btu">
			<span>取消删除</span>
		</div>
	</div>
		
</div>

<div class="delete-hotel-img-result modal ui">
	<div class="edit-add-title">
		<div class="ui radio checkbox first-menu">
			<label>信息返回</label>
		</div>
	</div>

	<div class="edit-add-content delete-hotel-image-result">
		
	</div>

	<div class="currency-btu margin-bottom-20" onclick="toRefresh()">
		<span>确认</span>
	</div>
		
</div>


<div class="hotel-iamge-cover modal ui">
	<div class="edit-add-title">
		<div class="ui radio checkbox first-menu">
			<label>封面设置</label>
		</div>
	</div>

	<div class="edit-add-content cover-hotel-image">
		确定设置 〖 <span id="sectionName"></span> 〗下的图片 <span id="pictureName" class="picture-name"></span> 为封面吗？
		<img src="" class="delete-picture">
	</div>

	<div class="content-button-colmun" id="cover-image">
		<input type="hidden" id="hotelImageId" value="" />
		<input type="hidden" id="status" value="" />
		<div class="delete-yes-btu" id="toCover" >
			<span>确认设置</span>
		</div>

		<div class="delete-no-btu">
			<span>取消设置</span>
		</div>
	</div>
		
</div>

@endforeach


@stop

@section('script')

<script type="text/javascript">

	$(document).ready(function(){

		var imageObj = '';
   	    var imageKey = '';
   	    var imageListDocument = '';
   	    var sectionId = 0;

   	    var uploader = WebUploader.create({

            // swf文件路径
            swf: 'webuploader/Uploader.swf',

            // 文件接收服务端。
            server: '/admin/manageHotel/uploadImage',

            // 选择文件的按钮。可选。
            // 内部根据当前运行是创建，可能是input元素，也可能是flash.
            pick: '.filePicker',

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
                'hotelId' : '{{ $hotelId }}',
            },

        });

   	    $(".filePicker").bind('click',function(){
   	    	imageListDocument = '#' + $(this).attr('name');
   	    	sectionId = $(this).siblings("#sectionId").val();
   	    })


        uploader.on('fileQueued', function (file) {
            var $li = $(
               	'<div id="' + file.id + '" class="image-frame">' +
               		'<i class="remove icon teal remove-image"> </i>' +
               		'<img>' +
               		'<div class="info">' + file.name + '</div>' +
               		'<p class="state" id="state">等待上传...</p>' +
               	'</div>'
            ),
            $img = $li.find('img');

            // $list为容器jQuery实例
            $(imageListDocument).append($li);

            // 创建缩略图
            // 如果为非图片文件，可以不用调用此方法。
            // thumbnailWidth x thumbnailHeight 为 100 x 100
            uploader.makeThumb(file, function (error, src) {
                if (error) {
                    $img.replaceWith('<span>不能预览</span>');
                    return;
                }

                $img.attr('src', src);
            }, 100, 75);
        });

        $(document).on('click', '.remove-image', function () {

            var key = $(this).siblings('.image-key').val();
            imageObj = $(this).parent();
            if ( key !== undefined &&  key !== '' ) {
                imageKey = key;
                $('.confirmDimmer').dimmer('show');
            }
            else
            {
                uploader.removeFile( imageObj.attr('id') );
                imageObj.fadeOut(1000);
            }

        });

        uploader.on('uploadBeforeSend', function( block, data, headers) {
		    data.sectionId = sectionId;
		});


        $(".uploadImages").click(function(){

        	var list = $(this).parent().siblings('.classification-list-box').children('.image-list-row');

        	$(list).find('.image-frame').each(function(){
				uploader.upload($(this).attr('id'));
			})
        })

        uploader.on( 'uploadProgress', function( file, percentage ) {
		    var $li = $( '#'+file.id ),
		        $percent = $li.find('.progress .progress-bar');

		    // 避免重复创建
		    if ( !$percent.length ) {
		        $percent = $('<div class="progress progress-striped active">' +
		          '<div class="progress-bar" role="progressbar" style="width: 0%">' +
		          '</div>' +
		        '</div>').appendTo( $li ).find('.progress-bar');
		    }

		    $li.find('p.state').text('上传中.........');
		    $li.find('p.state').css('color',"#FFCC33");
		    $percent.css( 'width', percentage * 100 + '%' );
		});

		uploader.on( 'uploadSuccess', function( file ) {
			$( '#'+file.id ).find('p.state').css('color',"#00FF33");
		    $( '#'+file.id ).find('p.state').text('已上传!');
		});

		uploader.on( 'uploadError', function( file ) {
			$( '#'+file.id ).find('p.state').css('color',"#FF0000");
		    $( '#'+file.id ).find('p.state').text('上传出错!');
		});

		uploader.on( 'uploadComplete', function( file ) {
		    $( '#'+file.id ).find('.progress').fadeOut();
		});


		$(".piclist-remove-image").click(function(){
			var iamgeId = $(this).siblings("#imageId").val();
			var sectionName = $(this).parent().parent().siblings(".classification-box-title").children().eq(0).html();
			var pictureName = $(this).siblings(".info").html();
			var pictureLink = $(this).siblings(".hotel-img-small").attr("src");

			$("#delete-iamge #hotelImageId").val(iamgeId);
			$("#delete-iamge #hotelImagekey").val(pictureName);

			$(".delete-hotel-image #sectionName").html(sectionName);
			$(".delete-hotel-image #pictureName").html(pictureName);
			$(".delete-hotel-image .delete-picture").attr("src" , pictureLink);
			$('.delete-hotel-img').modal({
				closable  : true,
		    	
	  		}).modal('show');
		})

		$("#delete-iamge #toDelete").click(function(){
			var iamgeId = $(this).siblings("#hotelImageId").val();
			var key = $(this).siblings("#hotelImagekey").val();
			console.log(key);
			$.ajax({
				type: 'POST',
                url: '/admin/manageHotel/deleteHotelImage',
                data: {iamgeId : iamgeId , key : key},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                	$(".delete-hotel-image-result").html(data.statusMsg);
                	$(".delete-hotel-img-result").modal({
						closable  : true,
				    	
			  		}).modal('show');
		        }
			})
		})

		$("#cover-image #toCover").click(function(){
			var iamgeId = $(this).siblings("#hotelImageId").val();
			var status = $(this).siblings("#status").val();
			var hotelId = $("#hotelId").val();
			$.ajax({
				type: 'POST',
                url: '/admin/manageHotel/coverHotelImage',
                data: {iamgeId : iamgeId , status : status , hotelId : hotelId},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                	$(".delete-hotel-image-result").html(data.statusMsg);
                	$(".delete-hotel-img-result").modal({
						closable  : true,
				    	
			  		}).modal('show');
		        }
			})
		})


	})
	
	function toRefresh() {
		location.reload();
	}

	function cover(status,_this) {
		var iamgeId = $(_this).siblings("#imageId").val();
		var sectionName = $(_this).parent().parent().siblings(".classification-box-title").children().eq(0).html();
		var pictureName = $(_this).siblings(".info").html();
		var pictureLink = $(_this).siblings(".hotel-img-small").attr("src");

		$("#cover-image #hotelImageId").val(iamgeId);
		$("#cover-image #status").val(status);

		$(".cover-hotel-image #sectionName").html(sectionName);
		$(".cover-hotel-image #pictureName").html(pictureName);
		$(".cover-hotel-image .delete-picture").attr("src" , pictureLink);

		$(".hotel-iamge-cover").modal({
						closable  : true,
			  		}).modal('show');
	}

	function transition(classId) {
		$('#'+classId).transition('drop');
	}
</script>

@stop