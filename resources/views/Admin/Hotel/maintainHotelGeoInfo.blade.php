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

            <div class="header">附近交通</div>

            <div class="map-information-row">
                    <div class="map-box" id="map"></div>
                    <div class="map-information-box">
                        <div class="hotel-address">
                            <span class="title-font">酒店地址</span>
                            <span class="small-font down">{{$address}}</span>
                        </div>

                        <div class="longitude-latitude-box">
                            <span class="title-font">经纬度</span>
                            <span class="small-font down" id="longitudeAndlatitude">{{$address}}</span>
                            <input type="hidden" name="longitude" id="longitudeInput" value="" />
                            <input type="hidden" name="latitude" id="latitudeInput" value="" />
                        </div>

                        <div class="manual-locate-btn" onclick="manualMap()">
                            <img src="/Admin/icon/locate.png" />
                            手动定位
                        </div>

                    </div>
                </div>

            <div class="surrounding-environment">
                    <span class="height-40">周边环境  :</span>

                    @if(count($hotelSurrounding)> 0)
                    <table class="ui primary striped selectable table hotel-surrounding-table " >
                        <thead>
                        <tr>
                            <th>名称</th>
                            <th>名称(英文)</th>
                            <th>距离</th>
                            <th>出租车</th>
                            <th>步行</th>
                            <th>公交线路</th>
                            <th>地铁</th>
                            <th>操作</th>
                        </tr>
                        </thead>
                        <tbody id="surroundingTableBody">
                        @foreach($hotelSurrounding as $surrounding)
                            <tr>

                                <td class="s-name"><span>{{$surrounding->name}}</span></td>
                                <td class="s-name-en"><span>{{$surrounding->name_en}}</span></td>
                                <td class="s-distance"><span>{{$surrounding->distance}}</span> km</td>
                                <td class="s-taxi"><span>{{$surrounding->by_taxi}}</span> 分钟</td>
                                <td class="s-walk"><span>{{$surrounding->by_walk}}</span> 分钟</td>
                                <td class="s-bus"><span>{{$surrounding->by_bus}}</span> 路</td>
                                <td class="s-sub"><span>{{$surrounding->by_sub}}</span> 线</td>
                                <td>
                                    <input type="hidden" class="surround-item" value="{{$surrounding->id}}">
                                    <span class="delete-surrounding-item">删除</span>
                                    <span  class="edit-surrounding-item">编辑</span>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @endif
                    <div class="add-surrounding-btn" id="addSurroundingBtn">
                        <img src="/Admin/icon/add.png">添加更多</div>
                    {{--<input type="hidden" name="surrounding" id="surrounding" value="{{$hotelInfo ==null?'':$hotelInfo->surrounding_environment}}" />--}}
                </div>

        </div>

        <div class="edit-add-box modal ui" id="manualMap">
            <div class="edit-add-title">
                <span class="title-font margin-left-20">手动定位</span>
            </div>

            <div class="edit-add-content">
                <div class="content-colmun">
                    <div class="content-colmun-left">
                        <label>经度</label>
                        <input type="text" name="longitude" id="longitude" class="content-input overall-length"></div>
                </div>

                <div class="content-colmun field">
                    <label>纬度</label>
                    <input type="text" name="latitude" id="latitude" class="content-input overall-length"></div>

                <div class="content-button-colmun">
                    <div class="currency-btu" onclick="orientate()">
                        <span>确认添加</span>
                    </div>
                </div>

            </div>
        </div>

        <div class="ui page dimmer confirm-request">


                <h3>是否删除该周边项目</h3>
                <div class="confirm-btns">
                    <div class="regular-btn blue-btn confirm">
                        确定
                        <div class="ui active inline  small  loader" id="loader"></div>
                    </div>
                    <div class="regular-btn red-btn cancel">取消</div>
                </div>

        </div>

        <div class="edit-add-box modal ui" id="addSurrounding">
            <div class="edit-add-title">
                <span class=" margin-left-20">添加周边环境</span>
            </div>

            <div class="add-surrounding-box ">
                <form id="surroundingForm" method="post" >

                    <input type="hidden" value="{{$hotelId}}" name="hotelId"/>
                    <input type="hidden" value="" name="surroundingId" id="surroundingId"/>
                    <input type="hidden" value="create" name="createOrUpdate" id="createOrUpdate"/>
                    <div class="add-surrounding-input-box" >
                        <label>名称</label>
                        <input type="text" name="name" id="name" >

                    </div>

                    <div class="add-surrounding-input-box" >
                        <label>名称(英文)</label>
                        <input type="text" name="nameEn" id="nameEn" >
                    </div>
                    <div class="add-surrounding-input-box">
                        <label>距离</label>
                        <input type="text" name="distance" id="distance" >
                        <span>km</span>
                    </div>
                    <div class="add-surrounding-input-box">
                        <label>出租车</label>
                        <input type="text" name="byTaxi" id="byTaxi" placeholder="打车所需时间">
                        <span>分钟</span>
                    </div>
                    <div class="add-surrounding-input-box">
                        <label>步行</label>
                        <input type="text" name="byWalk" id="byWalk" placeholder="步行所需时间">
                        <span>分钟</span>
                    </div>
                    <div class="add-surrounding-input-box">
                        <label>公交</label>
                        <input type="text" name="byBus" id="byBus" placeholder="乘坐线路，逗号隔开" >
                        <span>线路</span>
                    </div>
                    <div class="add-surrounding-input-box">
                        <label>地铁</label>
                        <input type="text" name="bySub" id="bySub" placeholder="乘坐线路，逗号隔开" >
                        <span>线路</span>
                    </div>

                </form>


                    <div class="confirm-surrounding-btn auto-margin">
                       提交
                    </div>


            </div>
        </div>

    </div>
