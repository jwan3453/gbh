@extends('Admin.Hotel.maintainHotelInfo')

@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
    <script src={{ asset('semantic/modal.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>
@stop

@section('infoContent')

    <div class="info-content">
        <div class="hotel-info">
            <div class="header">酒店健娱乐</div>
            <div class="item-box">
                @if(count($recreationServiceList) > 0)
                    @foreach($recreationServiceList as $recreationService)
                        <div class="recreation-box">

                            <div class="recreation-box-row">
                                <label>名称：</label>
                                <input type="text" class="recreation-input name" value="{{$recreationService->name}}">

                                <label>名称(英文)：</label>
                                <input type="text" class="recreation-input name-en"  value="{{$recreationService->name_en}}">

                                <label>数量：</label>
                                <input type="text" class="recreation-input num" value="{{$recreationService->num}}">

                            </div>
                            <div class="recreation-box-row">

                                <label>描述：</label>
                                <input type="text" class="recreation-input description"  value="{{$recreationService->description}}">

                                <label>描述(英文)：</label>
                                <input type="text" class="recreation-input description-en"  value="{{$recreationService->description_en}}">

                                <label>营业时间：</label>
                                <input type="text" class="recreation-input business-hour"  value="{{$recreationService->business_hour}}">
                            </div>

                            <div class="recreation-operation-row">
                                <input type="hidden" class="recreation-item" value="{{$recreationService->id}}">
                                <label class="edit-recreation"><i class="icon edit large"></i><span>编辑</span></label>
                                <label class="delete-recreation"><i class="minus circle icon large red"></i><span>删除</span></label>
                            </div>
                            {{--<div class="remove-contact-row" onclick="removeContactRow(this)">--}}
                            {{--<img src="/Admin/icon/menu-retract.png">--}}
                            {{--</div>--}}
                        </div>
                    @endforeach
                @endif
                {{--<input type="hidden" value="@if(count($hotelInfo->contactList) > 0) {{count($hotelInfo->contactList)}} @else 1 @endif" name="contactCount" id="contactCount" />--}}

            </div>

            <div class="item-block width-200 border-blue" id="addNewRecreationBtn">
                <img src="/Admin/icon/add.png" class="margin-right-20">
                添加新项目
            </div>
        </div>
    </div>

    <div class="ui page dimmer confirm-request">

        <h3>是否删除该项目</h3>
        <div class="confirm-btns">
            <div class="regular-btn blue-btn confirm">
                确定
                <div class="ui active inline  small  loader" id="loader"></div>
            </div>
            <div class="regular-btn red-btn cancel">取消</div>
        </div>

    </div>

    <div class="edit-recreation-modal  modal ui" id="addRecreation">

        <div class="edit-add-title">
            <span class=" margin-left-20">新联系人</span>
        </div>

        <form class="recreation-box" id="recreationForm" >

            <input type="hidden" value="{{$hotelId}}" name="hotelId"/>
            <input type="hidden" value="" name="recreationId" id="recreationId"/>
            <input type="hidden" value="create" name="createOrUpdate" id="createOrUpdate"/>

            <div class="recreation-box-row">
                <label>名称：</label>
                <input type="text" class="recreation-input" name="name" id="name">

                <label>名称(英文)：</label>
                <input type="text" class="recreation-input" name="nameEn" id=nameEn>

            </div>

            <div class="recreation-box-row">

                <label>描述：</label>
                <input type="text" class="recreation-input" name="description"  id="description">

                <label>描述(英文)：</label>
                <input type="text" class="recreation-input" name="descriptionEn" id="descriptionEn">
            </div>


            <div class="recreation-box-row">

                <label>数量：</label>
                <input type="text" class="recreation-input" name="num" id="num">


                <label>营业时间：</label>
                <input type="text" class="recreation-input" name="businessHour"  id="businessHour">

            </div>




        </form>
        <div class="confirm-recreation-btn auto-margin" >
            提交
        </div>
    </div>

@stop


@section('infoScript')
    <script type="text/javascript">


        $(document).ready(function() {

            //打开输入框
            $('#addNewRecreationBtn').click(function(){

                $('#createOrUpdate').val('create');
                $('#addRecreation').modal('show');
                $('#recreationForm').find('input[type=text]').val('') ;
            })

            //防止编辑
            $('.item-box').find('input[type=text]').prop('disabled',true);


            //删除餐饮项目确认框
            var deleteItem;
            $(document).on('click','.delete-recreation',function(){

                deleteItem = $(this);
                $('#recreationId').val($(this).siblings('.recreation-item').val());
                $('.confirm-request').dimmer('show');
            })

            //确认删除
            $('.confirm').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/admin/manageHotel/hotelInfo/deleteHotelRecreationItem',
                    data: {recreationId :$('#recreationId').val()},
                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            deleteItem.parents('.recreation-box').remove();
                            toastAlert(data.statusMsg,1);


                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                        $('.confirm-request').dimmer('hide');
                    }
                })
            })

            //编辑酒店联系人
            var editItem;
            $(document).on('click','.edit-recreation',function(){
                editItem = $(this);
                $('#createOrUpdate').val('update');
                $('#recreationId').val($(this).siblings('.recreation-item').val());
                $('#name').val($(this).parents('.recreation-box').find('.name').val());
                $('#nameEn').val($(this).parents('.recreation-box').find('.name-en').val());
                $('#num').val($(this).parents('.recreation-box').find('.num').val());
                $('#description').val($(this).parents('.recreation-box').find('.description').val());
                $('#descriptionEn').val($(this).parents('.recreation-box').find('.description-en').val());
                $('#businessHour').val($(this).parents('.recreation-box').find('.business-hour').val());
                $('#addRecreation').modal({
                    closable  : true
                }).modal('show');

            })


            //新建或更新联系人
            $('.confirm-recreation-btn').click(function(){

                var options = {
                    url: '/admin/manageHotel/hotelInfo/createOrUpdateHotelRecreationItem',
                    type: 'post',
                    dataType: 'json',
                    encoding: "UTF-8",
                    data: decodeURIComponent( $("#recreationForm").serialize(),true),
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){

                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            toastAlert(data.statusMsg,1);
                            if($('#createOrUpdate').val() === 'create')
                            {
                                //动态添加新的项目
                                var html =
                                        '<div class="recreation-box">' +
                                        '<div class="recreation-box-row">'+

                                        '<label>名称：</label>'+'\n'+
                                        '<input type="text" class="recreation-input name" disabled value="'+$('#name').val()+'">'+'\n'+

                                        '<label>名称(英文)：</label>'+'\n'+
                                        '<input type="text" class="recreation-input name-en" disabled value="'+$('#nameEn').val()+'">'+'\n'+

                                        '<label>座位数量：</label>'+'\n'+
                                        '<input type="text" class="recreation-input num" disabled value="'+$('#num').val()+'">'+'\n'+


                                        '</div>'+'\n'+
                                        '<div class="recreation-box-row">'+'\n'+

                                        '<label>描述：</label>'+'\n'+
                                        '<input type="text" class="recreation-input description" disabled value="'+$('#description').val()+'">'+'\n'+

                                        '<label>描述(英文)：</label>'+'\n'+
                                        '<input type="text" class="recreation-input description-en" disabled value="'+$('#descriptionEn').val()+'">'+'\n'+


                                        '<label>营业时间：</label>'+'\n'+
                                        '<input type="text" class="recreation-input business-hour" disabled value="'+$('#businessHour').val()+'">'+'\n'+
                                        '</div>'+'\n'+


                                        '<div class="recreation-operation-row">'+'\n'+
                                        '<input type="hidden" class="recreation-item" value="'+data.extra+'">'+'\n'+
                                        '<label class="edit-recreation"><i class="icon edit large"></i><span>编辑</span></label>'+'\n'+
                                        '<label class="delete-recreation"><i class="minus circle icon large red"></i><span>删除</span></label>'+'\n'+
                                        '</div>'+'\n'+
                                        '</div>';
                                $('.item-box').append(html);

                            }
                            else if($('#createOrUpdate').val() === 'update')
                            {
                                //动态更新项目
                                editItem.parents('.recreation-box').find('.name').val($('#name').val());
                                editItem.parents('.recreation-box').find('.name-en').val($('#nameEn').val());
                                editItem.parents('.recreation-box').find('.num').val($('#num').val());
                                editItem.parents('.recreation-box').find('.description').val($('#description').val());
                                editItem.parents('.recreation-box').find('.description-en').val($('#descriptionEn').val());
                                editItem.parents('.recreation-box').find('.business-hour').val($('#businessHour').val());
                            }

                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                        $('#addRecreation').modal({
                            closable  : true
                        }).modal('hide');
                    },
                    error:function(data){
                    }
                };
                $.ajax(options);
            })


        })
    </script>
@stop










