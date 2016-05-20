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
		::-webkit-input-placeholder { color:#505050; }
		::-moz-placeholder { color:#505050; } /* firefox 19+ */
		:-ms-input-placeholder { color:#505050; } /* ie */
		input:-moz-placeholder { color:#505050; }

		*:focus {outline: none;}

		body{
			background-color: #e6e6e6;
		}
	</style>
</head>
	<script src={{ asset('../js/jquery-2.1.4.min.js') }}></script>
<body>
	<div class="ui container register-wrapper" >
		<div class="nav-header">
			<img src="../GbhMobile/img/left-icon.png" class="nav-header-left"/>
			<span class="nav-header-text">注册</span>
		</div>

		<div class="middle-box">

			<div class="register-input-div">

				<div class="input-div-column">
					<img src="../GbhMobile/img/register-mobile-icon.png">

					<input type="number" placeholder="请输入手机号码" class="register-input" />
				</div>

				<div class="column-separate"></div>

				<div class="input-div-column">
					<img src="../GbhMobile/img/register-mobilecode-icon.png">

					<input type="number" placeholder="请输入验证码" class="mobile-code-input" />

					<div class=" mobile-code-button  regular-btn"><span class="mobile-code-text">获取验证码</span></div>
				</div>

				<div class="column-separate"></div>

				<div class="input-div-column">
					<img src="../GbhMobile/img/register-password-icon.png">

					<input type="password" placeholder="请输入密码" class="register-input" />
				</div>

				<div class="column-separate"></div>

				<div class="input-div-column">
					<img src="../GbhMobile/img/register-password-icon.png">

					<input type="password" placeholder="请重复您的密码" class="register-input" />
				</div>

				<div class="column-separate"></div>

				<div class="input-div-column">
					<img src="../GbhMobile/img/register-username-icon.png">

					<input type="text" placeholder="请输入您的账户昵称" class="register-input" />
				</div>

				<div class="column-separate"></div>

			</div>

		</div>

		<div class="register-button-box">
			<div class="register-button  regular-btn">下一步</div>
		</div>

	</div>

</body>

	<script type="text/javascript"></script>

</html>