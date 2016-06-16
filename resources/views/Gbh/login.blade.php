
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=0;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=false;” />
    <meta name=”viewport” content=”width=device-width; initial-scale=1.0; maximum-scale=1.0; user-scalable=no;” />
    <meta name="viewport" content="width=device-width, user-scalable=no" />
    <meta name="_token" content="{{ csrf_token() }}"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <script src={{ asset('js/jquery-2.1.4.min.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('Gbh/css/website.css') }}>

    <style type="text/css">

    ::-webkit-input-placeholder { 
        color:#a0a0a0; 
        text-indent: 1em;
        font-size: 16px;
        font-weight: bold;
    }
    ::-moz-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        font-size: 16px;
        font-weight: bold;
    } /* firefox 19+ */
    :-ms-input-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        font-size: 16px;
        font-weight: bold;
    } /* ie */
    input:-moz-placeholder {
        color:#a0a0a0; 
        text-indent: 1em;
        font-size: 16px;
        font-weight: bold;
    }

    input {outline:none;}

    </style>

</head>

<body>

    <div class="background">
        

        <div class="login-input-box">

            <div class="login-input-title">
                <span>全球精品酒店用户登录</span>
            </div>

            <div class="login-input-buttom">
                
                <div class="login-input-row">
                    <img src="/Gbh/icon/user.png">
                    <input type="text" placeholder="请输入用户名">
                </div>

                <div class="login-input-row margin-top-30">
                    <img src="/Gbh/icon/password.png">
                    <input type="text" placeholder="请输入密码">
                </div>

                <div class="remember-me margin-top-30">
                    <input type="checkbox">
                    <span>记住我</span>
                </div>

                <div class="gbh-login-btn margin-top-30">
                    <span>登录</span>
                </div>

            </div>
            
        </div>


        <div class="login-foot-box">
            <span>全球精品酒店 版权所有 2016-2028 保留所有权利</span>
            <span>Copyright 2016-2028 Opulun.com All right reserved</span>
        </div>



    </div>

        


</body>






</html>
