@extends('Admin.Hotel.maintainHotelInfo')


@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
    <script src={{ asset('semantic/modal.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
@stop

@section('infoContent')

    <div class="info-content">
        <div class="hotel-info">
            <div class="header">酒店设施</div>


            <form id="hotelFacilityForm" action='{{url("/admin/manageHotel/hotelInfo/createOrUpdateHotelFacilities")}}' method="Post">

                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" value="{{$hotelId}}" id="hotelId" name="hotelId" />
                <input type="hidden" value="{{$createOrUpdate}}" id="createOrUpdate" name="createOrUpdate" />

                <div class="facility-list-box ">

                    @foreach($hotelFacilities['category'] as $category)
                    <div class="facility-category">{{$category->service_name}}</div>

                        <div class="facility-list">
                        @foreach($hotelFacilities['list'][$category->id] as $facilityItem)
                            <label>
                            <span>{{$facilityItem->name}}</span>
                            <input type="checkbox" value="{{$facilityItem->id}}" id="facility_{{$facilityItem->id}}" name="facilityItem[]" class="facility-checkbox none-display " />
                            </label>
                        @endforeach
                    </div>
                    @endforeach

                </div>
                <div type="submit" class = "next-step-btn auto-margin" id="submitBtn">保存</div>
            </form>
        </div>
    </div>


@stop


@section('infoScript')
    <script type="text/javascript">


        $(document).ready(function() {

            //选中设施
            $('.facility-list >label > span').click(function(){
                if($(this).hasClass('facility-selected'))
                {

                    $(this).removeClass('facility-selected');

                }
                else{

                    $(this).addClass('facility-selected');
                }
            })


            var facilitySelectedList ='';
            @if($hotelFacilities['settings']!=null)
                    facilitySelectedList= '{{$hotelFacilities['settings']->facilities_checkbox}}'.split(',');
            @endif



//
            for(var i =0; i<facilitySelectedList.length; i++ )
            {
               $('#facility_' + facilitySelectedList[i]).attr('checked','checked').siblings('span').addClass('facility-selected');//== 'checked';
            }
//
//
            //提交表单,刷新页面
            $('#submitBtn').click(function(){


                var options = {
                    url: '/admin/manageHotel/hotelInfo/createOrUpdateHotelFacilities',
                    type: 'post',
                    dataType: 'json',
                    encoding: "UTF-8",
                    data: decodeURIComponent( $("#hotelFacilityForm").serialize(),true),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){

                    },
                    success: function (data) {
                           location.reload();
                    },
                    error:function(data){
                    }
                };
                $.ajax(options);
            })

        })
    </script>
@stop










