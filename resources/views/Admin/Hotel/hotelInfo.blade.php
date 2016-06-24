@extends('Admin.site')



@section('resources')

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>
    <script src={{ asset('js/jquery.form.js') }}></script>
@stop

@section('content')

    <div class="admin-content">
        <div class="info-menu">
            <span>信息维护</span>
            <span>房型信息</span>
            <span>问答管理</span>
        </div>
        <hr/>

        <div class="info-content">
            <form class="detail-form room-detail-from" id="newRoomForm" action='{{url("/admin/manageHotel/createNewRoomType")}}' method="Post">

                <div class="header">添加新房型</div>
                <input type="hidden" value="{{csrf_token()}}" name="_token"/>
                <input type="hidden" name="hotelId" value="{{$hotelId}}">
                <div style="overflow:hidden">
                    <div class="short-input-box ">
                        <label>房型名称</label>
                        <input type="text" id="roomName" name="roomName">

                    </div>

                    <div class="short-input-box ">
                        <label>门市价格</label>
                        <input type="text" id="rackRate" name="rackRate">
                    </div>

                    <div class="short-input-box ">
                        <label>入住人数</label>
                        <input type="text" id="numOfPeople" name="numOfPeople">
                        <span class="unit">位</span>
                    </div>

                    <div class="short-input-box ">
                        <label>儿童人数</label>
                        <input type="text" id="numOfChildren" name="numOfChildren">
                        <span class="unit">位</span>
                    </div>

                    <div class="short-input-box ">
                        <label>房间数</label>
                        <input type="text" id="numOfRooms" name="numOfRooms">
                        <span class="unit">间</span>
                    </div>

                    <div class="short-input-box ">
                        <label>楼层</label>
                        <input type="text" id="floor" name="floor">
                        <span class="unit">层</span>
                    </div>
                    <div class="short-input-box ">
                        <label>面积</label>
                        <input type="text" id="acreage" name="acreage">
                        <span class="unit">平方</span>
                    </div>
                </div>
                <div class="bed-type" >
                    <label class="header-label">床型</label>
                    <div class="bed-type-list" id="bedTypeList" >
                        <div class="bed-item">
                            <input type="checkbox"   class="select-bed-type" name="doubleBed" value="" id="doubleBed" />
                            <label>双床</label>

                            <select class=" ui dropdown bedCate">
                                <option value="1">双床</option>
                                <option value="2">双床</option>
                                <option value="3">双床</option>
                                <option value="4">双床</option>
                            </select>

                            <input type="hidden" class="bedTypeName" name="doubleBedType">

                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text" name="numOfDoubleBed" id="numOfDoubleBed" >
                                <span class="unit">张</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widthOfDoubleBed" id="widthOfDoubleBed">
                                <span class="unit">米</span>
                            </div>

                        </div>
                        <div class="bed-item" >
                            <input type="checkbox" class="select-bed-type" name="singleBed" id="singleBed"/>
                            <label>单床</label>

                            <select class=" ui dropdown bedCate">
                                <option value="1">单床</option>
                                <option value="2">单床</option>
                                <option value="3">单床</option>
                                <option value="4">单床</option>
                            </select>

                            <input type="hidden" class="bedTypeName" name="singleBedType">

                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text"  name="numOfSingleBed" id="numOfSingleBed" >
                                <span class="unit">张</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widthOfSingleBed" id="widthOfSingleBed" >
                                <span class="unit">米</span>
                            </div>

                        </div>
                        <div class="bed-item">
                            <input type="checkbox" class="select-bed-type" name="largeBed" id="largeBed"/>
                            <label>大床</label>

                            <select class=" ui dropdown bedCate">
                                <option value="1">大床</option>
                                <option value="2">大床</option>
                                <option value="3">大床</option>
                                <option value="4">大床</option>
                            </select>

                            <input type="hidden" class="bedTypeName" name="largeBedType">

                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text" name="numOfLargeBed" id="numberOfLargeBed">
                                <span class="unit">张</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widthOfLargeBed" id="widthOfLargeBed">
                                <span class="unit">米</span>
                            </div>
                        </div>

                        <div class="bed-item">
                            <input type="checkbox" class="select-bed-type" name="multiBed" id="multiBed"/>
                            <label>多床</label>


                            <select class=" ui dropdown bedCate">

                                @foreach($bedTypes as $bedType)
                                    <option value="{{$bedType->id}}">{{$bedType->name}}</option>
                                @endforeach

                            </select>

                            <input type="hidden" class="bedTypeName" name="MultiBedName[]">

                            <div class="small-input-box ">
                                <label>数量:</label>
                                <input type="text" name="numerOfMultiBed[]" >
                                <span class="unit">张</span>
                            </div>

                            <div class="small-input-box ">
                                <label>床宽:</label>
                                <input type="text" name="widhtOfMultiBed[]">
                                <span class="unit">米</span>
                            </div>

                            <span class="add-new-bed" id="addNewBed">添加</span>
                        </div>
                    </div>
                </div>

                <div style="overflow:auto;display: block">
                    <div class="long-input-box">
                        <label>能否加床</label>
                        <div class="radio-selection">
                            <div class="radio-group">
                                <input type="radio" name="sex" value="male" /> 不可加床

                                <input type="radio" name="sex" value="female" /> 免费加床

                                <input type="radio" name="sex" value="female" /> 收费加床
                            </div>
                        </div>
                    </div>


                    <div class="long-input-box">
                        <label>宽带</label>
                        <div class="radio-selection">
                            <div class="radio-group">
                                <input type="radio" name="sex" value="male" /> 不可加床

                                <input type="radio" name="sex" value="female" /> 免费加床

                                <input type="radio" name="sex" value="female" /> 收费加床
                            </div>
                            <div class="radio-group">
                                <input type="radio" name="sex" value="male" /> 不可加床

                                <input type="radio" name="sex" value="female" /> 免费加床

                                <input type="radio" name="sex" value="female" /> 收费加床
                            </div>
                        </div>
                    </div>


                    <div class="long-input-box">
                        <label>无烟信息</label>
                        <div class="radio-selection">
                            <div class="radio-group">
                                <input type="radio" name="sex" value="male" /> 不可吸烟

                                <input type="radio" name="sex" value="female" /> 可以吸烟
                            </div>
                        </div>
                    </div>



                    <div class="long-input-box">
                        <label>是否有窗</label>
                        <div class="radio-selection">
                            <div class="radio-group">
                                <input type="radio" name="sex" value="male" /> 有窗

                                <input type="radio" name="sex" value="female" /> 无窗
                            </div>
                        </div>
                    </div>
                 </div>
                <div class="auto-margin regular-btn red-btn" id="saveRoom">保存房型</div>
            </form>
            <div class="regular-btn blue-btn  " id="newRoomBtn"><i class="icon plus "></i>添加新房型</div>
        </div>
    </div>