@stop


@section('infoScript')
    <script type="text/javascript">
    $(document).ready(function(){
            var map = new BMap.Map("map");
            var localSearch = new BMap.LocalSearch(map);
            map.clearOverlays();//清空原来的标注
            var keyword = "{{$address}}";
            localSearch.setSearchCompleteCallback(function (searchResult) {
                var poi = searchResult.getPoi(0);
                $("#longitudeAndlatitude").html(poi.point.lng + "  &nbsp;&nbsp;&nbsp;&nbsp;  " + poi.point.lat);
                $("#longitudeInput").val(poi.point.lng);
                $("#latitudeInput").val(poi.point.lat);
                var point = new BMap.Point(poi.point.lng, poi.point.lat);
                var marker = new BMap.Marker(point);
                map.addOverlay(marker);
                map.centerAndZoom(point, 20);
            });
            localSearch.search(keyword);



        function manualMap() {
            $('#manualMap').modal({
                closable  : true,
                onHide : function() {
                    $("#longitude").val("");
                    $("#latitude").val("");
                }
            }).modal('show');
        }

        function orientate() {
            var longitude = $("#longitude").val();
            var latitude = $("#latitude").val();
            var map = new BMap.Map("map");
            var point = new BMap.Point(longitude, latitude);
            var marker = new BMap.Marker(point);
            map.addOverlay(marker);
            map.centerAndZoom(point, 20);

            $("#longitudeAndlatitude").html(longitude + "  &nbsp;&nbsp;&nbsp;&nbsp;  " + latitude);

            $("#longitudeInput").val(longitude);
            $("#latitudeInput").val(latitude);

            $('#manualMap').modal({
                closable  : true,
                onHide : function() {
                    $("#longitude").val("");
                    $("#latitude").val("");
                }
            }).modal('hide');
        }


        //删除确认框
        var deleteItem;
        $(document).on('click','.delete-surrounding-item',function(){

            deleteItem = $(this);
            $('#surroundingId').val($(this).siblings('.surround-item').val());
            $('.confirm-request').dimmer('show');
        })

        $('.cancel').click(function(){
            $('.confirm-request').dimmer('hide');
        })

        $('.confirm').click(function(){
            $.ajax({
                type: 'POST',
                url: '/admin/manageHotel/hotelInfo/deleteSurroundingItem',
                data: {surroundingId :$('#surroundingId').val()},
                dataType: 'json',

                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success : function(data){
                    if(data.statusCode === 1)
                    {
                        //动态删除项目
                        deleteItem.parents('tr').remove();
                        toastAlert(data.statusMsg,1);
//                        toastAlert('处理完成');

                    }
                    else{
                        toastAlert(data.statusMsg,2);
                    }
                    $('.confirm-request').dimmer('hide');
                }
            })
        })

        //弹出输入框
        $('#addSurroundingBtn').click(function(){

            $('#createOrUpdate').val('create');

            $('#surroundingForm').find('input[type=text]').val('') ;

            $('#addSurrounding').modal({
                closable  : true,
                onHide : function() {
                    $("#surroundingName").val("");
                }
            }).modal('show');

        })

        //编辑周边项目
        var editItem;
        $(document).on('click','.edit-surrounding-item',function(){
            editItem = $(this);
            $('#createOrUpdate').val('update');
            $('#surroundingId').val($(this).siblings('.surround-item').val());
            $('#name').val($(this).parent().siblings('.s-name').find('span').text());
            $('#nameEn').val($(this).parent().siblings('.s-name-en').find('span').text());
            $('#distance').val($(this).parent().siblings('.s-distance').find('span').text());
            $('#byTaxi').val($(this).parent().siblings('.s-taxi').find('span').text());
            $('#byWalk').val($(this).parent().siblings('.s-walk').find('span').text());
            $('#byBus').val($(this).parent().siblings('.s-bus').find('span').text());
            $('#bySub').val($(this).parent().siblings('.s-sub').find('span').text());



            $('#addSurrounding').modal({
                closable  : true
            }).modal('show');

        })


        //提交或更新周边项目
        $('.confirm-surrounding-btn').click(function(){

            var options = {
                url: '/admin/manageHotel/hotelInfo/createOrUpdateSurrounding',
                type: 'post',
                dataType: 'json',
                encoding: "UTF-8",
                data: decodeURIComponent( $("#surroundingForm").serialize(),true),
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
                            var html ='<tr>'+
                                    '<td class="s-name"><span>'+$('#name').val()+'</span></td>'+
                                    '<td class="s-name-en"><span>'+$('#nameEn').val()+'</span></td>'+
                                    '<td class="s-distance"><span>'+ $('#distance').val()+'</span>km</td>'+
                                    '<td class="s-taxi"><span>'+$('#byTaxi').val()+'</span>分钟</td>'+
                                    '<td class="s-walk"><span>'+$('#byWalk').val()+'</span>分钟</td>'+
                                    '<td class="s-bus"><span>'+$('#byBus').val()+'</span>路</td>'+
                                    '<td class="s-sub"><span>'+$('#bySub').val()+'</span>线</td>'+
                                    '<td>'+
                                    '<input type="hidden" class="surround-item" value="'+data.extra+'">'+
                                    '<span class="delete-surrounding-item">删除</span>'+
                                    '<span  class="edit-surrounding-item">编辑</span>'+
                                    '</td>'+
                                    '</tr>';
                            $('#surroundingTableBody').append(html);

                        }
                        else if($('#createOrUpdate').val() === 'update')
                        {
                            //动态更新项目
                            editItem.parent().siblings('.s-name').find('span').text($('#name').val());
                            editItem.parent().siblings('.s-name-en').find('span').text($('#nameEn').val());
                            editItem.parent().siblings('.s-distance').find('span').text($('#distance').val());
                            editItem.parent().siblings('.s-taxi').find('span').text($('#byTaxi').val());
                            editItem.parent().siblings('.s-walk').find('span').text($('#byWalk').val());
                            editItem.parent().siblings('.s-bus').find('span').text($('#byBus').val());
                            editItem.parent().siblings('.s-sub').find('span').text($('#bySub').val());
                        }
                    }
                    else{
                        toastAlert(data.statusMsg,2);
                    }
                    $('#addSurrounding').modal({
                        closable  : true,
                        onHide : function() {
                            $("#surroundingName").val("");
                        }
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










