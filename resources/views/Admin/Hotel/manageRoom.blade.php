@extends('Admin.Hotel.maintainHotelInfo')

@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>
@stop



@section('infoContent')
    <div class="info-content">

        <div class="regular-btn blue-btn  " id="newRoomBtn"><i class="icon plus "></i>添加新房型</div>
        <form class="detail-form room-detail-from" id="newRoomForm" action='{{url("/admin/manageHotel/createNewRoomType")}}' method="Post">

            <div class="header">添加新房型</div>
            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
            <input type="hidden" name="hotelId" value="{{$hotelId}}">
            <div style="overflow:hidden">
                <div class="short-input-box ">
                    <label>房型名称</label>
                    <input type="text" id="roomName" name="roomName" data-input="房型名称" class="require">

                </div>

                <div class="short-input-box ">
                    <label>房型名称(英文)</label>
                    <input type="text" id="roomNameEn" name="roomNameEn"  data-input="房型名称(英文)" class="require">

                </div>

                <div class="short-input-box ">
                    <label>门市价格</label>
                    <input type="text" id="rackRate" name="rackRate" data-input="房型名称" class="require">
                </div>

                <div class="short-input-box ">
                    <label>入住人数</label>
                    <input type="text" id="numOfPeople" name="numOfPeople" data-input="入住人数" class="require">
                    <span class="unit">位</span>
                </div>

                <div class="short-input-box ">
                    <label>儿童人数</label>
                    <input type="text" id="numOfChildren" name="numOfChildren" data-input="儿童人数" class="require">
                    <span class="unit">位</span>
                </div>

                <div class="short-input-box ">
                    <label>房间数</label>
                    <input type="text" id="numOfRooms" name="numOfRooms"  data-input="房间数" class="require">
                    <span class="unit">间</span>
                </div>

                <div class="short-input-box ">
                    <label>楼层</label>
                    <input type="text" id="floor" name="floor" data-input="楼层" class="require">
                    <span class="unit">层</span>
                </div>
                <div class="short-input-box ">
                    <label>面积</label>
                    <input type="text" id="acreage" name="acreage" data-input="面积" class="require">
                    <span class="unit">平方</span>
                </div>

                <div class="long-input-box ">
                    <label>房型描述</label>
                    <textarea  id="description" name="description" data-input="房型描述" class="require"></textarea>
                </div>


                <div class="long-input-box ">
                    <label>房型描述(英文)</label>
                    <textarea  id="descriptionEn" name="descriptionEn" data-input="房型描述(英文)" class="require"></textarea>
                </div>



            </div>
            <div class="bed-type" >
                <label class="header-label">床型</label>
                <div class="bed-type-list" id="bedTypeList" >
                    <div class="bed-item b-i">
                        <input type="checkbox"   class="select-bed-type" name="doubleBed"  id="doubleBed" />
                        <label>双床</label>

                        <select class="  bedCate" name="doubleBedType">
                            @foreach($bedTypes as $bedType)
                                <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                            @endforeach
                        </select>


                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text" name="numOfDoubleBed" id="numOfDoubleBed"  data-input="双床数量" class="disabled-input" disabled='disabled'>
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfDoubleBed" id="lengthOfDoubleBed" data-input="双床床长" class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfDoubleBed" id="widthOfDoubleBed" data-input="双床床宽" class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>

                    </div>
                    <div class="bed-item b-i" >
                        <input type="checkbox" class="select-bed-type" name="singleBed" id="singleBed"/>
                        <label>单床</label>

                        <select class="  bedCate" name="singleBedType">
                            @foreach($bedTypes as $bedType)
                                <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                            @endforeach
                        </select>


                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text"  name="numOfSingleBed" id="numOfSingleBed"  data-input="单床数量" class="disabled-input" disabled='disabled'>
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfSingleBed" id="lengthOfSingleBed" data-input="单床床长" class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfSingleBed" id="widthOfSingleBed" data-input="单床床宽" class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>

                    </div>
                    <div class="bed-item b-i">
                        <input type="checkbox" class="select-bed-type" name="largeBed" id="largeBed"/>
                        <label>大床</label>

                        <select class="  bedCate" name="largeBedType">
                            @foreach($bedTypes as $bedType)
                                <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                            @endforeach
                        </select>

                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text" name="numOfLargeBed" id="numOfLargeBed" data-input="大床数量"  class="disabled-input" disabled='disabled'>
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfLargeBed" id="lengthOfLargeBed" data-input="大床床长"  class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfLargeBed" id="widthOfLargeBed" data-input="大床床宽"  class="disabled-input" disabled='disabled'>
                            <span class="unit">米</span>
                        </div>
                    </div>

                    <div id="multiBed" class="b-i">


                        <div class="bed-item ">
                            <input type="checkbox" class="select-bed-type" name="multiBed" id="multiBed"  />
                            <label>多床</label>

                            <select class="  bedCate" name="multiBedType[]">
                                @foreach($bedTypes as $bedType)
                                    <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                @endforeach
                            </select>



                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text" name="numOfMultiBed[]"  data-input="多床数量" class="disabled-input" disabled='disabled' >
                                <span class="unit">张</span>
                            </div>


                            <div class="small-input-box ">
                                <label>床长:</label>
                                <input type="text" name="lengthOfMultiBed[]" data-input="多床床长" class="disabled-input" disabled='disabled' >
                                <span class="unit">米</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widthOfMultiBed[]" data-input="多床床宽" class="disabled-input" disabled='disabled' >
                                <span class="unit">米</span>
                            </div>

                            <span class="add-new-bed" id="addNewBed">添加</span>
                        </div>
                    </div>
                </div>
            </div>

                <div style="overflow:auto;display: block">
                <div class="long-input-box">
                    <label>能否加床</label>
                    <div class="radio-selection">
                        <div class="radio-group">
                            <input type="radio" name="extraBed" value="1" checked /> 不可加床

                            <input type="radio" name="extraBed" value="2" /> 免费加床

                            <input type="radio" name="extraBed" value="3" /> 收费加床
                        </div>
                    </div>
                </div>


                <div class="long-input-box">
                    <label>wifi</label>
                    <div class="radio-selection">
                        <div class="radio-group">
                            <input type="radio" name="wifi" value="1" checked/> 无

                            <input type="radio" name="wifi" value="2" /> 免费

                            <input type="radio" name="wifi" value="3" /> 收费
                        </div>

                    </div>
                </div>


                <div class="long-input-box">
                    <label>无烟信息</label>
                    <div class="radio-selection">
                        <div class="radio-group">
                            <input type="radio" name="smoke" value="1" checked /> 不可吸烟

                            <input type="radio" name="smoke" value="2" /> 可以吸烟
                        </div>
                    </div>
                </div>



                {{--<div class="long-input-box">--}}
                    {{--<label>是否有窗</label>--}}
                    {{--<div class="radio-selection">--}}
                        {{--<div class="radio-group">--}}
                            {{--<input type="radio" name="sex" value="male" /> 有窗--}}

                            {{--<input type="radio" name="sex" value="female" /> 无窗--}}
                        {{--</div>--}}
                    {{--</div>--}}
                {{--</div>--}}
            </div>
            <div class="auto-margin regular-btn blue-btn" id="saveRoom">保存房型</div>
        </form>
        <table class="ui primary striped selectable table room-table " id="roomTalbe">


            <tbody>

                @foreach($roomList as $room)
                    <tr>

                        <td class="m-td">{{$room->room_name}}</td>
                        <td class="m-td">门市价:{{$room->rack_rate}}</td>
                        <td class="m-td">入住人数:{{$room->num_of_people}}</td>
                        <td class="m-td">平方数:{{$room->acreage}} 平方米</td>

                        <td class="l-td">



                            <div class="header-option f-left delete-room " id="{{$room->id}}" >

                                <img src = '/Admin/img/垃圾桶.png'/>
                                <span>删除</span>
                            </div>

                            <div class="header-option f-left">

                                <img src = '/Admin/img/编辑.png'/>
                                <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'/editRoom/'.$room->id)}}"><span>编辑</span></a>
                            </div>

                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>


        <div class="ui page dimmer confirm-request">

            <div id="confirmDeleteBox">
                <h3>是否删该房型</h3>
                <div class="confirm-btns">
                    <div class="regular-btn blue-btn " id="confirmDelete">
                        确定
                        <div class="ui active inline  small  loader" id="loader"></div>
                    </div>
                    <div class="regular-btn red-btn" id="cancelDelete">取消</div>
                </div>

            </div>
        </div>

    </div>
