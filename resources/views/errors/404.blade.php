@extends('Gbh.site')



@section('resources')


@stop

@section('content')





    <title>404</title>
    <div class="page-not-found">
        <img src = '/Gbh/img/404.png'>

        <div class="ui container">

            <div class="more-option">
                <a href="/"  class="option"><div>
                        带我回首页
                    </div></a>

                <a href="/destinationList" class="option"><div >
                        热门目的地
                    </div></a>

                <a href="http://gbhchina.com/newArticles" class="option"><div >
                        酒店体验
                    </div></a>
            </div>
        </div>
@stop


@section('script')
    <script type="text/javascript">

        $(document).ready(function(){

        })
    </script>

@stop