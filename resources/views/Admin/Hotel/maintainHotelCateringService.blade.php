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
        <div class="header">酒店餐饮服务</div>
        <div class="item-box">
            @if(count($cateringServiceList) > 0)
            @foreach($cateringServiceList as $cateringService)
            <div class="catering-box">

                <div class="catering-box-row">
                    <label>名称：</label>
                    <input type="text" class="catering-input name" value="{{$cateringService->name}}">

                    <label>名称(英文)：</label>
                    <input type="text" class="catering-input name-en"  value="{{$cateringService->name_en}}">

                    <label>面积：</label>
                    <input type="text" class="catering-input size"  value="{{$cateringService->size}}">
                </div>
                <div class="catering-box-row">
                    <label>座位数量：</label>
                    <input type="text" class="catering-input num-of-table" value="{{$cateringService->num_of_table}}">

                    <label>描述：</label>
                    <input type="text" class="catering-input description"  value="{{$cateringService->description}}">

                    <label>描述(英文)：</label>
                    <input type="text" class="catering-input description-en"  value="{{$cateringService->description_en}}">
                </div>
                <div class="catering-box-row">
                    <label>营业时间：</label>
                    <input type="text" class="catering-input business-hour"  value="{{$cateringService->business_hour}}">
                </div>
                <div class="catering-operation-row">
                    <input type="hidden" class="catering-item" value="{{$cateringService->id}}">
                    <label class="edit-catering"><i class="icon edit large"></i><span>编辑</span></label>
                    <label class="delete-catering"><i class="minus circle icon large red"></i><span>删除</span></label>
                </div>
                {{--<div class="remove-contact-row" onclick="removeContactRow(this)">--}}
                    {{--<img src="/Admin/icon/menu-retract.png">--}}
                    {{--</div>--}}
            </div>
            @endforeach
            @endif
            {{--<input type="hidden" value="@if(count($hotelInfo->contactList) > 0) {{count($hotelInfo->contactList)}} @else 1 @endif" name="contactCount" id="contactCount" />--}}

        </div>

        <div class="item-block width-200 border-blue" id="addNewCateringBtn">
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

<div class="edit-catering-modal  modal ui" id="addCatering">

    <div class="edit-add-title">
        <span class=" margin-left-20">新联系人</span>
    </div>

    <form class="catering-box" id="cateringForm" >

        <input type="hidden" value="{{$hotelId}}" name="hotelId"/>
        <input type="hidden" value="" name="cateringId" id="cateringId"/>
        <input type="hidden" value="create" name="createOrUpdate" id="createOrUpdate"/>

        <div class="catering-box-row">
            <label>名称：</label>
            <input type="text" class="catering-input" name="name" id="name">

            <label>名称(英文)：</label>
            <input type="text" class="catering-input" name="nameEn" id=nameEn>

        </div>
        <div class="catering-box-row">

            <label>面积：</label>
            <input type="text" class="catering-input" name="size" id="size">

            <label>座位数量：</label>
            <input type="text" class="catering-input" name="numOfTable" id="numOfTable">
        </div>

        <div class="catering-box-row">

            <label>描述：</label>
            <input type="text" class="catering-input" name="description"  id="description">

            <label>描述(英文)：</label>
            <input type="text" class="catering-input" name="descriptionEn" id="descriptionEn">
        </div>

        <div class="catering-box-row">

            <label>营业时间：</label>
            <input type="text" class="catering-input" name="businessHour"  id="businessHour">


        </div>

    </form>
    <div class="confirm-catering-btn auto-margin" >
        提交
    </div>
</div>

@stop


