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

    /*
    *  level = city|province|district
    */
    public function getAdressInfo($level = '' , $code = 110000)
    {
        if ($level == '') {
            return false;
        }
        $info = '';
        switch ($level) {
            case 'city':
                $info = City::select('city_name')->where('code',$code)->first()->city_name;
                break;
            case 'province':
                $info = Province::select('province_name')->where('code',$code)->first()->province_name;
                break;
            case 'district':
                $info = District::select('district_name')->where('code',$code)->first()->district_name;
                break;
            default:
                $info = "未知";
                break;
        }

        return $info;


    }



}


