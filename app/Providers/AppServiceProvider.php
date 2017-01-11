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
    public function boot()
    {

        view()->composer('*',function($view){
            $commonService = new CommonService;

            //获得用户
            $adminUserCookie = '';
            if(isset($_COOKIE['adminusername']))
            {
                $adminUserCookie = $_COOKIE['adminusername'];
            }

            $getCurrentUser  =  $adminUserCookie;
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
            for($i=0; $i  < count($getMenuId); $i++){
                $menuStr .= $getMenuId[$i]->permission_id."|";
            }
            //转化成数组
            $prevstr      =   substr($menuStr,0,iconv_strlen($menuStr)-1);                     //大于10的字符串
            $menuArr      =   explode('|',$prevstr);


            //--------permissionList
            $perStr = "";
            for( $i = 0; $i < count($getPermission); $i++){
                $perStr  .= $getPermission[$i]->permission_id."|";
            }
            $perStr = substr($perStr,0,iconv_strlen($perStr)-1);
            $perToArr = explode('|',$perStr);

            $hasPerms = [];
            for($i=0; $i < count($perToArr); $i++){
                if(in_array($perToArr[$i],$menuArr)){
                    $hasPerms[] = $perToArr[$i];
                }
            }

            $allMenuLists = [];
            //查询菜单
            for( $k=0; $k < count($hasPerms); $k++){
                $adminUser  = new AdminUserService;
                if($adminUser->loadMenuList($hasPerms[$k])){
                    $allMenuLists[] = $adminUser->loadMenuList($hasPerms[$k]);
                }
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
