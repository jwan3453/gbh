
@extends('Admin.site')

@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>
@stop

@section('content')

    <div class="light-bg">
        <div>
            <table class="ui primary striped selectable table room-price-request-list " >
                <thead>
                <tr>
                    <th>房型</th>
                    <th>付款方式</th>
                    <th>变价时间</th>
                    <th>早餐</th>
                    <th>适用星期</th>
                    <th>卖价</th>
                    <th>佣金</th>
                    <th>状态</th>
                    <th>审核评论</th>
                    <th>申请日期</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach($requestList as $request)
                    <tr>
                        <td>
                            @foreach($roomTypeList as $room)
                                @if($request->room_id == $room->id)
                                    {{$room->room_name}}
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @if($request->pay_type ==1)
                                现付
                            @elseif($request->pay_type ==2)
                                预付

                            @endif

                        </td>
                        <td>{{$request->request_date_from}} ~ {{$request->request_date_to}}</td>
                        <td>{{$request->breakfast}}份</td>
                        <td>
                            @if($request->is_all_week == 1)
                                整周
                            @else
                                @foreach(explode('|',$request->selected_week_day) as $weekday)
                                    @if($weekday ==1)
                                        一
                                    @endif
                                    @if($weekday ==2)
                                        二
                                    @endif
                                    @if($weekday ==3)
                                        三
                                    @endif
                                    @if($weekday ==4)
                                        四
                                    @endif
                                    @if($weekday ==5)
                                        五
                                    @endif
                                    @if($weekday ==6)
                                        六
                                    @endif
                                    @if($weekday ==7)
                                        日
                                    @endif

                                @endforeach
                            @endif
                        </td>
                        <td>平时:{{$request->week_day_rate}},周末:{{$request->weekend_rate}}</td>
                        <td>平时:{{$request->week_day_comm}},周末:{{$request->weekend_comm}}</td>
                        <td>
                            @if($request->status ==0)
                                审核中
                            @elseif($request->status ==1)
                                通过
                            @else
                                拒绝
                            @endif
                        </td>
                        <td>{{$request->comment}}</td>
                        <td>{{$request->request_date}}</td>
                        <td>
                            @if($request->status ==0)
                                <span class="process-request" data-request-id="{{$request->id}}" >处理</span>
                            @else
                                <span class="process-request disabled" data-request-id="{{$request->id}}" >已处理</span>
                            @endif

                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </div>


    <div class="ui page dimmer confirm-request">


            <h3>是否处理该条房价申请单</h3>
            <div class="confirm-btns">
                <div class="regular-btn blue-btn confirm">
                    确定
                    <div class="ui active inline  small  loader" id="loader"></div>
                </div>
                <div class="regular-btn red-btn cancel">取消</div>
            </div>


    </div>




@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            //点击处理申请单
            var requestId = '';
            var requestText =null;
            $('.process-request').click(function(){
                if($(this).hasClass('disabled'))
                {
                    return;
                }

                requestText = $(this);
                requestId = $(this).attr('data-request-id');
                $('.dimmer')
                        .dimmer({
                            onShow:function(){

                                $('#teamMemberDimmer').transition('fly right');
                                $('#memberDesc').transition('fly left');
                            },
                            opacity:0.9,
                            closable:true
                        }).dimmer('show');

            })

            $('.confirm').click(function(){


                $.ajax({
                    type: 'POST',
                    url: '/admin/manageRoomPrice/confirmRoomPriceRequest',
                    data: {requestId :requestId},
                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){
                        $('#loader').transition('scale');
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            $('#loader').transition('scale');
                            $('.dimmer').dimmer('hide');
                            toastAlert('处理完成');
                            requestText.text('已处理').addClass('disabled');
                        }
                    }
                })
            })

            $('.cancel').click(function(){
                $('.dimmer').dimmer('hide');
            })
        })
    </script>
@stop