@extends('Admin.site')





@section('content')

    <div class="admin-content">
        <div class="info-menu">

            <a  class="info-menu-selected" id="informationMaintenance"> <span  >
                信息维护
            </span></a>
            <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/manageRoom')}}"><span>房型信息</span></a>
            <a><span>问答管理</span></a>
        </div>
        <ul class="info-maintain-menu" id="infoMaintainMenu">
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelBasicInfo')}}" >基本信息</a></li>
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelGeoInfo')}}" >交通地理</a></li>
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelPolicy')}}" >酒店政策</a></li>
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelContact')}}" >联系方式</a></li>
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelFacilities')}}" >酒店设施</a></li>
            <li><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelImage')}}">酒店图片</a></li>
            <li><a >酒店活动管理</a></li>
        </ul>
        <div class="color-divider"></div>

       @yield('infoContent')
    </div>
@stop

@section('script')
    <script type="text/javascript">

        $(document).ready(function(){
            $("#informationMaintenance").hover(function() {
                    t = setTimeout(function(){
                            if($('#infoMaintainMenu').css('display') == 'none')
                            {
                                $('#infoMaintainMenu').transition('drop');
                            }
                        },
                        200);
                },
                function(e){
                    if($('#infoMaintainMenu').is(":hover"))
                    {
                        return;
                    }
                    else{
                        $('#infoMaintainMenu').transition('drop');
                    }
                });
            $('#infoMaintainMenu').hover(function(){

            },function(){
                if($('#informationMaintenance').is(":hover"))
                {
                    return;
                }
                $('#infoMaintainMenu').transition('drop');
            })
        })




    </script>

    @yield('infoScript')
@stop