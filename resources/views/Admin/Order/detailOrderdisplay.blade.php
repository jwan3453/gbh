@extends('Admin.site')

@section('resources')

@stop


@section('content')

    @include('Admin.partial.breadcrumbTrail')

    <div class="h-content detail-order-info">
        <div class="order-sn">
            <span>订单号:{{$getDetailInfo->order_sn}}</span>
            <span>下单时间:{{$getDetailInfo->created_at}}</span>
        </div>
        <hr/>
        <div class="order-status-box">
            <ul>
                <li class="order-arrow-status order-status-submit current-status">订单提交<span class="small-arrow current-arrow-status"></span></li>
                <li class="order-arrow-status order-status-payment current-status">付款成功<span class="left-small-arrow current-left-arrow-status"></span><span class="small-arrow current-arrow-status"></span></li>
                <li class="order-arrow-status order-status-confirm">订单确认<span class="left-small-arrow"></span><span class="small-arrow"></span></li>
                <li class="order-arrow-status order-status-checkIn">入住<span class="left-small-arrow"></span><span class="small-arrow"></span></li>
            </ul>
        </div>
        <div class="hotel-detail-info">
            <ul>
                <li class="hotel-detail-left">酒店详情</li>
                <li class="hotel-detail-middle">
                    @if(isset($getDetailInfo->roomDetail->imageLink->link))
                        <img class="hotel-image-info" src="{{$getDetailInfo->roomDetail->imageLink->link}}"/>
                    @else
                        <img class="hotel-image-info" src="/Admin/img/default-image-gbh.jpg"/>
                    @endif
                </li>
                <li class="detail-address-info">
                    <span class="hotel-name-info">{{$getDetailInfo->hotelDetail->name}}</span>
                    <span>{{$getDetailInfo->roomDetail->room_name}}</span>
                        <span>
                            <i class="icon marker large"></i>{{$getDetailInfo->hotelDetail->province}}{{$getDetailInfo->hotelDetail->city}}{{$getDetailInfo->hotelDetail->district=''?$getDetailInfo->hotelDetail->district->district_name:'' }}{{$getDetailInfo->hotelDetail->address->detail}}
                        </span>
                </li>
            </ul>

        </div>
        <hr/>
        <div class="check-in-info">
            <ul>
                <li class="hotel-detail-left">入住详情</li>
                <li class="hotel-detail-middle check-time-middle">
                    房间数量: {{$getDetailInfo->num_of_room}}
                </li>
                <li class="detail-address-info check-time-right">
                    <span>入住时间 : {{$getDetailInfo->check_in_date}}</span>
                    <span>退房时间 : {{$getDetailInfo->check_out_date}}</span>
                    <span>入住天数 : {{$getDetailInfo->dateDiff}}</span>
                </li>
            </ul>
        </div>
        <hr/>
        <div class="check-in-info">
            <ul>
                <li class="hotel-detail-left">入客详情</li>
                <li class="hotel-detail-middle check-time-middle">
                    入住客人: {{$getDetailInfo->guest_list}}
                </li>
                <li class="person-detail">
                    <span>联系方式 : {{$getDetailInfo->contact_phone}}</span>
                </li>
            </ul>
        </div>
        <hr/>
        <div class="check-in-info">
            <ul>
                <li class="hotel-detail-left">订单金额</li>
                <li class="hotel-detail-middle check-time-middle">
                    房间均价 : {{$getDetailInfo->average_price}}
                </li>
                <li class="person-detail">
                    <span>房间总价 : {{$getDetailInfo->total_amount}}</span>
                </li>
            </ul>
        </div>
        <hr/>
        <div class="check-in-info">
            <ul>
                <li class="hotel-detail-left">支付详情</li>
                @if($getDetailInfo->pay_status == 0)
                <li class="hotel-detail-middle check-time-middle">
                    未支付
                </li>
                <li class="person-detail">
                    <span>支付方式 : 无</span>
                </li>
                @elseif($getDetailInfo->pay_status == 1)
                    <li class="hotel-detail-middle check-time-middle">
                        已支付
                    </li>
                    <li class="person-detail">
                        <span>支付方式 :
                            @if($getDetailInfo->payment_type == 0)       银联
                            @elseif($getDetailInfo->payment_type == 1)   支付宝
                            @elseif($getDetailInfo->payment_type == 2)   微信
                            @endif
                        </span>
                    </li>
                @endif
            </ul>
        </div>

    </div>

@endsection