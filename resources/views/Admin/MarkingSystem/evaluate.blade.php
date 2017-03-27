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
                <label>酒店名称:</label><input type="text" id="hotelName" />
            </div>
            <div class="eva-hotel-d">
                <label>入住客房:</label><input type="text" id="roomName" />
            </div>
            <div class="eva-hotel-d">
                <label>评估员:</label><input type="text" id="evaluator" />
            </div>
            {{--<div class="eva-hotel-d">--}}
                {{--<label>总得分:</label> <span id="totalPoints">0</span>--}}
            {{--</div>--}}

        </div>

            <input type="hidden" id="status" value="new">
            <div style="display:none">{{$loop = 0}}</div>
            @foreach( $standardList as $section)
            <div style="display:none">{{$loop++}}</div>

                @if($loop > 1)
                    <form style="display:none" class="section-from section_{{$section->id}}"  enctype="multipart/form-data"  >
                @else
                    <form  class="section-from section_{{$section->id}}"  enctype="multipart/form-data"  >
                @endif

                <input type="hidden" name="section"   value="{{$section->id}}">
                <input type="hidden" name="sHotelName" class="s-hotel-name"  value="">
                <input type="hidden" name="sRoomName" class="s-room-name"  value="">
                <input type="hidden" name="sEvaluator" class="s-evaluator"  value="">
                <input type="hidden" name="sStatus" class="s-status" value="">
                <input type="hidden" name="recordId" class="s-record" value="">


                <div class="s-name">{{$loop .'. '.$section->name}}</div>
                <table class="ui table group marking-table" >
                    <thead>
                    <tr>
                        <th>项目</th>
                        <th style="text-align: center">打分</th>
                        <th style="text-align: center">描述</th>
                        <th style="text-align: center">图片</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach( $section->standards as $standard)
                        <tr>
                            <td  class="s-des">{{ $standard->description }}</td>
                            <td>

                                <select class="evl-points" name="evlPoints_{{$standard->id}}">
                                    <option value ="0">0</option>
                                    <option value ="10">10</option>
                                    <option value ="20">20</option>
                                    <option value="30">30</option>
                                    <option value="40">40</option>
                                    <option value="50">50</option>
                                    <option value="60">60</option>
                                    <option value="70">70</option>
                                    <option value="80">80</option>
                                    <option value="90">90</option>
                                    <option value="100">100</option>
                                </select>
                            </td>
                            <td><input type="text" class="evl-desc" name="evlDesc_{{$standard->id}}"/></td>
                            <td><input type="file" accept="image/*" capture="camera" id="cameraInput" name="cameraInput_{{$standard->id}}" class="sign_file"/></td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>


                <div>
                    <div class="regular-btn red-btn auto-margin submit-eval" > 提交评估表 </div>
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

     </script>
 @stop