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
		<span class="width-140">服务设置</span>

		<div class="classificationandtag-btn" onclick="addServiceItems()">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>
	</div>

	<div class="classification-list-box" id="serviceItems">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">ID</div>
			<div class="classification-colmun width-200">服务名称</div>
			<div class="classification-colmun width-80">英文标识</div>
			<div class="classification-colmun width-120">分类标识</div>
			<div class="classification-colmun width-160">添加时间</div>
			<div class="classification-colmun width-160">修改时间</div>
			<div class="classification-colmun width-120">操作管理员</div>
			<div class="classification-colmun width-200">操作</div>
		</div>
			@foreach ($hotelImageManage as $hotelImage)
			<div class="classification-list-row">
				<div class="classification-colmun width-50">
					{{$hotelImage->id}}
				</div>
				<div class="classification-colmun width-200">
					{{$hotelImage->section_name}}
				</div>
				<div class="classification-colmun width-80">
					{{$hotelImage->section_name_eg}}
				</div>
				<div class="classification-colmun width-120">
					{{$hotelImage->section_type}}
				</div>
				<div class="classification-colmun width-160">
					{{$hotelImage->created_at}}
				</div>
				<div class="classification-colmun width-160">
					{{$hotelImage->updated_at}}
				</div>
				<div class="classification-colmun width-120">
					{{$hotelImage->admin_id}}
				</div>
				<div class="classification-colmun width-200">
					<img src="/Admin/icon/menu-edit.png" class="classification-edit" onclick="edithotelImage({{$hotelImage->id}},'{{$hotelImage->section_name}}','{{$hotelImage->section_name_eg}}','{{$hotelImage->section_type}}')" />
					<img src="/Admin/icon/menu-delete.png" onclick="delhotelImage({{$hotelImage->id}},'{{$hotelImage->section_name}}',this)" />
				</div>
			</div>
		@endforeach
	</div>
</div>

<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<span class="title-font margin-left-20">添加酒店图片分类</span>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>名称</label>
					<input type="text" name="sectionName" id="sectionName" class="content-input overall-length"></div>

			</div>

			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>英文标识</label>
					<input type="text" name="sectionNameEg" id="sectionNameEg" class="content-input overall-length"></div>

			</div>

			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>分类标识</label>
					<input type="text" name="sectionType" id="sectionType" class="content-input overall-length"></div>

			</div>

			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="sectionId" name="sectionId" value="0">
				<div class="currency-btu" onclick="submitForm()">
					<span>确认添加</span>
				</div>
			</div>

		</div>
	</form>
</div>

@stop

@section('script')

<script type="text/javascript">
	
	function addServiceItems() {
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#sectionName").val("");
      			$("#sectionNameEg").val("");
      			$("#sectionType").val("");
      			$("#EditOrAdd").val("add");
      			$("#sectionId").val("0");
    		}
  		}).modal('show');
	}

	function submitForm() {
		$.ajax({
			type: 'POST',
            url: '/admin/system/hotelImageOperation',
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

	function edithotelImage(id,name,name_eg,type) {
		$("#EditOrAdd").val('edit');
		$("#sectionName").val(name);
		$("#sectionNameEg").val(name_eg);
      	$("#sectionType").val(type);
      	$("#sectionId").val(id);
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#sectionName").val("");
      			$("#sectionNameEg").val("");
      			$("#sectionType").val("");
      			$("#EditOrAdd").val("add");
      			$("#sectionId").val("0");
    		}
  		}).modal('show');
	}

	function delhotelImage(id,name,_this) {
		if (confirm("确定删除  "+name+"  ? ")) {
			$.ajax({
				type: 'POST',
	            url: '/admin/system/delhotelImage',
	            data: {sectionId : id},
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