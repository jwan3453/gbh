@extends('GbhMobile.site')

@section('resources')

@stop

@section('content')
<div class="ui container orderinfo-wrapper" >
	
	<div class="nav-header">
		<img src="../GbhMobile/img/left-icon.png" class="nav-header-left"/>
		<span class="nav-header-text">订单详情</span>
	</div>

	<div class="order-info-hotel">
		<div class="order-hotel-img">
			<img src="../GbhMobile/personnelportrait/order-img.png">
		</div>

		<div class="order-hotel-content">
			<div class="order-hotel-content-name">古典2公寓</div>
			<div class="order-hotel-content-info">高级双人床 28-32平方米 外宾房</div>
		</div>
	</div>

	<div class="menu-separate-colmun"></div>

	<div class="orderinfo-detail-list-box">
		<div class="orderinfo-detail-colmun">
			<div class="orderinfo-detail-colmun-above">
				<span class="name">高级双人床 28-32平方米 外宾房</span>
				<span class="money">￥998.00</span>
			</div>

			<div class="orderinfo-detail-colmun-middle">
				<span>含两人早餐，双床</span>
			</div>

			<div class="orderinfo-detail-colmun-below">
				<span class="time">入住 5月16日 - 退房 5月23日</span>
				<span class="user">
					<img src="../GbhMobile/img/register-username-icon.png">
					陈泽
				</span>
			</div>
		</div>
	</div>

</div>
@stop

@section('script')

@stop