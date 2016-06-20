@extends('Admin.site')

@section('resources')
@stop

@section('content')

<div class="h-c-steps">
	<div class="step s-active ">1</div>
	<div class="s-line s-l-active "></div>
	<div class="s-line  s-l-active"></div>
	<div class="step s-active">2</div>
	<div class="s-line  s-l-active"></div>
	<div class="s-line  s-l-active"></div>
	<div class="step s-active">3</div>
	<div class="s-line "></div>
	<div class="s-line "></div>
	<div class="step ">4</div>
</div>

<div class="facility-box">
	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>服务项目</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>接机服务</span>
			</div>

			@endfor
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>宠物</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 3; $i++)
			<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>可携带宠物</span>
			</div>

			@endfor
		</div>

	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>通用设施</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>通用设施</span>
			</div>

			@endfor
		</div>

	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>活动设施</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="item-block" id="serviceItems" onclick="serviceItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>活动设施</span>
			</div>

			@endfor
		</div>

	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-便利设施</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">便利设施</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>

			</div>

			@endfor
		</div>

	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-媒体/科技</span>
		</div>

		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">媒体/科技</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>

			</div>

			@endfor
		</div>

	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-食品和饮品</span>
		</div>
		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">食品和饮品</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>
			</div>
			@endfor
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-浴室</span>
		</div>
		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">浴室</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>
			</div>
			@endfor
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-室外/景观</span>
		</div>
		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">室外/景观</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>
			</div>
			@endfor
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>客房设施-服务及其他</span>
		</div>
		<div class="item-box">
			@for ($i = 0; $i < 30; $i++)
			<div class="radio-item-block">
				<span class="radio-item-title">服务及其他</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">全部</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">部分</span>

				<input type="radio" class="radio-item-input" > 
					<span class="radio-item-span">无</span>
			</div>
			@endfor
		</div>
	</div>


	<div class="hotel-policy-row height-80">
      	<div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
    </div>
	
</div>

@stop

@section('script')

<script type="text/javascript">

	function serviceItems(_this) {
		$(_this).addClass("click-item-block");
	}
	
</script>

@stop