@extends('Admin.site')

@section('resources')

@stop


@section('content')

    @include('Admin.partial.breadcrumbTrail')

    <div class="detail-count-orders">
        未处理订单数 : <span>{{$countOrders}}</span>
    </div>

    <div class="h-content unprocessed-orders">

        <table class="ui table group" style="margin-top: -10px;">
            <thead>
            <tr>
                <th>订单号</th>
                <th>状态</th>
                <th>房型</th>
                <th>房间数</th>
                <th>预定人</th>
                <th>入住人数</th>
                <th>入离日期</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>

            @foreach($unprocessedOrders as $orderInfo)

                <tr class="order-search-info">
                    <td id="{{ $orderInfo->id }}" class="get-id"></td>
                    <td>{{ $orderInfo->order_sn }}</td>
                    <td>
                        未处理
                    </td>
                    <td>{{ $orderInfo->room_name }}</td>
                    <td>{{ $orderInfo->num_of_rooms }}</td>
                    <td>{{ $orderInfo->guest_list }}</td>
                    <td>{{ $orderInfo->num_of_people }}</td>
                    <td>
                        <p>{{$orderInfo->check_in_date}}</p>
                        <p>{{$orderInfo->check_out_date}}</p>
                    </td>
                    <td><a href="{{url('/admin/manageOrders/detailorderinfo')}}/{{$orderInfo->order_sn}}">查看</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>

@endsection