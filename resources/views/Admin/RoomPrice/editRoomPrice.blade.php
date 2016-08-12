@extends('Admin.site')


@section('resources')

    <script src={{ asset('js/datepicker/laydate.js') }}></script>
    <script src={{ asset('js/jquery.form.js') }}></script>

@endsection


@section('content')

    <div class="light-bg">
        <div class="room-price-search">
            <form style="display: inline-block" action="{{url('/admin/manageRoomPrice/searchRoomPrice')}}" method="post" id="searchForm">

                <input type="hidden" name="hotelId" value="{{$hotelId}}">
                <input type="hidden" name="_token" value="{{csrf_token()}}">

                <select class="room-type" id="selectedRoomType" name="selectedRoomType">

                    <option value="0">全部房型</option>
                    @foreach($roomTypeList as $room)
                        <option value="{{$room->id}}">{{$room->room_name}}</option>
                    @endforeach
                </select>

                <input type="text" placeholder="选择日期" id="searchDate" name="searchDate" value="{{$selectedDate}}"/>


                {{--<select class="year">--}}
                    {{--<option>年份</option>--}}
                {{--</select>--}}

                {{--<span>年</span>--}}

                {{--<span class="date-dash">--</span>--}}

                {{--<select class="month">--}}
                    {{--<option>月份</option>--}}
                {{--</select>--}}

                {{--<span>月</span>--}}

                <div class="regular-btn blue-btn room-price-search-btn " id="searchBtn">查询</div>
            </form>
            <a href="/admin/manageRoomPrice/roomPriceBatch/{{$hotelId}}"><div class="regular-btn red-btn batch-edit-room-price">批量修改房价</div></a>
        </div>


            {{--<div class="select-month">--}}
                {{--<i class="angle left icon f-left big pre-month"></i>--}}
                {{--<span></span>--}}
                {{--<i class="angle right icon f-right big next-month"></i>--}}
            {{--</div>--}}
        <div class="room-price-calendar " >
                <table>
                    <tr class="t-header">
                        <td class="td-header">
                            房型
                        </td>

                        @foreach($weekDayList as $weekDay)
                            <td class="date-header">
                                <span class="up"></span>
                                <span class="date">{{$weekDay['weekDay']}}</span>
                                <span class="down">{{$weekDay['date']}}</span>
                            </td>
                        @endforeach
                    </tr>


                </table>

            @foreach($roomTypeList as $roomType)

                    <div class="room-type-header">{{$roomType->room_name}}</div>
                    <table>
                        <tr>
                            <td class="td-header">
                                先付
                            </td>
                            @foreach($roomPriceMonthList[$roomType->room_name ] as $roomPrice)
                                <td class="price-column">
                                    @if($roomPrice->emptyPrice == true)
                                        {{$roomPrice->rate}}
                                    @else
                                        <span class="up">￥<span class="r-p">{{$roomPrice->rate}}</span></span>
                                        <span class="down">早餐:<span class="n-of-bf">{{$roomPrice->num_of_breakfast}}</span></span>
                                    @endif
                                        <input type="hidden" class="r-c" value="{{$roomPrice->commission}}">
                                        <input type="hidden" class="r-id" value="{{$roomPrice->room_id}}">
                                        <input type="hidden" class="p-d" value="{{$roomPrice->date}}">
                                        <input type="hidden" class="p-t" value="1">
                                </td>
                            @endforeach
                        </tr>

                        <tr>
                            <td class="td-header">
                                预付
                            </td>
                            @foreach($roomPriceMonthList[$roomType->room_name ] as $roomPrice)
                                <td class="price-column">
                                    @if($roomPrice->emptyPrice == true)
                                        {{$roomPrice->prepaid_rate}}
                                    @else
                                        <span class="up">￥<span class="r-p">{{$roomPrice->prepaid_rate}}</span></span>
                                        <span class="down">早餐:<span class="n-of-bf">{{$roomPrice->prepaid_num_of_breakfast}}</span></span>
                                    @endif
                                    <input type="hidden" class="r-c" value="{{$roomPrice->prepaid_commission}}">
                                    <input type="hidden" class="r-id" value="{{$roomPrice->room_id}}">
                                    <input type="hidden" class="p-d" value="{{$roomPrice->date}}">
                                    <input type="hidden" class="p-t" value="2">
                                </td>
                            @endforeach
                        </tr>
                    </table>
            @endforeach
            </div>

        <div class="update-price-popup" id="updatePricePopup">
            <i class="icon remove"> </i>
            <form id="updateRoomPriceFrom">
                <input type="hidden" name="hotelId" value="{{$hotelId}}">
                <input type="hidden" name="roomId" id="roomId" value="">
                <input type="hidden" name="payType" id="paidType" value="">
                <input type="hidden" name="date" id="date" value="">
                <div>
                    <label>房价:</label> <input type="text" id="roomRate" name="roomRate"/>
                </div>
                <div>
                    <label>佣金:</label> <input type="text" id="roomComm" name="roomComm"/>
                </div>
                <div>
                    <label>早餐:</label>
                    <select  name="breakfast" id="breakfast">
                        <option value="0">0份</option>
                        <option value="1">1份</option>
                        <option value="2">2份</option>
                    </select>

                </div>

                <div class="regular-btn red-btn auto-margin " id="submitPrice">提交价格</div>
           </form>
        </div>

    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            laydate({
                elem: '#searchDate'
            })

            //按条件搜索
            $('#searchBtn').click(function(){

                $('#searchForm').submit();
            })


            $('.price-column').hover(function(){


//                var top= $(this).offset().top;
//                var left = $(this).offset().left;
//                $('#updatePricePopup').css('top',top-30).css('left',left-170).show();
                $(this).addClass('price-column-hover');

            },
            function(){
                $(this).removeClass('price-column-hover');

            })

            //点击弹出变价框
            var currentPriceObj=null;
            $('.price-column').click(function(){

                currentPriceObj = $(this);

                $('#roomId').val($(this).find('.r-id').val());
                $('#paidType').val($(this).find('.p-t').val());
                $('#date').val($(this).find('.p-d').val());
                $('#roomRate').val($(this).find('.r-p').text());
                $('#roomComm').val($(this).find('.r-c').val());
                $('#breakfast').val($(this).find('.n-of-bf').text());


                if($('#updatePricePopup').css('display') !== 'none')
                {
                    $('#updatePricePopup').hide();
                }
                var top= $(this).offset().top;
                var left = $(this).offset().left;
                $('#updatePricePopup').css('top',top).css('left',left-200).fadeIn();
            })

            //关闭变价框
            $('.remove').click(function(){
                $('#updatePricePopup').hide();
            })

            //提交新的房价
            $('#submitPrice').click(function(){
                if($('#roomRate').val()==='' || parseInt($('#roomRate').val())=== 0 )
                {
                    toastAlert('房价不能为空或零');
                    return;
                }
                if($('#roomComm').val()==='' || parseInt($('#roomComm').val())=== 0 )
                {
                    toastAlert('佣金不能为空或零');
                    return;
                }

                //提交价格

                var options = {
                    url: '/admin/manageRoomPrice/roomPriceUpdateSubmit',
                    type: 'post',
                    dataType: 'json',
                    data: $("#updateRoomPriceFrom").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            //动态更改更新后的房价
                            currentPriceObj.find('.r-p').text($('#roomRate').val());
                            currentPriceObj.find('.n-of-bf').text($('#breakfast').val());
                            $('#updatePricePopup').hide();
                            toastAlert('更新成功',1);
                        }
                        else{
                            $('#updatePricePopup').hide();
                            toastAlert('更新失败');
                        }
                    },
                    error:function(data){

                    }
                };
                $.ajax(options);

            })

        })
    </script>
@stop