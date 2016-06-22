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

@stop

@section('content')

@foreach($serviceItemsList as $serviceItem)

<div class="classification-box">
	<div class="classification-box-title">
		<span class="width-140">{{$serviceItem->service_name}}</span>

		<div class="classificationandtag-btn" onclick="addServiceItems({{$serviceItem->service_type}})">
			<img src="/Admin/icon/add.png" />
			添加更多
		</div>

		<div class="drop-item-icon"  onclick="transition('{{$serviceItem->service_name_eg}}')">
			<span>点击展开</span>
			<img src="/Admin/icon/drop-down.png">
		</div>
	</div>

	<div class="classification-list-box display-none" id="{{$serviceItem->service_name_eg}}">

		<div class="classification-list-row">
			<div class="classification-colmun width-50">ID</div>
			<div class="classification-colmun width-200">服务名称</div>
			<div class="classification-colmun width-120">分类标识</div>
			<div class="classification-colmun width-200">添加时间</div>
			<div class="classification-colmun width-200">修改时间</div>
			<div class="classification-colmun width-120">操作管理员</div>
			<div class="classification-colmun width-200">操作</div>
		</div>
		@if($serviceItem->itemlist == 0)
			<div class="classification-list-row text-align-center empty-data">暂无数据...</div>
		@else
			<div class="classification-list-row">
				<div class="classification-colmun width-50">
					1
				</div>
				<div class="classification-colmun width-200">
					2
				</div>
				<div class="classification-colmun width-120">分类标识</div>
				<div class="classification-colmun width-200">
					3
				</div>
				<div class="classification-colmun width-200">
					4
				</div>
				<div class="classification-colmun width-120">
					5
				</div>
				<div class="classification-colmun width-200">
					
				</div>
			</div>
		@endif
	</div>
</div>

<div class="width-all height-20"></div>

@endforeach

<div class="width-all height-80"></div>

<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<span class="title-font margin-left-20">添加服务分类</span>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>名称</label>
					<input type="text" name="itemName" id="itemName" class="content-input overall-length"></div>

			</div>

			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>分类标识</label>
					<input type="text" name="serviceType" id="serviceType" class="content-input overall-length"></div>

			</div>

			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="serviceId" name="serviceId" value="0">
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

	function transition(classId) {
		$('#'+classId).transition('drop');
	}

	function addServiceItems(type) {
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#serviceName").val("");
      			$("#serviceNameEg").val("");
      			$("#serviceType").val("");
      			$("#EditOrAdd").val("add");
      			$("#serviceId").val("0");
    		}
  		}).modal('show');
	}
	
</script>

@stop