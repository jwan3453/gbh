@extends('Admin.site')

@section('resources')
    <script src={{ asset('js/jquery.form.js') }}></script>
@stop

@section('content')

    <div class="admin-content">
        <div class="destination-list">

            <div id="caption" class="d-c-caption">
                <span id="cap-a_e" class="active">ABCDE</span>
                <span id="cap-f_j">FGHIJ</span>
                <span id="cap-k_p">KLMNOP</span>
                <span id="cap-q_v">QRSTUV</span>
                <span id="cap-w_z">WXYZ</span>
                <span id="cap-intCity">国外</span>
            </div>

            @foreach($initialGroup as $key => $initialList)
            <div id="city_{{$key}}" class="d-city-section" >

                @foreach($initialList as $initial )
                    @if(isset($cities[$initial]))
                    <div class="d-city-group">
                        @if(strlen($initial) <=1)
                            <div class="d-city-initial">
                                    {{$initial}}
                            </div>
                        @endif
                        <div class="d-city-initial-list">

                                @foreach($cities[$initial] as $city)
                                <span class="city" id="{{$city->code}}">{{$city->city_name}}</span>
                                @endforeach

                        </div>

                    </div>
                    @endif
                @endforeach
            </div>
            @endforeach
        </div>


        <h3 class="ui horizontal divider header destination-divider">
            <i class="tag icon"></i>
            目的地详情
        </h3>


        <form id="destinationInfoForm" enctype="multipart/form-data" >

            <input type="hidden" id="code" name="code">
            <input type="hidden" id="code" name="imageType" value="2">
            <div class="city-info">
                <div class="city-line-detail">
                    <label>目的地名字:</label>
                    <input type="text" disabled="disabled" id="name"/>
                </div>

                <div class="city-line-detail">
                    <label>目的地名字(英文):</label>
                    <input type="text"  name="nameEn" id="nameEn"/>
                </div>

                <div class="city-line-detail">
                    <label>酒店数量:</label>
                    <input type="text"  name="numOfHotel" id="numOfHotel"/>
                </div>



                <div class="city-line-detail">
                    <label>目的地描述:</label>
                    <textarea id="description" name="description"></textarea>
                </div>




                <div class="city-line-detail">
                    <label>目的地描述(英文):</label>
                    <textarea id="descriptionEn" name="descriptionEn"></textarea>
                </div>



                <div class="city-line-detail">
                    <label>目的地图片</label>
                    <img id="pic" src="" >
                    <input id="upload" name="file" id="file" accept="image/*" type="file" />
                </div>


                <div class="city-line-detail">
                    <label>状态开启:</label>
                    <input type="checkbox" name="status" id="status"/>
                </div>

                <div class="city-line-detail">
                    <label>设为热门:</label>
                    <input type="checkbox" name="is_hot" id="is_hot"/>
                </div>

                <div class="regular-btn red-btn auto-margin" id="submit">保存</div>
            </div>
        </form>

    </div>
@stop

@section('script')
    <script type="text/javascript">




        //建立一個可存取到該file的url
        function getObjectURL(file) {
            var url = null ;
            if (window.createObjectURL!=undefined) { // basic
                url = window.createObjectURL(file[0]) ;
            } else if (window.URL!=undefined) { // mozilla(firefox)
                url = window.URL.createObjectURL(file[0]) ;
            } else if (window.webkitURL!=undefined) { // webkit or chrome
                url = window.webkitURL.createObjectURL(file[0]) ;
            }

            return url ;
        }


        $(document).ready(function(){
            $('#city_a_e').show();

            //点击字母分类切换
            $(document).on('click','.d-c-caption>span',function(){

                $(this).addClass('active').siblings('span').removeClass('active');



                $initialGroupId = $(this).attr('id').split('-')[1];

                $('#city_'+$initialGroupId).show().siblings('.d-city-section').hide();


            });



            $('.city').click(function(){

                $('.city').removeClass('selected-city');
                $(this).addClass('selected-city');//.siblings('span').removeClass('selected-city');
                $('#code').val($(this).attr('id'));
                $('#name').val($(this).text());


                var file = $('#file');
                file.after(file.clone().val(""));
                file.remove();
                $('#file').val('');


                $.ajax({
                    type: 'POST',
                    url: '/admin/system/getDestinationInfo',
                    data: {code :$(this).attr('id')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success : function(data){
                        if(data.statusCode === 1)
                        {


                            $('#nameEn').val(data.extra.city_name_en);

                            if(parseInt(data.extra.status)===0)
                            {
                                $('#status').prop('checked',false);
                            }
                            else{
                                $('#status').prop('checked',true);
                            }
                            if(parseInt(data.extra.is_hot)===0)
                            {
                                $('#is_hot').prop('checked',false);
                            }
                            else{
                                $('#is_hot').prop('checked',true);
                            }
                            $('#numOfHotel').val(data.extra.num_of_hotel);
                            $('#description').val(data.extra.description);
                            $('#descriptionEn').val(data.extra.description_en);
                            $('#pic').attr('src',data.extra.cover_image);

                        }
                        else{

                            $('#nameEn').val('');
                            $('#status').prop('checked',false);
                            $('#is_hot').prop('checked',false);
                            $('#numOfHotel').val('');
                            $('#description').val('');
                            $('#descriptionEn').val('');
                            $('#pic').attr('src','');
                        }

                    }
                });


            })

            $("#pic").click(function () {

                $("#upload").click();               //隐藏了input:file样式后，点击头像就可以本地上传
            });
            $("#upload").on("change",function(){
                var objUrl = getObjectURL(this.files) ;  //获取图片的路径，该路径不是图片在本地的路径

                if (objUrl) {
                    $("#pic").attr("src", objUrl) ;      //将图片路径存入src中，显示出图片
                }
            });



            //提交目的地信息

            $('#submit').click(function(){

                if($('#name').val() === '')
                {
                    toastAlert('请选择一个城市',2);
                    return;
                }


                $("#destinationInfoForm").ajaxSubmit({
                    url: '/admin/system/saveDestinationInfo',
                    type: 'post',
                    dataType: 'json',
                    encoding: "UTF-8",


                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    beforeSend:function(){

                    },
                    success: function (data) {
                        if(data.statusCode===1)
                        {
                            toastAlert(data.statusMsg,1);
                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                    },
                    error:function(data){
                    }
                });

            })

         })








    </script>
@stop