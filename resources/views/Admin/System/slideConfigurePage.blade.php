@extends('Admin.site')

@section('resources')
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
<script src={{ asset('semantic/modal.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
<script src={{ asset('semantic/dimmer.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
<script src={{ asset('semantic/dropdown.js') }}></script>

<script src={{ asset('js/jquery.form.js') }}></script>
@stop

@section('content')
<div class="classification-box">
	<div class="classification-box-title">
		<span>轮播图管理</span>

		<div class="classificationandtag-btn" onclick="addSlide()">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>
	</div>

	<div class="classification-list-box">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">ID</div>
			<div class="classification-colmun width-120">名称</div>
			<div class="classification-colmun width-120">描述</div>
			<div class="classification-colmun width-200">添加时间</div>
			<div class="classification-colmun width-200">修改时间</div>
			<div class="classification-colmun width-200">图片</div>
			<div class="classification-colmun width-200">操作</div>
		</div>
		@foreach ($slideList as $slide)
			<div class="slide-list-row">
				<div class="classification-colmun line-height-100 width-50">
					{{$slide->id}}
				</div>
				<div class="classification-colmun line-height-100 width-120">
					{{$slide->slide_name}}
				</div>
				<div class="classification-colmun line-height-100 width-120">
					{{$slide->slide_desc}}
				</div>
				<div class="classification-colmun line-height-100 width-200">
					{{$slide->created_at}}
				</div>
				<div class="classification-colmun line-height-100 width-200">
					{{$slide->updated_at}}
				</div>
				<div class="classification-colmun width-200">
					<img src="{{$slide->img_url}}" class="list-slide-img">
				</div>
				<div class="classification-colmun line-height-100 width-200">
					<img src="/Admin/icon/menu-edit.png" class="classification-edit" onclick="editSlide({{$slide->id}},'{{$slide->slide_name}}','{{$slide->slide_desc}}','{{$slide->img_url}}')" />
					<img src="/Admin/icon/menu-delete.png" onclick="delslide({{$slide->id}},'{{$slide->slide_name}}',this)" />
				</div>
			</div>
		@endforeach
	</div>

</div>

<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<span class="title-font margin-left-20">添加轮播图</span>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>名称</label>
					<input type="text" name="slideName" id="slideName" class="content-input overall-length"></div>

			</div>

			<div class="content-colmun field">
				<label>描述</label>
				<input type="text" name="slideDesc" id="slideDesc" class="content-input overall-length"></div>

			<div class="content-upload-colmun">
				<label>上传图片</label>
				<div class="upload-box" id="uploadBoxOne">
					<img src="/Admin/img/plus.png"></div>
				<input type="file" class="upload-input" id="uploadBoxOneInput" name="uploadBoxOneInput" />
				<input type="hidden" name="imgUrl" id="imgUrl" />

			</div>

			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="slideId" name="slideId" value="0">
				<div class="currency-btu" onclick="submitMenu()">
					<span>确认添加</span>
				</div>
			</div>

		</div>
	</form>
</div>
@stop

@section('script')
<script type="text/javascript">
	function addSlide() {
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#slideName").val("");
      			$("#slideDesc").val("");
      			$("#imgUrl").val("");
      			$("#EditOrAdd").val("add");
      			$("#classificationId").val("0");
    		}
  		}).modal('show');
	}

	$("#uploadBoxOne").click(function(){
		$(this).siblings('#uploadBoxOneInput').val('').trigger('click');
		$("#uploadBoxOneInput").wrap("<form id='myupload' action='/admin/system/uploadImg' method='post' enctype='multipart/form-data'></form>");
	})

	$("#uploadBoxOneInput").change(function(){
		$("#myupload").ajaxSubmit({
			dataType : 'json',
			data : { filename : 'uploadBoxOneInput'},
			headers : {
				'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
			},
			success : function(data){
				console.log(data);
				$("#uploadBoxOne").html("<img src='"+data.imgPath+"' class='slide-img'/>");
				$("#imgUrl").val(data.imgPath);
				$("#uploadBoxOneInput").unwrap();
			}
		})
	})

	function submitMenu() {
		$.ajax({
			type: 'POST',
            url: '/admin/system/createSlide',
            data: $("#edit-add-form").serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
            	console.log(data);
            	alert(data.statusMsg);
            	location.reload();
            }
		})
	}

	function editSlide(id,name,desc,url) {
		$("#slideName").val(name);
		$("#slideDesc").val(desc);
      	$("#imgUrl").val(url);
      	$("#EditOrAdd").val("edit");
      	$("#slideId").val(id);
      	$("#uploadBoxOne").html("<img src='"+url+"' class='slide-img'/>");
      	$(".currency-btu").html("<span>确认修改</span>");

      	$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#slideName").val("");
      			$("#slideDesc").val("");
      			$("#imgUrl").val("");
      			$("#EditOrAdd").val("add");
      			$("#slideId").val("0");
      			$("#uploadBoxOne").html("<img src='/Admin/img/plus.png'></div>");
      			$(".currency-btu").html("<span>确认添加</span>");
    		}
  		}).modal('show');
	}

	function delslide(id,name,_this) {
		if (confirm("确定删除  "+name+"  ? ")) {
			$.ajax({
				type: 'POST',
	            url: '/admin/system/delSlide',
	            data: {slideId : id},
	            dataType: 'json',
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	            },
	            success : function(data){
	            	if (data.statusCode == 0) {
	            		alert('删除失败');
	            	}else{
	            		$(_this).parent().parent().remove();
	            		alert("删除成功");
	            	}
	            }
			})
			
		}
	}
</script>
@stop