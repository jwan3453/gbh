<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\SystemService;

use Session;

use App\Tool\MessageResult;
use App\Service\Common\CommonService;

/**
* 
*/
class SystemController extends Controller
{
    private $system;

    private $commonService;

    function __construct(SystemService $system,CommonService $commonService)
    {
        $this->system = $system;
        $this->commonService = $commonService;
    }


    //--------------轮播图管理----------
    public function slideConfigure()
    {
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $slideList = $this->system->getSlideList();
        return view('Admin.System.slideConfigurePage')->with(['slideList' => $slideList , 'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);
    }

    public function uploadImg(Request $request)
    {
        $file = $_FILES[$request->input('filename')];

        return $this->system->uploadImg($file, 'uploads/slide');
    }

    public function createSlide(Request $request)
    {
        $jsonResult = new MessageResult();

        $createSlide = $this->system->createOrUpdateSlide($request->input());

        if ($createSlide) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delSlide(Request $request)
    {
        $jsonResult = new MessageResult();

        $delSlide = $this->system->delSlide($request->input('slideId'));

        if ($delSlide) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }


    //----------------银行卡、信用卡管理----------------
    public function creditCardManage()
    {

        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $InternalList = $this->system->getCreditCardList(1);
        $AbroadList = $this->system->getCreditCardList(2);
        return view('Admin.System.creditCardManage')->with('InternalList', $InternalList)->with(['AbroadList' => $AbroadList , 'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);
    }

    public function createCreditCard(Request $request)
    {
        $jsonResult = new MessageResult();

        $createCreditCard = $this->system->createOrUpdateCreditCard($request->input());

        if ($createCreditCard) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delCredit(Request $request)
    {
        $jsonResult = new MessageResult();

        $delCredit = $this->system->delCredit($request->input('creditId'));

        if ($delCredit) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }


    //-----------------服务分类管理----------------
    public function serviceSetting()
    {

        $serviceCategorylist = $this->system->getServiceCategoryList();
        return view('Admin.System.serviceSetting')->with('serviceCategorylist', $serviceCategorylist);
    }

    public function createServiceCategory(Request $request)
    {
        $jsonResult = new MessageResult();

        $createServiceCategory = $this->system->createOrUpdateServiceCategory($request->input());

        if ($createServiceCategory) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delServiceCategory(Request $request)
    {
        $jsonResult = new MessageResult();

        $delServiceCategory = $this->system->delServiceCategory($request->input('serviceId'));

        if ($delServiceCategory) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }


    //-----------------酒店服务管理---------------
    public function serviceItems()
    {

        $serviceItemsList = $this->system->getServiceItemsList();
        return view('Admin.System.serviceItemsPage')->with('serviceItemsList', $serviceItemsList);
    }

    public function createServiceItem(Request $request)
    {
        $jsonResult = new MessageResult();

        $createServiceItem = $this->system->createOrUpdateServiceItem($request->input());

        if ($createServiceItem) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
            $jsonResult->extra_name = $request->input("itemName");
            $jsonResult->service_type = $request->input("serviceType");
            $jsonResult->admin = Session::get('adminusername');
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delitem(Request $request)
    {
        $jsonResult = new MessageResult();

        $delitem = $this->system->delitem($request->input('serviceId'));

        if ($delitem) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function hotelImageManage()
    {
        $hotelImageManage = $this->system->hotelImageManage();
        return view('Admin.System.hotelImageManage')->with('hotelImageManage', $hotelImageManage);
    }

    public function hotelImageOperation(Request $request)
    {
        $jsonResult = new MessageResult();

        $hotelImageOperation = $this->system->hotelImageOperation($request->input());

        if ($hotelImageOperation) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
            $jsonResult->extra_name = $request->input("itemName");
            $jsonResult->service_type = $request->input("serviceType");
            $jsonResult->admin = Session::get('adminusername');
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function delhotelImage(Request $request)
    {
        $jsonResult = new MessageResult();

        $delhotelImage = $this->system->delhotelImage($request->input('sectionId'));

        if ($delhotelImage) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }


    //管理目的地
    public function manageDestination()
    {

        //$initial_a_e = ['A','B','C','D','E'];
        $cities = $this->system->getCities();

        $initialGroup = [];
        $initialGroup['a_e'] = ['A', 'B', 'C', 'D', 'E'];
        $initialGroup['f_j'] = ['F', 'G', 'H', 'I', 'J'];
        $initialGroup['k_p'] = ['K', 'L', 'M', 'N', 'O', 'P'];
        $initialGroup['q_v'] = ['Q', 'R', 'S', 'T', 'U', 'V'];
        $initialGroup['w_z'] = ['W', 'X', 'Y', 'Z'];
        $initialGroup['intCity'] = ['intCity'];

        return view('Admin.System.manageDestination')->with('cities', $cities)->with('initialGroup', $initialGroup);
    }

    //获取目的地信息
    public function  getDestinationInfo(Request $request)
    {

        $jsonResult = new MessageResult();

        $result = $this->system->getDestinationInfo($request);

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
            $jsonResult->extra = $result;
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    //保存目的地信息
    public function saveDestinationInfo(Request $request)
    {

        $jsonResult = new MessageResult();

        $result = $this->system->saveDestinationInfo($request);

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
            $jsonResult->extra = $result;
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    //设置酒店分类
    public function manageHotelCategory()
    {
        $categories = $this->system->getHotelCategories();
        return view('Admin.System.manageHotelCategory')->with('categories',$categories);
    }

    //保存目的地信息
    public function saveHotelCategory(Request $request)
    {

        $jsonResult = new MessageResult();

        $result = $this->system->saveHotelCategory($request);

        if ($result) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "保存成功";
            $jsonResult->extra = $result;
        } else {
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "保存失败";
        }

        return response($jsonResult->toJson());
    }

    //删除酒店分类
    public function deleteHotelCategory(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->system->deleteHotelCategory($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='删除成功';
        }
        else{
            $jsonResult->statusCode =0;
            $jsonResult->statusMsg ='删除失败';
        }
        return response($jsonResult->toJson());
    }


}




?>