<?php
namespace App\Service\Admin;

use App\Models\MenuSetting;


class MenuSettingService {

	public function getOneMenu()
	{
		$MenuList = MenuSetting::where('menu_level' , 1)->select('id','menu_name','menu_name_eg','icon_img_1','menu_description')->get();
        return $MenuList ;
	}

    public function getSecondMenu($parent_id)
    {
    	$MenuList = MenuSetting::where('parent_id' , $parent_id)->select('id','menu_name','icon_img_1','menu_description')->get();
        return $MenuList ;
    }

}


