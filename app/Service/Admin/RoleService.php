<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 16/12/28
 * Time: 下午4:08
 */

namespace App\Service\Admin;


use App\Models\Hotel;
use App\Models\Role\RoleUser;
use Illuminate\Support\Facades\DB;
use App\Models\Role\AdminUser;
use Illuminate\Http\Request;
use App\Tool\MessageResult;

use App\Models\MenuSetting;
use App\Models\Role\Permission;
use App\Models\Role\Role;
use App\Models\Role\PermissionRole;
use App\Models\Role\MenuPermission;
use Illuminate\Support\Facades\Session;

class RoleService {


    public function firstMenuInfo(){

        return MenuSetting::where('menu_level','=',1)->get();

    }


    //--------用户管理------

    public  function userData(){

        return DB::table('admin_user')->leftJoin('hotel','admin_user.hotel_id','=','hotel.id')->leftJoin('roles','admin_user.role_id','=','roles.id')->select('admin_user.*','hotel.id','hotel.name','roles.display_name')->paginate(15);

    }

    public function countData(){

        return AdminUser::count('user_id');

    }

    //酒店数据
    public function hotelData(){

        return Hotel::all();

    }

    public function ResultPaginate(){

        return DB::table('admin_user')->paginate(3);

    }


    //检查用户名重复性
    public function checkUser(){

        $username = $_POST['username'];
        $where = ['username' => $username];
        return AdminUser::where($where)->first();

    }

    //新增用户
    public function addUser(){

        if($_POST['hotel_type'] == 1){
            $hotelType  =   1;
            $hotelId    =   $_POST['hotelId'];
        }else if($_POST['hotel_type'] == 2){
            $hotelType  =   2;
            $hotelId    =   0;
        }else{
            $hotelType  =   0;
            $hotelId    =   0;
        }

        return AdminUser::create([
            'username'    =>  $_POST['username'],
            'truename'    =>  $_POST['truename'],
            'mobile'      =>  $_POST['mobile'],
            'position'    =>  $_POST['position'],
            'password'    =>  bcrypt($_POST['password']),
            'hotel_type'  =>  $hotelType,
            'hotel_id'    =>  $hotelId,
        ]);

    }

    //获取用户数据
    public function getUser(){

        $id = $_POST['id'];
        return AdminUser::where('user_id',$id)->first();

    }
    //编辑存储
    public function storeUser(){

        if($_POST['edit_hotel_type'] == 1){
            $hotelType  =  1;
            $hotelId    =  $_POST['editHotelId'];
        }else if($_POST['edit_hotel_type'] == 2){
            $hotelType  =  2;
            $hotelId    =  0;
        }else{
            $hotelType  =  0;
            $hotelId    =  0;
        }

        $data = [
            'username'    =>  $_POST['username_'],
            'truename'    =>  $_POST['truename_'],
            'mobile'      =>  $_POST['mobile_'],
            'position'    =>  $_POST['position_'],
            'hotel_type'  =>  $hotelType,
            'hotel_id'    =>  $hotelId,
        ];
        return AdminUser::where('user_id',$_POST['userId'])->update($data);

    }
    public function editUsername(){

        return AdminUser::where('user_id','<>',$_POST['id'])->where('username',$_POST['username'])->first();

    }

    //删除用户
    public function removeUser(){

        return AdminUser::where('user_id',$_POST['userId'])->delete();

    }
    public function IsHasBindGroup(){
        return RoleUser::where('user_id',$_POST['userId'])->first();
    }
    public function removeHasBingRole(){
        return RoleUser::where('user_id',$_POST['userId'])->delete();
    }






    //--------用户组管理------



    //用户组绑定的角色数据
    public function currentRoleInfo($group_id){

        return AdminUser::find($group_id)->Role;

    }


    //是否绑定角色
    public function hasRole($user_id){

        return RoleUser::where('user_id',$user_id)->first();

    }


    //绑定角色
    public function bindingRole(Request $request){

        $userId_    =   $request->input('userIdForRole');
        $roleId     =   $request->input('roleInput');

        //验证是否已绑定角色
        $hasRole    =   $this->checkBindRole($userId_,$roleId);

        $jsonResult =   new MessageResult();

        if($hasRole){

            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg  = "角色已经绑定";

        }else{

            $adminUser =   AdminUser::where('user_id',$userId_)->first();

            $role      =   Role::where('id',$roleId)->first();

            $this->removeHasRole($userId_);

            $adminUser->attachRole($role);

            //绑定的同时记录到用户表
            $this->recordRole($userId_,$roleId);

            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg  = "绑定成功";


        }

        return response($jsonResult->toJson());


    }

    public function recordRole($userId_,$roleId){

        return AdminUser::where('user_id',$userId_)->update(['role_id' => $roleId]);

    }

