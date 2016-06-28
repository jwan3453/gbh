@extends('Admin.site')

@section('resources')
@stop

@section('content')
<div class="h-c-steps">
	<div class="step s-active ">1</div>
	<div class="s-line s-l-active "></div>
	<div class="s-line s-l-active"></div>
	<div class="step s-active">2</div>
	<div class="s-line s-l-active"></div>
	<div class="s-line s-l-active"></div>
	<div class="step s-active">3</div>
	<div class="s-line s-l-active"></div>
	<div class="s-line s-l-active"></div>
	<div class="step s-active">4</div>
</div>

<div class="facility-box">
	<form id="hotelBasicInfo" action='{{url("/admin/manageHotel/insertFacility")}}' method="Post">
		<input type="hidden" value="{{csrf_token()}}" name="_token"/>
		<input type="hidden" value="{{$hotelId}}" name="hotelId" />
		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>服务项目</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[1] as $ectraService)
				<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
					<input type="checkbox" class="display-none" value="{{$ectraService->
					id}}" name="serviceItems[]">
					<span class="pandding">{{$ectraService->extra_name}}</span>
				</div>
				@endforeach
			</div>
		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>宠物</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[2] as $ectraService)
				<div class="item-block " id="serviceItems" onclick="petItems(this)">
					<input type="checkbox" class="display-none" value="{{$ectraService->
					id}}" name="serviceItems[]">
					<span class="pandding">{{$ectraService->extra_name}}</span>
				</div>
				@endforeach
			</div>

		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>通用设施</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[3] as $ectraService)
				<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
					<input type="checkbox" class="display-none" value="{{$ectraService->
					id}}" name="serviceItems[]">
					<span class="pandding">{{$ectraService->extra_name}}</span>
				</div>
				@endforeach
			</div>

		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>活动设施</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[4] as $ectraService)
				<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
					<input type="checkbox" class="display-none" value="{{$ectraService->
					id}}" name="serviceItems[]">
					<span class="pandding">{{$ectraService->extra_name}}</span>
				</div>
				@endforeach
			</div>

		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-便利设施</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[5] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1" checked="checked" >
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>

				</div>
				@endforeach
			</div>

		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-媒体/科技</span>
			</div>

			<div class="item-box">
				@foreach ($ExtraServiceList[6] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1"  checked="checked" >
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>

				</div>
				@endforeach
			</div>

		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-食品和饮品</span>
			</div>
			<div class="item-box">
				@foreach ($ExtraServiceList[7] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1" checked="checked"  >
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>
				</div>
				@endforeach
			</div>
		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-浴室</span>
			</div>
			<div class="item-box">
				@foreach ($ExtraServiceList[8] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1" checked="checked"  >
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>
				</div>
				@endforeach
			</div>
		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-室外/景观</span>
			</div>
			<div class="item-box">
				@foreach ($ExtraServiceList[9] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1" checked="checked"  >
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>
				</div>
				@endforeach
			</div>
		</div>

		<div class="facility-items-box">
			<div class="facility-item-title">
				<span>客房设施-服务及其他</span>
			</div>
			<div class="item-box">
				@foreach ($ExtraServiceList[10] as $ectraService)
				<div class="radio-item-block">
					<span class="radio-item-title">{{$ectraService->extra_name}}</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_1" checked="checked">
					<span class="radio-item-span">全部</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_2"  >
					<span class="radio-item-span">部分</span>

					<input type="radio" class="radio-item-input" name="{{$ectraService->
					id}}"  value="{{$ectraService->id}}_3"  >
					<span class="radio-item-span">无</span>
				</div>
				@endforeach
			</div>
		</div>

		<div class="hotel-policy-row height-80">
			<div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
		</div>
	</form>
</div>
@stop

@section('script')
<script type="text/javascript">

	function serviceItems(_this) {
		$(_this).addClass("click-item-block");
		$(_this).children("input").attr("checked",'true');

		$(_this).attr('onclick','unserviceItems(this)');
	}

	function unserviceItems(_this) {
		$(_this).removeClass("click-item-block");
		$(_this).children("input").removeAttr("checked");

		$(_this).attr('onclick','serviceItems(this)');
	}

	function petItems(_this) {
		$(_this).siblings().removeClass("click-item-block");
		$(_this).siblings().children("input").removeAttr("checked");

		$(_this).addClass("click-item-block");
		$(_this).children("input").attr("checked",'true');
	}

	$('#nsBtn').click(function(){

        $('#hotelBasicInfo').submit();

    })
</script>
@stop