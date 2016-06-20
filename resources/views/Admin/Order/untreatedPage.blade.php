@extends('Admin.site')

@section('resources')
@stop

@section('content')
<div class="order-upper">
	<div class="order-upper-row order-upper-select">
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

	<div class="order-upper-row ">
		<span>订单查询</span>
	</div>

	<div class="order-upper-row-separate"></div>

	<div class="order-upper-row">
		<span>订单提醒设置</span>
	</div>

</div>

<div class="search-result-list-box margin-top-20">
	<div class="search-result-title">
		<div class="search-result-title-name width-240">
			<span>订单号</span>
		</div>
		<div class="search-result-title-name width-160">
			<span>房型</span>
		</div>
		<div class="search-result-title-name width-160">
			<span>订单状态</span>
		</div>
		<div class="search-result-title-name width-200">
			<span>入离时间</span>
		</div>
		<div class="search-result-title-name width-140">
			<span>客户姓名</span>
		</div>
		<div class="search-result-title-name width-240">
			<span>编辑|操作</span>
		</div>
	</div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>

	<div class="search-result-row">
		<div class="search-result-detailed width-240">
			<span class="up">2016060776273627</span>
			<span class="down">(未处理)</span>
		</div>
		<div class="search-result-detailed width-160">
			<span>高级双人床</span>
			<span class="down">(外宾)</span>
		</div>
		<div class="search-result-single width-160">
			<span class="untreated">未处理</span>
		</div>
		<div class="search-result-detailed width-200">
			<span>2106-06-08</span>
			<span class="down">2106-06-11</span>
		</div>
		<div class="search-result-single width-140">
			<span>胡歌</span>
		</div>
		<div class="search-result-detailed width-240">
			<span class="order-handle"> 
				<img src="/Admin/icon/order-handle.png" class="operation-icon"> 处理订单
			</span>
			<span class="order-rewrite  margin-left-20"> 
				<img src="/Admin/icon/order-rewrite.png"  class="operation-icon"> 改写订单 
			</span>
			<span class="order-operation"> 
				<img src="/Admin/icon/order-operation-log.png"  class="operation-icon"> 操作日志
			</span>
		</div>
	</div>
	<div class="dashed"></div>
</div>

<div class="width-all height-80"></div>

@stop