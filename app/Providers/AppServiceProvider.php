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




            //--------permissionList
            //查询所在的角色组
            $checkWhereRole  =  $commonService->checkWhereRole($getCurrentUser);

            //获得该组的权限
            $getPermission   =  $commonService->getPermissions($checkWhereRole->id);

            //获得一级MenuId
            $perCon = [];
            for( $i = 0; $i < count($getPermission); $i++){

                $perCon[] = $commonService->getMenuForPerm($getPermission[$i]->permission_id);

            }
            //MenuId转化成数组
            $perConArr = [];
            for($i = 0; $i < count($perCon) ; $i++){
                foreach($perCon[$i] as $newArr){
                    $perConArr[] = "$newArr->menu_id";
                }
            }
            //获得二级MenuId
            $secondCon = [];
            for($j = 0; $j < count($getPermission); $j++){

                $secondCon[] = $commonService->getMenuForSecond($getPermission[$j]->permission_id);

            }
            //MenuId转化成数组
            $secondConArr = [];
            for($j = 0; $j < count($secondCon) ; $j++){
                foreach($secondCon[$j] as $newSecondArr){
                    $secondConArr[] = "$newSecondArr->menu_id";
                }
            }






            //--------menuList
            //一级菜单Info
            $getMenuId       =  $commonService->getMenuInfo();
            $menuStr = "";
            for($i=0; $i  < count($getMenuId); $i++){
                $menuStr .= $getMenuId[$i]->id."|";
            }
            //转化成数组
            $prevstr      =   substr($menuStr,0,iconv_strlen($menuStr)-1);                     //大于10的字符串
            $menuArr      =   explode('|',$prevstr);

            //二级菜单Info
            $getMenuIdForSecond = $commonService->getSecondMenu();
            $menuStr_ = "";
            for($j=0; $j < count($getMenuIdForSecond); $j++){
                $menuStr_ .= $getMenuIdForSecond[$j]->id."|";
            }
            //转化成数组
            $prevstr_      = substr($menuStr_,0,iconv_strlen($menuStr_)-1);
            $menuArr_      = explode('|',$prevstr_);

            //匹配存在的一级菜单
            $hasPerms = [];
            for($i=0; $i < count($perConArr); $i++){
                if(in_array($perConArr[$i],$menuArr)){
                    $hasPerms[] = $perConArr[$i];
                }
            }
            //匹配存在的二级菜单
            $hasSecondPerms = [];
            for($j=0; $j < count($secondConArr); $j++){
                if(in_array($secondConArr[$j],$menuArr_)){
                    $hasSecondPerms[] = $secondConArr[$j];
                }
            }
            //记录二级菜单的所属的一级菜单
            $addFirstMenu = [];
            for($p=0; $p < count($hasSecondPerms); $p++){
                $addFirstMenuData = $commonService->addFirstMenu($hasSecondPerms[$p]);
                $addFirstMenu[]   = "$addFirstMenuData->parent_id";
            }
            $firstMenu = array_unique($addFirstMenu);
            $addFirstMenuArr = [];
            foreach($firstMenu as $firstMenuValue){
                if(!in_array($firstMenuValue,$hasPerms)){
                    $addFirstMenuArr[] = $firstMenuValue;
                }
            }
            $hasNewPerms = array_merge($hasPerms, $addFirstMenuArr);



            //forSession
            for($q=0;$q < count($hasSecondPerms); $q++){
                $commonService->putIdSession($hasSecondPerms[$q]);
            }


            $allMenuLists = [];
            //查询菜单
            for( $k=0; $k < count($hasNewPerms); $k++){
                $adminUser  = new AdminUserService;
                if($adminUser->loadMenuList($hasNewPerms[$k])){
                    $allMenuLists[] = $adminUser->loadMenuList($hasNewPerms[$k]);
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
