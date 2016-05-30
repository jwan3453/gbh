@extends('GbhMobile.site')

@section('resources')
	<style type="text/css">
		body{
			background-color: #e6e6e6;
		}
	</style>
@stop

@section('content')
<div class="ui container orderinfo-wrapper" >
	
	<div class="nav-header">
		<img src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);"/>
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

	<div class="orderinfo-detail-number-box">
		<div>订  单  号：30847239473274283497</div>
		<div class="order-phone-number">联系电话：13959203539</div>
		<div>到店时间：2016-05-26 14:30 - 15:00</div>
	</div>

	<div class="orderinfo-operate-menu-box">

		<div class="orderinfo-menu-map">
			<div class="orderinfo-menu-colmun">
				<img src="../GbhMobile/img/orderinfo-marker.png" class="orderinfo-menu-icon">
				<span class="menu-name">厦门滨南斗西路口金陵大厦旁</span>
				<span class="menu-remarks">
					进入定位
					<i class="chevron right icon"></i>
				</span>
			</div>
		</div>

		<div class="orderinfo-menu-map">
			<img src="../GbhMobile/img/orderinfo-phone.png" class="orderinfo-menu-icon">
			<span class="menu-name">联系电话 : 13959205032</span>
			<span class="menu-remarks">
				复制到拨号界面
				<i class="chevron right icon"></i>
			</span>
		</div>

		<div class="orderinfo-menu-map">
			<img src="../GbhMobile/img/personnel-points.png" class="orderinfo-menu-icon">
			<span class="menu-name">总金额 : ￥2994.00</span>
			<span class="menu-remarks">
				查看明细
				<i class="chevron right icon"></i>
			</span>
		</div>

	</div>

	<div class="orderinfo-button-box">
		<!-- <div class=" orderinfo-paynow-button  regular-btn">
			<span class="mobile-code-text">立即支付</span>
		</div> -->

		<div class=" orderinfo-cancel-button  regular-btn">
			<span>取消订单</span>
		</div>

	</div>


</div>
@stop

@section('script')

@stop