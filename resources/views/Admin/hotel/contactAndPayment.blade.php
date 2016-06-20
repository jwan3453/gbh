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


{{-- 直接使用酒店设置页的部分css样式  --}}
<div class="facility-box">
	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>联系方式</span>
		</div>

		<div class="item-box">

			<div class="contact-box">
				<div class="contact-box-row">
					<label>姓名：</label>
					<input type="text" class="contact-input">

					<label>电话：</label>
					<input type="text" class="contact-input">

					<label>手机：</label>
					<input type="text" class="contact-input">
				</div>
				<div class="contact-box-row">
					<label>职务：</label>
					<input type="text" class="contact-input">

					<label>传真：</label>
					<input type="text" class="contact-input">

					<span>Email   ：</span>
					<input type="text" class="contact-input">
				</div>
			</div>

			<div class="item-block width-200 border-blue" onclick="addContact(this)">
				<img src="/Admin/icon/add.png" class="margin-right-20">
				添加联系人
			</div>
			
		</div>
	</div>


	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>信用卡</span>
		</div>

		<div class="item-box">

			<div class="item-block width-200">
				不支持信用卡
			</div>
			
		</div>
	</div>


	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>国内信用卡</span>
		</div>

		<div class="item-box">
			<div class="credit-row">
				<div class="item-block pandding-20" >
					国内发行银联卡
				</div>
			</div>

			@for ($i = 0; $i < 30; $i++)
			<div class="item-block pandding-20" id="serviceItems" onclick="creditItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>国内信用卡</span>
			</div>

			@endfor
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>国外信用卡</span>
		</div>

		<div class="item-box">

			@for ($i = 0; $i < 30; $i++)
			<div class="item-block pandding-20" id="serviceItems" onclick="creditItems(this)">
				<!-- <input type="hidden" name="serviceItems"> -->
				<span>国外信用卡</span>
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
	function creditItems(_this) {
		$(_this).addClass("click-item-block");
	}

	function addContact(_this) {
		var a = '';
		a += '<div class="contact-box">';
		a += '		<div class="contact-box-row">';
		a += '			<label>姓名：</label>';
		a += '			<input type="text" class="contact-input">';

		a += '			<label>电话：</label>';
		a += '			<input type="text" class="contact-input">';

		a += '			<label>手机：</label>';
		a += '			<input type="text" class="contact-input">';
		a += '		</div>';
		a += '		<div class="contact-box-row">';
		a += '			<label>职务：</label>';
		a += '			<input type="text" class="contact-input">';

		a += '			<label>传真：</label>';
		a += '			<input type="text" class="contact-input">';

		a += '			<span>Email   ：</span>';
		a += '			<input type="text" class="contact-input">';
		a += '		</div>';
		a += '	</div>';

		$(_this).before(a);
	}
</script>

@stop