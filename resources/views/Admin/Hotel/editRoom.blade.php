@extends('Admin.Hotel.maintainHotelInfo')


@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>
    <script src={{ asset('js/jquery.form.js') }}></script>
@stop



@section('infoContent')



    <form class="detail-form room-detail-from-visible" id="updateRoomForm" action='{{url("/admin/manageHotel/updateRoom")}}' method="Post">

        <div class="header">房型维护</div>
        <input type="hidden" value="{{csrf_token()}}" name="_token"/>
        <input type="hidden" name="hotelId" value="{{$hotelId}}">
        <input type="hidden" name="roomId" value="{{$roomId}}"/>
        <div style="overflow:hidden">
            <div class="short-input-box ">
                <label>房型名称</label>
                <input type="text" id="roomName" name="roomName" value="{{$room->room_name}}" data-input="房型名称" class="require">

            </div>

            <div class="short-input-box ">
                <label>房型名称(英文)</label>
                <input type="text" id="roomNameEn" name="roomNameEn" value="{{$room->room_name_en}}" data-input="房型名称(英文)" class="require">

            </div>


            <div class="short-input-box ">
                <label>门市价格</label>
                <input type="text" id="rackRate" name="rackRate" value="{{$room->rack_rate}}" data-input="房型名称" class="require">
            </div>

            <div class="short-input-box ">
                <label>入住人数</label>
                <input type="text" id="numOfPeople" name="numOfPeople" value="{{$room->num_of_people}}" data-input="入住人数" class="require">
                <span class="unit">位</span>
            </div>

            <div class="short-input-box ">
                <label>儿童人数</label>
                <input type="text" id="numOfChildren" name="numOfChildren" value="{{$room->num_of_children}}" data-input="儿童人数" class="require">
                <span class="unit">位</span>
            </div>

            <div class="short-input-box ">
                <label>房间数</label>
                <input type="text" id="numOfRooms" name="numOfRooms" value="{{$room->num_of_rooms}}" data-input="房间数" class="require">
                <span class="unit">间</span>
            </div>

            <div class="short-input-box ">
                <label>楼层</label>
                <input type="text" id="floor" name="floor" value="{{$room->floor}}" data-input="楼层" class="require">
                <span class="unit">层</span>
            </div>
            <div class="short-input-box ">
                <label>面积</label>
                <input type="text" id="acreage" name="acreage" value="{{$room->acreage}}" data-input="面积" class="require">
                <span class="unit">平方</span>
            </div>
        </div>
        <div class="bed-type" >
            <label class="header-label">床型</label>
            <div class="bed-type-list" id="bedTypeList" >



                    <div class="bed-item b-i">
                        <input type="checkbox"   class="select-bed-type" name="doubleBed"  id="doubleBed"  {{$room->doubleBed==null?'': 'checked'}} />
                        <label>双床</label>

                        <select class=" bedCate " name="doubleBedType"  >
                            <option value="">选择床型</option>
                            @foreach( $bedTypes as $bedType )
                              @if( !is_null($room->doubleBed)   && $room->doubleBed->bed_type_id == $bedType->id)
                                <option value="{{$bedType->id}}" selected>{{$bedType->name}}</option>
                                @else
                                    <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                              @endif
                            @endforeach
                        </select>



                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text"  name="numOfDoubleBed" id="numOfDoubleBed"  data-input="双床数量" {{$room->doubleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{$room->doubleBed==null?'': $room->doubleBed->num_of_beds}}" >
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfDoubleBed" id="lengthOfDoubleBed" data-input="双床床长" {{$room->doubleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{$room->doubleBed==null?'': $room->doubleBed->length}}">
                            <span class="unit">米</span>
                        </div>


                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfDoubleBed" id="widthOfDoubleBed" data-input="双床床宽" {{$room->doubleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{$room->doubleBed==null?'': $room->doubleBed->width}}">
                            <span class="unit">米</span>
                        </div>

                    </div>
                    <div class="bed-item b-i" >
                        <input type="checkbox" class="select-bed-type" name="singleBed" id="singleBed" {{$room->singleBed==null?'': 'checked'}}/>
                        <label>单床</label>

                        <select class=" bedCate" name="singleBedType">
                            <option value="">选择床型</option>
                            @foreach( $bedTypes as $bedType )
                                @if( !is_null($room->singleBed)   && $room->singleBed->bed_type_id == $bedType->id)
                                    <option value="{{$bedType->id}}" selected>{{$bedType->name}}</option>
                                @else
                                    <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                @endif
                            @endforeach
                        </select>



                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text"  name="numOfSingleBed" id="numOfSingleBed"  data-input="单床数量" {{$room->singleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->singleBed==null?'': $room->singleBed->num_of_beds}}">
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfSingleBed" id="lengthOfSingleBed" data-input="单床床长" {{$room->singleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->singleBed==null?'': $room->singleBed->length}}" >
                            <span class="unit">米</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfSingleBed" id="widthOfSingleBed" data-input="单床床宽" {{$room->singleBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->singleBed==null?'': $room->singleBed->width}}" >
                            <span class="unit">米</span>
                        </div>

                    </div>
                    <div class="bed-item b-i" >
                        <input type="checkbox" class="select-bed-type" name="largeBed" id="largeBed" {{$room->largeBed==null?'': 'checked'}}/>
                        <label>大床</label>

                        <select class=" bedCate" name="largeBedType">
                            <option value="">选择床型</option>
                            @foreach( $bedTypes as $bedType )
                                @if( !is_null($room->largeBed)   && $room->largeBed->bed_type_id == $bedType->id)
                                    <option value="{{$bedType->id}}" selected>{{$bedType->name}}</option>
                                @else
                                    <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                @endif
                            @endforeach
                        </select>

                        <div class="small-input-box ">
                            <label>数量:</label>
                            <input type="text" name="numOfLargeBed" id="numOfLargeBed"  data-input="大床数量" {{$room->largeBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->largeBed==null?'': $room->largeBed->num_of_beds}}">
                            <span class="unit">张</span>
                        </div>

                        <div class="small-input-box ">
                            <label>床长:</label>
                            <input type="text" name="lengthOfLargeBed" id="lengthOfLargeBed"  data-input="大床床长"  {{$room->largeBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->largeBed==null?'': $room->largeBed->length}}">
                            <span class="unit">米</span>
                        </div>


                        <div class="small-input-box ">
                            <label>床宽:</label>
                            <input type="text" name="widthOfLargeBed" id="widthOfLargeBed"  data-input="大床床宽"  {{$room->largeBed==null? 'class=disabled-input disabled=disabled': 'class=require'}}  value="{{$room->largeBed==null?'': $room->largeBed->width}}">
                            <span class="unit">米</span>
                        </div>
                    </div>

                    <div id="multiBed" class="b-i">


                        <div class="bed-item " >
                            <input type="checkbox" class="select-bed-type" name="multiBed" id="multiBed"  {{ count($room->multiBed)==0?'': 'checked'}}/>
                            <label>多床</label>


                            <select class="  bedCate" name="multiBedType[]">
                                <option value="">选择床型</option>
                                @foreach( $bedTypes as $bedType )
                                    @if( count($room->multiBed)!=0   && $room->multiBed[0]->bed_type_id == $bedType->id)
                                        <option value="{{$bedType->id}}" selected>{{$bedType->name}}</option>
                                    @else
                                        <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                    @endif
                                @endforeach

                            </select>


                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text" name="numOfMultiBed[]"  data-input="多床数量" {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}}  value=" {{count($room->multiBed)==0?'': $room->multiBed[0]->num_of_beds}}">
                                <span class="unit">张</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床长:</label>
                                <input type="text" name="lengthOfMultiBed[]" data-input="多床床长" {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{count($room->multiBed)==0?'': $room->multiBed[0]->length}}">
                                <span class="unit">米</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widthOfMultiBed[]" data-input="多床床宽" {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{count($room->multiBed)==0?'': $room->multiBed[0]->width}}">
                                <span class="unit">米</span>
                            </div>

                            <span class="add-new-bed" id="addNewBed">添加</span>
                        </div>

                        @for($i=1; $i<count($room->multiBed); $i++ )
                            <div class="bed-item " >


                                <div style="width:60px; display:inline-block"></div>

                                <select class="  bedCate" name="multiBedType[]">
                                    <option value="">选择床型</option>
                                    @foreach( $bedTypes as $bedType )
                                        @if( count($room->multiBed)!=0   && $room->multiBed[$i]->bed_type_id == $bedType->id)
                                            <option value="{{$bedType->id}}" selected>{{$bedType->name}}</option>
                                        @else
                                            <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                        @endif
                                    @endforeach

                                </select>


                                <div class="small-input-box " id="tet">
                                    <label>数量:</label>
                                    <input type="text" name="numOfMultiBed[]"  data-input="多床数量"  {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}} value=" {{$room->multiBed==null?'': $room->multiBed[$i]->num_of_beds}}">
                                    <span class="unit">张</span>
                                </div>

                                <div class="small-input-box ">
                                    <label>床长:</label>
                                    <input type="text" name="lengthOfMultiBed[]"  data-input="多床床长" {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{$room->multiBed==null?'': $room->multiBed[$i]->length}}">
                                    <span class="unit">米</span>
                                </div>

                                <div class="small-input-box ">
                                    <label>床宽:</label>
                                    <input type="text" name="widthOfMultiBed[]" data-input="多床床宽" {{count($room->multiBed)==0? 'class=disabled-input disabled=disabled': 'class=require'}} value="{{$room->multiBed==null?'': $room->multiBed[$i]->width}}">
                                    <span class="unit">米</span>
                                </div>

                                <span class="delete-new-bed" >删除</span>
                            </div>


                        @endfor


                    </div>








            </div>
        </div>

        <div style="overflow:auto;display: block">
            <div class="long-input-box">
                <label>能否加床</label>
                <div class="radio-selection">
                    <div class="radio-group" >
                        <input type="radio" name="extraBed" value="1" /> 不可加床

                        <input type="radio" name="extraBed" value="2" /> 免费加床

                        <input type="radio" name="extraBed" value="3" /> 收费加床
                    </div>
                </div>
            </div>


            <div class="long-input-box">
                <label>宽带</label>
                <div class="radio-selection">
                    <div class="radio-group">
                        <input type="radio" name="wifi" value="1" /> 无

                        <input type="radio" name="wifi" value="2" /> 免费

                        <input type="radio" name="wifi" value="3" /> 收费
                    </div>

                </div>
            </div>


            <div class="long-input-box">
                <label>无烟信息</label>
                <div class="radio-selection">
                    <div class="radio-group">
                        <input type="radio" name="smoke" value="1" /> 不可吸烟

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
        <div class="auto-margin regular-btn blue-btn" id="saveRoom">保存修改</div>
    </form>
