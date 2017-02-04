@extends('Admin.site')

@section('resources')

    <script src={{ asset('js/datepicker/laydate.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>

@endsection

@section('content')

    @include('admin.partial.breadcrumbTrail')

    <div class="light-bg">

        <form class="room-status-batch-edit" id="roomStatusBatchForm" method="post" action="{{url('/admin/manageRoomPrice/roomBatchSubmit')}}">

            <input type="hidden"  name='hotelId' value = '{{$hotelId}}'>
            <div class="type">
                <label>房型选择</label>

                <div class="room-type" id="roomTypeSelect">
                    <span>选择房型</span>
                    <input type="hidden" value="" id="selectedRoomType" name="selectedRoomType">
                </div>

                <div class="dropdown-room-type" id="roomTypeSelectionMenu">
                    @foreach($roomTypeList as $room)

                        <label><input type="checkbox"  class="room-type-check" value="{{$room->id}}" name="{{$room->id.'_roomType'}}" />{{$room->room_name}}</label>
                    @endforeach
                </div>


                <select class="paid-type" name="payType">
                    <option value="0">现付&预付</option>
                    <option value="1">现付</option>
                    <option value="2">预付</option>
                </select>

            </div>

            <div class="date-range">

                <label>时间范围</label>

                <input id="dateRangeFrom" name='dateRangeFrom' type="text" placeholder="开始时间" />


                <input id="dateRangeTo" name="dateRangeTo"  type="text"  placeholder="结束时间" />
                <div id="dd"></div>

            </div>

            <div class="room-status">

                <label>房间状态</label>
                <select class="paid-type" name="roomStatus">
                    <option value="0">房间关闭</option>
                    <option value="1">可预订</option>
                    <option value="2">满房</option>
                </select>
            </div>

            <div class="room-num">
                <label>数量</label>
                <input class="num_only" id="numOfBlockedRoom" name='numOfBlockedRoom' type="text" placeholder="房间数量"/>
                <span>间</span>
            </div>

            <div class="regular-btn red-btn " id="submit">提交申请单</div>
        </form>

        <div>
            <table class="ui primary striped selectable table room-status-request-list " >


                <thead>
                <tr>
                    <th>房型</th>
                    <th>付款方式</th>
                    <th>房态更新时间</th>
                    <th>房间状态</th>
                    <th>保留房数量</th>
                    <th>是否担保</th>
                    <th>提交日期</th>

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
                            @elseif($request->paid_type ==2)
                                预付
                            @else
                                现付&预付
                            @endif
                        </td>
                        <td>{{$request->date_from}} ~ {{$request->date_to}}</td>
                        <td>
                            @if($request->room_status ==1)
                                有房
                            @elseif($request->paid_type ==2)
                                满房
                            @else
                                房价关闭
                            @endif

                        </td>

                        <td>{{$request->num_of_blocked_room}}间</td>

                        <td>
                            @if($request->is_guarantee ==1)
                                是
                            @else
                                否
                            @endif
                        </td>

                        <td>
                           {{$request->request_date}}
                        </td>


                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>

    <div class="room-status-batch-loader ui active inline  massive   loader" id="loader"></div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){

            laydate({
                elem: '#dateRangeFrom'
            })

            laydate({
                elem: '#dateRangeTo'
            })

            //选择房型
            $('#roomTypeSelect').click(function(){
                $('#roomTypeSelectionMenu').transition('drop');

            });
        });

        //获取选择的房型列表 用空格隔开
        $('.room-type-check').click(function(){
            var selectedRoomType = '';
            $('#roomTypeSelectionMenu').find('input[type=checkbox]').each(function(){
                if($(this).prop('checked') === true)
                {
                    selectedRoomType +=  $(this).attr('value')+ ' ';
                }

            })
            $('#selectedRoomType').val(selectedRoomType);
        })


        //只能输入数字和小数点
        $.fn.onlyNum = function(e){
            $(this).keypress(function(event){
                var eventObj = event || e;
                var keyCode = eventObj.keyCode || eventObj.which;
                if (keyCode == 46 || (keyCode >= 48 && keyCode <=57))
                {
                    return true;
                }
                else
                    return false;

            }).focus(function(){
                this.style.imeMode='disabled';
            }).bind('past',function(){
                var clipboard = window.clipboardData.getData("Text");
                if (/^(\d)+$/.test(clipboard))
                    return true;
                else
                    return fasle;
            }).css("ime-mode", "disabled");

        }

        $('.num_only').onlyNum();

        $('#submit').click(function(){

            //检查输入
            var check = true;

            if($('#selectedRoomType').val() ==='')
            {
                toastAlert('最少选择一个房型');
                return;
            }

            if( $('#dateRangeFrom').val() === '' ||  $('#dateRangeTo').val()==='')
            {

                toastAlert('请选择时间范围');
                return;
            }
            if($('#numOfBlockedRoom').val() ==='')
            {
                toastAlert('房间数量不能为空');
                return;
            }



            if(check === true)
            {
                //提交房态更改
                var options = {
                    url: '/admin/manageRoomStatus/roomStatusBatchRequestSubmit',
                    type: 'post',
                    dataType: 'json',
                    data: $("#roomStatusBatchForm").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){
                        $('#loader').transition('scale');
                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            $('#loader').transition('scale');
                            toastAlert(data.statusMsg,1);
                            setTimeout(function () {
                                location.reload();
                            }, 2000);


                        }
                    },
                    error:function(data){

                    }
                };
                $.ajax(options);
            }

        })




    </script>
@stop