    //检查绑定角色重复性
    public function checkBindRole($userId_,$roleId){

        return RoleUser::where('user_id',$userId_)->where('role_id',$roleId)->first();

    }

    //更改绑定的角色信息
    public function removeHasRole($userId_){

        return RoleUser::where('user_id',$userId_)->delete();

    }






    //--------角色管理------
    public function roleData(){

        return Role::all();

    }

    //统计用户组个数
    public function countRole(){

        return Role::count('id');

    }

    //检查角色重复性
    public function checkRole(){

        return DB::table('roles')->where('display_name',$_POST['rolename'])->first();

    }

    //新增角色
    public function addRole(){

        return DB::insert('insert into roles (display_name,description) value (?,?)',[$_POST['rolename'],$_POST['description']]);

    }

    //获取角色详情
    public function getRole(){

        return DB::table('roles')->where('id',$_POST['role_id'])->first();

    }

    //检查除某角色以外的重复性
    public function editRole(){

        return DB::table('roles')->where('id','<>',$_POST['id'])->where('display_name',$_POST['rolename'])->first();

    }

    //编辑存储角色
    public function storeRole(Request $request){

        return DB::table('roles')->where('id',$request->input('roleIdForEdit'))->update(['display_name' => $request->input('rolename_'),'description' => $_POST['description_']]);

    }

    //删除角色
    public function removeRole(){

        return DB::table('roles')->where('id',$_POST['roleId'])->delete();

    }
    public function IsHasGroup(){
        return RoleUser::where('role_id',$_POST['roleId'])->first();
    }


    //获取所有绑定用户
    public function hasUser(){

        $roleId = $_POST['role_id'];
        return AdminUser::where('role_id',$roleId)->get();


    }

    //分配权限
    public function settingPermission(Request $request){

        $roleId  =   $request->input('detailRoleId');
        $str     =   $request->input('selectPerList');
        $newStr  =   substr($str,0,strlen($str)-1);
        $split   =   explode(',',$newStr);                   //str_split(字符串,分割长度);

        //与原绑定做比较
        $prevHas = $this->prevHasPermissions($roleId);
        $hasPermId = [];
        foreach($prevHas as $prevHasId){
            $hasPermId[] = $prevHasId->permission_id;
        }
        for($k=0; $k < count($hasPermId); $k++){
            if(!in_array($hasPermId[$k],$split)){
                //移除与当前不一致的权限
                $this->removeHas($roleId,$hasPermId[$k]);
            }
        }
        //存入数据
        for($i=0; $i < count($split); $i++){

            //验证是否已绑定权限
            $hasPerms = $this->checkPerm($roleId,$split[$i]);
            if(!$hasPerms){
                $permission  = Permission::where('id',$split[$i])->first();

                $currentRole = Role::where('id',$roleId)->first();

                $currentRole->attachPermission($permission);

            }

        }
        return "ok";

    }

    public function prevHasPermissions($roleId){

        return PermissionRole::where('role_id',$roleId)->get();

    }

    public function removeHas($roleId,$hasPermId){

        return PermissionRole::where('role_id',$roleId)->where('permission_id',$hasPermId)->delete();

    }


    //获得具体某个角色信息
    public function detailRole($id){

        return DB::table('roles')->where('id',$id)->first();

    }

    //验证权限是否存在
    public function checkPerm($roleId,$permId){

        return PermissionRole::where('role_id',$roleId)->where('permission_id',$permId)->first();

    }

    //当前拥有权限
    public function currentPerm($id){

        return Role::find($id)->permission;

    }

    //删除权限
    public function deletePerm(){

        $permId     =   $_POST['permId'];
        $roleId     =   $_POST['roleId'];

        return PermissionRole::where('role_id',$roleId)->where('permission_id',$permId)->delete();
//        $permission =   Permission::where('id',$permId)->first();
//        $role       =   Role::where('id',$roleId)->first();
//        return $role->detachPermission($permission);

    }








    //--------权限管理------
    public function permissionData(){

        $firstPermList = Permission::where('permission_level',1)->get();
        foreach($firstPermList as $secondPermList){
            $secondPermList->secondPerm = Permission::where(['permission_level' => 2,'parent_id' => $secondPermList->id])->get();
        }
        return $firstPermList;

    }

    public function permInfoData(){

//        return DB::table('permissions')->leftJoin('menu_permission','permissions.id','=','menu_permission.permission_id')->leftJoin('menu_setting','menu_permission.menu_id','=','menu_setting.id')->get();
        return Permission::all();

    }

    //检查权限重复性
    public function checkPermissions(){

        return DB::table('permissions')->where('display_name',$_POST['permissionName'])->orWhere('name',$_POST['englishName'])->first();

    }

