@extends('Admin.site')





@section('content')

    <div class="admin-content">
        <div class="info-menu">

            <span id="informationMaintenance" class="hover-menu"> 
                <a>信息维护</a> 
                <a class="display-none">酒店基本信息</a>
                <a class="display-none">交通地理</a>
                <a class="display-none">酒店政策</a>
                <a class="display-none">联系方式</a>
                <a class="display-none">信用卡</a>
                <a class="display-none">酒店设施</a>
                <a class="display-none">酒店图片</a>
                <a class="display-none">酒店活动管理</a>
            </span>

            <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/manageRoom')}}"><span>房型信息</span></a>
            <span>问答管理</span>
        </div>
        <hr/>

       @yield('infoContent')
    </div>
@stop

@section('script')
    <script type="text/javascript">

        $("#informationMaintenance").mouseover(function(){
            $(this).find("a").each(function(){
                if ($(this).hasClass('display-none')) {
                    $(this).removeClass('display-none');
                }
            })
        })

        $("#informationMaintenance").mouseout(function(){
            $(this).find("a:first-child").siblings().addClass('display-none');
        })

    </script>

    @yield('infoScript')
@stop