@extends('Admin.site')

@section('resources')

    <script src={{ asset('js/datepicker/laydate.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

@endsection

@section('content')

    <div class="light-bg">

        <form class="room-price-batch-edit" id="roomPriceBatchForm" method="post" action="{{url('/admin/manageRoomPrice/roomPriceBatchSubmit')}}">

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

            <div class="breakfast">
                <label>早餐</label>
                <select class="paid-type" name="breakfast">
                    <option value="0">不变</option>
                    <option value="1">1份</option>
                    <option value="2">2份</option>
                </select>
            </div>

            <div class="valid-week-day">
                <label>有效星期</label>
                <label><input type="checkbox"  id="weekAll" name="weekAll" />全选</label>
                <div id="allWeekDays" style="display: inline-block">
                    <label><input type="checkbox"  name="mon" />周一</label>
                    <label><input type="checkbox"  name="tue" />周二</label>
                    <label><input type="checkbox"  name="wed" />周三</label>
                    <label><input type="checkbox"  name="thr" />周四</label>
                    <label><input type="checkbox"  name="fri" />周五</label>
                    <label><input type="checkbox"  name="sat" />周六</label>
                    <label><input type="checkbox"  name="sun" />周日</label>
                </div>
            </div>

            <div class="valid-week-day">
                <label>区分周末</label>
                <label><input type="checkbox" id="weekendOn" name="weekendOn" />是</label>

            </div>


            @foreach($roomTypeList as $room)

                <div class="room-price" id="{{$room->id.'_price'}}">
                    <label >{{$room->room_name}}</label>

                    <div class="price-input">
                        <div class="weekday" >

                            <span class="label-text">平时:</span>
                            <span>底价 </span>
                            <input  type="text" class="num_only" name={{$room->id.'_weekdayRate'}} />

                            <span>佣金</span>
                            <input  type="text" class="num_only"  name={{$room->id.'_weekdayComm'}} />
                        </div>

                        <div class="weekend">

                            <span class="label-text">周末:</span>
                            <span>底价</span>
                            <input  type="text" class="num_only"  name={{$room->id.'_weekendRate'}} />

                            <span>佣金 </span>
                            <input  type="text" class="num_only"  name={{$room->id.'_weekendComm'}}  />
                        </div>
                    </div>
                </div>
            @endforeach




            <div class="regular-btn red-btn " id="submit">提交申请单</div>
        </form>

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
                            @if($request->paid_type ==1)
                                现付
                            @elseif($request->paid_type ==2)
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
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

    </div>
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

            $('.room-type-check').click(function(){
                var selectedRoomType = '';
                $('#roomTypeSelectionMenu').find('input[type=checkbox]').each(function(){
                    if($(this).prop('checked') === true)
                    {
                        selectedRoomType +=  $(this).attr('value')+ ' ';
                    }

                })
                $('#selectedRoomType').val(selectedRoomType);
                $('#'+$(this).attr('value')+'_price').transition('scale');
            })


            //选择整个周
            $('#weekAll').click(function(){

                if($(this).prop('checked')  === true)
                {

                    $('#allWeekDays').find("input[type=checkbox]").prop("checked",true);
                }
                else {
                    $('#allWeekDays').find("input[type=checkbox]").prop("checked",false);
                }
            })

            $('#weekendOn').click(function(){
                if($(this).prop('checked')  === true)
                {
                    $('.weekend').show();
                }
                else{
                    $('.weekend').hide();

                }
            })
        });

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
            if( $('#dateRangeFrom').val() === '' ||  $('#dateRangeTo').val()==='')
            {

                toastAlert('请选择时间范围');
                return;
            }
            //todo
            if($('.num_only').val()===''  )
            {

                toastAlert('房价和佣金不能为空');
                return;
            }

            if($('#weekendOn').prop('checked') === true)
            {

                if($('#weekendRate').val() === '' ||  $('#weekendComm').val() ==='' )
                {

                    toastAlert('周末房价和佣金不能为空');
                    return;
                }
            }


            if(check === true)
            {
                //提交批量修改房价申请单
                var options = {
                    url: '/admin/manageRoomPrice/roomPriceBatchRequestSubmit',
                    type: 'post',
                    dataType: 'json',
                    data: $("#roomPriceBatchForm").serialize(),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
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