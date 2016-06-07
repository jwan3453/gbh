<?php
namespace App\Service\Admin;

use App\Models\MenuSetting;

use App\Tool\MessageResult;


class MenuSettingService {

	public function getOneMenu()
	{
		$MenuList = MenuSetting::where('menu_level' , 1)->select('id','menu_name','menu_name_eg','icon_img_1','menu_description','menu_chaining')->get();
        return $MenuList ;
	}

    public function getSecondMenu($parent_id)
    {
    	$MenuList = MenuSetting::where('parent_id' , $parent_id)->select('id','menu_name','icon_img_1','menu_description','menu_chaining')->get();
        return $MenuList ;
    }

   	public function uploadIcon($file,$menuLevel)
   	{
   		$jsonResult = new MessageResult();

   		$typeArr = array("image/jpeg","image/jpg","image/png","image/gif");

   		if (in_array($file['type'], $typeArr)) {
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "请上传png、jpg、gif格式图片";
   		}

   		if ($file['size'] > 1024000) {
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "文件大小不得超过1M";
   		}

   		$imageSize = getimagesize($file['tmp_name']);

   		if ($menuLevel == 1) {
   			if ($imageSize[0] > 24 || $imageSize[1] > 24) {
	   			$jsonResult->statusCode = 0;
	   			$jsonResult->statusMsg = "请上传24×24图片";
	   		}
   		}
   		if ($menuLevel == 2) {
   			if ($imageSize[0] > 12 || $imageSize[1] > 12) {
	   			$jsonResult->statusCode = 0;
	   			$jsonResult->statusMsg = "请上传12×12图片";
	   		}
   		}

   		
   		$path = 'Admin/icon';

   		$pic_path = $path. '/' .$file['name'];

   		if (file_exists($path)) {
   			$jsonResult->statusCode = 1;
   			$jsonResult->statusMsg = "文件夹存在";
   		}else{
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "文件夹不存在";
   		}

		move_uploaded_file($file['tmp_name'], $pic_path);

		$menuName = explode('.', $file['name']);

		$jsonResult->statusCode = 1;
   		$jsonResult->statusMsg = "成功";
   		$jsonResult->name = $menuName[0];
   		$jsonResult->imgPath = '/'.$pic_path;

   		return response($jsonResult->toJson());
   		
   	}

   	public function createOrUpdateMenu($dataArr)
   	{
   		$menuLevel = $dataArr['menuLevel'];
    	$menuStatus = $dataArr['menuStatus'];
    	$parentId = $dataArr['parentId'];
    	$menuName = $dataArr['menuName'];
    	$menuNameEg = $dataArr['menuNameEg'];

    	$menuDescription = $dataArr['menuDescription'];
    	$menuChaining = $dataArr['menuChaining'];
    	$iconImg1 = $dataArr['iconImg1'];
    	$iconImg2 = $dataArr['iconImg2'];
    	$EditOrAdd = $dataArr['EditOrAdd'];

    	$menuId = $dataArr['menuId'];

    	if ($EditOrAdd == 'edit') {
    		$isUpdateOrAdd = MenuSetting::where('id',$menuId)->update(['menu_name'=>$menuName,'menu_name_eg'=>$menuNameEg,'menu_level'=>$menuLevel,'menu_status'=>$menuStatus,'menu_chaining'=>$menuChaining,'icon_img_1'=>$iconImg1,'icon_img_2'=>$iconImg2,'parent_id'=>$parentId,'menu_description'=>$menuDescription]);
    	}else if ($EditOrAdd == 'add') {
    		$isUpdateOrAdd = MenuSetting::insert([
			    'menu_name'=>$menuName,'menu_name_eg'=>$menuNameEg,'menu_level'=>$menuLevel,'menu_status'=>$menuStatus,'menu_chaining'=>$menuChaining,'icon_img_1'=>$iconImg1,'icon_img_2'=>$iconImg2,'parent_id'=>$parentId,'menu_description'=>$menuDescription
			]);
    	}


    	if ($isUpdateOrAdd) {
    		return true;
    	}
    	else{
    		return false;
    	}
   	}

   	public function getMenuInfoById($menuId)
   	{
   		$MenuInfo = MenuSetting::where('id' , $menuId)->select('menu_name','menu_name_eg','icon_img_1','icon_img_2','menu_description','menu_level','menu_status','menu_chaining','parent_id')->first();
        return $MenuInfo ;
   	}

   	public function menuDelete($menuId)
   	{
   		$iconImg = MenuSetting::where('id' , $menuId)->select('icon_img_1','icon_img_2')->first();
   		$iconImg1 =  substr($iconImg->icon_img_1, 3);
   		$iconImg2 =  substr($iconImg->icon_img_2, 3);

   		$jsonResult = new MessageResult();

   		if(file_exists($iconImg1)){
   			unlink($iconImg1);
   		}else{
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "删除图片1失败";
   		}
   		if(file_exists($iconImg2)){
   			unlink($iconImg2);
   		}else{
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "删除图片2失败";
   		}

   		$isdelete = MenuSetting::where('id' , $menuId)->delete();

   		if ($isdelete) {
   			$jsonResult->statusCode = 1;
   			$jsonResult->statusMsg = "成功！";
   		}else{
   			$jsonResult->statusCode = 0;
   			$jsonResult->statusMsg = "失败";
   		}
   		return response($jsonResult->toJson());

   	}

}


