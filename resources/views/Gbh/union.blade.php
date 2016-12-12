@extends('Gbh.site')

@section('resources')

@stop

@section('content')
    <title>酒店联盟</title>

    <div class="container">
        <div class="top-box">
            <div class="union-info" id="unionInfo">
                <h1>LATEST:<span>联盟成员</span></h1>
                <div class="pic-box" id="picBox" style="left: -240px;">
                    <ul>
                        <li class="pic-one">
                            <div><img src="#"><p>x11x</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x22xx</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x33x</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x44x</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x55x</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x66x</p></div>
                        </li>
                        <li class="pic">
                            <div><img src="#"><p>x77x</p></div>
                        </li>
                    </ul>

                </div>

            </div>
            <div>
                <a href="javascript:;" class="arrow" id="prev">&lt;</a>
                <a href="javascript:;" class="arrow" id="next">&gt;</a>
            </div>
            <div class="word-top">
                <h3>如果您与我们有同样的追求</h3>
                <h2>欢迎成为我们的联盟酒店</h2>
            </div>
        </div>
        @yield('contents')
    </div>
@stop

@section('script')
    <script>
        window.onload = function(){
            var unionInfo = document.getElementById('unionInfo');
            var picBox = document.getElementById('picBox');
            var prev = document.getElementById('prev');
            var next = document.getElementById('next');


            next.onclick = function(){
                picBox.style.left = parseInt(picBox.style.left) - 200 + 'px';
            }
            prev.onclick = function(){
                picBox.style.left = parseInt(picBox.style.left) + 200 + 'px';
            }
        }
    </script>
@stop
