<?php

namespace App\Service\Admin;

use App\Tool\MessageResult;
use App\Models\Slide;
use App\Models\CreditCard;
use App\Models\AdminUser;
use App\Models\ServiceCategory;
use App\Models\ExtraService;
use App\Models\HotelSectionImage;

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
     
         $a = $this->resize_image($file['name'],$file['tmp_name'],400,400,time());

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
      $slideLink = $dataArr['slideLink'];
      $imgUrl = $dataArr['imgUrl'];
      
      $EditOrAdd = $dataArr['EditOrAdd'];

      $slideId = $dataArr['slideId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = Slide::where('id',$slideId)->update(['slide_name'=>$slideName,'slide_desc'=>$slideDesc,'slide_link'=>$slideLink,'img_url'=>$imgUrl]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = Slide::insert([
            'slide_name'=>$slideName,'slide_desc'=>$slideDesc,'slide_link'=>$slideLink,'img_url'=>$imgUrl
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
         $item->itemlist = ExtraService::where('service_type',$item->service_type)->get();

         foreach ($item->itemlist as $smallItem) {
            $smallItem->admin = AdminUser::where('id',$smallItem->admin_id)->select('username')->first()->username;
         }
         
      }

      return $list;
   }

   public function createOrUpdateServiceItem($dataArr)
   {
      $adminId = Session::get('adminid');

      $itemName = $dataArr['itemName'];
      $serviceType = $dataArr['serviceType'];

      $EditOrAdd = $dataArr['EditOrAdd'];
      $serviceId = $dataArr['serviceId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = ExtraService::where('id',$serviceId)->update(['extra_name'=>$itemName,'service_type'=>$serviceType,'admin_id'=>$adminId]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = ExtraService::insert([
            'extra_name'=>$itemName,'service_type'=>$serviceType,'admin_id'=>$adminId
         ]);
      }

      if ($isUpdateOrAdd) {
         return true;
      }
      else{
         return false;
      }
   }

   public function delitem($serviceId)
   {
      return ExtraService::where('id' , $serviceId)->delete();
   }

   public function hotelImageManage()
   {
      return HotelSectionImage::all();
   }

   public function hotelImageOperation($dataArr)
   {
      $adminId = Session::get('adminid');

      $sectionName = $dataArr['sectionName'];
      $sectionType = $dataArr['sectionType'];
      $sectionNameEg = $dataArr['sectionNameEg'];

      $EditOrAdd = $dataArr['EditOrAdd'];
      $sectionId = $dataArr['sectionId'];

      if ($EditOrAdd == 'edit') {
         $isUpdateOrAdd = HotelSectionImage::where('id',$sectionId)->update(['section_name'=>$sectionName,'section_type'=>$sectionType,'section_name_eg'=>$sectionNameEg,'admin_id'=>$adminId]);
      }else if ($EditOrAdd == 'add') {
         $isUpdateOrAdd = HotelSectionImage::insert([
            'section_name'=>$sectionName,'section_type'=>$sectionType,'section_name_eg'=>$sectionNameEg,'admin_id'=>$adminId
         ]);
      }


      return $isUpdateOrAdd;
   }

   public function delhotelImage($sectionId)
   {
      return HotelSectionImage::where('id' , $sectionId)->delete();
   }


   function resize_image($filename, $tmpname, $xmax, $ymax,$time)
    {
        
        $ext = explode(".", $filename);
        $ext = $ext[count($ext)-1];
        if($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif($ext == "gif")
            $im = imagecreatefromgif($tmpname);

         
        $x = imagesx($im);
        $y = imagesy($im);
        $size = filesize($tmpname);
        $size = $size / 1024;
        
        //--图片大小在200k以内的不压缩，直接返回false
        if ($size < 200) {
            return false;
        }

        if($x >= $y) {
            $newx = $xmax;
            $newy = $newx * $y / $x;
        }
        else {
            $newy = $ymax;
            $newx = $x / $y * $newy;
        }
        $im2 = imagecreatetruecolor($newx, $newy);

        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);
        
        $paths='uploads/default/';//上传小图路径

        $os = strtoupper(substr(PHP_OS,0,3));

        if ($os === 'WIN') {
            $encode = mb_detect_encoding($filename, array("ASCII",'UTF-8',"GB2312","GBK",'BIG5'));
            $filename = mb_convert_encoding($filename, 'GB2312', $encode);
        }
    
        $file3 = $paths.$filename;

        imagejpeg($im2,$file3,95);
        
        dd($os);
        
        return $file3;

    }

}



?>