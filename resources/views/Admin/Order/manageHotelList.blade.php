@extends('Admin.site')

@section('resources')

@stop


@section('content')
    @include('admin.partial.breadcrumbTrail')
    <div class="h-content order-list-box">

        <div class="all-search-order">
            <a href="{{ url('/admin/manageOrders/hotelordersearch/allOrders') }}">订单查询</a>
        </div>

        <table class="hotel-table ui table primary striped selectable " id="orderTable" style="margin:0 auto;">

            <thead>
            <tr>
                <th>酒店图片</th>
                <th>酒店名称</th>
                <th>酒店地址</th>
                <th>操作</th>
            </tr>
            </thead>

            <tbody>

            @foreach($manageIsAllHotel as $hotelItem)
                <tr>
                    <td class="m-td">
                        <img class="hotel-img" src = '{{$hotelItem->firstCoverImage->link}}'>
                    </td>
                    <td class="m-td">{{$hotelItem->name}}</td>
                    <td><i class="icon marker large"></i><span>{{$hotelItem->addressInfo}}</span></td>
                    <td class="order-actions">
                        {{--<p><a href="{{ url('/admin/manageOrders/hotelordersearch') }}/{{$hotelItem->id}}">订单查询</a></p>--}}
                        <p><a href="{{ url('/admin/manageOrders/unprocessedorders') }}/{{$hotelItem->id}}">未处理订单</a></p>
                        <p><a href="{{ url('/admin/manageOrders/todayorders') }}/{{$hotelItem->id}}">今日订单</a></p>
                        <p><a href="{{ url('/admin/manageOrders/allorders') }}/{{$hotelItem->id }}">所有订单</a></p>
                    </td>
                </tr>

            @endforeach

            </tbody>
        </table>

    </div>


@stop