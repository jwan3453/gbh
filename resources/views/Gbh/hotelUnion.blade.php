
@extends('Gbh.union')

@section('resources')

@stop

@section('contents')
    <div id="alertBox" class="alert-box"></div>
    <div class="path-box">
        <p class="action-path">填写信息</p>
        <p>提交结果</p>
    </div>
    <div class="from-boxs ui form">
        <div class="union-box">

            <form class="form-content" method="post" action="{{ url('/joinUnion') }}">
                <ul>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <li><label>酒&nbsp;&nbsp;店&nbsp;&nbsp;名</label><input type="text" name='Union[hotel_name]' id="hotel_name"></li>
                    <li><label>酒店地址</label><input type="text" class="form-control" name='Union[hotel_address]' id="hotel_address"></li>
                    <li><label>酒店电话</label><input type="text" name='Union[hotel_number]' id="hotel_number"></li>
                    <li><label>联&nbsp;&nbsp;系&nbsp;&nbsp;人</label><input type="text" name='Union[hotel_person]' id="hotel_person"></li>
                    <li><label>联系人手机</label><input type="text" name='Union[person_number]' id="person_number"></li>
                    <li><label>联系人邮箱</label><input type="text" name='Union[person_email]' id="person_email"></li>
                    <li><textarea placeholder="备注信息......" name='Union[remarks]' id="remarks"></textarea></li>
                </ul>
                <button id="unionBtn">确认加入</button>

            </form>
        </div>
    </div>
@stop

@section('script')
    <script>
        $(function(){
            $("#unionBtn").click(function(){
                if($("#hotel_name").val()==""){
                    $("#hotel_name").focus();
                    toastAlert('酒店名不能为空',1);
                    return false;
                }
                if($("#hotel_address").val()==""){
                    $("#hotel_address").focus();
                    toastAlert('酒店地址不能为空',1);
                    return false;
                }
                var pregnumber = /((\(?[0-9]{3}\)?|[0-9]{3}\-?)[0-9]{8}|[0-9]{4}\-[0-9]{7}|[0-9]{8})/;
                if($("#hotel_number").val()==""){
                    $("#hotel_number").focus();
                    toastAlert('酒店电话不能为空',1);
                    return false;
                }
                else{
                    if(!pregnumber.test($("#hotel_number").val())){
                        $("#hotel_number").focus();
                        toastAlert('酒店电话格式不正确',1);
                        return false;
                    }
                }

                if($("#hotel_person").val()==""){
                    $("#hotel_person").focus();
                    toastAlert('联系人不能为空',1);
                    return false;
                }
                var pregphone = /13[0-9]{9}|14[0-9]{9}|15[0-9]{9}|17[0-9]{9}|18[0-9]{9}/;
                if($("#person_number").val()==""){
                    $("#person_number").focus();
                    toastAlert('联系人电话不能为空',1);
                    return false;
                }

                if(!pregphone.test($("#person_number").val())){
                    $("#person_number").focus();
                    toastAlert('手机格式不正确',1);
                    return false;
                }
                var pregemail = /\w[-\.\w+]*@([A-Za-z0-9][-A-Za-z0-9]+\.)+[A-Za-z0-9]{2,14}/;
                if($("#person_email").val()==""){
                    $("#person_email").focus();
                    toastAlert('邮箱不能为空',1);
                    return false;
                }

                if(!pregemail.test($("#person_email").val())){
                    $("#person_email").focus();
                    toastAlert('邮箱格式不正确',1);
                    return false;
                }


            });


        });
        function toastAlert(Msg,status)
        {

            if(status === 1)
            {
                $('#alertBox').removeClass('wrong-input').addClass('wrong-input');
            }
            $('#alertBox').text(Msg).fadeIn();

            setTimeout(function () {
                $('#alertBox').fadeOut();
            }, 2000);

        }
        window.onload = function(){
            var unionInfo = document.getElementById('unionInfo');
            var picBox = document.getElementById('picBox');
            var prev = document.getElementById('prev');
            var next = document.getElementById('next');
            var animated = false;
            var timer;

            function animate(offset){
                animated = true;
                var newLeft = parseInt(picBox.style.left) + offset;
                var time = 300;  //位移总时间
                var interval = 10;  //位移间隔时间
                var speed = offset/(time/interval);  //每次位移量

                function go(){
                    if((speed < 0 && parseInt(picBox.style.left) > newLeft) || (speed > 0 && parseInt(picBox.style.left) < newLeft)){
                        picBox.style.left = parseInt(picBox.style.left) + speed + 'px';
                        setTimeout(go,interval);
                    }else{
                        animated = false;
                        picBox.style.left = newLeft + 'px';
                        if(newLeft > -240){
                            picBox.style.left = -960 + 'px';
                        }
                        if(newLeft < -960){
                            picBox.style.left = -240 + 'px';
                        }
                    }
                }
                go();

//                picBox.style.left = newLeft + 'px';
//                if(newLeft > -240){
//                    picBox.style.left = -960 + 'px';
//                }
//                if(newLeft < -960){
//                    picBox.style.left = -240 + 'px';
//                }
            }
            function play(){
                timer = setInterval(function(){
                    next.onclick();
                },2000);
            }
            function stop(){
                clearInterval(timer);
            }

            next.onclick = function(){
                animate(-240);
            }
            prev.onclick = function(){
                animate(240);
            }
            picBox.onmousemove = stop;  //悬停停止
            picBox.onmouseout = play;   //移开执行
            play();
        }
    </script>
@stop