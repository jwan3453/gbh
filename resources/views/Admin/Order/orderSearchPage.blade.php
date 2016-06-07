@extends('Admin.site')

@section('resources')
@stop

@section('content')
<div class="order-upper">
	<div class="order-upper-row">
		<span>未处理订单</span>
	</div>

	<div class="order-upper-row-separate"></div>

	<div class="order-upper-row">
		<span>今日新订汇总</span>
	</div>

	<div class="order-upper-row-separate"></div>

	<div class="order-upper-row">
		<span>今日入住汇总</span>
	</div>

	<div class="order-upper-row-separate"></div>

	<div class="order-upper-row order-upper-select">
		<span>订单查询</span>
	</div>

	<div class="order-upper-row-separate"></div>

	<div class="order-upper-row">
		<span>订单提醒设置</span>
	</div>

</div>

<div class="order-inquiry-condition-box">
	
	<div class="inquiry-condition-row height-24">
		<span class="title-font">日期选择：</span>

		<input type="radio" name="seachdate" value="1" class="check-radio" />
		<span class="small-font margin-right-20">全部日期</span>
		<input type="radio" name="seachdate" value="2" class="check-radio" />
		<span class="small-font margin-right-20">指定日期</span>

		<span class="small-font margin-right-10">入住</span>
		<input type="text" class="dateinput margin-right-10" placeholder="2016-06-10" />
		<span class="small-font margin-right-10">至</span>
		<input type="text" class="dateinput margin-right-20" placeholder="2016-06-10" />

		<span class="small-font margin-right-10">离店</span>
		<input type="text" class="dateinput margin-right-10" placeholder="2016-06-10" />
		<span class="small-font margin-right-10">至</span>
		<input type="text" class="dateinput" placeholder="2016-06-10" />
	</div>

	<div class="inquiry-condition-row height-24">
		<span class="title-font">订单标签：</span>

		<div class="order-inquiry-condition-tag select">
			<span>需支付</span>
		</div>
		<div class="order-inquiry-condition-tag ">
			<span>订购成功</span>
		</div>
		<div class="order-inquiry-condition-tag ">
			<span>已完成</span>
		</div>
		<div class="order-inquiry-condition-tag ">
			<span>退款中</span>
		</div>
	</div>

	<div class="inquiry-condition-row height-32">
		<span class="title-font margin-right-10">订单号</span>

		<input type="text" class="inquiry-condition-input margin-right-20" />

		<span class="title-font margin-right-10">客户姓名</span>

		<input type="text" class="inquiry-condition-input " />
	</div>

	<div class="inquiry-condition-row height-32">
		<span class="title-font margin-right-10">房型</span>

		<select class="inquiry-condition-select margin-right-20">
			<option>全部</option>
			<option>豪华大床房</option>
			<option>豪华标准房</option>
		</select>

		<span class="title-font margin-right-10">状态</span>

		<select class="inquiry-condition-select margin-right-20">
			<option>全部</option>
			<option>正常</option>
			<option>取消</option>
		</select>

		<span class="title-font margin-right-10">订单状态</span>

		<select class="inquiry-condition-select">
			<option>全部</option>
			<option>正常</option>
			<option>取消</option>
		</select>
	</div>

	<div class="inquiry-condition-row height-40">
		<div class="order-search-btu">
			<span>确认添加</span>
			<img src="/Admin/icon/search-btn.png">
		</div>
	</div>

</div>

<div class="order-search-number">
	<span class="number">200</span> <span class="title-font"> 条相关信息</span>
</div>

<div class="search-result-list-box">
	<div class="search-result-title">
		<div class="search-result-title-name"></div>
	</div>
</div>
@stop

@section('script')

@stop