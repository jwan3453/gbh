@extends('GbhMobile.site')

@section('resources')
	<style type="text/css">
		body{
			background-color: #e6e6e6;
		}

		*:focus {outline: none;}

		::-webkit-input-placeholder { color:#505050; }
		::-moz-placeholder { color:#505050; } /* firefox 19+ */
		:-ms-input-placeholder { color:#505050; } /* ie */
		input:-moz-placeholder { color:#505050; }
	</style>
@stop


@section('content')
<div class="ui container edit-user-wrapper" >

	<div class="nav-header">
		<img src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);" />
		<span class="nav-header-text">账号设置</span>
	</div>

	<div class="edit-username-box">
		<img src="../GbhMobile/img/register-username-icon.png">
		<input type="text" placeholder="修改昵称" />
		<span class="username">阿泽</span>
	</div>

	<div class="edit-password-box">
		<div class="edit-password-colmun">
			<img src="../GbhMobile/img/register-password-icon.png">
			<input type="password" placeholder="修改密码" />
			<span class="remarks">若不修改则无需填写此行</span>
		</div>

		<div class="edit-password-colmun">
			<img src="../GbhMobile/img/register-password-icon.png">
			<input type="password" placeholder="确认密码" />
			<span class="remarks">若不修改则无需填写此行</span>
		</div>

		<div class="edit-password-colmun">
			<img src="../GbhMobile/img/register-mobilecode-icon.png">
			<input type="number" placeholder="输入手机验证码" />
			<div class=" edituser-mobilecode-button  regular-btn">
				<span class="mobile-code-text">获取验证码</span>
			</div>
		</div>
	</div>

	<div class=" edituser-confirm-button  regular-btn">
		<span>确认修改</span>
	</div>

</div>
@stop


@section('script')
	<script type="text/javascript">
		$("input").focus(function(){
			$(this).next('span').css('display','none');
			$(this).data('placeholder', $(this).prop('placeholder')).removeAttr('placeholder')
			console.log($(this).data('placeholder'));
		})

		$("input").blur(function(){
			$(this).next('span').css('display','block');
			$(this).prop('placeholder', $(this).data('placeholder'));
		})
	</script>
@stop