    //新增权限
    public function addPermissions(){


        //是否选择绑定权限组:
        if($_POST['selectPermType'] == 1){
            $parentId         = $_POST['permLists'];
            $permission_level = 2;
        }else{
            $parentId         = 0;
            $permission_level = 1;
        }
        //绑定菜单类型
        if($_POST['selectMenuType']      == 1){
            $getMenuId        = $_POST['menuLists'];
            $menuType         = 1;
        }elseif($_POST['selectMenuType'] == 2){
            $getMenuId        = $_POST['secondMenuList'];
            $menuType         = 2;
        }else{
            $getMenuId        = 0;
            $menuType         = 0;
        }

        return Permission::create([
            'name'               =>       $_POST['englishName'],
            'display_name'       =>       $_POST['permissionName'],
            'description'        =>       $_POST['description'],
            'route'              =>       $_POST['routeUrl'],
            'permission_level'   =>       $permission_level,
            'parent_id'          =>       $parentId,
            'menu_id'            =>       $getMenuId,
            'menu_type'          =>       $menuType
        ]);

    }

    //获取权限详情
    public function getPermissions(){

        return DB::table('permissions')->where('id',$_POST['id'])->first();

    }

    //获得菜单Name
    public function getMenuName($menuId){

        return MenuSetting::where('id',$menuId)->first();

    }

    public function getMenuData(){

        return MenuSetting::where('menu_level',1)->get();

    }

    public function getSecondMenu(){

        return MenuSetting::where('menu_level',2)->get();

    }

    public function toMenuId($permId){

        return MenuPermission::where('permission_id',$permId)->get();

    }

    //检查除某权限以外的重复性
    public function editPermissions(){

        return DB::table('permissions')->where('id','<>',$_POST['id'])->where('display_name',$_POST['permissionName'])->first();

    }

    //编辑存储权限
    public function storePermissions(){
        //权限类型
        if($_POST['selectPermType_'] == 1){
            $permission_level = 2;
            $parent_id = $_POST['permListsForEdit'];
        }else{
            $permission_level = 1;
            $parent_id = 0;
        }
        //绑定菜单类型
        if($_POST['selectMenuType_']      == 1){
            $getMenuId = $_POST['menuListsForEdit'];
            $menuType  = 1;
        }elseif($_POST['selectMenuType_'] == 2){
            $getMenuId = $_POST['secondMenuListForEdit'];
            $menuType  = 2;
        }else{
            $getMenuId = 0;
            $menuType  = 0;
        }

        return DB::table('permissions')->where('id',$_POST['permissionId'])->update([
            'display_name'      =>  $_POST['permissionName_'],
            'description'       =>  $_POST['description_'],
            'name'              =>  $_POST['englishName_'],
            'route'             =>  $_POST['routeUrl_'],
            'permission_level'  =>  $permission_level,
            'parent_id'         =>  $parent_id,
            'menu_id'           =>  $getMenuId,
            'menu_type'         =>  $menuType
        ]);

        //选择绑定酒店
//        if($editData){
//            if($_POST['selectPermType_'] == 1){
//
//                $getPermId  = $_POST['permissionId'];
//                $getMenuId  = $_POST['menuListsForEdit'];
//                $getType    = $_POST['selectPermType_'];
//
//                MenuPermission::where('permission_id',$getPermId)->delete();
//
//                MenuPermission::create([
//                    'permission_id'   =>  $getPermId,
//                    'menu_id'         =>  $getMenuId,
//                    'permission_type' =>  $getType
//                ]);
//            }
//            return true;
//        }else{
//            if($_POST['selectPermType_'] == 1){
//
//                $getPermId  = $_POST['permissionId'];
//                $getMenuId  = $_POST['menuListsForEdit'];
//                $getType    = $_POST['selectPermType_'];
//
//                MenuPermission::where('permission_id',$getPermId)->delete();
//
//                MenuPermission::create([
//                    'permission_id'   =>  $getPermId,
//                    'menu_id'         =>  $getMenuId,
//                    'permission_type' =>  $getType
//                ]);
//            }
//            return true;
//        }

    }

    //删除权限
    public function removePermissions(){

        return DB::table('permissions')->where('id',$_POST['id'])->delete();

    }
    //是否有绑定权限
    public function IsHasPermission(){
        return PermissionRole::where('permission_id',$_POST['id'])->first();
    }

    //判断权限类型
    public function typePermList(){

        if($_POST['type'] == 1){
            return Permission::where('permission_level',1)->get();
        }

    }

    //判断菜单类型
    public function typeMenuList(){

        if($_POST['type'] == 1){
            return MenuSetting::where('menu_level',1)->get();
        }

    }


}