@stop

@section('script')
    <script type="text/javascript">
        $(document).ready(function(){
            $('#newRoomBtn').click(function(){
                $('#newRoomForm').transition('scale');
            })

            $(' .ui.dropdown').dropdown({
                onChange: function(value, text, $selectedItem) {
                    $(this).parent().siblings('.bedTypeName').val(text);
                }
            })

            //选择多床型，动态添加
            $('#addNewBed').click(function(){
                var html = '<div class="bed-item">' + '\n'+

                                '<div style="width:60px; display:inline-block"></div>' + '\n'+

                                '<select class=" ui dropdown bedCate">'+'\n'+

                                    @foreach($bedTypes as $bedType)
                                        '<option value="{{$bedType->id}}">{{$bedType->name}}</option>'+'\n'+
                                    @endforeach
                                 '</select>'+'\n'+

                                '<input type="hidden" class="bedTypeName" name="MultiBedName[]">'+ '\n'+

                                '<div class="small-input-box ">'+'\n'+
                                    '<label>数量:</label>'+'\n'+
                                    '<input type="text" name="numerOfMultiBed[]">'+'\n'+
                                    '<span class="unit">张</span>'+'\n'+
                                '</div>'+'\n'+

                                '<div class="small-input-box ">'+'\n'+
                                    '<label>床宽:</label>'+'\n'+
                                    '<input type="text"  name="widhtOfMultiBed[]">'+'\n'+
                                    '<span class="unit">米</span>'+'\n'+
                                '</div>'+'\n'+

                                '<span class="add-new-bed" id="addNewBed">添加</span>'+'\n'+
                                '<span class="delete-new-bed" >删除</span>'+'\n'+
                            '</div>';
                $('#bedTypeList').append(html);
                $(' .ui.dropdown').dropdown({
                    onChange: function(value, text, $selectedItem) {
                        $(this).parent().siblings('.bedTypeName').val(text);
                    }
                })
            })

            //选择床型 checkbox
            $('.select-bed-type').change(function(){

                if(!$(this).is(':checked'))
                {
                    $(this).siblings('.small-input-box').fadeOut();
                }
                else{
                    $(this).siblings('.small-input-box').fadeIn();
                }
            })

            // ajax 上传新的房型
            $('#saveRoom').click(function(){
                $.ajax({
                    type: 'POST',
                    url: '/admin/manageHotel/createNewRoom',
                    data: $("#newRoomForm").serialize(),
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        alert(data.statusMsg);

                    }
                })
            })

        })
    </script>
@stop