<?php

namespace App\Service\Admin;

use App\Tool\MessageResult;
use App\Models\Slide;


/**
* 
*/
class SystemService
{

   public function getSlideList()
   {
      return Slide::all();
   }
	
	public function uploadImg($file,$path = '')
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

         if ($path == '') {
            $path = 'uploads/default';
         }
   		

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

   public function createOrUpdateSlide($dataArr)
   {
      $slideName = $dataArr['slideName'];
      $slideDesc = $dataArr['slideDesc'];
      $imgUrl = $dataArr['imgUrl'];
      
      $EditOrAdd = $dataArr['EditOrAdd'];

      $slideId = $dataArr['slideId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = Slide::where('id',$slideId)->update(['slide_name'=>$slideName,'slide_desc'=>$slideDesc,'img_url'=>$imgUrl]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = Slide::insert([
            'slide_name'=>$slideName,'slide_desc'=>$slideDesc,'img_url'=>$imgUrl
         ]);
      }


      if ($isUpdateOrAdd) {
         return true;
      }
      else{
         return false;
      }
   }

   public function delSlide($slideId)
   {
      return Slide::where('id' , $slideId)->delete();
   }
}



?>