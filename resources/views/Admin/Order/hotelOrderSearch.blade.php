@extends('Admin.site')

@section('resources')

@stop


@section('content')

    @include('admin.partial.breadcrumbTrail')
    <div class="h-content order-search-partial">

        <form class="order-search-form" id="orderSearchForm">
            @if(isset($hotelId))
            <input type="hidden" class="get-hotel-id" name="get-hotel-id" value="{{$hotelId}}">
            @endif
            <div class="order-date-choice">
                <span>日期选择</span>
                <select id="orderTimeType" name="order-date" onchange="orderDate();">
                    <option value="0">所有日期</option>
                    <option value="1">下单时间</option>
                    <option value="2">入住时间</option>
                </select>
                <div class="date-choice-list ordered-time">
                    <input name="order-datetime-start" type="text" placeholder="2017-02-17">
                    至
                    <input name="order-datetime-stop" type="text" placeholder="2017-02-17">
                </div>
            </div>
            <div class="order-search-list">
                <ul>
                    <li>
                        <span>订单号</span><input name="order-sn" type="text">
                    </li>
                    <li>
                        <span>预定人</span><input name="order-person" type="text"></li>
                    <li>
                        <span>酒店确认号</span><input readonly name="hotel-confirm-number" type="text" placeholder="未开通">
                    </li>
                    <li>
                        <span>酒店确认人</span><input readonly name="hotel-confirm-person" type="text" placeholder="未开通">
                    </li>
                    <li>
                        <span>房型</span>
                        <select name="choice-room-type">
                            {{--@foreach($getRoomType as $roomType)--}}
                                <option value="0">全部</option>
                                <option value="1">海景双人房</option>
                                <option value="2">海景大人房</option>
                                <option value="3">海景大床房</option>
                                <option value="4">海景双床房</option>
                            {{--@endforeach--}}
                        </select>
                    </li>
                    <li>
                        <span>订单状态</span>
                        <select name="choice-order-status">
                            <option value="2">所有</option>
                            <option value="0">未支付</option>
                            <option value="1">已支付</option>
                        </select>
                    </li>
                    <li>
                        <span>订单类型</span>
                        <select disabled>
                            <option>未开通</option>
                        </select>
                    </li>
                    <li>
                        <span>确认方式</span>
                        <select disabled>
                            <option>未开通</option>
                        </select>
                    </li>
                    <li>
                        <span>订单处理方式</span>
                        <select disabled>
                            <option>未开通</option>
                        </select>
                    </li>
                    <li>
                        <span>预约发票</span>
                        <select disabled>
                            <option>未开通</option>
                        </select>
                    </li>
                    <li>
                        <span>排列顺序</span>
                        <select name="result-sort">
                            <option value="0">按订单先后</option>
                            <option value="1">按最新时间</option>
                        </select>
                    </li>
                </ul>

            </div>
            <div class="search-bottom">
                <div class="search-submit" id="searchSubmit">查询</div>
            </div>
        </form>

        <div class="search-results-box">
            <table class="ui table group" style="margin-top: -10px;">

                <thead>
                <tr>
                    <th>订单号</th>
                    <th>状态</th>
                    <th>房型</th>
                    <th>房间数</th>
                    <th>入住人数</th>
                    <th>入离日期</th>
                    <th>支付类型</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody class="search-results-content">

                @foreach($hotelOrderInfo as $orderInfo)

                <tr class="order-search-info">
                    <td data-id="{{ $orderInfo->hotel_id }}" id="{{ $orderInfo->hotel_id }}" class="get-id"></td>
                    <td>{{ $orderInfo->order_sn }}</td>
                    <td>
                        @if($orderInfo->pay_status == 0)      未支付
                        @elseif($orderInfo->pay_status == 1)  已支付
                        @endif
                    </td>
                    <td>{{ $orderInfo->room_name }}</td>
                    <td>{{ $orderInfo->num_of_rooms }}</td>
                    <td>{{ $orderInfo->num_of_people }}</td>
                    <td>
                        <p>入住 : {{$orderInfo->check_in_date}}</p>
                        <p>离开 : {{$orderInfo->check_out_date}}</p>
                    </td>
                    <td>
                         @if($orderInfo->pay_status == 1)
                         @if($orderInfo->payment_type == 0)      银联
                        @elseif($orderInfo->payment_type == 1)   支付宝
                        @elseif($orderInfo->payment_type == 2)   微信
                        @endif
                        @else
                            无
                        @endif
                    </td>
                    <td><a href="{{url('/admin/manageOrders/detailorderinfo')}}/{{$orderInfo->order_sn}}">查看</a></td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

@stop

@section('script')

    <script>

        function orderDate(){

            if($("#orderTimeType").val() == 0){
                $(".date-choice-list").removeClass('ordered-time').addClass('ordered-time');
            }

            if($("#orderTimeType").val() == 1){
                $(".date-choice-list").addClass('ordered-time').removeClass('ordered-time');
            }

            if($("#orderTimeType").val() == 2){
                $(".date-choice-list").addClass('ordered-time').removeClass('ordered-time');
            }

        }
        $(function(){


            $("#searchSubmit").click(function(){

//                $(".get-hotel-id").val($(".get-id").attr('id'));

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/manageOrders/ordersearchforhotel',
                    data:$("#orderSearchForm").serialize(),
                    dataType: 'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){

                        if(data.statusCode == 1){
                            if($('.search-results-content').children()){
                                $('.search-results-content').children().remove();
                            }
                                var options = "";
                                for(var i=0; i < data.extra.length; i++){

                                    var payStatus = '';
                                    var payment_type = '';
                                    if(data.extra[i].pay_status == 0){
                                        payStatus    = '未支付';
                                        payment_type = '无';
                                    }else if(data.extra[i].pay_status == 1){
                                        payStatus = '已支付';
                                        if(data.extra[i].payment_type == 0){
                                            payment_type = '银联';
                                        }else if(data.extra[i].payment_type == 1){
                                            payment_type = '支付宝';
                                        }else{
                                            payment_type = '微信';
                                        }

                                    }


                                    options += '<tr class="search-results-style">'
                                            +'<td id="'+data.extra[i].hotel_id+'" class="get-id"></td>'
                                            + '<td>'+data.extra[i].order_sn+'</td>'
                                            +'<td>'+payStatus+'</td>'
                                            +'<td>'+data.extra[i].room_name+'</td>'
                                            +'<td>'+data.extra[i].num_of_rooms+'</td>'
                                            +'<td>'+data.extra[i].num_of_people+'</td>'
                                            +'<td><p>入住 : '+data.extra[i].check_in_date+'</p><p>离开 : '+data.extra[i].check_out_date+'</p></td>'
                                            +'<td>'+ payment_type+'</td>'
                                            +'<td>'+'<a href="/admin/manageOrders/detailorderinfo/'+data.extra[i].order_sn+'">查看</a>'+'</td>'
                                            +'</tr>';

                                }


                                $('.search-results-content').append(options);

                        }else if(data.statusCode == 2){
                            $('.search-results-content').children().remove();
                        }

                    }
                });

            });

        });
    </script>

@endsection