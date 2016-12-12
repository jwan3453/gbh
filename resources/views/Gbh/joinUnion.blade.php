
@extends('Gbh.union')

@section('resources')
    <style>
        .sucess-box{
            width: 700px;
            height: 300px;
            margin: -5px auto 50px auto;
            background: rgba(9, 9, 26, 0.9);
        }
        .sucess-box h1,.sucess-box p{
            padding-top: 50px;
            text-align: center;
            color: #fff;
        }
        .sucess-box h1{
            color: #FFCA8B;
        }
        .sucess-box p:nth-child(3){
            color: dimgrey;
        }
    </style>
@stop

@section('contents')
    <div class="path-box">
        <p>填写信息</p>
        <p class="action-path">提交结果</p>
    </div>
    <div class="sucess-box" >
        <h1>提交成功</h1>
        <p>您的信息已经以火箭般的速度送往小编的碗里啦,稍后您将会收到我们的申请确认邮件~</p>
        <p>如果没有收到,请尝试联系客服哦.</p>
    </div>
@stop
@section('script')
    <script>

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
