@extends('Admin.site')

@section('content')
    {{--@include('admin.partial.breadcrumbTrail')--}}
    <div class="admin-content" id="adminContent">

        @include('Admin.partial.breadcrumbTrail')

        <div class="info-menu">
            <div class="ui simple dropdown " >
                    <label>信息维护</label>
                    <i class="dropdown icon"></i>
                    <div class="menu">
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelBasicInfo')}}" >基本信息</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelGeoInfo')}}" >交通地理</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelPolicy')}}" >酒店政策</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelContact')}}" >联系方式</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelFacilities')}}" >酒店设施</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelCateringService')}}" >酒店餐饮</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelRecreationService')}}" >健身娱乐</a></div>
                            <div class="sub-item"><a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelImage')}}">酒店图片</a></div>
                            <div class="sub-item"><a >酒店活动管理</a></div>
                    </div>
                </div>
            <a class="menu-item" href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/manageRoom')}}"><span>房型信息</span></a>
            <a class="menu-item"> <span>问答管理</span></a>
        </div>

        <div class="color-divider"></div>

       @yield('infoContent')
    </div>
@stop

@section('script')

    @yield('infoScript')

    <script>

        $(function(){

            function AdjustHeights() {

                var heightMenu = document.getElementById('menuBox').offsetHeight;

                var heightHotel = document.getElementById('adminContent').offsetHeight;

                if(heightHotel > heightMenu){
                    $('#menuBox').css('height',heightHotel+60);
                }

            }

            AdjustHeights();

        });

    </script>
@stop