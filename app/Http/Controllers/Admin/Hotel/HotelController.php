<?php

namespace App\Http\Controllers\Admin\Hotel;


use App\Service\Admin\SystemService;
use App\Tool\MessageResult;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Common\CommonService;
use App\Service\Admin\HotelService;
use App\Service\Admin\ImageService;
use App\Models\Hotel;

use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Route;



class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $commonService;
    private $hotelService;
    private $imageService;

    public function __construct(CommonService $commonService, HotelService $hotelService , ImageService $imageService,SystemService $systemService){

        $this->commonService = $commonService;
        $this->hotelService = $hotelService;
        $this->imageService = $imageService;
        $this->SytemService = $systemService;
    }

    public function index()
    {



        $nav =  $this-> getCurrentNav();


        //判断权限
        $getCurrentUser = Session::get('adminusername');
        //查询用户
        $userInfo       = $this->commonService->checkInUser($getCurrentUser);

        //查询有无权限
        $checkIsPerm = $this->commonService->checkIsPermHotel($userInfo);

        if(!$checkIsPerm){

            return redirect(url('admin/Error/NotPermission'));
        }


        $manageHotelList = $this->hotelService->getHotelList();
        if($manageHotelList == "NotPermission"){
            return redirect(url('admin/Error/NotPermission'));
        }else{
            foreach ($manageHotelList as $hotelList) {

                if($hotelList->address != null)
                {


                    $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code,$hotelList->address->type);
                    $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code,$hotelList->address->type);
                    $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code,$hotelList->address->type);
                    $detail = $hotelList->address->detail;

                    $hotelList->addressInfo = $province.$city.$district.$detail;
                }

            }

            return view('Admin.Hotel.manageHotel')->with(['manageHotelList' => $manageHotelList , 'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //


    public function geolocation($hotelId)
    {
        $address = "福建省厦门市思明区凡悦咖啡厅";
        $hotelInfo = new Hotel();
        return view('Admin.Hotel.geoLocation')->with('address',$address)->with('hotelId',$hotelId)->with('hotelInfo',$hotelInfo);
    }

    //todo  修改
    public function insertPolicy(Request $request)
    {
        $isCreate = $this->hotelService->insertPolicy($request->input());

        $createOrupdate = $request->input('createOrupdate');;

        $hotelId = $request->input('hotelId');

        if ($isCreate) {
            $InternalList = $this->hotelService->getCreditList(1);
            $AbroadList = $this->hotelService->getCreditList(2);

            if ($createOrupdate == "update") {
                return redirect(url('admin/manageHotel/editPaymentAndContact/'.$isCreate));
            }
            return view('Admin.Hotel.contactAndPayment')->with('InternalList',$InternalList)->with('AbroadList',$AbroadList)->with('hotelId',$isCreate);
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/2/'.$hotelId));
        }
    }

    public function facility($hotelId)
    {
        $ExtraServiceList = $this->hotelService->getExtraService();
        return view('Admin.Hotel.facility')->with('ExtraServiceList',$ExtraServiceList)->with('hotelId',$hotelId);
    }

    public function contactAndPayment($hotelId)
    {
        $domesticCardList = $this->hotelService->getCreditList(1);
        $internationalCardList = $this->hotelService->getCreditList(2);
        $hotelInfo = new Hotel();

        return view('Admin.Hotel.contactAndPayment')->with('domesticCardList ',$domesticCardList )->with('internationalCardList',$internationalCardList)->with('hotelInfo',$hotelInfo)->with('hotelId',$hotelId);
    }

    public function insertContactPayment(Request $request)
    {
        $isCreate = $this->hotelService->insertContactPayment($request->input());

        $createOrupdate = $request->input('createOrupdate');;

        $hotelId = $request->input('hotelId');
        if ($isCreate) {
            $ExtraServiceList = $this->hotelService->getExtraService();

            if ($createOrupdate == "update") {
                return redirect(url('admin/manageHotel/editFacility/'.$isCreate));
            }
            return view('Admin.Hotel.facility')->with('ExtraServiceList',$ExtraServiceList)->with('hotelId',$isCreate);
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/3/'.$hotelId));
        }
    }

    public function insertFacility(Request $request)
    {
        $isCreate = $this->hotelService->insertFacility($request->input());

        $hotelId = $request->input('hotelId');

        if ($isCreate) {
            return redirect(url('admin/manageHotel/createHotelError/5/0'));
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/4/'.$hotelId));
        }
    }

    public function createHotelError($errorId,$hotelId)
    {
        return view('Admin.Hotel.createHotelError')->with('errorId',$errorId)->with('hotelId',$hotelId);
    }

    public function selectUpOrDown(Request $request)
    {
        $jsonResult = new MessageResult();

        $isUp = $this->hotelService->selectUpOrDown($request->input());

        if ($isUp) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    public function itemUpOrDown(Request $request)
    {
        $jsonResult = new MessageResult();

        $isUp = $this->hotelService->itemUpOrDown($request->input());

        if ($isUp) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 0;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());
    }

    //置顶酒店
    public function toTop(Request $request)
    {
        $jsonResult = new MessageResult();

        $isUp = $this->hotelService->toTop($request);

        if ($isUp) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "置顶成功";
        }else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg = "置顶失败";
        }

        return response($jsonResult->toJson());
    }

    //删除酒店
    public function deleteHotel(Request $request)
    {
        $jsonResult = new MessageResult();

        $isUp = $this->hotelService->deleteHotel($request);

        if ($isUp) {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg = "成功";
        }else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg = "失败";
        }

        return response($jsonResult->toJson());

    }


    //编辑酒店基本信息
    public function editHotel($hotelId)
    {
        $geoData = $this->commonService->getGeoDetail();
        $hotelCategories =
        $hotelInfo = $this->hotelService->getHotelBasicInfo($hotelId);

        $province = $this->commonService->getAdressInfo('province',$hotelInfo->address->province_code);
        $city = $this->commonService->getAdressInfo('city',$hotelInfo->address->city_code);
        $district = $this->commonService->getAdressInfo('district',$hotelInfo->address->district_code);

        $hotelInfo->addressInfo = $province . "-" .$city . "-" . $district;
        $hotelInfo->detail = $hotelInfo->address->detail;

        $hotelInfo->id = $hotelId;

        $createOrUpdate = "update";

        return view('Admin.Hotel.createHotel')->with('geoData',$geoData)->with('hotelInfo',$hotelInfo)->with('createOrUpdate',$createOrUpdate);
    }


    //创建编辑酒店地理信息 //删除
    public function editGeoLocation($hotelId)
    {
        //获取地址信息, 省份代码
        $addressInfo = $this->hotelService->getHotelAddress($hotelId);

        //获取省份城市名字
        $province = $this->commonService->getAdressInfo('province',$addressInfo->province_code);
        $city = $this->commonService->getAdressInfo('city',$addressInfo->city_code);
        $district = $this->commonService->getAdressInfo('district',$addressInfo->district_code);

        $detail = $addressInfo->detail;

        $address = $province . $city . $district .$detail;
        $hotelInfo = $this->hotelService->getStepTwoInfo($hotelId);


        $createOrUpdate = "update";

        return view('Admin.Hotel.geoLocation')->with('address',$address)->with('hotelId',$hotelId)->with('hotelInfo',$hotelInfo)->with('createOrUpdate',$createOrUpdate);
    }

    public function editPaymentAndContact($hotelId)
    {
        $hotelInfo = $this->hotelService->getStepThreeInfo($hotelId);

        $createOrUpdate = "update";

        $itemArr = $hotelInfo->paymentArr;

        $domesticCardList = $this->hotelService->getCreditList(1);
        $internationalCardList = $this->hotelService->getCreditList(2);

        foreach ($domesticCardList as $domesticCard) {

            if (in_array($domesticCard->id, $itemArr)) {
                $domesticCard->ispay = 1;
            }else{
                $domesticCard->ispay = 0;
            }
        }

        foreach ($internationalCardList as $internationalCard) {
            if (in_array($internationalCard->id, $itemArr)) {
                $internationalCard->ispay = 1;
            }else{
                $internationalCard->ispay = 0;
            }
        }

        return view('Admin.Hotel.contactAndPayment')->with('domesticCardList',$domesticCardList)->with('internationalCardList',$internationalCardList)->with('hotelId',$hotelId)->with('hotelInfo',$hotelInfo)->with('createOrUpdate',$createOrUpdate);
    }

    public function editFacility($hotelId)
    {
        $ExtraServiceList = $this->hotelService->getExtraService();
        $StepFourInfo = $this->hotelService->getStepFourInfo($hotelId);

        $createOrUpdate = "update";

        $checkboxArr = explode(',', $StepFourInfo->facilities_checkbox);
        $radioArr = explode(',', $StepFourInfo->facilities_radio);

        for ($i=0; $i < count($radioArr); $i++) { 
            $radioArr[$i] = explode('_', $radioArr[$i]);
        }

        $i = 0;
        foreach ($ExtraServiceList as $ExtraService) {
            if ($i < 4) {
                foreach ($ExtraService as $service) {
                    
                    if (in_array($service->id, $checkboxArr)) {
                        $service->ischeck = 1;
                    }else{
                        $service->ischeck = 0;
                    }
                }
              
            }else{

                foreach ($ExtraService as $service) {
                  
                    foreach ($radioArr as $radioItem) {

                        if ($service->id == $radioItem[0]) {
                            $service->ischeck = $radioItem[1];
                        }
                        
                    }
                    
                }
            }

            $i++;
            
        }

        return view('Admin.Hotel.facility')->with('ExtraServiceList',$ExtraServiceList)->with('hotelId',$hotelId)->with('createOrUpdate',$createOrUpdate);
    }

    public function uploadImage(Request $request)
    {
        return $this->imageService->uploadImage($request);
    }


    
    public function coverHotelImage(Request $request)
    {
        return $this->imageService->coverHotelImage($request->input());
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    //酒店信息回复
    public function hotelInfo($hotelId){

        return view('Admin.Hotel.hotelInfo');
    }



    //////////////////////////////////////////////////////////////////////////////////////////////////////

    //创建酒店 输入基本信息
    public function createHotel()
    {

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '新建酒店';

        $geoData = $this->commonService->getGeoDetail();
        $categoryList = $this->SytemService->getHotelCategories();
        $hotelInfo = new Hotel();
        $createOrUpdate = "create";
        return view('Admin.Hotel.createHotel')->with('geoData',$geoData)
                                              ->with('categoryList',$categoryList)
                                              ->with('hotelInfo',$hotelInfo)
                                              ->with('createOrUpdate',$createOrUpdate)
                                              ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
        //
    }

    //维护酒店基本信息
    public function maintainHotelBasicInfo($hotelId)
    {

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店信息维护';

        $geoData = $this->commonService->getGeoDetail();
        $hotelInfo = $this->hotelService->getHotelBasicInfo($hotelId);

        //酒店分类
        $categories = $this->hotelService->getCategories($hotelId);

        //可选酒店分类列表
        $categoryList = $this->SytemService->getHotelCategories();

        if($hotelInfo->address != null)
        {
            $province = $this->commonService->getAdressInfo('province',$hotelInfo->address->province_code,$hotelInfo->address->type);
            $city = $this->commonService->getAdressInfo('city',$hotelInfo->address->city_code,$hotelInfo->address->type);
            $district = $this->commonService->getAdressInfo('district',$hotelInfo->address->district_code,$hotelInfo->address->type);
            $hotelInfo->addressInfo = $province . "-" .$city . "-" . $district;
        }


        //$hotelInfo->detail = $hotelInfo->address->detail;

        $hotelInfo->id = $hotelId;

        $createOrUpdate = "update";

        return view('Admin.Hotel.maintainHotelBasicInfo')->with('geoData',$geoData)
                                                    ->with('categories',$categories)
                                                    ->with('categoryList',$categoryList)
                                                    ->with('hotelInfo',$hotelInfo)
                                                    ->with('createOrUpdate',$createOrUpdate)
                                                    ->with('hotelId',$hotelId)
                                                    ->with('getMenuName',$getMenuName)
                                                    ->with('SecondMenuName', $SecondMenuName);
    }



    //保存基本信息创建 或 跟新
    public function storeHotel(Request $request)
    {

        //
        $isCreate =  $this->hotelService->createHotel($request);
        //判断是创建酒店 还是更新酒店
        $createOrUpdate = $request->input('createOrupdate');
        if ($isCreate) {
            $province = $this->commonService->getAdressInfo('province',$request->input('provinceCode'),$request->input('addressType'));
            $city = $this->commonService->getAdressInfo('city',$request->input('cityCode'),$request->input('addressType'));
            $district = $this->commonService->getAdressInfo('district',$request->input('districtCode'),$request->input('addressType'));
            $detail = $request->input('hotelAddress');

            $addressInfo = $province.$city.$district.$detail;

            if ($createOrUpdate == "update") {
                $hotelId = $request->input('hotelId');
                return redirect(url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelBasicInfo'));
            }else{
                $hotelInfo = new Hotel();
                //return view('Admin.Hotel.geoLocation')->with('createOrUpdate',$createOrUpdate)->with('hotelInfo',$hotelInfo)->with('address',$addressInfo)->with('hotelId',$isCreate);
                return redirect(url('admin/manageHotel'));
            }

        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/1/0'));
        }

    }

    //维护酒店交通信息
    public function maintainHotelGeoInfo($hotelId){

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店周边信息';


        //获取地址信息, 省份代码
        $addressInfo = $this->hotelService->getHotelAddress($hotelId);

        //获取省份城市名字
        $address = '';
        if($addressInfo != null) {
            $province = $this->commonService->getAdressInfo('province', $addressInfo->province_code,$addressInfo->type);
            $city = $this->commonService->getAdressInfo('city', $addressInfo->city_code,$addressInfo->type);
            $district = $this->commonService->getAdressInfo('district', $addressInfo->district_code,$addressInfo->type);
            $detail = $addressInfo->detail;
            $address= $province . $city . $district .$detail;
        }


        $hotelSurrounding = $this->hotelService->getHotelSurrounding($hotelId);


        $createOrUpdate = "update";

        return view('Admin.Hotel.maintainHotelGeoInfo')
                            ->with('address',$address)
                            ->with('hotelId',$hotelId)
                            ->with('hotelSurrounding',$hotelSurrounding)
                            ->with('createOrUpdate',$createOrUpdate)
                            ->with('getMenuName',$getMenuName)
                            ->with('SecondMenuName', $SecondMenuName);

    }


    //维护酒店周边环境
    public function createOrUpdateSurrounding(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->createOrUpdateSurrounding($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
            $jsonResult->extra = $result;
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }


    //删除酒店周边环境项目
    public function deleteSurroundingItem(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->deleteSurroundingItem($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='删除成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='删除失败';
        }
        return response($jsonResult->toJson());
    }

    //维护酒店政策
    public function maintainHotelPolicy($hotelId)
    {

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店政策';

        $hotelPolicy  = $this->hotelService->getHotelPolicy($hotelId);
        $timespans = ['00:00','00:30','01:00','01:30','02:00','02:30',
                     '03:00','03:30','04:00','04:30','05:00','05:30',
                     '06:00','06:30','07:00','07:00','08:00','08:30',
                     '09:00','09:30','10:00','10:30','11:00','11:30',
                     '12:00','12:30','13:00','13:30','14:00','14:30',
                     '15:00','15:30','16:00','16:30','17:00','17:30',
                     '18:00','18:30','19:00','19:30','20:00','20:30',
                     '21:00','21:30','22:00','22:30','23:00','23:30',
                     '24:00'];
        return view('Admin.Hotel.maintainHotelPolicy')->with('hotelId',$hotelId)
                                                      ->with('hotelPolicy',$hotelPolicy)
                                                      ->with('timespans',$timespans)
                                                      ->with('getMenuName',$getMenuName)
                                                      ->with('SecondMenuName', $SecondMenuName);

    }

    //创建或更新酒店政策
    public function createOrUpdatePolicy(Request $request)
    {

        $result = $this->hotelService->insertPolicy($request);
        $createOrupdate = $request->input('createOrupdate');
        $hotelId = $request->input('hotelId');

        if ($result) {
            return redirect(url('admin/manageHotel/hotelInfo/'.$hotelId.'/maintainHotelPolicy'));
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/2/'.$hotelId));
        }
    }

    //维护酒店联系人
    public function maintainHotelContact($hotelId)
    {


        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店联系人';

        $contactList =  $this->hotelService->getHotelContactList($hotelId);
        return view('Admin.Hotel.maintainHotelContact')->with('hotelId', $hotelId)
                                                       ->with('contactList',$contactList)
                                                        ->with('getMenuName',$getMenuName)
                                                        ->with('SecondMenuName', $SecondMenuName);
    }



    //创建或更新酒店联系人
    public function createOrUpdateContact(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->createOrUpdateContact($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
            $jsonResult->extra = $result;
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());

    }


    //删除酒店联系人
    public function deleteHotelContact(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->deleteHotelContact($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='删除成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='删除失败';
        }
        return response($jsonResult->toJson());
    }

    //维护管理酒店设施
    public function maintainHotelFacilities($hotelId)
    {


        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店设施';

        $createOrUpdate = 'create';
        $hotelFacilities = $this->hotelService->getHotelFacilities($hotelId);


        if($hotelFacilities['settings'] != null)
        {
            $createOrUpdate = 'update';
        }

        return view('Admin.Hotel.maintainHotelFacilities')->with('hotelId',$hotelId)
                                                          ->with('hotelFacilities',$hotelFacilities)
                                                          ->with('createOrUpdate',$createOrUpdate)
                                                          ->with('getMenuName',$getMenuName)
                                                          ->with('SecondMenuName', $SecondMenuName);

    }

    //新增或修改酒店设施
    public function createOrUpdateHotelFacilities(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->createOrUpdateHotelFacilities($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }

    //维护管理酒店餐饮服务
    public function maintainHotelCateringService($hotelId)
    {
        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店餐饮';

        $cateringServiceList=  $this->hotelService->getHotelCateringServiceList($hotelId);
        return view('Admin.Hotel.maintainHotelCateringService')->with('hotelId', $hotelId)
                                                               ->with('cateringServiceList',$cateringServiceList)
                                                               ->with('getMenuName',$getMenuName)
                                                               ->with('SecondMenuName', $SecondMenuName);;
    }


    //新增或修改酒店餐饮服务项目
    public function createOrUpdateHotelCateringItem(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->createOrUpdateHotelCateringItem($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }

    //删除酒店餐饮服务项目
    public function deleteHotelCateringItem(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->deleteHotelCateringItem($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='删除成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='删除失败';
        }
        return response($jsonResult->toJson());
    }

    //维护管理酒店健身娱乐服务
    public function maintainHotelRecreationService($hotelId)
    {

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店健身娱乐';

        $recreationServiceList=  $this->hotelService->getHotelRecreationServiceList($hotelId);
        return view('Admin.Hotel.maintainHotelRecreationService')->with('hotelId', $hotelId)
                                                                 ->with('recreationServiceList',$recreationServiceList)
                                                                 ->with('getMenuName',$getMenuName)
                                                                 ->with('SecondMenuName', $SecondMenuName);
    }


    //新增或修改酒店健身娱乐项目
    public function createOrUpdateHotelRecreationItem(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->createOrUpdateHotelRecreationItem($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }

    //删除酒店健身娱乐项目
    public function deleteHotelRecreationItem(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->deleteHotelRecreationItem($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='删除成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='删除失败';
        }
        return response($jsonResult->toJson());
    }


    //管理酒店图片
    public function maintainHotelImage($hotelId)
    {


        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店图片管理';

        $sectionListAndImage = $this->hotelService->getHotelImages($hotelId);
        return view('Admin.Hotel.maintainHotelImage')->with('sectionListAndImage',$sectionListAndImage)->with('hotelId',$hotelId)->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    //上传酒店图片
    public function uploadHotelImage(Request $request)
    {
        $jsonResult = new MessageResult();
        $jsonResult = $this->imageService->uploadImage($request);
        return response($jsonResult->toJson());
    }

    //删除酒店图片
    public function deleteHotelImage(Request $request){
        $jsonResult = new MessageResult();
        $jsonResult = $this->imageService->deleteHotelImage($request);

        return response($jsonResult->toJson());
    }

    //获取酒店区域图片
    public function getSectionImage(Request $request)
    {
        $jsonResult = new MessageResult();
        //返回酒店区域图片列表
        $result =  $this->hotelService->getSectionImage($request);


        if(count($result) > 0)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='获取成功';
            $jsonResult->extra = $result;
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='暂时没有图片';
        }
        return response($jsonResult->toJson());
    }

    //设置酒店封面图片
    public function setHotelCoverImage(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->setHotelImageCover($request);


        if($result == 1)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='设置成功';

        }
        else if($result == 2){
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='设置失败';
        }
        else{
            $jsonResult->statusCode =3;
            $jsonResult->statusMsg ='封面达到最大数';
        }
        return response($jsonResult->toJson());
    }
    //取消酒店封面图片
    public function cancelHotelCoverImage(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->cancelHotelCoverImage($request);


        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='设置成功';

        }
        else {
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='设置失败';
        }
        return response($jsonResult->toJson());
    }


    //获取酒店封面图片
    public function getHotelCoverImage(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->getHotelCoverImage($request);
        if(count($result) > 0)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='获取成功';
            $jsonResult->extra = $result;
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='暂时没有图片';
        }

        return response($jsonResult->toJson());
    }

    //设置酒店首张图片
    public function setHotelFirstImage(Request $request)
    {
        $jsonResult = new MessageResult();
        $result =  $this->hotelService->setHotelFirstImage($request);


        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='设置成功';

        }
        else {
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='设置失败';
        }
        return response($jsonResult->toJson());
    }


    //////////////////////////////////////////////////////////////////////////////////////////



    //管理房间
    public function manageRoom($hotelId){

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '酒店房型管理';

        $roomList = $this->hotelService->getRoomTypeList($hotelId);
        $bedTypes = $this->hotelService->getAllBedType();
        return view('Admin.Hotel.manageRoom')->with('bedTypes', $bedTypes)->with('roomList',$roomList)->with('hotelId',$hotelId)
                                             ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    //创建新房型
    public function createNewRoom(Request $request)
    {

        $result = $this->hotelService->createNewRoom($request);
        $jsonResult = new MessageResult();

        if($result)
        {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg='创建成功';
        }
        else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg='创建失败';
        }


        return response($jsonResult->toJson());
    }


    public function editRoom($hotelId, $roomId)
    {

        Session::put('currentPath_','/admin/manageHotel');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '编辑房型管理';
        $room = $this->hotelService->editRoom($hotelId,$roomId);
        $bedTypes = $this->hotelService->getAllBedType();
        return view('Admin.Hotel.editRoom')->with('room',$room)->with('bedTypes', $bedTypes)->with('hotelId',$hotelId)->with('roomId',$roomId)
            ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    public function updateRoom(Request $request)
    {

        $room = $this->hotelService->updateRoom($request);
        return redirect('/admin/manageHotel/hotelInfo/'.$request->input('hotelId').'/manageRoom');
    }

    //删除房型
    public function deleteRoom(Request $request)
    {
        $result = $this->hotelService->deleteRoom($request);
        $jsonResult = new MessageResult();

        if($result)
        {
            $jsonResult->statusCode = 1;
            $jsonResult->statusMsg='删除成功';
        }
        else{
            $jsonResult->statusCode = 2;
            $jsonResult->statusMsg='删除失败';
        }

        return response($jsonResult->toJson());
    }


    /******************************/

    //管理酒店房态，主要显示酒店列表
    public function manageRoomStatus()
    {

        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();

        $getMenuName   = $this->commonService->getMenuName($currentUrl);
        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        //判断权限
        $getCurrentUser = Session::get('adminusername');
        //查询用户
        $userInfo       = $this->commonService->checkInUser($getCurrentUser);

        //查询有无权限
        $checkIsPerm = $this->commonService->checkIsPermRoomStatus($userInfo);
        if(!$checkIsPerm) {
            return redirect(url('admin/Error/NotPermission'));
        }
        $manageHotelList = $this->hotelService->getHotelList();

        // dd($manageHotelList);
        foreach ($manageHotelList as $hotelList) {

            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code,$hotelList->address->type);
            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code,$hotelList->address->type);
            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code,$hotelList->address->type);
            $detail = $hotelList->address->detail;
            $hotelList->addressInfo = $province.$city.$district.$detail;

        }

        return view('Admin.RoomStatus.manageRoomStatus')->with(['manageHotelList' => $manageHotelList , 'getMenuName' => $getMenuName, 'firstMenuName' => $firstMenuName]);
    }

    //编辑跟新酒店房态
    public function showRoomStatus(Request $request, $hotelId = 0){

        Session::put('currentPath_','/admin/manageRoomStatus');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '房态维护';

        //post 搜索请求和get 请求都是这个方法

        //获取post的search请求数据
        $date = date('Y-m-d');
        $roomType = '';
        if($request->input('hotelId')!=null)
        {
            $hotelId = $request->input('hotelId');
            $date = $request->input('searchDate');
            $roomType = $request->input('selectedRoomType');

        }


        $weekDayList=[];

        //往后10天的周
        for($i= 0 ; $i<10; $i++){

            //获得房价显示表头的日期 和 周几显示
            if($request->input('hotelId')!=null)
            {
                $weekDay['weekDay'] = $this->getWeek(date('w',strtotime($date) + (86400 * $i)));
                $weekDay['date'] = date('m-d',strtotime($date) + (86400 * $i));
            }
            else{
                $weekDay['weekDay'] = $this->getWeek(date("w",strtotime('+'.$i. 'day')));
                $weekDay['date'] = date("m-d",strtotime('+'.$i. 'day'));
            }

            $weekDayList[] = $weekDay;
        }



        //获取房型列表
        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId,$roomType);

        //获取当前时间房价列表(所有房型)
        $roomStatusMonthList =  $this->hotelService->getRoomStatusList($hotelId,$roomTypeList,$date);

        return view('Admin.RoomStatus.editRoomStatus')->with('roomTypeList',$roomTypeList)
                                                      ->with('weekDayList',$weekDayList)
                                                      ->with('roomStatusMonthList',$roomStatusMonthList)
                                                      ->with('hotelId',$hotelId)
                                                      ->with('selectedDate',$date)
                                                      ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }


    //批量修改房态 show
    public function roomStatusBatch($hotelId)
    {

        Session::put('currentPath_','/admin/manageRoomStatus');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '批量修改房态';

        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        $requestList= $this->hotelService->getRoomStatusBatchLogList($hotelId);
        return view('Admin.RoomStatus.roomStatusBatch')->with('hotelId',$hotelId)->with('roomTypeList',$roomTypeList)->with('requestList',$requestList)
            ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    //提交批量修改房态请求

    public function roomStatusBatchRequestSubmit(Request $request)
    {


        $jsonResult = new MessageResult();
        $result =  $this->hotelService->roomStatusBatchRequestSubmit($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());

    }

    //提交单次房态修改请求
    public function roomStatusUpdateSubmit(Request $request){


        $jsonResult = new MessageResult();
        $result =  $this->hotelService->roomStatusUpdateSubmit($request);

        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }



    //查看批量更改房态改变记录
    public function roomStatusBatchLog($hotelId)
    {


        Session::put('currentPath_','/admin/manageRoomStatus');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '房态修改单';

        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        $logList= $this->hotelService->getRoomStatusBatchLogList($hotelId);
        return view('Admin.RoomStatus.showRoomStatusBatchLog')->with('hotelId',$hotelId)->with('roomTypeList',$roomTypeList)->with('logList',$logList)
                                                              ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

    }

    /***************************************/


    //管理酒店房价，主要显示酒店列表
    public function manageRoomPrice()
    {


        $nav = $this->getCurrentNav();

        //判断权限
        $getCurrentUser = Session::get('adminusername');
        //查询用户
        $userInfo       = $this->commonService->checkInUser($getCurrentUser);

        //查询有无权限
        $checkIsPerm = $this->commonService->checkIsPermRoomPrice($userInfo);
        if(!$checkIsPerm) {
            return redirect(url('admin/Error/NotPermission'));
        }
        $manageHotelList = $this->hotelService->getHotelList();

        // dd($manageHotelList);
        foreach ($manageHotelList as $hotelList) {

            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code,$hotelList->address->type);
            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code,$hotelList->address->type);
            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code,$hotelList->address->type);
            $detail = $hotelList->address->detail;
            $hotelList->addressInfo = $province.$city.$district.$detail;

        }

        return view('Admin.RoomPrice.manageRoomPrice')->with(['manageHotelList' => $manageHotelList , 'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName'] ]);
    }

    //编辑跟新酒店房价
    public function showRoomPrice(Request $request, $hotelId = 0){


        Session::put('currentPath_','/admin/manageRoomPrice');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '房价维护';

        //post 搜索请求和get 请求都是这个方法
        $date = date('Y-m-d');
        //获取post的search请求数据
        $roomType = '';
        if($request->input('hotelId')!=null)
        {
            $hotelId = $request->input('hotelId');
            $date = $request->input('searchDate');
            $roomType = $request->input('selectedRoomType');

        }

        $weekDayList=[];

        //往后10天的周
        for($i= 0 ; $i<10; $i++){

            //获得房价显示表头的日期 和 周几显示
            if($request->input('hotelId')!=null)
            {
                $weekDay['weekDay'] = $this->getWeek(date('w',strtotime($date) + (86400 * $i)));
                $weekDay['date'] = date('m-d',strtotime($date) + (86400 * $i));
            }
            else{
                $weekDay['weekDay'] = $this->getWeek(date("w",strtotime('+'.$i. 'day')));
                $weekDay['date'] = date("m-d",strtotime('+'.$i. 'day'));
            }

            $weekDayList[] = $weekDay;
        }

        //获取房型列表
        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId,$roomType);

        //获取当月房价列表(所有房型)
        $roomPriceMonthList =  $this->hotelService->getRoomPriceList($hotelId,$roomTypeList,$date);


        return view('Admin.RoomPrice.editRoomPrice')->with('roomTypeList',$roomTypeList)
                                                    ->with('roomPriceMonthList',$roomPriceMonthList)
                                                    ->with('weekDayList',$weekDayList)
                                                    ->with('hotelId',$hotelId)
                                                    ->with('selectedDate',$date)
                                                    ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    //获得日期是周几
    public function getWeek($weekday)
    {
        $week=array(
            "0"=>"周日",
            "1"=>"周一",
            "2"=>"周二",
            "3"=>"周三",
            "4"=>"周四",
            "5"=>"周五",
            "6"=>"周六"
        );
        return $week[$weekday];
    }

    //批量修改房价
    public function roomPriceBatch($hotelId){

        Session::put('currentPath_','/admin/manageRoomPrice');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '批量修改房价';



        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        $requestList= $this->hotelService->getRoomPriceBatchRequestList($hotelId);
        return view('Admin.RoomPrice.roomPriceBatch')->with('hotelId',$hotelId)->with('roomTypeList',$roomTypeList)->with('requestList',$requestList)
                                                     ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

    }

    //提交单次房价修改请求
    public function roomPriceUpdateSubmit(Request $request){


        $jsonResult = new MessageResult();
        $result =  $this->hotelService->roomPriceUpdateSubmit($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='更新成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='更新失败';
        }
        return response($jsonResult->toJson());
    }



    //提交批量修改房价请求
    public function roomPriceBatchRequestSubmit(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->roomPriceBatchRequestSubmit($request);
        if($result)
        {
            $jsonResult->statusCode =1;
            $jsonResult->statusMsg ='申请提交成功';
        }
        else{
            $jsonResult->statusCode =2;
            $jsonResult->statusMsg ='申请提交失败';
        }
        return response($jsonResult->toJson());
    }


    //超级管理员 管理批量房价申请
