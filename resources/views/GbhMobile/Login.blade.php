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
</head>
	<script src={{ asset('../js/jquery-2.1.4.min.js') }}></script>
<body>
	<div class="ui container login-box" >
		
		<img src="../GbhMobile/img/login-background.png" class="brackgroud-img">

		<div class="logo-div">
			<img src="../GbhMobile/img/logo.png" class="logo">
		</div>

		<div class="login-form-box">
			<div class="login-username-box">
				<img src="../GbhMobile/img/baise.png" class="login-input-base-left">
				<div class="login-input-icon">
					<img src="../GbhMobile/img/username-icon.png" class="login-input-icon">
				</div>

				<input type="text" placeholder="请输入手机号" class="login-username-input" />

				<img src="../GbhMobile/img/baise.png" class="login-input-base-right">
			</div>

			<div class="login-password-box">
				<img src="../GbhMobile/img/baise.png" class="login-input-base-left">
				<div class="login-input-icon">
					<img src="../GbhMobile/img/password-icon.png" class="login-input-icon">
					<input type="password" placeholder="请输入密码" class="login-username-input" />
				</div>
				<img src="../GbhMobile/img/baise.png" class="login-input-base-right">
			</div>

			<div class="login-text-box">
				<a class="text-forget">忘记密码</a>
			</div>




			<div class="login-button-box">
				<div class=" login-button  regular-btn">登录</div>

				<button class="regular-btn register-button">注册</button>
			</div>
			
		</div>

	</div>

	
</body>

	<script type="text/javascript"></script>

</html>