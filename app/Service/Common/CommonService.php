<?php
namespace App\Service\Common;

use App\Models\Country;
use App\Models\InternationalCity;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Tool\MessageResult;
use Illuminate\Support\Facades\DB;

class CommonService {

    //获取省份城市地区数据
    public function getGeoDetail()
    {
        $region['province'] = Province::all();
        $region['city'] = City::all();
        $region['district'] = District::all();

        $region['internationalCity'] = DB::table('international_city')->join('country','country.code','=','international_city.country_code')->select('international_city.*','country.name')->get();
        $jsonResult = new MessageResult();
        $jsonResult->extra = $region;
        return $jsonResult->toJson();
    }

    /*
    *  level = city|province|district
    */
    public function getAdressInfo($level = '' , $code = 110000, $type)

    {

        if ($level == '') {
            return false;
        }
        $info = '';
        switch ($level) {
            case 'city':
                if($type==1)
                    $info = City::select('city_name')->where('code',$code)->first()->city_name;
                else
                    $info = InternationalCity::select('city_name')->where('code',$code)->first()->city_name;
                break;
            case 'province':
                if($type==1)
                    $info = Province::select('province_name')->where('code',$code)->first()->province_name;
                else
                    $info = Country::select('name')->where('code',$code)->first()->name;
                break;
            case 'district':
                if($type==1)
                    $info = District::select('district_name')->where('code',$code)->first()->district_name;
                else
                    $info ='';
                break;
            default:
                $info = "未知";
                break;
        }

        return $info;


    }



}


