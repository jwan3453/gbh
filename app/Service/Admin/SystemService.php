<?php

namespace App\Service\Admin;

use App\Tool\MessageResult;
use App\Models\Slide;
use App\Models\CreditCard;
use App\Models\AdminUser;
use App\Models\ServiceCategory;
use App\Models\ExtraService;
use App\Models\HotelSectionImage;
use App\Models\City;
use App\Models\InternationalCity;
use Session;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Destination;
use App\Service\Admin\ImageService;
use App\Models\Category;
/**
* 
*/
class SystemService
{

    public function getSlideList()
    {
        return Slide::all();
    }

    public function uploadImg($file, $path = '')
    {
        $jsonResult = new MessageResult();

        $typeArr = array("image/jpeg", "image/jpg", "image/png", "image/gif");

        if (in_array($file['type'], $typeArr)) {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "请上传png、jpg、gif格式图片";
        }

        if ($file['size'] > 1024000) {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "文件大小不得超过1M";
        }

        // $a = $this->resize_image($file['name'],$file['tmp_name'],0,0,50,'');

        if ($path == '') {
            $path = 'uploads/default';
        }


        $pic_path = $path . '/' . $file['name'];

        if (file_exists($path)) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "文件夹存在";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "文件夹不存在";
        }

        move_uploaded_file($file['tmp_name'], $pic_path);

        $menuName = explode('.', $file['name']);

