<?php
namespace App\Service\Common;

use App\Models\Country;
use App\Models\InternationalCity;
use App\Models\MenuSetting;
use App\Models\Province;
use App\Models\City;
use App\Models\District;
use App\Models\Role\AdminUser;
use App\Models\Role\Permission;
use App\Models\Role\PermissionRole;
use App\Models\Role\RoleUser;
use App\Tool\MessageResult;
use Illuminate\Support\Facades\DB;

use App\Models\Role\Role;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;

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


    public function getCurrentUser(){

        return Session::get('adminusername');

    }

    public function checkWhereRole($getSession){

        $user = AdminUser::where('username',$getSession)->first();

        $hasRole= RoleUser::where('user_id',$user->user_id)->first();

        $role = Role::where('id',$hasRole->role_id)->first();

        return $role;

    }

    public function checkInRole($userInfo,$currentRole){

        return $userInfo->hasRole($currentRole);

    }

    public function checkInUser($getCurrentUser){

        return AdminUser::where('username',$getCurrentUser)->first();

    }

    public function checkIsRole($userInfo){

        return $userInfo->hasRole('admin');

    }

    public function checkIsPermArticle($userInfo){

        return $userInfo->may('文章管理');

    }

    public function checkIsPermHotel($userInfo){

        return $userInfo->may('酒店管理');

    }

    public function checkIsPermRoomStatus($userInfo){

        return $userInfo->may('房态管理');

    }

    public function checkIsPermRoomPrice($userInfo){

        return $userInfo->may('房价管理');

    }

    public function checkIsPermSystems($userInfo){

        return $userInfo->may('系统配置');

    }

    public function getPermissions($role_id){

        return PermissionRole::where('role_id',$role_id)->get();

    }

    public function getMenuInfo(){

        return MenuSetting::where('menu_level',1)->get();

    }

    public function checkAdminUser(Request $request){

        return AdminUser::where('username',$request->input('username'))->first();

    }






    //--------面包屑导航----
    public function getCurrentUrl(){

        $getUrl  = Session::get('currentPath_');

        //是否有其它参数:
        $strPos = strpos($getUrl,'?',0);
        if($strPos){
            return substr($getUrl,13,$strPos-13);
        }

        return substr($getUrl,13);

    }

    public function getMenuName($currentUrl){

        return MenuSetting::where('menu_chaining',$currentUrl)->first();

    }

    public function firstMenuName($getMenuName){

        return MenuSetting::where('id',$getMenuName->parent_id)->first();

    }
    //将地址存入Session
    public function putSession($putSession){

        return Session::put('currentPath_',$putSession);

    }

}


