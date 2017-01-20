@extends('Admin.site')


@section('content')
<div id="errorContainer" style="background: #F7F7F7;">

    <div class="error-box">
        <img src="/Admin/img/not-permission.jpg">
        <h2>啊哦o(—﹏—)o,您当前没有权限访问该页面</h2>
        <p onclick="history.go(-1)">返回</p>
    </div>

</div>

@endsection
