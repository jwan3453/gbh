

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
                    <th>房间状态</th>
                    <th>保留上数量</th>
                    <th>是否担保</th>
                    <th>申请日期</th>
                </tr>
                </thead>
                <tbody>
                @foreach($logList as $log)
                    <tr>
                        <td>
                            @foreach($roomTypeList as $room)
                                @if($log->room_id == $room->id)
                                    {{$room->room_name}}
                                @endif
                            @endforeach
                        </td>

                        <td>
                            @if($log->pay_type ==1)
                                现付
                            @elseif($log->pay_type ==2)
                                预付
                            @else
                                现付&预付
                            @endif
                        </td>
                        <td>{{$log->date_from}} ~ {{$log->date_to}}</td>

                        <td>
                            @if($log->room_status ==0)
                                房间关闭
                            @elseif($log->room_status ==1)
                                可预定
                            @elseif($log->room_status ==2)
                                满房
                            @endif
                        </td>
                        <td>{{$log->num_of_blocked_room}}间</td>
                        <td>
                            @if($log->is_guarantee ==1)
                                是
                            @elseif($log->is_guarantee ==2)
                                否

                            @endif
                        </td>

                        <td>{{$log->request_date}}</td>

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