@extends('Admin.site')

@section('resources')
<script type="text/javascript" src="http://api.map.baidu.com/api?v=1.3"></script>
@stop

@section('content')
<div class="h-c-steps">
  <div class="step s-active ">1</div>
  <div class="s-line s-l-active "></div>
  <div class="s-line  s-l-active"></div>
  <div class="step s-active">2</div>
  <div class="s-line  s-l-active"></div>
  <div class="s-line  s-l-active"></div>
  <div class="step s-active">3</div>
  <div class="s-line "></div>
  <div class="s-line "></div>
  <div class="step ">4</div>
</div>

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
        <span class="small-font down">{{$address}}</span>
      </div>

      <div class="manual-locate-btn">
        <img src="/Admin/icon/locate.png" />
        手动定位
      </div>

    </div>
  </div>

  <div class="surrounding-environment">
      <span>周边环境 : </span>
      <input type="text" class="scenic-spot" />

      <div class="manual-locate-btn">
        <img src="/Admin/icon/add.png" />
        添加更多
      </div>
  </div>

</div>

<div class="hotel-policy-box">
    <div class="hotel-policy-title">
        <div class="hotel-policy-title-font">酒店政策</div>
    </div>

    <div class="hotel-policy-row height-40">
        <span class="policy-title-font float-left">入住时间</span>
        <div class="hotel-policy-input margin-right-10 float-left" >
          <span class="policy-input-font">12:00</span>
          <img src="/Admin/icon/drop-down.png">
        </div>
        <span class="policy-tips-font float-left">至</span>
        <div class="hotel-policy-input margin-right-10 float-left" >
          <span class="policy-input-font">--:--</span>
          <img src="/Admin/icon/drop-down.png">
        </div>
        <span class="policy-tips-font float-left">入住时间决定用户从几时开始算第一天的时间</span>
    </div>

    <div class="hotel-policy-row height-40">
        <span class="policy-title-font float-left">离店时间</span>
        <div class="hotel-policy-input margin-right-10 float-left" >
          <span class="policy-input-font">12:00</span>
          <img src="/Admin/icon/drop-down.png">
        </div>
        <span class="policy-tips-font float-left">至</span>
        <div class="hotel-policy-input margin-right-10 float-left" >
          <span class="policy-input-font">--:--</span>
          <img src="/Admin/icon/drop-down.png">
        </div>
        <span class="policy-tips-font float-left">离店时间决定用户从几时开始算第二天的钱</span>
    </div>

    <div class="hotel-policy-row height-80">
      <div class="title-font-box heihht-40 margin-right-10">
        <span class="policy-title-font float-left">押金预付</span>
      </div>
      <textarea class="hotel-policy-textarea margin-right-10"></textarea>
      <div class="title-font-box heihht-40">
        <span class="policy-tips-font float-left">在此输入酒店押金入住信息</span>
      </div>
    </div>

    <div class="hotel-policy-row height-80">
      <div class="title-font-box heihht-40 margin-right-10">
        <span class="policy-title-font float-left">膳食安排</span>
      </div>
      <textarea class="hotel-policy-textarea margin-right-10"></textarea>
      <div class="title-font-box heihht-40">
        <span class="policy-tips-font float-left">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>
      </div>
    </div>

    <div class="hotel-policy-row height-80">
      <div class="title-font-box heihht-40 margin-right-10">
        <span class="policy-title-font float-left">其他政策</span>
      </div>
      <textarea class="hotel-policy-textarea margin-right-10"></textarea>
      <div class="title-font-box heihht-40">
        <span class="policy-tips-font float-left">酒店其他政策，包括加床，儿童床等</span>
      </div>
    </div>

    <div class="hotel-policy-row height-80">
      <div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
    </div>
</div>
@stop


@section('script')
<script type="text/javascript">
  $(function(){
    var map = new BMap.Map("map");
        var point = new BMap.Point('118.102058', '24.494934');
        map.centerAndZoom(point, 20);

        var marker = new BMap.Marker(point);  // 创建标注

        map.addOverlay(marker);               // 将标注添加到地图中
        marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        map.enableScrollWheelZoom(true); //设置鼠标滚轮

        // var map = new BMap.Map("container");
        // map.centerAndZoom("厦门", 12);
        // var localSearch = new BMap.LocalSearch(map);
        // localSearch.enableAutoViewport(); //允许自动调节窗体大小
        // function searchByStationName() {
        //     map.clearOverlays();//清空原来的标注
        //     var keyword = document.getElementById("address").value;
        //     localSearch.setSearchCompleteCallback(function (searchResult) {
        //         var poi = searchResult.getPoi(0);
        //         // document.getElementById("result_").value = poi.point.lng + "," + poi.point.lat;
        //         $("#longitude").val(poi.point.lng);
        //         $("#latitude").val(poi.point.lat);
        //         // map.centerAndZoom(poi.point, 13);
        //         // var marker = new BMap.Marker(new BMap.Point(poi.point.lng, poi.point.lat));  // 创建标注，为要查询的地方对应的经纬度
        //         // map.addOverlay(marker);
        //         // var content = document.getElementById("address").value + "<br/><br/>经度：" + poi.point.lng + "<br/>纬度：" + poi.point.lat;
        //         // var infoWindow = new BMap.InfoWindow("<p style='font-size:14px;'>" + content + "</p>");
        //         // marker.addEventListener("click", function () { this.openInfoWindow(infoWindow); });
        //         // marker.setAnimation(BMAP_ANIMATION_BOUNCE); //跳动的动画
        //     });
        //     localSearch.search(keyword);
        // }
  })
</script>
@stop