@stop


@section('script')
    <script type="text/javascript">
        $(document).ready(function(){


            //给radio选项赋值
            $('input[name="extraBed"][value='+ '{{$room->is_extra_bed}}'+']').attr("checked",true);
            $('input[name="wifi"][value='+ '{{$room->wifi}}'+']').attr("checked",true);
            $('input[name="smoke"][value='+ '{{$room->smoke}}'+']').attr("checked",true);



            //选择多床型，动态添加
            var multiBedCount =  parseInt('{{count($room->multiBed)}}');
            if(multiBedCount>=0)
                multiBedCount -= 1;

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
                            '<input type="text" name="numOfMultiBed[]"  data-input="多床数量" >'+'\n'+
                            '<span class="unit">张</span>'+'\n'+
                            '</div>'+'\n'+


                            '<div class="small-input-box ">'+'\n'+
                            '<label>床长:</label>'+'\n'+
                            '<input type="text"  name="lengthOfMultiBed[]"  data-input="多床床长">'+'\n'+
                            '<span class="unit">米</span>'+'\n'+
                            '</div>'+'\n'+

                            '<div class="small-input-box ">'+'\n'+
                            '<label>床宽:</label>'+'\n'+
                            '<input type="text"  name="widthOfMultiBed[]"  data-input="多床床宽">'+'\n'+
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


            $('#saveRoom').click(function(){

                var checkForm = true;

                checkForm = alertBox(checkForm);

                if(checkForm) {
                    $('#updateRoomForm').submit();
                }
            })

        })
    </script>
@stop