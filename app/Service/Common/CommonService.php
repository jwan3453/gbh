<?php
namespace App\Service\Common;

use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Tool\MessageResult;


class CommonService {

    //获取省份城市地区数据
    public function getGeoDetail()
    {
        $region['province'] = Province::all();
        $region['city'] = City::all();
        $region['district'] = District::all();

        $jsonResult = new MessageResult();
        $jsonResult->extra = $region;
        return $jsonResult->toJson();
    }



}


