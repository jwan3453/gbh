<?php

namespace App\Service\Admin;

use App\Tool\MessageResult;
use App\Models\Slide;
use App\Models\CreditCard;
use App\Models\AdminUser;
use App\Models\ServiceCategory;
use App\Models\ExtraService;

use Session;


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

   public function createOrUpdateCreditCard($dataArr)
   {
      $adminId = Session::get('adminid');

      $creditName = $dataArr['creditName'];
      $creditType = $dataArr['creditType'];

      $EditOrAdd = $dataArr['EditOrAdd'];
      $creditId = $dataArr['creditId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = CreditCard::where('id',$creditId)->update(['credit_name'=>$creditName,'credit_type'=>$creditType,'admin_id'=>$adminId]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = CreditCard::insert([
            'credit_name'=>$creditName,'credit_type'=>$creditType,'admin_id'=>$adminId
         ]);
      }

      if ($isUpdateOrAdd) {
         return true;
      }
      else{
         return false;
      }
   }

   public function getCreditCardList($credit_type)
   {
      $list = CreditCard::where('credit_type',$credit_type)->get();
      foreach ($list as $item) {
         if ($item->admin_id != 0) {
            $item->admin = AdminUser::where('id',$item->admin_id)->select('username')->first()->username;
         }
      }
      return $list;
   }

   public function delCredit($creditId)
   {
      return CreditCard::where('id' , $creditId)->delete();
   }

   public function createOrUpdateServiceCategory($dataArr)
   {
      $adminId = Session::get('adminid');

      $serviceName = $dataArr['serviceName'];
      $serviceType = $dataArr['serviceType'];
      $serviceNameEg = $dataArr['serviceNameEg'];

      $EditOrAdd = $dataArr['EditOrAdd'];
      $serviceId = $dataArr['serviceId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = ServiceCategory::where('id',$serviceId)->update(['service_name'=>$serviceName,'service_name_eg'=>$serviceNameEg,'service_type'=>$serviceType,'admin_id'=>$adminId]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = ServiceCategory::insert([
            'service_name'=>$serviceName,'service_name_eg'=>$serviceNameEg,'service_type'=>$serviceType,'admin_id'=>$adminId
         ]);
      }

      if ($isUpdateOrAdd) {
         return true;
      }
      else{
         return false;
      }
   }

   public function getServiceCategoryList()
   {
      $list = ServiceCategory::all();
      foreach ($list as $item) {
         if ($item->admin_id != 0) {
            $item->admin = AdminUser::where('id',$item->admin_id)->select('username')->first()->username;
         }
      }
      return $list;
   }

   public function delServiceCategory($serviceId)
   {
      return ServiceCategory::where('id' , $serviceId)->delete();
   }

   public function getServiceItemsList()
   {
      $list = ServiceCategory::orderBy('service_type','ASC')->get();
      foreach ($list as $item) {
         $itemlist = ExtraService::where('service_type',$item->service_type)->get();
         if ($itemlist == '') {
            $itemlist = "0";
         }
      }
      return $list;
   }

}



?>