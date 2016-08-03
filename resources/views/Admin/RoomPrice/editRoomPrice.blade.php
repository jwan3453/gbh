@extends('Admin.site')



@section('content')

    <div class="light-bg">
        <div class="room-price-search">
            <select class="room-type">

                <option>全部房型</option>
            </select>

            <select class="paid-type">
                <option>全部支付类型</option>
            </select>

            <select class="year">
                <option>年份</option>
            </select>

            <span>年</span>

            <span class="date-dash">--</span>

            <select class="month">
                <option>月份</option>
            </select>

            <span>月</span>

            <div class="regular-btn blue-btn room-price-search-btn ">查询</div>
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
                                        <span class="up">￥{{$roomPrice->rate}}</span>
                                        <span class="down">早餐:{{$roomPrice->num_of_breakfast}}</span>
                                    @endif
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
                                        <span class="up">￥{{$roomPrice->prepaid_rate}}</span>
                                        <span class="down">早餐:{{$roomPrice->prepaid_num_of_breakfast}}</span>
                                    @endif
                                </td>
                            @endforeach
                        </tr>
                    </table>
            @endforeach
            </div>

            {{--<table class="auto-margin">--}}
                {{--<tr class="t-header">--}}
                    {{--<th>周日</th>--}}
                    {{--<th>周一</th>--}}
                    {{--<th>周二</th>--}}
                    {{--<th>周三</th>--}}
                    {{--<th>周四</th>--}}
                    {{--<th>周五</th>--}}
                    {{--<th>周六</th>--}}
                {{--</tr>--}}
                {{--<tr class="t-row">--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                    {{--<td>--}}
                        {{--<div class="up"></div>--}}
                        {{--<span class="date">23</span>--}}
                        {{--<span class="down">￥122~101.2</span>--}}
                    {{--</td>--}}
                {{--<tr>--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                {{--<tr>--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                {{--<tr>--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                {{--<tr>--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                {{--<tr>--}}
                {{--<tr>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                    {{--<td></td>--}}
                {{--<tr>--}}
            {{--</table>--}}




    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


        })
    </script>
@stop