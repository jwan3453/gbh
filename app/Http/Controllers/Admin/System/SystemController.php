<?php

namespace App\Http\Controllers\Admin\System;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Admin\SystemService;

use Session;

use App\Tool\MessageResult;

/**
* 
*/
class SystemController extends Controller
{
	private $system;
	function __construct(SystemService $system)
	{
		$this->system = $system;
	}


	//--------------轮播图管理----------
	public function slideConfigure()
	{
        $is = $this->isRolePermission("slide");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }

		$slideList = $this->system->getSlideList();
		return view('Admin.System.slideConfigurePage')->with('slideList',$slideList);
	}

	public function uploadImg(Request $request)
	{      
		$file = $_FILES[$request->input('filename')];
  
        return $this->system->uploadImg($file,'uploads/slide');
	}

	public function createSlide(Request $request)
	{
		$jsonResult = new MessageResult();

		$createSlide = $this->system->createOrUpdateSlide($request->input());

		if ($createSlide) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
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
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
	}


	//----------------银行卡、信用卡管理----------------
	public function creditCardManage()
	{
        $is = $this->isRolePermission("creditcard");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }

		$InternalList = $this->system->getCreditCardList(1);
		$AbroadList = $this->system->getCreditCardList(2);
		return view('Admin.System.creditCardManage')->with('InternalList',$InternalList)->with('AbroadList',$AbroadList);
	}

	public function createCreditCard(Request $request)
	{
		$jsonResult = new MessageResult();

		$createCreditCard = $this->system->createOrUpdateCreditCard($request->input());

		if ($createCreditCard) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
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
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
	}


	//-----------------服务分类管理----------------
	public function serviceSetting()
	{
        $is = $this->isRolePermission("facility-settings");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }

		$serviceCategorylist = $this->system->getServiceCategoryList();
		return view('Admin.System.serviceSetting')->with('serviceCategorylist',$serviceCategorylist);
	}

	public function createServiceCategory(Request $request)
	{
		$jsonResult = new MessageResult();

		$createServiceCategory = $this->system->createOrUpdateServiceCategory($request->input());

		if ($createServiceCategory) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
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
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
	}


	//-----------------酒店服务管理---------------
	public function serviceItems()
	{
        $is = $this->isRolePermission("serviceitems");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }
        
		$serviceItemsList = $this->system->getServiceItemsList();
		return view('Admin.System.serviceItemsPage')->with('serviceItemsList',$serviceItemsList);
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
        }else{
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
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function hotelImageManage()
    {
        $hotelImageManage = $this->system->hotelImageManage();
        return view('Admin.System.hotelImageManage')->with('hotelImageManage',$hotelImageManage);
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
        }else{
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
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }



}




?>