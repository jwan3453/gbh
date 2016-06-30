@extends('Admin.site')

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

@section('content')
<div class="h-c-steps">
    <div class="step s-active ">1</div>
    <div class="s-line s-l-active "></div>
    <div class="s-line  s-l-active"></div>
    <div class="step s-active">2</div>
    <div class="s-line  s-l-active"></div>
    <div class="s-line"></div>
    <div class="step">3</div>
    <div class="s-line"></div>
    <div class="s-line"></div>
    <div class="step">4</div>
</div>
<form id="hotelBasicInfo" action='{{url("/admin/manageHotel/insertPolicy")}}' method="Post">
    <input type="hidden" value="{{csrf_token()}}" name="_token"/>
    <input type="hidden" value="{{$hotelId}}" name="hotelId" />
    <input type="hidden" value="{{$hotelInfo->hotelPolicy->id}}" name="policyId" id="policyId" />
    <input type="hidden" value="{{$createOrUpdate}}" id="createOrupdate" name="createOrupdate" />
    <div class="geoLocation-box">

        <div class="geoLocation-title">
            <div class="geoLocation-title-font">附近交通</div>
        </div>

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
            @foreach($hotelInfo->itemArr as $item)
            <span class="height-40">{{$item}}</span>
            @endforeach
            <div class="add-surrounding-btn" onclick="addSurrounding()">
                <img src="/Admin/icon/add.png">添加更多</div>
            <input type="hidden" name="surrounding" id="surrounding" value="{{$hotelInfo->surrounding_environment}}" />
        </div>

    </div>

    <div class="hotel-policy-box">
        <div class="hotel-policy-title">
            <div class="hotel-policy-title-font">酒店政策</div>
        </div>

        <div class="hotel-policy-row height-40">
            <span class="policy-title-font float-left">入住时间</span>
            <select class="ui dropdown hotel-policy-input float-left margin-right-10" name="checkTimeFrom">
                <option value="">00 : 00</option>
            </select>

            <span class="policy-tips-font float-left">至</span>

            <select class="ui dropdown hotel-policy-input float-left margin-right-10" name="checkTimeTo">
                <option value="">--:--</option>
            </select>

            <span class="policy-tips-font float-left">入住时间决定用户从几时开始算第一天的时间</span>
        </div>

        <div class="hotel-policy-row height-40">
            <span class="policy-title-font float-left">离店时间</span>
            <select class="ui dropdown hotel-policy-input float-left margin-right-10" name="checkoutTimeFrom">
                <option value="">00 : 00</option>
            </select>
            <span class="policy-tips-font float-left">至</span>
            <select class="ui dropdown hotel-policy-input float-left margin-right-10" name="checkoutTimeTo">
                <option value="">--:--</option>
            </select>
            <span class="policy-tips-font float-left">离店时间决定用户从几时开始算第二天的钱</span>
        </div>

        <div class="hotel-policy-row height-80">
            <div class="title-font-box height-40 margin-right-10">
                <span class="policy-title-font float-left">押金预付</span>
            </div>
            <textarea class="hotel-policy-textarea margin-right-10" name="prepaidDeposit">{{$hotelInfo->hotelPolicy->prepaid_deposit}}</textarea>
            <div class="title-font-box height-40">
                <span class="policy-tips-font float-left">在此输入酒店押金入住信息</span>
            </div>
        </div>

        <div class="hotel-policy-row height-80">
            <div class="title-font-box height-40 margin-right-10">
                <span class="policy-title-font float-left">膳食安排</span>
            </div>
            <textarea class="hotel-policy-textarea margin-right-10" name="cateringArrangements">{{$hotelInfo->hotelPolicy->catering_arrangements}}</textarea>
            <div class="title-font-box height-40">
                <span class="policy-tips-font float-left">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>
            </div>
        </div>

        <div class="hotel-policy-row height-80">
            <div class="title-font-box height-40 margin-right-10">
                <span class="policy-title-font float-left">其他政策</span>
            </div>
            <textarea class="hotel-policy-textarea margin-right-10" name="otherPolicy">{{$hotelInfo->hotelPolicy->other_policy}}</textarea>
            <div class="title-font-box height-40">
                <span class="policy-tips-font float-left">酒店其他政策，包括加床，儿童床等</span>
            </div>
        </div>

        <div class="hotel-policy-row height-80">
            <div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
        </div>
    </div>

</form>

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

<div class="edit-add-box modal ui" id="addSurrounding">
    <div class="edit-add-title">
        <span class="title-font margin-left-20">添加周边环境</span>
    </div>

    <div class="edit-add-content">
        <div class="content-colmun">
            <div class="content-colmun-left">
                <label>名称</label>
                <input type="text" name="surroundingName" id="surroundingName" class="content-input overall-length"></div>
        </div>

        <div class="content-button-colmun">
            <div class="currency-btu" onclick="surroundingInsert()">
                <span>确认添加</span>
            </div>
        </div>

    </div>
</div>
@stop


@section('script')
<script type="text/javascript">
    $(function(){
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


        var j = 0;
        var s = '';
        for (var i = 1; i < 48; i++) {
            if (i % 2 == 0) {
                j = parseInt(j) + 1;
                s = j + " : 00";
            }else{
                s = j + " : 30";
            }
            $(".hotel-policy-input > select").append("<option>"+s+"</option>")
        }

    })

    $('.ui.dropdown').dropdown();

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

    function addSurrounding() {
        $('#addSurrounding').modal({
            closable  : true,
            onHide : function() {
                $("#surroundingName").val("");
            }
        }).modal('show');
    }

    function surroundingInsert() {
        var surroundingName = $("#surroundingName").val();
        var a = '<span class="height-40">'+surroundingName+'</span>';

        $(".add-surrounding-btn").before(a);

        var data = $("#surrounding").val();

        if (data == '') {
            $("#surrounding").val(surroundingName);
        }else{
            var s = data + "|" + surroundingName;
            $("#surrounding").val(s);
        }

        $('#addSurrounding').modal({
            closable  : true,
            onHide : function() {
                $("#surroundingName").val("");
            }
        }).modal('hide');
    }

    $('#nsBtn').click(function(){

        $('#hotelBasicInfo').submit();

    })

</script>
@stop