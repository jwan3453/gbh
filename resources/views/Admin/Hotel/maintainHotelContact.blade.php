@extends('Admin.Hotel.maintainHotelInfo')

@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
    <script src={{ asset('semantic/modal.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>

    <script src={{ asset('js/jquery.form.js') }}></script>

    <script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
@stop

@section('infoContent')

    <div class="info-content">
        <div class="hotel-info">
            <div class="header">酒店联系人</div>
                <div class="item-box">
                        @if(count($contactList) > 0)
                            @foreach($contactList as $contact)
                                <div class="contact-box">

                                    <div class="contact-box-row">
                                        <label>姓名：</label>
                                        <input type="text" class="contact-input name" value="{{$contact->name}}">

                                        <label>电话：</label>
                                        <input type="text" class="contact-input telephone"  value="{{$contact->telephone}}">

                                        <label>手机：</label>
                                        <input type="text" class="contact-input mobile"  value="{{$contact->mobile}}">
                                    </div>
                                    <div class="contact-box-row">
                                        <label>职务：</label>
                                        <input type="text" class="contact-input position" value="{{$contact->position}}">

                                        <label>传真：</label>
                                        <input type="text" class="contact-input fax"  value="{{$contact->fax}}">

                                        <label>Email：</label>
                                        <input type="text" class="contact-input email"  value="{{$contact->email}}">
                                    </div>

                                    <div class="contact-operation-row">
                                        <input type="hidden" class="contact-item" value="{{$contact->id}}">
                                        <label class="edit-contact"><i class="icon edit large"></i><span>编辑</span></label>
                                        <label class="delete-contact"><i class="minus circle icon large red"></i><span>删除</span></label>
                                    </div>
                                    {{--<div class="remove-contact-row" onclick="removeContactRow(this)">--}}
                                        {{--<img src="/Admin/icon/menu-retract.png">--}}
                                    {{--</div>--}}
                                </div>
                            @endforeach
                        @endif
                        {{--<input type="hidden" value="@if(count($hotelInfo->contactList) > 0) {{count($hotelInfo->contactList)}} @else 1 @endif" name="contactCount" id="contactCount" />--}}

                    </div>

                <div class="item-block width-200 border-blue" id="addNewContactBtn">
                        <img src="/Admin/icon/add.png" class="margin-right-20">
                        添加联系人
                </div>
        </div>
    </div>

    <div class="ui page dimmer confirm-request">

        <h3>是否删除该联系人</h3>
        <div class="confirm-btns">
            <div class="regular-btn blue-btn confirm">
                确定
                <div class="ui active inline  small  loader" id="loader"></div>
            </div>
            <div class="regular-btn red-btn cancel">取消</div>
        </div>

    </div>

    <div class="edit-contact-modal  modal ui" id="addContact">

        <div class="edit-add-title">
            <span class=" margin-left-20">新联系人</span>
        </div>

        <form class="contact-box" id="contactForm" >

            <input type="hidden" value="{{$hotelId}}" name="hotelId"/>
            <input type="hidden" value="" name="contactId" id="contactId"/>
            <input type="hidden" value="create" name="createOrUpdate" id="createOrUpdate"/>

            <div class="contact-box-row">
                <label>姓名：</label>
                <input type="text" class="contact-input" name="name" id="name">

                <label>电话：</label>
                <input type="text" class="contact-input" name="telephone" id=telephone>

            </div>
            <div class="contact-box-row">

                <label>手机：</label>
                <input type="text" class="contact-input" name="mobile" id="mobile">

                <label>职务：</label>
                <input type="text" class="contact-input" name="position" id="position">
            </div>

            <div class="contact-box-row">

                <label>传真：</label>
                <input type="text" class="contact-input" name="fax"  id="fax">

                <label>Email：</label>
                <input type="text" class="contact-input" name="email" id="email">
            </div>
        </form>
        <div class="confirm-contact-btn auto-margin" >
            提交
        </div>
    </div>

@stop


@section('infoScript')
    <script type="text/javascript">


        $(document).ready(function() {

            //打开输入框
            $('#addNewContactBtn').click(function(){

                $('#createOrUpdate').val('create');
                $('#addContact').modal('show');
                $('#contactForm').find('input[type=text]').val('') ;
            })

            //防止编辑
            $('.item-box').find('input[type=text]').prop('disabled',true);


            //删除联系人确认框
            var deleteItem;
            $(document).on('click','.delete-contact',function(){

                deleteItem = $(this);
                $('#contactId').val($(this).siblings('.contact-item').val());
                $('.confirm-request').dimmer('show');
            })

            //确认删除
            $('.confirm').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/admin/manageHotel/hotelInfo/deleteHotelContact',
                    data: {contactId :$('#contactId').val()},
                    dataType: 'json',

                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            deleteItem.parents('.contact-box').remove();
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
            $(document).on('click','.edit-contact',function(){
                editItem = $(this);
                $('#createOrUpdate').val('update');
                $('#contactId').val($(this).siblings('.contact-item').val());
                $('#name').val($(this).parents('.contact-box').find('.name').val());
                $('#telephone').val($(this).parents('.contact-box').find('.telephone').val());
                $('#mobile').val($(this).parents('.contact-box').find('.mobile').val());
                $('#position').val($(this).parents('.contact-box').find('.position').val());
                $('#fax').val($(this).parents('.contact-box').find('.fax').val());
                $('#email').val($(this).parents('.contact-box').find('.email').val());

                $('#addContact').modal({
                    closable  : true
                }).modal('show');

            })


            //新建或更新联系人
            $('.confirm-contact-btn').click(function(){

                var options = {
                    url: '/admin/manageHotel/hotelInfo/createOrUpdateContact',
                    type: 'post',
                    dataType: 'json',
                    encoding: "UTF-8",
                    data: decodeURIComponent( $("#contactForm").serialize(),true),
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
                                        '<div class="contact-box">' +
                                            '<div class="contact-box-row">'+

                                                '<label>姓名：</label>'+'\n'+
                                                '<input type="text" class="contact-input name" disabled value="'+$('#name').val()+'">'+'\n'+

                                                '<label>电话：</label>'+'\n'+
                                                '<input type="text" class="contact-input telephone" disabled value="'+$('#telephone').val()+'">'+'\n'+

                                                '<label>手机：</label>'+'\n'+
                                                '<input type="text" class="contact-input mobile" disabled value="'+$('#mobile').val()+'">'+'\n'+
                                            '</div>'+'\n'+
                                            '<div class="contact-box-row">'+'\n'+
                                                '<label>职务：</label>'+'\n'+
                                                '<input type="text" class="contact-input position" disabled value="'+$('#position').val()+'">'+'\n'+

                                                '<label>传真：</label>'+'\n'+
                                                '<input type="text" class="contact-input fax" disabled value="'+$('#fax').val()+'">'+'\n'+

                                                '<label>Email：</label>'+'\n'+
                                                '<input type="text" class="contact-input email" disabled value="'+$('#email').val()+'">'+'\n'+
                                            '</div>'+'\n'+

                                            '<div class="contact-operation-row">'+'\n'+
                                                '<input type="hidden" class="contact-item" value="'+data.extra+'">'+'\n'+
                                                '<label class="edit-contact"><i class="icon edit large"></i><span>编辑</span></label>'+'\n'+
                                                '<label class="delete-contact"><i class="minus circle icon large red"></i><span>删除</span></label>'+'\n'+
                                            '</div>'+'\n'+
                                        '</div>';
                                $('.item-box').append(html);

                            }
                            else if($('#createOrUpdate').val() === 'update')
                            {
                                //动态更新项目
                                editItem.parents('.contact-box').find('.name').val($('#name').val());
                                editItem.parents('.contact-box').find('.telephone').val($('#telephone').val());
                                editItem.parents('.contact-box').find('.mobile').val($('#mobile').val());
                                editItem.parents('.contact-box').find('.position').val($('#position').val());
                                editItem.parents('.contact-box').find('.fax').val($('#fax').val());
                                editItem.parents('.contact-box').find('.email').val($('#email').val());
                            }

                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                        $('#addContact').modal({
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










