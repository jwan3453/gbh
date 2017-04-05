@extends('Admin.MarkingSystem.layout')


@section('resources')
    <script src={{ asset('js/jquery.form.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
@stop

@section('content')




    <div id="loader" class="ui active centered inline loader large " style="display: none; position: fixed;top:30%;left:calc(50% - 50px)"></div>
    <div>
        <h2 style="text-align: center">酒店运营检查系统</h2>



        <div style="width: 100%">
            <div class="eva-hotel-d">
                <label>酒店名称:</label><input type="text" id="hotelName" value="{{$recordInfo->name}}" disabled="disabled"/>
            </div>
            <div class="eva-hotel-d">
                <label>入住客房:</label><input type="text" id="roomName" value="{{$recordInfo->room_name}}" disabled="disabled"/>
            </div>
            <div class="eva-hotel-d">
                <label>评估员:</label><input type="text" id="evaluator" value="{{$recordInfo->evaluator}}" disabled="disabled"/>
            </div>
            {{--<div class="eva-hotel-d">--}}
            {{--<label>总得分:</label> <span id="totalPoints">0</span>--}}
            {{--</div>--}}

        </div>
        <div style="margin:20px 0" >
            <a href="/admin/markingSystem/exportExcel/{{$recordInfo->id}}"><div class="regular-btn blue-btn auto-margin" id="exportExcel">导出excel</div></a>
        </div>


        <input type="hidden" id="status" value="old">
        <div style="display:none">{{$loop = 0}}</div>
        @foreach( $evaluatedStandardList as $section)
            <div style="display:none">{{$loop++}}</div>

            @if($loop > 1)
                <form style="display: none;" class="section-from section_{{$section->id}}" data-field="{{$section->id}}" enctype="multipart/form-data"  >
                    @else
                        <form   class="section-from section_{{$section->id}}" data-field="{{$section->id}}" enctype="multipart/form-data"  >
                            @endif

                            <input type="hidden" name="section"   value="{{$section->id}}">
                            <input type="hidden" name="sHotelName" class="s-hotel-name"  value="">
                            <input type="hidden" name="sRoomName" class="s-room-name"  value="">
                            <input type="hidden" name="sEvaluator" class="s-evaluator"  value="">
                            <input type="hidden" name="sStatus" class="s-status" value="">
                            <input type="hidden" name="recordId" class="s-record" value="{{$recordInfo->id}}">

                            <div >
                                <div class="regular-btn red-btn  next-item  f-left previous" style="display: inline-block"> 上一区 </div>
                                <div class="regular-btn red-btn  next-item f-right next" style="display: inline-block"> 下一区 </div>
                            </div>


                            <div class="s-name">{{$loop .'. '.$section->name}}</div>

                            <ul class="marking-table" >
                                <li class="head">

                                    <span>项目</span>
                                    <span style="text-align: center">打分</span>
                                    <span style="text-align: center">描述</span>
                                    <span style="text-align: center">图片</span>

                                </li>

                                @foreach( $section->standards as $index=> $standard)
                                    <li>
                                        <div  class="s-des">{{($index+1).'. '. $standard->description }}</div>
                                        <div class="s-points">

                                            <select class="evl-points" name="evlPoints_{{$standard->id}}" value="{{$standard->points}}">

                                                @for($index=0; $index<=10; $index++)
                                                    @if(($index*10) == $standard->points)
                                                        <option value ="{{$index*10}}" selected="selected">{{$index*10}}</option>
                                                    @else
                                                        <option value ="{{$index*10}}">{{$index*10}}</option>
                                                    @endif
                                                @endfor
                                            </select>
                                        </div>
                                        <div class="s-desc"><input   type="text" class="evl-desc" name="evlDesc_{{$standard->id}}" value="{{$standard->mpdesc}}"/></div>
                                        <div  class="s-file">
                                            @if(strlen($standard->images) >0)
                                                <img  src = '{{$standard->images}}' style="height:200px;width:150px;">
                                            @else
                                                <input  type="file" accept="image/*" capture="camera" id="cameraInput" name="cameraInput_{{$standard->id}}" class="sign_file s-file"/>
                                           @endif
                                        </div>
                                    </li>
                                @endforeach

                            </ul>


                            <div>
                                <div class="regular-btn red-btn  next-item  f-left previous" style="display: inline-block"> 上一区 </div>
                                <div class="regular-btn red-btn  next-item f-right next" style="display: inline-block"> 下一区 </div>
                                <div class="regular-btn red-btn auto-margin submit-eval" > 更新评估表 </div>
                            </div>
                        </form>
                @endforeach






    </div>
@stop


@section('script')

    <script type="text/javascript">
        $(document).ready(function() {

            $('#submitEval').click(function(){


            })


            $('.evl-points').change(function(e){

                var oldnum=$(this).val();
                var num = e.keyCode - 48;
                var v = oldnum.toString() + num;
                v = parseInt(v);
                if (v < 0 || v > 100) {
                    var s = $(this).val();
                    toastAlert('分数为 0 - 100',2);
                    $(this).val( s.substring(0,s.length-1)  );
                    e.preventDefault();
                } else {

                    var totalPoints = 0;
                    $('.evl-points').each(function(){

                        if( isNaN(parseInt($(this).val())))
                        {
                            totalPoints += 0;

                        }
                        else
                            totalPoints += parseInt($(this).val());
                    })

                    $('#totalPoints').text(totalPoints);

                }
            })


        });

        $('.submit-eval').click(function(){


            if($('#hotelName').val() === '')
            {

                $('html, body').animate({
                    scrollTop: $('#hotelName').offset().top
                }, 500);
                $('#hotelName').css('border','1px solid #ff5f76');
                toastAlert('酒店名称不能为空',2);
                return;
            }

            if($('#roomName').val() === '')
            {

                $('html, body').animate({
                    scrollTop: $('#roomName').offset().top
                }, 500);
                $('#roomName').css('border','1px solid #ff5f76');
                toastAlert('房间类型不能为空',2);
                return;
            }

            if($('#evaluator').val() === '')
            {

                $('html, body').animate({
                    scrollTop: $('#evaluator').offset().top
                }, 500);
                $('#evaluator').css('border','1px solid #ff5f76');
                toastAlert('评估员不能为空',2);
                return;
            }


            //更改form里面的状态


            $(this).parents('form').find('.s-hotel-name').val($('#hotelName').val());
            $(this).parents('form').find('.s-room-name').val($('#roomName').val());
            $(this).parents('form').find('.s-evaluator').val($('#evaluator').val());
            $(this).parents('form').find('.s-status').val($('#status').val());


            //显示loader
            $('#loader').show();

            //提交价格
            var formData   = new FormData($(this).parents('form')[0]);
            var options = {
                url: '/admin/markingSystem/saveSectionEvaluates',
                type: 'post',
                dataType: 'json',
                data:  formData,
                processData: false,
                contentType: false,
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    $('#loader').hide();
                    if(data.statusCode===1)
                    {
                        var resultString = data.statusMsg.split('_');
                        var section = resultString[0];
                        var recordId = resultString[1];
                        $('.section-from').each(function(){
                            if($(this).hasClass('section_'+section))
                            {
                                $(this).show();
                                $('#status').val('old');
                                $(this).find('.s-hotel-name').val($('#hotelName').val());
                                $(this).find('.s-status').val($('#status').val());
                                $(this).find('.s-record').val(recordId);

                            }
                            else{
                                $(this).hide();
                            }
                        })

                        if(section =='0')
                        {
                            toastAlert('评估完成',2);
                            location.href='/admin/markingSystem';
                        }
                    }

                },
                error:function(data){

                }
            };

            $.ajax(options);



        })


        //获取分区id列表
        var formList = [];
        var initialIndex = 0;
        var initialForm = 0;
        $('.section-from').each(function(){

            formList.push( $(this).attr('data-field'));
        })


        $('.previous').click(function(){

            if(initialIndex === 0)
            {
                toastAlert('没有上一区了',2);
            }
            else{
                initialIndex--;
                initialForm= formList[initialIndex];
                $('.section-from').each(function(){

                    if($(this).hasClass('section_'+initialForm))
                    {
                        $(this).show();
                        //$('#status').val('old');
                        //$(this).find('.s-hotel-name').val($('#hotelName').val());
                        //$(this).find('.s-status').val($('#status').val());
                        //$(this).find('.s-record').val(recordId);

                    }
                    else{
                        $(this).hide();
                    }
                })
            }
           //var form =  $(this).parents('form').prev('form');

            //orm.show();
        })

        $('.next').click(function(){

            if(initialIndex === (formList.length - 1))
            {
                toastAlert('没有下一区了',2);
            }
            else{
                initialIndex++;
                initialForm= formList[initialIndex];
                $('.section-from').each(function(){

                    if($(this).hasClass('section_'+initialForm))
                    {
                        $(this).show();
                        //$('#status').val('old');
                        //$(this).find('.s-hotel-name').val($('#hotelName').val());
                        //$(this).find('.s-status').val($('#status').val());
                        //$(this).find('.s-record').val(recordId);

                    }
                    else{
                        $(this).hide();
                    }
                })
            }

        })

    </script>
@stop