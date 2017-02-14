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
	@include('Admin.partial.breadcrumbTrail')
<div class="classification-box">
	<div class="classification-box-title">
		<span>文章分类管理</span>

		<div class="classificationandtag-btn" onclick="addClassification()">
			<img src="/Admin/icon/add.png" />
        	添加更多
		</div>
	</div>

	<div class="classification-list-box">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">
				分类ID
			</div>
			<div class="classification-colmun width-120">
				分类名称
			</div>
			<div class="classification-colmun width-120">
				分类级别
			</div>
			<div class="classification-colmun width-200">
				添加时间
			</div>
			<div class="classification-colmun width-200">
				修改时间
			</div>
			<div class="classification-colmun width-200">
				分类简介
			</div>
			<div class="classification-colmun width-200">
				操作
			</div>
		</div>

		@foreach($categoryList as $category)
			<div class="classification-list-row">
				<div class="classification-colmun width-50">
					{{$category->id or '未知'}}
				</div>
				<div class="classification-colmun width-120">
					{{$category->category_name}}
				</div>
				<div class="classification-colmun width-120">
					{{$category->levelName}}
				</div>
				<div class="classification-colmun width-200">
					{{$category->created_at}}
				</div>
				<div class="classification-colmun width-200">
					{{$category->updated_at}}
				</div>
				<div class="classification-colmun width-200">
					{{$category->description}}

				</div>
				<div class="classification-colmun width-200">
					<img src="/Admin/icon/menu-edit.png" class="classification-edit" onclick="editCategory({{$category->id}},'{{$category->category_name}}','{{$category->description}}',{{$category->parent_id}})" />
					<img src="/Admin/icon/menu-delete.png" onclick="delCategory({{$category->id}},'{{$category->category_name}}',this)" />
				</div>
			</div>
		@endforeach


	</div>

</div>

<div class="tag-box">
	<div class="classification-box-title">
		<span>文章标签管理</span>
	</div>

	<div class="tag-add-row">
		<input type="text" id="tag_name" name="tag_name" />
		<img src="/Admin/icon/menu-setting-add.png" onclick="addArticleTag()">
	</div>

	<div class="tag-list-box">

		@foreach($tagNameList as $tagName)
			<div class="tag-content-block">
				<span>{{$tagName->tag_name}}</span>
				<input type="hidden" id="tag_id" value="{{$tagName->id}}" />
				<img src="/Admin/icon/menu-open.png" onclick="deleteTag(this)">
			</div>
		@endforeach

		
	</div>

</div>

<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<span class="title-font margin-left-20">文章分类</span>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>分类名称</label>
					<input type="text" name="classificationName" id="classificationName" class="content-input">
				</div>
				<div class="content-colmun-right" id="parentIdBox">
					<label>分类级别</label>
					<select class="ui dropdown select-box" name="parentId" id="parentId">
						<option value="0">请选择</option>
						@foreach($oneLevelCategoryList as $category)
							<option value="{{$category->id}}">{{$category->category_name}}</option>
						@endforeach
					</select>
				</div>
			</div>


			<div class="content-colmun field">
				<label>描述信息</label>
				<input type="text" name="Description" id="Description" class="content-input overall-length"></div>


			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="classificationId" name="classificationId" value="0">
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
	
	function addArticleTag() {
		var tag_name = $("#tag_name").val();
		if (tag_name == '') {
			alert("请填写标签名");
		}else{
			$.ajax({
				type: 'POST',
	            url: '/admin/manageArticle/addArticleTag',
	            data: {tag_name : tag_name},
	            dataType: 'json',
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	            },
	            success : function(data){
	            	if (data.statusCode == 0) {
	            		alert('添加失败');
	            	}else{
	            		var a = '';
	            		a += '<div class="tag-content-block">';
						a += '<span>'+data.tagName+'</span>';
						a += '<img src="/Admin/icon/menu-open.png">';
						a += '</div>';
						$(".tag-list-box").prepend(a);
						$("#tag_name").val("");
						alert('添加成功');
	            	}
	            }
			})
		}
	}

	function deleteTag(_this) {
		var id = $(_this).siblings("#tag_id").val();
		if (id == '' || id == 0) {
			alert('未知错误');
		}else{
			$.ajax({
				type: 'POST',
	            url: '/admin/manageArticle/delArticleTag',
	            data: {tag_id : id},
	            dataType: 'json',
	            headers: {
	                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
	            },
	            success : function(data){
	            	if (data.statusCode == 0) {
	            		alert('删除失败');
	            	}else{
	            		$(_this).parent().remove();
	            		alert("删除成功");
	            	}
	            }
			})
		}
	}

	function addClassification() {
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#classificationName").val("");
      			$("#parentId").val("");
      			$("#Description").val("");
      			$("#EditOrAdd").val("add");
      			$("#classificationId").val("0");
    		}
  		}).modal('show');
	}

	function submitMenu() {
		$.ajax({
			type: 'POST',
            url: '/admin/manageArticle/classificationOperate',
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

	function editCategory(id,category_name,description,parent_id) {
		$("#EditOrAdd").val('edit');
		$("#classificationName").val(category_name);
      	$("#parentId").val(parent_id);
      	$("#Description").val(description);
      	$("#classificationId").val(id);

      	$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#classificationName").val("");
      			$("#parentId").val("");
      			$("#Description").val("");
      			$("#EditOrAdd").val("add");
      			$("#classificationId").val("0");
    		}
  		}).modal('show');
	}

	function delCategory(id,category_name,_this) {
		if (confirm("确定删除"+category_name+" ? ")) {
			$.ajax({
				type: 'POST',
	            url: '/admin/manageArticle/delArticleCategory',
	            data: {categoryId : id},
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