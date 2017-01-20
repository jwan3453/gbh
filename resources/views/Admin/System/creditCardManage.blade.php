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
		<span>国内银行卡管理</span>

		<div class="classificationandtag-btn" onclick="addCreditCard()">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>
	</div>

	<div class="classification-list-box">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">ID</div>
			<div class="classification-colmun width-200">名称</div>
			<div class="classification-colmun width-120">所属</div>
			<div class="classification-colmun width-200">添加时间</div>
			<div class="classification-colmun width-200">修改时间</div>
			<div class="classification-colmun width-120">操作管理员</div>
			<div class="classification-colmun width-200">操作</div>
		</div>
		@foreach ($InternalList as $Internalcredit)
			<div class="classification-list-row">
				<div class="classification-colmun width-50">
					{{$Internalcredit->id}}
				</div>
				<div class="classification-colmun width-200">
					{{$Internalcredit->credit_name}}
				</div>
				<div class="classification-colmun width-120">
					国内银行卡
					<input type="hidden" value="{{$Internalcredit->credit_type}}" />
				</div>
				<div class="classification-colmun width-200">
					{{$Internalcredit->created_at}}
				</div>
				<div class="classification-colmun width-200">
					{{$Internalcredit->updated_at}}
				</div>
				<div class="classification-colmun width-120">
					{{$Internalcredit->admin}}
				</div>
				<div class="classification-colmun width-200">
					<img src="/Admin/icon/menu-edit.png" class="classification-edit" onclick="editCredit({{$Internalcredit->id}},'{{$Internalcredit->credit_name}}','{{$Internalcredit->credit_type}}')" />
					<img src="/Admin/icon/menu-delete.png" onclick="delCredit({{$Internalcredit->id}},'{{$Internalcredit->credit_name}}',this)" />
				</div>
			</div>
		@endforeach
	</div>

</div>

<div class="width-all height-40"></div>

<div class="classification-box">
	<div class="classification-box-title">
		<span>国外银行卡管理</span>

		<div class="classificationandtag-btn" onclick="addCreditCard()">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>
	</div>

	<div class="classification-list-box">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">ID</div>
			<div class="classification-colmun width-200">名称</div>
			<div class="classification-colmun width-120">所属</div>
			<div class="classification-colmun width-200">添加时间</div>
			<div class="classification-colmun width-200">修改时间</div>
			<div class="classification-colmun width-120">操作管理员</div>
			<div class="classification-colmun width-200">操作</div>
		</div>
		@foreach ($AbroadList as $Abroadcredit)
			<div class="classification-list-row">
				<div class="classification-colmun width-50">
					{{$Abroadcredit->id}}
				</div>
				<div class="classification-colmun width-200">
					{{$Abroadcredit->credit_name}}
				</div>
				<div class="classification-colmun width-120">
					国外银行卡
					<input type="hidden" value="{{$Abroadcredit->credit_type}}" />
				</div>
				<div class="classification-colmun width-200">
					{{$Abroadcredit->created_at}}
				</div>
				<div class="classification-colmun width-200">
					{{$Abroadcredit->updated_at}}
				</div>
				<div class="classification-colmun width-120">
					{{$Abroadcredit->admin}}
				</div>
				<div class="classification-colmun width-200">
					<img src="/Admin/icon/menu-edit.png" class="classification-edit" onclick="editCredit({{$Abroadcredit->id}},'{{$Abroadcredit->credit_name}}','{{$Abroadcredit->credit_type}}')" />
					<img src="/Admin/icon/menu-delete.png" onclick="delCredit({{$Abroadcredit->id}},'{{$Abroadcredit->credit_name}}',this)" />
				</div>
			</div>
		@endforeach
	</div>

</div>

<div class="width-all height-80"></div>


<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<span class="title-font margin-left-20">添加银行卡</span>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>名称</label>
					<input type="text" name="creditName" id="creditName" class="content-input overall-length"></div>

			</div>

			<div class="content-colmun field">
				<label>所属</label>
				<select class="ui dropdown select-box" name="creditType" id="creditType">
					<option value="1">国内银行卡</option>
					<option value="2">国外银行卡</option>
				</select>	
			</div>

			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="creditId" name="creditId" value="0">
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
	function addCreditCard() {
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#creditName").val("");
      			$("#EditOrAdd").val("add");
      			$("#creditId").val("0");
    		}
  		}).modal('show');
	}

	function submitForm() {
		$.ajax({
			type: 'POST',
            url: '/admin/system/createCreditCard',
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

	function editCredit(id,name,type) {
		$("#EditOrAdd").val('edit');
		$("#creditId").val(id);
		$("#creditName").val(name);
		$("#creditType").val(type);
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#creditName").val("");
      			$("#EditOrAdd").val("add");
      			$("#creditId").val("0");
      			$("#creditType").val("1");
    		}
  		}).modal('show');
	}

	function delCredit(id,name,_this) {
		if (confirm("确定删除  "+name+"  ? ")) {
			$.ajax({
				type: 'POST',
	            url: '/admin/system/delCredit',
	            data: {creditId : id},
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

	function AdjustCardHeight() {

		$('#menuBox').css('height',900);

	}

	AdjustCardHeight();
</script>

@stop