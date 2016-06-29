@extends('Admin.site')



@section('content')

    {{--@foreach($geoData['province'] as $province)--}}
        {{--
<div>{{$province->parent_id}}</div>
--}}
    {{--@endforeach--}}
<div id="geoData" style="display: none">{{$geoData}}</div>
<div>
    <div class="h-c-steps">
        <div class="step s-active ">1</div>

        <div class="s-line s-l-active "></div>
        <div class="s-line"></div>
        <div class="step">2</div>
        <div class="s-line"></div>
        <div class="s-line"></div>
        <div class="step">3</div>
        <div class="s-line"></div>
        <div class="s-line"></div>
        <div class="step ">4</div>

    </div>

    <div class="hotel-info  hotel-basic-info">
        <div class="header">酒店基本信息</div>

        <form class="detail-form" id="hotelBasicInfo" action='{{url("/admin/manageHotel/create")}}' method="Post">

            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
            <div class="short-input-box ">
                <label>酒店名称</label>
                <input type="text" id="hotelName" name="hotelName" value="{{$hotelInfo->hotel_name}}">
                <span>请输入酒店的英文名</span>
            </div>

            <div class="long-input-box ">
                <label>省份城市</label>
                <input type="text" id="province"  autocomplete="off">
                <input type="hidden" id="provinceCode" name="provinceCode">
                <input type="hidden" id="cityCode" name="cityCode">
                <input type="hidden" id="districtCode" name="districtCode">
                <span>请输入酒店所在省份城市区域</span>
            </div>

            <div class="long-input-box ">
                <label>具体地址</label>
                <input type="text" name="hotelAddress">
                <span>请输入酒店的具体地址</span>
            </div>
            <div class="short-input-box ">
                <label>邮编</label>
                <input type="text" name="hotelPostcode" onchange="number(this)">
                <span>请输入酒店所在地区的邮编</span>
            </div>
            <div class="short-input-box ">
                <label>传真</label>
                <input type="text" name="hotelFax" onchange="faxphone(this)">
                <span>请输入酒店的传真</span>
            </div>
            <div class="short-input-box ">
                <label>固话</label>
                <input type="text" name="hotelPhone" onchange="faxphone(this)">
                <span>请输入酒店固定电话</span>
            </div>
            <div class="long-input-box ">
                <label>网址</label>
                <input type="text" name="hotelWebsite">
                <span>请输入酒店的网址</span>
            </div>
            <div class="short-input-box ">
                <label>客房数</label>
                <input type="text" name="hotelTotalRooms" onchange="number(this)">
                <span>请输入酒店的客房总数</span>
            </div>
            <div class="long-input-box ">
                <label>特色</label>
                <input type="text" name="hotelFeature">
                <span>请输入酒店的特色</span>
            </div>
            <div class="long-input-box ">
                <label>酒店简介</label>
                <textarea name="hotelBrief"></textarea>
                <span>请输入酒店的简介</span>
            </div>

            <div class="long-input-box ">
                <label>酒店封面</label>

                <span>请输入酒店的简介</span>
            </div>

        </form>

        <div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
    </div>

</div>
@stop

