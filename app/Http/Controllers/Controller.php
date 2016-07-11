<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Session;

abstract class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function isRolePermission($Permission = '')
    {

    	$isPermission = false;

    	$permissionArr = Session::get('permission');

        // dd($permissionArr);

    	if ($permissionArr == "all") {
    		$isPermission = true;
    	}else{
    		if (is_array($permissionArr)) {
    			if (in_array($Permission, $permissionArr)) {
		    		$isPermission = true;
		    	}
    		}
    	}

    	if ($isPermission) {
    		return true;
    	}else{
    		return false;
    	}


    }
}
