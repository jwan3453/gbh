<?php

namespace App\Providers;


use App\Models\MenuSetting;
use App\Models\Role\AdminUser;
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\ServiceProvider;
use App\Service\Common\CommonService;
use App\Service\Admin\AdminUserService;

class AppServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    //多个页面共享数据
    public function boot(Request $request)
    {

        view()->composer('*',function($view){
            $commonService = new CommonService;

            //获得用户

            $getCurrentUser  =  $_COOKIE['adminusername'];
            if(!$getCurrentUser){
                return view('Admin.Sign.sign');
            }

            //查询所在的角色组
            $checkWhereRole  =  $commonService->checkWhereRole($getCurrentUser);

            //获得该组的权限
            $getPermission   =  $commonService->getPermissions($checkWhereRole->id);

            //菜单Info
            $getMenuId       =  $commonService->getMenuInfo();


            //--------menuList
            $menuStr = "";
            for($i=0; $i < count($getMenuId); $i++){
                $menuStr .= $getMenuId[$i]->permission_id;
            }

            $prevstr     =   substr($menuStr,0,2);                     //大于10的字符串
            $prevarr      =   str_split($prevstr,2);                   //转化成数组




            //--------permissionList
            $perStr = "";
            for( $i=0; $i < count($getPermission); $i++){
                $perStr  .= $getPermission[$i]->permission_id;
            }

            //判断有无10
            $perStrs   = substr($perStr,iconv_strlen($perStr)-2,2);

            //除10以外剩下的字符串
            $lastPrems = substr($perStr,0,iconv_strlen($perStr)-2);
            $lastPrems = str_split($lastPrems,1);

            if($perStrs){
                array_unshift($lastPrems,$prevarr[0]);
            }

            $allMenuLists = [];
            //查询菜单
            for( $k=0; $k < count($lastPrems); $k++){
                $adminUser = new AdminUserService;
                $allMenuLists[] = $adminUser->loadMenuList($lastPrems[$k]);
            }

            $view->with('allMenuList', $allMenuLists);
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Session::get('adminusername');
    }
}