@section('script')
<script>

        $.fn.gbhCityChooser = function(e)
        {

            var obj = $(this);
            var geoData = $.parseJSON($('#geoData').html());

            var provinceList = geoData.extra.province;
            var cityList = geoData.extra.city;
            var districtList = geoData.extra.district;
            var $container = setupContainer();
            var $searchContainer = setupSearchContainer();

            obj.readOnly=true;
            var offset = obj.offset();
            var height = obj.height();
            var width = obj.width();
            var cont_top = offset.top + height;
            var cont_left = offset.left;
            var selectedProvince='';
            var selectedProvinceId = 0;

            var selectedCity ='';
            var selectedCityId =0

            var selectedDistrict='';
            var selectedDistrictId = 0;

            $container.appendTo($("body")).css({
                'top': cont_top + 5,
                'left': cont_left,
                'width':300,
//            'color': 'rgba(6, 148, 204, 0.98)',
                'color': 'black',
                'position':'absolute',
                'display':'none',
                'background':' #f8f8f8',
                'border':'1px solid grey'
            });

            $searchContainer.css('display','none');// = 'none';



            $('#province').keyup(function(){
                if($(this).val()!== '')
                {
                    $container.fadeOut();
                    $searchContainer.appendTo($("body")).css({
                        'top': cont_top + 5,
                        'left': cont_left,
                        'width':300,

//            'color': 'rgba(6, 148, 204, 0.98)',
                        'color': 'black',
                        'position':'absolute',
                        'display':'none',
                        'background':' white',
                        'border':'1px solid grey'
                    })
                    $searchContainer.empty();
                    var searchListCount = 0;
                    for(var i=0; i<districtList.length; i++)
                    {


                        if( (districtList[i].district_name).indexOf($(this).val()) !== -1)
                        {
                            searchListCount++;

                            for(var j=0; j<cityList.length; j++)
                            {

                                if(districtList[i].city_code ===  cityList[j].code )
                                {
                                    //console.log( cityList[j].city_name);

                                    for(var k=0; k<provinceList.length ; k++)
                                    {
                                        if( cityList[j].province_code === provinceList[k].code)
                                        {
                                            searchListCount++;

                                            var html = '<div class="geo-search-line">' +
                                                    '<i class ="icon marker"></i>' +
                                                    '<span class="d" id="'+ districtList[i].code +'">'+districtList[i].district_name+'</span>'+
                                                    '<span class="c" id="'+ cityList[j].code +'">'+cityList[j].city_name+'</span>'+
                                                       '<span  class="p" id="'+ provinceList[k].code +'">'+provinceList[k].province_name +'</span></div>';
                                            $searchContainer.show();
                                            $searchContainer.append(html);
                                        }
                                    }

                                }
                            }



                       }
                    }


                }

            })



            function setupContainer(){

                var container = document.createElement("div");
                var caption = document.createElement("div");
                var province = document.createElement("div");
                var city = document.createElement("div");
                var district = document.createElement('div');

                var $container = $(container).attr("id", "container");
                var $caption = $(caption).attr("id", "caption").addClass('c-caption-section');
                var $province = $(province).attr("id", "provinceSection");
                var $city = $(city).attr("id", "citySection");
                var $district =$(district).attr("id","districtSection");


                var captionHtml = '<span class="active" id="cap_p">省份</span>'+
                        '<span  id="cap_c">城市</span>'+
                        '<span id="cap_d">县/区</span>';
                $caption.append(captionHtml);

                $container.append($caption).append($province).append($city).append($district);
                $province.addClass("province-section");
                $city.addClass("city-section");
                $district.addClass("district-section");



                for(var i=0; i<provinceList.length; i++)
                {
                    if(selectedProvinceId === provinceList[i].code )
                        $('<span class="province geo-selected" id="province_'+provinceList[i].code +'">'+ provinceList[i].province_name+'</span>').appendTo($province);
                    else
                        $('<span class="province" id="province_'+provinceList[i].code +'">'+ provinceList[i].province_name+'</span>').appendTo($province);
                }







//            $("<h1>选择城市</h1>").appendTo($caption);

//            $("<span>关闭</span>").appendTo($caption).click(function(){
//                $container.slideUp(100);
//            });
                return $container;
            }

            function setupSearchContainer(){
                var searchContainer = document.createElement("div");
                var $searchContainer = $(searchContainer).attr("id", "searchContainer");
                return $searchContainer;
            }


            var provinceSection = $('#provinceSection');
            var citySection =  $('#citySection');
            var districtSection=$('#districtSection');




            $('#cap_p').click(function(){


                if($('#provinceSection').css('display') === 'none') {
                    provinceSection.slideToggle();
                    citySection.hide();
                    districtSection.hide();
                    $('#cap_p').addClass('active').siblings('span').removeClass('active');
                }
            })
            $('#cap_c').click(function(){



                if($('#citySection').css('display') === 'none') {
                    if (selectedProvinceId !== 0) {
                        provinceSection.hide();
                        citySection.slideToggle();
                        districtSection.hide();
                        $('#cap_c').addClass('active').siblings('span').removeClass('active');
                    }

                }

            })
            $('#cap_d').click(function(){

                if($('#districtSection').css('display') === 'none') {
                    if (selectedCityId !== 0) {
                        provinceSection.hide();
                        citySection.hide();
                        districtSection.slideToggle();
                        $('#cap_d').addClass('active').siblings('span').removeClass('active');
                    }

                }
            })



            $('.province').click(function(){

                citySection.empty();
                citySection.hide();



                selectedProvinceId = $(this).attr('id').split('_')[1];

                selectedProvince = $(this).text();

                $(this).addClass('geo-selected ').siblings('span').removeClass('geo-selected ');

                for(var i=0; i<cityList.length; i++) {

                    if (parseInt(selectedProvinceId) === parseInt(cityList[i].province_code)) {

                        $('<span class="city" id="city_' + cityList[i].code + "_" + selectedProvinceId + '">' + $.trim(cityList[i].city_name) + '</span>').appendTo(citySection);
                    }
                }
                provinceSection.hide();
                citySection.slideToggle();
                districtSection.hide();

                $('#cap_c').addClass('active').siblings('span').removeClass('active');

            });




            $(document).on('click','.city',function(){

                districtSection.empty();
                districtSection.hide();

                selectedCityId = $(this).attr('id').split('_')[1];
                selectedCity = $(this).text();

                $(this).addClass('geo-selected ').siblings('span').removeClass('geo-selected ');

                for(var i=0; i<districtList.length; i++) {

                    if (parseInt(selectedCityId) === parseInt(districtList[i].city_code)) {

                        $('<span class="district" ' +
                                'id="district_' + districtList[i].code + "_" + selectedCityId + "_" + selectedProvinceId +'\">' +
                                $.trim(districtList[i].district_name) + '</span>').appendTo(districtSection);
                    }
                }

                provinceSection.hide();
                citySection.hide();
                districtSection.slideToggle();

                $('#cap_d').addClass('active').siblings('span').removeClass('active');


            });



            $(document).on('click','.district',function() {

                $(this).addClass('geo-selected ').siblings('span').removeClass('geo-selected ');
                selectedDistrictId = $(this).attr('id').split('_')[1];

                $('#districtCode').val($(this).attr('id').split('_')[1]);
                $('#cityCode').val($(this).attr('id').split('_')[2]);
                $('#provinceCode').val($(this).attr('id').split('_')[3]);
                obj.val(selectedProvince + " - "+ selectedCity + " - " +$(this).text());
//                provinceSection.show();
//                citySection.hide();
//                districtSection.hide();
                $container.fadeOut(200);

            })

            $(document).on('click','.geo-search-line',function(){



                $('#province').val($.trim($(this).find('.p').text())+' - '
                                    +$.trim($(this).find('.c').text()) + ' - '
                                    +$.trim($(this).find('.d').text()) );
                $('#provinceCode').val($.trim($(this).find('.p').attr('id')));


                $('#cityCode').val($.trim($(this).find('.c').attr('id')));


                $('#district').val($.trim($(this).find('.d').attr('id')));

                $searchContainer.hide();

            })


            $(document).bind("click",function(e){

                e = e || window.event;
                var target = $(e.target);
                if(target.closest($container).length == 0 && target.closest($('#province')).length == 0){
                    if($container.css('display') !== 'none')
                    {

                        $container.hide ();
                    }
                }
                if(target.closest($searchContainer).length == 0){
                    if($searchContainer.css('display') !== 'none')
                    {

                        $searchContainer.hide ();
                    }
                }


            });

            $(this).focus(function(){

                if($container.css('display') === 'none')//
                {

                    if($searchContainer.css('display') ==='none' ) {


                        setTimeout(function () {
                            $container.fadeIn();
                        }, 100);

                    }
                }

            });

        }



        $(document).ready(function(){

            $('#province').gbhCityChooser();
         //   $('#city').gbhCityChooser();

            $('#nsBtn').click(function(){
                var isSubmit = false;
                $("form").find(":text").each(function(i){
                    if ( $(this).val() ) {
                        isSubmit = true;
                    }
                    if ( !$(this).val() ) {
                        alert($(this).prev().html() + "   不能为空");
                        isSubmit = false;
                        return false;
                    }

                })

                if (isSubmit) {
                    $('#hotelBasicInfo').submit();
                }

            })

        })

        function number(_this) {
            console.log($(_this).val());
            var val = $(_this).val();
            var re = /^[0-9]*[1-9][0-9]*$/ ; 

            if (re.test(val)) {
                return true;
            }else{
                $(_this).val("");
                alert("只能为数字");
                return false;
            }
        }


        function faxphone(_this) {
            var re = /^(\d{0,10}-)?\d{0,10}$/;
            var val = $(_this).val();

            if (re.test(val)) {
                return true;
            }else{
                $(_this).val("");
                alert("格式为 XXXX-XXXXXXXXXXX");
                return false;
            }
        }



   </script>
@stop