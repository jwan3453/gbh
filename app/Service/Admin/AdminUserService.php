<?php

namespace App\Service\Admin;

use App\Models\Role\AdminUser;

use App\Tool\MessageResult;
use App\Models\MenuSetting;
use Hash;

/**
* 
*/
class AdminUserService{



    public function loadMenuList($IdForPerms){

        $firstMenuRes = MenuSetting::where('menu_level','=',1)->where('id',$IdForPerms)->get();
        foreach($firstMenuRes as $secondMenuList)
        {
            $secondMenuList->secondMenu = MenuSetting::where(['menu_level'=>2,'parent_id'=>$secondMenuList->id])->get();
        }
        return $firstMenuRes;
    }

	public function isAdmin($request)
    {
        //--是否有该用户名
        $admin = AdminUser::where('username',$request['username'])->select('password')->first();

        $isLogin = false;
        //---验证密码是否正确
        if (Hash::check($request['password'], $admin->password)) {
            //---密码是否需要重新加密
//            if (Hash::needsRehash($admin->password)) {
//                $password = Hash::make($request['password']);
//                //---将新的密码更新到数据
//                AdminUser::where('username',$request['username'])->update(['password'=>$password]);
//            }

            $isLogin = true;
        }
        return $isLogin;
    }

    public function getAdminInfo($username)
    {
    	$info = AdminUser::where('username',$username)->first();
    	
    	if ($info->permission != 'all') {
    		$info->permission = explode("|", $info->permission);
    	}
        return $info;
    }

    public function toRegister($request)
    {
    	$password = Hash::make($request['password']);
    	$username = $request['username'];
    	return AdminUser::insert(['username'=>$username,'password'=>$password,'admin_level'=>1]);
    }


}


?>