<!DOCTYPE html>
<html>
<head>
    <meta name="_token" content="{{ csrf_token() }}"/>
    <title></title>

    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('Admin/css/adminSite.css') }}>

    <script src={{ asset('js/jquery.form.js') }}></script>

    <style type="text/css">

    ::-webkit-input-placeholder { 
        color:#a0a0a0; 
        text-indent: 1em;
        text-transform:uppercase;
    }
    ::-moz-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        text-transform:uppercase;
    } /* firefox 19+ */
    :-ms-input-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        text-transform:uppercase;
    } /* ie */
    input:-moz-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        text-transform:uppercase;
    }

    </style>
<body>

<div class="login-box">

    <div class="login-logo">
        <img src="/Admin/img/chang.png">
    </div>

    <div class="login-input-box">

        <div class="login-small-box">
            <form id="loginForm">

                <div class="login-input-row">
                    <input type="text" class="input-login" name="username" placeholder="请输入用户名" />
                </div>

                <div class="login-input-row">
                    <input type="text" class="input-login" name="password" placeholder="请输入密码" />
                </div>

                <div class="login-input-row">
                    <div class="login-btn" onclick="ToSubmit()">
                        <span>登录</span>
                    </div>
                </div>

            </form>
            
        </div>

    </div>
    
</div>
    

    
</body>

    <script type="text/javascript">
    
    function ToSubmit() {
        console.log($('#loginForm').serialize());
        $.ajax({
            type: 'POST',
            url: '/admin/Sign',
            data: $('#loginForm').serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }


</script>

</html>