@stop


@section('infoScript')
    <script type="text/javascript">
        $(document).ready(function(){


            $('#newRoomBtn').click(function(){
                $('#newRoomForm').transition('scale');
            })

            var multiBedCount=0;

            //选择多床型，动态添加
            $('#addNewBed').click(function(){
                if(multiBedCount < 2 && $(this).siblings('input[type=checkbox]').is(':checked'))
                {

                    multiBedCount++;
                    var html = '<div class="bed-item">' + '\n'+

                            '<div style="width:60px; display:inline-block"></div>' + '\n'+

                            '<select class="  bedCate" name="multiBedType[]">'+'\n'+
                            '<option value="">选择床型</option>'+'\n'+
                            @foreach($bedTypes as $bedType)
                                '<option value="{{$bedType->id}}">{{$bedType->name}}</option>'+'\n'+
                            @endforeach
                         '</select>'+'\n'+

                            '<div class="small-input-box ">'+'\n'+
                            '<label>数量:</label>'+'\n'+
                            '<input type="text" name="numOfMultiBed[]" data-input="多床数量"  >'+'\n'+
                            '<span class="unit">张</span>'+'\n'+
                            '</div>'+'\n'+

                            '<div class="small-input-box ">'+'\n'+
                            '<label>床长:</label>'+'\n'+
                            '<input type="text"  name="lengthOfMultiBed[]"  data-input="多床床长"  >'+'\n'+
                            '<span class="unit">米</span>'+'\n'+
                            '</div>'+'\n'+


                            '<div class="small-input-box ">'+'\n'+
                            '<label>床宽:</label>'+'\n'+
                            '<input type="text"  name="widthOfMultiBed[]"  data-input="多床床宽"  >'+'\n'+
                            '<span class="unit">米</span>'+'\n'+
                            '</div>'+'\n'+
                            '<span class="delete-new-bed" >删除</span>'+'\n'+
                            '</div>';
                    $('#multiBed').append(html);
                }

            })

            $(document).on('click','.delete-new-bed',function(){
                $(this).parent().remove();

                if(multiBedCount!== 0 )
                    multiBedCount--;
            })

            //选择床型 checkbox
            $('.select-bed-type').change(function(){

                if(!$(this).is(':checked'))
                {
                    $(this).parents('.b-i').find('input[type=text]').addClass('disabled-input ').removeClass('require').attr('disabled',true);
                }
                else{

                    $(this).parents('.b-i').find('input[type=text]').removeClass('disabled-input ').addClass('require').attr('disabled',false);
                }
            })

            // ajax 上传新的房型
            $('#saveRoom').click(function(){

                var checkForm = true;

                checkForm = alertBox(checkForm);

                if(checkForm)
                {
                    $.ajax({
                        type: 'POST',
                        url: '/admin/manageHotel/createNewRoom',
                        data: $("#newRoomForm").serialize(),
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            if(data.statusCode === 1)
                            {
                                //动态删除项目
                                toastAlert(data.statusMsg,1);
                                location.reload();
                            }
                            else{
                                toastAlert(data.statusMsg,2);
                            }
                        }
                    })
                }

            })

            //删除房型
            var deleteRoom = ''
            var deleteRoomRow;
            $('.delete-room').click(function(){
                deleteRoom = $(this).attr('id');
                deleteRoomRow = $(this);
                $('.dimmer').dimmer('show');
            })

            $('#confirmDelete').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/admin/manageHotel/deleteRoom',
                    data: {roomId :deleteRoom},
                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            deleteRoomRow.parents('tr').remove();
                            toastAlert(data.statusMsg,1);

                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                        $('.confirm-request').dimmer('hide');
                    }
                })
            })


        })
    </script>
@stop