//    public function manageRoomPriceRequest()
//    {
//
//
//        $manageHotelList = $this->hotelService->getHotelList();
//
//        // dd($manageHotelList);
//        foreach ($manageHotelList as $hotelList) {
//
//            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code);
//            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code);
//            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code);
//            $detail = $hotelList->address->detail;
//            $hotelList->addressInfo = $province.$city.$district.$detail;
//
//        }
//        return view('Admin.RoomPrice.manageRoomPriceRequest')->with('manageHotelList',$manageHotelList);
//    }



    //查看批量更改房价改变记录
    public function processRoomPriceRequest($hotelId)
    {
        Session::put('currentPath_','/admin/manageRoomPrice');
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName   = $this->commonService->getMenuName($currentUrl);

        $SecondMenuName = '房价申请单';

        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        $requestList= $this->hotelService->getRoomPriceBatchRequestList($hotelId);
        return view('Admin.RoomPrice.processRoomPriceRequest')->with('hotelId',$hotelId)->with('roomTypeList',$roomTypeList)->with('requestList',$requestList)
            ->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

    }
    //确认房价修改请求
    public function confirmRoomPriceRequest(Request $request)
    {


        $jsonResult = new MessageResult();
        $result = $this->hotelService->confirmRoomPriceRequest($request);
        $jsonResult->statusMsg = '更新完成';
        $jsonResult->statusCode = 1;
        return response($jsonResult->toJson());

    }


    public function getCurrentNav(){
        //获取路由
        $currentUrl    = $this->commonService->getCurrentUrl();


        $getMenuName   = $this->commonService->getMenuName($currentUrl);


        //父级菜单
        $firstMenuName = $this->commonService->firstMenuName($getMenuName);

        $nav['menuName'] = $getMenuName;
        $nav['firstMenuName'] = $firstMenuName;

        return $nav;
    }



}