@section('infoScript')
<script type="text/javascript">


    $(document).ready(function() {

        //打开输入框
        $('#addNewCateringBtn').click(function(){

            $('#createOrUpdate').val('create');
            $('#addCatering').modal('show');
            $('#cateringForm').find('input[type=text]').val('') ;
        })

        //防止编辑
        $('.item-box').find('input[type=text]').prop('disabled',true);


        //删除餐饮项目确认框
        var deleteItem;
        $(document).on('click','.delete-catering',function(){

            deleteItem = $(this);
            $('#cateringId').val($(this).siblings('.catering-item').val());
            $('.confirm-request').dimmer('show');
        })

        //确认删除
        $('.confirm').click(function(){

            $.ajax({
                type: 'POST',
                url: '/admin/manageHotel/hotelInfo/deleteHotelCateringItem',
                data: {cateringId :$('#cateringId').val()},
                dataType: 'json',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data){
                    if(data.statusCode === 1)
                    {
                        //动态删除项目
                        deleteItem.parents('.catering-box').remove();
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
        $(document).on('click','.edit-catering',function(){
            editItem = $(this);
            $('#createOrUpdate').val('update');
            $('#cateringId').val($(this).siblings('.catering-item').val());
            $('#name').val($(this).parents('.catering-box').find('.name').val());
            $('#nameEn').val($(this).parents('.catering-box').find('.name-en').val());
            $('#size').val($(this).parents('.catering-box').find('.size').val());
            $('#numOfTable').val($(this).parents('.catering-box').find('.num-of-table').val());
            $('#description').val($(this).parents('.catering-box').find('.description').val());
            $('#descriptionEn').val($(this).parents('.catering-box').find('.description-en').val());
            $('#businessHour').val($(this).parents('.catering-box').find('.business-hour').val());
            $('#addCatering').modal({
                closable  : true
            }).modal('show');

        })


        //新建或更新联系人
        $('.confirm-catering-btn').click(function(){

            var options = {
                url: '/admin/manageHotel/hotelInfo/createOrUpdateHotelCateringItem',
                type: 'post',
                dataType: 'json',
                encoding: "UTF-8",
                data: decodeURIComponent( $("#cateringForm").serialize(),true),
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
                                '<div class="catering-box">' +
                                '<div class="catering-box-row">'+

                                '<label>名称：</label>'+'\n'+
                                '<input type="text" class="catering-input name" disabled value="'+$('#name').val()+'">'+'\n'+

                                '<label>名称(英文)：</label>'+'\n'+
                                '<input type="text" class="catering-input name-en" disabled value="'+$('#nameEn').val()+'">'+'\n'+

                                '<label>面积：</label>'+'\n'+
                                '<input type="text" class="catering-input size" disabled value="'+$('#size').val()+'">'+'\n'+
                                '</div>'+'\n'+
                                '<div class="catering-box-row">'+'\n'+
                                '<label>座位数量：</label>'+'\n'+
                                '<input type="text" class="catering-input num-of-table" disabled value="'+$('#numOfTable').val()+'">'+'\n'+

                                '<label>描述：</label>'+'\n'+
                                '<input type="text" class="catering-input description" disabled value="'+$('#description').val()+'">'+'\n'+

                                '<label>描述(英文)：</label>'+'\n'+
                                '<input type="text" class="catering-input description-en" disabled value="'+$('#descriptionEn').val()+'">'+'\n'+
                                '</div>'+'\n'+

                                '<div class="catering-box-row">'+'\n'+

                                '<label>营业时间：</label>'+'\n'+
                                '<input type="text" class="catering-input business-hour" disabled value="'+$('#businessHour').val()+'">'+'\n'+
                                '</div>'+'\n'+

                                '<div class="catering-operation-row">'+'\n'+
                                '<input type="hidden" class="catering-item" value="'+data.extra+'">'+'\n'+
                                '<label class="edit-catering"><i class="icon edit large"></i><span>编辑</span></label>'+'\n'+
                                '<label class="delete-catering"><i class="minus circle icon large red"></i><span>删除</span></label>'+'\n'+
                                '</div>'+'\n'+
                                '</div>';
                            $('.item-box').append(html);

                        }
                        else if($('#createOrUpdate').val() === 'update')
                        {
                            //动态更新项目
                            editItem.parents('.catering-box').find('.name').val($('#name').val());
                            editItem.parents('.catering-box').find('.name-en').val($('#nameEn').val());
                            editItem.parents('.catering-box').find('.size').val($('#size').val());
                            editItem.parents('.catering-box').find('.num-of-table').val($('#numOfTable').val());
                            editItem.parents('.catering-box').find('.description').val($('#description').val());
                            editItem.parents('.catering-box').find('.description-en').val($('#descriptionEn').val());
                            editItem.parents('.catering-box').find('.business-hour').val($('#businessHour').val());
                        }

                    }
                    else{
                        toastAlert(data.statusMsg,2);
                    }
                    $('#addCatering').modal({
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










