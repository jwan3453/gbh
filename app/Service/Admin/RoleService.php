<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 16/12/28
 * Time: 下午4:08
 */

namespace App\Service\Admin;


use App\Models\Role\RoleUser;
use Illuminate\Support\Facades\DB;
use App\Models\Role\AdminUser;
use Illuminate\Http\Request;
use App\Tool\MessageResult;

use App\Models\MenuSetting;
use App\Models\Role\Permission;
use App\Models\Role\Role;
use App\Models\Role\PermissionRole;
use Illuminate\Support\Facades\Session;

class RoleService {


    public function firstMenuInfo(){

        return MenuSetting::where('menu_level','=',1)->get();

    }


    //--------用户管理------

    public  function userData(){

        return DB::table('admin_user')->leftJoin('hotel','admin_user.hotel_id','=','hotel.id')->leftJoin('roles','admin_user.role_id','=','roles.id')->select('admin_user.*','hotel.id','hotel.name','roles.display_name')->paginate(3);

    }

    public function countData(){

        return AdminUser::count('user_id');

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

        return AdminUser::create([
            'username'  =>  $_POST['username'],
            'truename'  =>  $_POST['truename'],
            'mobile'    =>  $_POST['mobile'],
            'hotel_id'  =>  $_POST['hotel_id'],
            'position'  =>  $_POST['position'],
            'password'  =>  bcrypt($_POST['password']),
        ]);

    }

    //获取用户数据
    public function getUser(){

        $id = $_POST['id'];
        return AdminUser::where('user_id',$id)->first();

    }
    //编辑存储
    public function storeUser(){

        $data = [
            'username'  =>  $_POST['username_'],
            'truename'  =>  $_POST['truename_'],
            'mobile'    =>  $_POST['mobile_'],
            'hotel_id'  =>  $_POST['hotel_ids'],
            'position'  =>  $_POST['position_']
        ];
        return AdminUser::where('user_id',$_POST['userid'])->update($data);

    }
    public function editUsername(){

        return AdminUser::where('user_id','<>',$_POST['id'])->where('username',$_POST['username'])->first();

    }

    //删除用户
    public function removeUser(){

        return AdminUser::where('user_id',$_POST['userId'])->delete();

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

        for($i=0; $i< count($split); $i++){

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

        return Permission::all();

    }

    public function menuInfoData(){

//        return MenuSetting::where('menu_level',1)->get();
        return DB::table('menu_setting')->where('menu_level',1)->leftJoin('permissions','menu_setting.permission_id','=','permissions.id')->get();

    }

    //检查权限重复性
    public function checkPermissions(){

        return DB::table('permissions')->where('display_name',$_POST['permissionName'])->first();

    }

    //新增权限
    public function addPermissions(){

        return DB::insert('insert into permissions (display_name,description) value (?,?)',[$_POST['permissionName'],$_POST['description']]);

    }

    //获取权限详情
    public function getPermissions(){

        return DB::table('permissions')->where('id',$_POST['id'])->first();

    }

    //检查除某权限以外的重复性
    public function editPermissions(){

        return DB::table('permissions')->where('id','<>',$_POST['id'])->where('display_name',$_POST['permissionName'])->first();

    }

    //编辑存储权限
    public function storePermissions(){

        return DB::table('permissions')->where('id',$_POST['id'])->update(['display_name' => $_POST['permissionName'],'description' => $_POST['description']]);

    }

    //删除权限
    public function removePermissions(){

        return DB::table('permissions')->where('id',$_POST['id'])->delete();

    }



}