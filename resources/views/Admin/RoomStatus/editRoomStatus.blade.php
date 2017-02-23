@extends('Admin.site')


@section('resources')

    <script src={{ asset('js/datepicker/laydate.js') }}></script>
    <script src={{ asset('js/jquery.form.js') }}></script>

@endsection


@section('content')

    @include('Admin.partial.breadcrumbTrail')

    <div class="light-bg">
        <div class="room-status-search">
            <form style="display: inline-block" action="{{url('/admin/manageRoomStatus/searchRoomStatus')}}" method="post" id="searchForm">

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

                <div class="regular-btn blue-btn room-status-search-btn " id="searchBtn">查询</div>
            </form>
            <a href="/admin/manageRoomStatus/roomStatusBatch/{{$hotelId}}"><div class="regular-btn red-btn batch-edit-room-status">批量修房态</div></a>
        </div>


        {{--<div class="select-month">--}}
        {{--<i class="angle left icon f-left big pre-month"></i>--}}
        {{--<span></span>--}}
        {{--<i class="angle right icon f-right big next-month"></i>--}}
        {{--</div>--}}
        <div class="room-table-calendar " >
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
                            现付
                        </td>
                        @foreach($roomStatusMonthList[$roomType->room_name ] as $roomStatus)
                            <td class="detail-column">
                                @if($roomStatus->emptyStatus == true)
                                    {{$roomStatus->room_status}}
                                @else
                                    <span class="up">保留房:<span class="n-of-blocked-room">{{$roomStatus->num_of_blocked_room}}</span></span>
                                    <span class="down">已预订:<span class="n-of-sold-room">{{$roomStatus->num_of_sold_room}}</span></span>
                                @endif

                                <input type="hidden" class="r-id" value="{{$roomType->id}}">
                                <input type="hidden" class="p-d" value="{{$roomStatus->date}}">
                                <input type="hidden" class="r-s" value="{{$roomStatus->room_status}}">
                                <input type="hidden" class="p-t" value="1">
                            </td>
                        @endforeach
                    </tr>

                    <tr>
                        <td class="td-header">
                            预付
                        </td>
                        @foreach($roomStatusMonthList[$roomType->room_name ] as $roomStatus)
                            <td class="detail-column">
                                @if($roomStatus->emptyStatus == true)
                                    {{$roomStatus->prepaid_room_status}}
                                @else
                                    <span class="up">保留房:<span class="n-of-blocked-room">{{$roomStatus->prepaid_num_of_blocked_room}}</span></span>
                                    <span class="down">已预订:<span class="n-of-sold-room">{{$roomStatus->prepaid_num_of_sold_room}}</span></span>
                                @endif
                                <input type="hidden" class="r-id" value="{{$roomStatus->room_id}}">
                                <input type="hidden" class="p-d" value="{{$roomStatus->date}}">
                                <input type="hidden" class="r-s" value="{{$roomStatus->prepaid_room_status}}">
                                <input type="hidden" class="p-t" value="2">
                            </td>
                        @endforeach
                    </tr>
                </table>
            @endforeach
        </div>


        <div class="update-room-cell-popup" id="updateStatusPopup">
            <i class="icon remove"> </i>
            <form id="updateRoomStatusFrom">
                <input type="hidden" name="hotelId" value="{{$hotelId}}">
                <input type="hidden" name="roomId" id="roomId" value="">
                <input type="hidden" name="payType" id="payType" value="">
                <input type="hidden" name="date" id="date" value="">
                <div>
                    <label>保留房:</label> <input type="text" id="numOfBlockedRoom" name="numOfBlockedRoom"/>
                </div>
                <div>
                    <label>房间状态:</label>
                    <select  name="roomStatus" id="roomStatus">
                        <option value="0">房间关闭</option>
                        <option value="1">可预订</option>
                        <option value="2">满房</option>
                    </select>

                </div>

                <div class="regular-btn red-btn auto-margin " id="submitStatus">提交房态</div>
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


            $('.detail-column').hover(function(){


//                var top= $(this).offset().top;
//                var left = $(this).offset().left;
//                $('#updatePricePopup').css('top',top-30).css('left',left-170).show();
                        $(this).addClass('room-column-hover');

                    },
                    function(){
                        $(this).removeClass('room-column-hover');

                    })

            //点击弹出房态框
            var currentStatusObj=null;
            $('.detail-column').click(function(){

                currentStatusObj = $(this);

                $('#roomId').val($(this).find('.r-id').val());
                $('#payType').val($(this).find('.p-t').val());
                $('#date').val($(this).find('.p-d').val());
                $('#numOfBlockedRoom').val($(this).find('.n-of-blocked-room').text());
                $('#roomStatus').val($(this).find('.r-s').val());


                if($('#updateStatusPopup').css('display') !== 'none')
                {
                    $('#updateStatusPopup').hide();
                }
                var top= $(this).offset().top-110;
                var left = $(this).offset().left;
                $('#updateStatusPopup').css('top',top).css('left',left-210).fadeIn();
            })

            //关闭房态框
            $('.remove').click(function(){
                $('#updateStatusPopup').hide();
            })

            //提交新的房态
            $('#submitStatus').click(function(){
                if($('#numOfBlockedRoom').val()==='' || parseInt($('#numOfBlockedRoom').val())=== 0 )
                {
                    toastAlert('房间数量不能为空或零');
                    return;
                }

                //提交房态

                var options = {
                    url: '/admin/manageRoomStatus/roomStatusUpdateSubmit',
                    type: 'post',
                    dataType: 'json',
                    data: $("#updateRoomStatusFrom").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            //动态更改更新后的房态
                            currentStatusObj.find('.n-of-blocked-room').text($('#numOfBlockedRoom').val());
                            currentStatusObj.find('.r-s').val($('#roomStatus').val());
                            $('#updateStatusPopup').hide();
                            toastAlert('更新成功',1);
                        }
                        else{
                            $('#updateStatusPopup').hide();
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