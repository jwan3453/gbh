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
    <div class="alert-box" id="alertBox"></div>

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
                    <input type="password" class="input-login" name="password" placeholder="请输入密码" />
                </div>

                <div class="login-input-row">
                    <div class="login-btn" onclick="ToSubmit()">
                        <span>登录</span>
                    </div>

                    <span class="login-msg" id="msg"></span>
                </div>

            </form>
            
        </div>

    </div>
    
</div>
    

    
</body>

    <script type="text/javascript">

    host = window.location.host;
    
    function ToSubmit() {


        $.ajax({
            type:'POST',
            url:'/admin/checkadminuser',
            data:$('#loginForm').serialize(),
            dataType:'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                if(data.status == 1){

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

                            if (data.status == 1) {
                                location.href = "http://"+host+"/admin/AdminCenter";
                            }else{
                                toastAlert('密码错误',1);
                            }
                        },
                        error: function(xhr, type){
                            alert('Ajax error!')
                        }
                    });


                }else{
                    toastAlert('用户名不正确',1);
                }
            }
        });

    }

    function toastAlert(Msg,status)
    {

        if(status === 1)
        {
            $('#alertBox').removeClass('wrong-input').addClass('wrong-input');
        }
        if(status === 2){
            $('#alertBox').removeClass('success-toast').addClass('success-toast');
        }
        $('#alertBox').text(Msg).fadeIn();

        setTimeout(function () {
            $('#alertBox').fadeOut();
        }, 2000);
    }


</script>

</html>