        $jsonResult->statusCode = 1;
        $jsonResult->statusMsg = "成功";
        $jsonResult->name = $menuName[0];
        $jsonResult->imgPath = '/' . $pic_path;

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
            $isUpdateOrAdd = Slide::where('id', $slideId)->update(['slide_name' => $slideName, 'slide_desc' => $slideDesc, 'slide_link' => $slideLink, 'img_url' => $imgUrl]);
        } else if ($EditOrAdd == 'add') {
            $isUpdateOrAdd = Slide::insert([
                'slide_name' => $slideName, 'slide_desc' => $slideDesc, 'slide_link' => $slideLink, 'img_url' => $imgUrl
            ]);
        }


        if ($isUpdateOrAdd) {
            return true;
        } else {
            return false;
        }
    }

    public function delSlide($slideId)
    {
        return Slide::where('id', $slideId)->delete();
    }

    public function createOrUpdateCreditCard($dataArr)
    {
        $adminId = Session::get('adminid');

        $creditName = $dataArr['creditName'];
        $creditType = $dataArr['creditType'];

        $EditOrAdd = $dataArr['EditOrAdd'];
        $creditId = $dataArr['creditId'];

        if ($EditOrAdd == 'edit') {
            $isUpdateOrAdd = CreditCard::where('id', $creditId)->update(['credit_name' => $creditName, 'credit_type' => $creditType, 'admin_id' => $adminId]);
        } else if ($EditOrAdd == 'add') {
            $isUpdateOrAdd = CreditCard::insert([
                'credit_name' => $creditName, 'credit_type' => $creditType, 'admin_id' => $adminId
            ]);
        }

        if ($isUpdateOrAdd) {
            return true;
        } else {
            return false;
        }
    }

    public function getCreditCardList($credit_type)
    {
        $list = CreditCard::where('credit_type', $credit_type)->get();
        foreach ($list as $item) {
            if ($item->admin_id != 0) {
                $item->admin = AdminUser::where('id', $item->admin_id)->select('username')->first()->username;
            }
        }
        return $list;
    }

    public function delCredit($creditId)
    {
        return CreditCard::where('id', $creditId)->delete();
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
            $isUpdateOrAdd = ServiceCategory::where('id', $serviceId)->update(['service_name' => $serviceName, 'service_name_eg' => $serviceNameEg, 'service_type' => $serviceType, 'admin_id' => $adminId]);
        } else if ($EditOrAdd == 'add') {
            $isUpdateOrAdd = ServiceCategory::insert([
                'service_name' => $serviceName, 'service_name_eg' => $serviceNameEg, 'service_type' => $serviceType, 'admin_id' => $adminId
            ]);
        }

        if ($isUpdateOrAdd) {
            return true;
        } else {
            return false;
        }
    }

    public function getServiceCategoryList()
    {
        $list = ServiceCategory::all();
        foreach ($list as $item) {
            if ($item->admin_id != 0) {
                $item->admin = AdminUser::where('id', $item->admin_id)->select('username')->first()->username;
            }
        }
        return $list;
    }

    public function delServiceCategory($serviceId)
    {
        return ServiceCategory::where('id', $serviceId)->delete();
    }

    public function getServiceItemsList()
    {
        $list = ServiceCategory::orderBy('service_type', 'ASC')->get();
        foreach ($list as $item) {
            $item->itemlist = ExtraService::where('service_type', $item->service_type)->get();

            foreach ($item->itemlist as $smallItem) {
                $smallItem->admin = AdminUser::where('id', $smallItem->admin_id)->select('username')->first()->username;
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
            $isUpdateOrAdd = ExtraService::where('id', $serviceId)->update(['extra_name' => $itemName, 'service_type' => $serviceType, 'admin_id' => $adminId]);
        } else if ($EditOrAdd == 'add') {
            $isUpdateOrAdd = ExtraService::insert([
                'extra_name' => $itemName, 'service_type' => $serviceType, 'admin_id' => $adminId
            ]);
        }

        if ($isUpdateOrAdd) {
            return true;
        } else {
            return false;
        }
    }

    public function delitem($serviceId)
    {
        return ExtraService::where('id', $serviceId)->delete();
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
            $isUpdateOrAdd = HotelSectionImage::where('id', $sectionId)->update(['section_name' => $sectionName, 'section_type' => $sectionType, 'section_name_eg' => $sectionNameEg, 'admin_id' => $adminId]);
        } else if ($EditOrAdd == 'add') {
            $isUpdateOrAdd = HotelSectionImage::insert([
                'section_name' => $sectionName, 'section_type' => $sectionType, 'section_name_eg' => $sectionNameEg, 'admin_id' => $adminId
            ]);
        }


        return $isUpdateOrAdd;
    }

    public function delhotelImage($sectionId)
    {
        return HotelSectionImage::where('id', $sectionId)->delete();
    }


    /*
    * filename 图片原名称
    * tmpname 图片缓存地址$_FILE['tmp_name']
    * xmax  想要压缩的宽度 传0则不压缩宽度
    * ymax  想要压缩的高度 传0则不压缩高度
    * quality 图片清晰度 不设置则默认100%
    * paths 图片压缩后存储路径，不设置则默认 uploads/default/
    */
    function resize_image($filename, $tmpname, $xmax = 0, $ymax = 0, $quality = 100, $paths = '')
    {

        $ext = explode(".", $filename);
        $ext = $ext[count($ext) - 1];
        if ($ext == "jpg" || $ext == "jpeg")
            $im = imagecreatefromjpeg($tmpname);
        elseif ($ext == "png")
            $im = imagecreatefrompng($tmpname);
        elseif ($ext == "gif")
            $im = imagecreatefromgif($tmpname);

        $x = imagesx($im);
        $y = imagesy($im);
        $size = filesize($tmpname);
        $size = $size / 1024;

        //--图片大小在200k以内的不压缩，直接返回false
        if ($size < 200) {
            return false;
        }

        //----对图片宽高不做缩放时----
        if ($xmax == 0 || $ymax == 0) {
            $newx = $x;
            $newy = $y;
        } else {
            if ($x >= $y) {
                $newx = $xmax;
                $newy = $newx * $y / $x;
            } else {
                $newy = $ymax;
                $newx = $x / $y * $newy;
            }
        }

        $im2 = imagecreatetruecolor($newx, $newy);

        imagecopyresized($im2, $im, 0, 0, 0, 0, floor($newx), floor($newy), $x, $y);

        if ($paths == '') {
            $paths = 'uploads/default/';//上传小图路径
        }

        //判断操作系统，win为GB2312编码，LINUX为UTF-8编码，此处用于中文编码转换
        $os = strtoupper(substr(PHP_OS, 0, 3));

        if ($os === 'WIN') {
            $encode = mb_detect_encoding($filename, array("ASCII", 'UTF-8', "GB2312", "GBK", 'BIG5'));
            $filename = mb_convert_encoding($filename, 'GB2312', $encode);
        }

        $file3 = $paths . $filename;

        imagejpeg($im2, $file3, $quality);

        return $file3;

    }


    //获取所有城市
    public function  getCities()
    {
        $cityList = City::select('initial', 'code', 'city_name')->orderby('initial', 'asc')->get();


        //按照首字母给城市分组

        $cityInitialList = [];
        $tempCityArray = [];
        $previous = '';
        for ($i = 0; $i < count($cityList); $i++) {


            if (strcmp($cityList[$i]->initial, "") != 0) {
                if (strcmp($previous, $cityList[$i]->initial) == 0) {
                    $previous = $cityList[$i]->initial;
                    $tempCityArray[] = $cityList[$i];
                } else {

                    $cityInitialList[$previous] = $tempCityArray;
                    $tempCityArray = [];
                    $tempCityArray[] = $cityList[$i];
                    $previous = $cityList[$i]->initial;
                }


                if ($i == (count($cityList) - 1)) {
                    $cityInitialList[$cityList[$i]->initial] = $tempCityArray;
                }
            }
        }
        $cityInitialList['intCity'] = InternationalCity::all();

        return $cityInitialList;
    }


    public function getDestinationInfo(Request $request)
    {
        $code = $request->input('code');

        $destinationInfo = DB::table('city')->join('destination', 'city.code', '=', 'destination.city_code')
            ->where('city.code', $code)->select('city.status', 'city.city_name_en', 'city.is_hot', 'destination.num_of_hotel','destination.description','destination.description_en', 'destination.cover_image')->first();


        if($destinationInfo == null)
        {
            $destinationInfo = DB::table('international_city')->join('destination', 'international_city.code', '=', 'destination.city_code')
                ->where('international_city.code', $code)->select('international_city.status', 'international_city.is_hot', 'international_city.city_name_en', 'destination.num_of_hotel','destination.description','destination.description_en', 'destination.cover_image')->first();
        }

        return $destinationInfo;
    }


    public function saveDestinationInfo(Request $request)
    {

        $code = $request->input('code');

        $city  = City::where('code',$code)->first();
        if($city != null)
        {

            if($request->input('status') == null)
            {
                $city->status = 0;
            }
            else{
                $city->status = 1;
            }

            if($request->input('is_hot') == null)
            {
                $city->is_hot = 0;
            }
            else{
                $city->is_hot = 1;
            }

            $city->city_name_en = $request->input('nameEn');
            $city->save();
        }

        $imageService = new ImageService();

        $result = null;


        if($request->file('file')!=null)
        {
            $result = $imageService->uploadImage($request);
        }


        $destination = destination::where('city_code',$code)->first();
        if($destination != null)
        {

            $destination->num_of_hotel = $request->input('numOfHotel');
            $destination->description = $request->input('description');
            $destination->description_en = $request->input('descriptionEn');


            if($request->file('file')!=null)
            {

                $deleteImage =  $imageService->deleteImage($destination->cover_image);
                $destination->cover_image= $result->extra;
            }

            $destination->save();
        }
        else{

            $destination  = new Destination();
            $destination->city_code = $code;
            $destination->num_of_hotel = $request->input('numOfHotel');
            $destination->description = $request->input('description');
            $destination->description_en = $request->input('descriptionEn');
            if($request->file('file')!=null)
            {
                $destination->cover_image = $result->extra;
            }
            $destination->save();
        }

        return 1;
    }


    //获取酒店分类

    public function getHotelCategories()
    {


        $categories = Category::where('category_level',1)->get();
        foreach($categories as $category )
        {
            $category->secondLevelCategory =  Category::where(['parent_id'=>$category->id,'category_level'=>2])->get();
        }
        return $categories;
    }

    //保存酒店酒店分类
    public function saveHotelCategory(Request $request)
    {


        $newCategory = new Category();
        $cateName = $request->input('cateName');
        $cateNameEng = $request->input('cateNameEng');
        $cateLevel = $request->input('cateLevel');
        $parent = $request->input('parentLevel');
        $imageService = new ImageService();
        $result = null;


        if($request->file('file')!=null)
        {
            $result = $imageService->uploadImage($request);
        }
        $newCategory->category_name = $cateName;
        $newCategory->category_name_en = $cateNameEng;
        $newCategory->category_level = $cateLevel;
        if($cateLevel !=1 )
        {
            $newCategory->parent_id = $parent;
        }
        if($request->file('file')!=null)
        {
            $newCategory->icon = $result->extra;
        }
        return $newCategory->save();


    }


    //保存酒店酒店分类
    public function deleteHotelCategory(Request $request)
    {
        $imageService = new ImageService();

        $categoryId = $request->input('categoryId');

        $category = Category::where('id',$categoryId)->first();
        if($category != null)
        {
                $deleteIcon = $imageService->deleteImage($category->icon);
                if($deleteIcon->statusCode ==1)
                {
                    return $category->delete();
                }
                else{
                    return 0;
                }
        }
        return 1;


    }
}



?>