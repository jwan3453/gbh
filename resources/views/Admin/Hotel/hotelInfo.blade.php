@extends('Admin.site')





@section('content')

    <div class="admin-content">
        <div class="info-menu">
            <span>信息维护</span>
            <span>房型信息</span>
            <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelId.'manageRoom')}}"><span>问答管理</span></a>
        </div>
        <hr/>

       @yield('infoContent')
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

                                '<input type="hidden" class="bedTypeName" name="multiBedType[]">'+ '\n'+

                                '<div class="small-input-box ">'+'\n'+
                                    '<label>数量:</label>'+'\n'+
                                    '<input type="text" name="numOfMultiBed[]">'+'\n'+
                                    '<span class="unit">张</span>'+'\n'+
                                '</div>'+'\n'+

                                '<div class="small-input-box ">'+'\n'+
                                    '<label>床宽:</label>'+'\n'+
                                    '<input type="text"  name="widthOfMultiBed[]">'+'\n'+
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