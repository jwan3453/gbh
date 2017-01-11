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

	@include('admin.partial.breadcrumbTrail')
<div class="classification-box">
	<div class="classification-box-title">
		<span>轮播图管理</span>

		<div class="classificationandtag-btn" onclick="addSlide()">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>
	</div>

	<table class="ui primary striped selectable table  slide-table ">


		<tbody>
			<thead><tr>

				<th>图片</th>
				<th>名称</th>
				<th>描述</th>
				<th>链接</th>
				<th>操作</th>

			</tr></thead>
		@foreach($slideList as $slide )
			<tr>

				<td class="m-td"> <img class="list-slide-img" src = '{{$slide->img_url}}'></td>
				<td class="m-td">{{$slide->slide_name}}</td>
				<td class="m-td">{{$slide->slide_desc}}</td>
				<td class="m-td">{{$slide->slide_link}}</td>
				<td class="l-td">

					<div class="header-option f-left" onclick="editSlide('{{$slide->id}}','{{$slide->slide_name}}','{{$slide->slide_desc}}','{{$slide->slide_link}}','{{$slide->img_url}}')">
							<img src="/Admin/icon/menu-edit.png"  />
							<span class="edit">编辑</span>
					</div>

					<div class="header-option f-left" onclick="delslide({{$slide->id}},'{{$slide->slide_name}}',this)">
						<img src="/Admin/icon/menu-delete.png"  />
						<span class="delete">删除</span>
					</div>

				</td>
			</tr>
		@endforeach






		</tbody>
	</table>

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
				<input type="text" name="slideDesc" id="slideDesc" class="content-input overall-length">
			</div>

			<div class="content-colmun field">
				<label>链接</label>
				<input type="text" name="slideLink" id="slideLink" class="content-input overall-length">
			</div>


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
				$("#slideLink").val("");
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

	function editSlide(id,name,desc,link,url) {
		$("#slideName").val(name);
		$("#slideDesc").val(desc);
		$("#slideLink").val(link);
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
				$('#slideLink').val("");
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