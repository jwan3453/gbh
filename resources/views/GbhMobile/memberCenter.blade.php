<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
	<meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
	<meta name="viewport" content="width=device-width, user-scalable=no" />
	<meta name="_token" content="{{ csrf_token() }}"/>
	<title></title>
	<link rel="stylesheet" type="text/css" href= {{ asset('../GbhMobile/css/mobileSite.css') }}>
	<link rel="stylesheet" type="text/css" href= {{ asset('../semantic/grid.css') }}>
	<link rel="stylesheet" type="text/css" href= {{ asset('../semantic/icon.css') }}>
	<link rel="stylesheet" type="text/css" href= {{ asset('../semantic/button.css') }}>
	<style type="text/css">
		body{
			background-color: #f8f8f8;

			-moz-user-select: none; 
			-webkit-user-select: none; 
			-ms-user-select: none; 
			-khtml-user-select: none; 
			user-select: none; 
		}
	</style>
</head>
	<script src={{ asset('../js/jquery-2.1.4.min.js') }}></script>
<body>
	<div class="ui container personnel-wrapper" >
		
		<div class="personnel-header-brackground">

			<div class="personnel-portrait-box">
				<img src="../GbhMobile/personnelportrait/big-bai.png" class="personnel-portrait-img">
			</div>

			<div class="personnel-username-box">
				<span class="personnel-username-text">阿泽</span>
			</div>

			<div class="personnel-content-box">
				<div class="personnel-unpaid">
					<span class="personnel-content-text">未付款</span><br>
					<span class="personnel-content-number">(40)</span>
				</div>

				<div class="personnel-content-separate-1"></div>

				<div class="personnel-already-paid">
					<span class="personnel-content-text">已付款</span><br>
					<span class="personnel-content-number">(40)</span>
				</div>

				<div class="personnel-content-separate-2"></div>

				<div class="personnel-pending-payment">
					<span class="personnel-content-text">待付款</span><br>
					<span class="personnel-content-number">(40)</span>
				</div>
			</div>
			
		</div>

		<div class="personnel-menu-box">

			<div class="personnel-menu-colmun" onclick="location.href='order/orderListAll'">
				<img src="../GbhMobile/img/personnel-order.png" class="personnel-menu-icon">
				<span>订单详情</span>
				<i class="chevron right icon"></i>
			</div>

			<div class="personnel-menu-colmun">
				<img src="../GbhMobile/img/personnel-points.png" class="personnel-menu-icon">
				<span>积分查询</span>
				<a>100 积分可用</a>
				<i class="chevron right icon"></i>
			</div>

			<div class="personnel-menu-colmun" onclick="location.href='myCollection'">
				<img src="../GbhMobile/img/personnel-collection.png" class="personnel-menu-icon">
				<span>我的收藏</span>
				<i class="chevron right icon"></i>
			</div>

			<div class="personnel-menu-colmun-last" onclick="location.href='editUserInfo'">
				<img src="../GbhMobile/img/personnel-setting.png" class="personnel-menu-icon">
				<span>账户设置</span>
				<i class="chevron right icon"></i>
			</div>
			
		</div>

		<div class="personnel-menu-separate-foot"></div>

		<div class="personnel-foot-box">

			<div class=" return-mall-button  regular-btn" onclick="location.href='/'">返回商城</div>

			<div class=" change-user-button  regular-btn">切换账户</div>
		</div>

	</div>

</body>

	<script type="text/javascript"></script>

</html>