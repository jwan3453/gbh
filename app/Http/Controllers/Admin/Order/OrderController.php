<?php

namespace App\Http\Controllers\Admin\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

use App\Service\Admin\OrderService;
use App\Service\Common\CommonService;
use App\Tool\MessageResult;

class OrderController extends Controller
{

    private $orderManage;
    private $commonService;

    public function __construct(OrderService $orderManage,CommonService $commonService){

        $this->orderManage   = $orderManage;
        $this->commonService = $commonService;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//        //判断当前用户是否管理所有酒店
//        $manageIsAllHotel = $this->orderManage->getHotelList();
//        if($manageIsAllHotel){
//            return view('Admin.Order.orderSearchPage')->with('manageIsAllHotel',$manageIsAllHotel);
//        }else{
//            return redirect(url('admin/Error/NotPermission'));
//        }

    }

    public function orderSearchPage()
    {

//        $is = $this->isRolePermission("order-search");
//
//        if (!$is) {
//            return redirect(url('admin/Error/NotPermission'));
//        }

        return view('Admin.Order.orderSearchPage');
    }

    public function untreatedPage()
    {
        return view('Admin.Order.untreatedPage');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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






    //酒店列表
    public function hotelList(){

        $nav =  $this->getCurrentNav();

        //判断当前用户是否管理所有酒店
        $manageIsAllHotel = $this->orderManage->getHotelList();
        if($manageIsAllHotel){

            foreach($manageIsAllHotel as $hotelList){
                if($hotelList->address != null)
                {
                    $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code,$hotelList->address->type);
                    $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code,$hotelList->address->type);
                    $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code,$hotelList->address->type);
                    $detail = $hotelList->address->detail;

                    $hotelList->addressInfo = $province.$city.$district.$detail;

                }
            }

            return view('Admin.Order.manageHotelList')->with(['manageIsAllHotel' => $manageIsAllHotel ,'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);
        }else{
            return redirect(url('admin/Error/NotPermission'));
        }

    }


    //酒店订单查询
    public function hotelOrderSearch($hotelId){

        //判断当前管理酒店状态
        $currentUsername = session('adminusername');
        $getHotelType    = $this->commonService->getHotelType($currentUsername);
        if($getHotelType->hotel_type == 1){

            Session::put('currentPath_','/admin/manageOrders/hotelordersearch');
            $nav =  $this->getCurrentNav();

            //order_status = 0 未处理; 1 支付完结;  2 订单取消  ; 3 未入住  ; 4 未确认
            //pay_status   = 0 未支付; 1 已支付;
            //payment_type = 0 银联;  1 支付宝;  3 微信;


            //酒店订单信息

            $hotelOrderInfo = $this->orderManage->hotelOrderInfo($hotelId);
            if($hotelOrderInfo){

                return view('Admin.Order.hotelOrderSearch',compact('hotelOrderInfo'))->with(['hotelId' => $hotelId,'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);

            }else{

            }


        }

        if($getHotelType->hotel_type == 2){

            Session::put('currentPath_','/admin/manageOrders/hotellist');
            //获取路由
            $currentUrl    = $this->commonService->getCurrentUrl();
            //父级菜单
            $getMenuName   = $this->commonService->getMenuName($currentUrl);

            $SecondMenuName = '订单查询';

            $hotelOrderInfo = $this->orderManage->AllHotelOrderInfo();

            return view('Admin.Order.hotelOrderSearch',compact('hotelOrderInfo','getRoomType'))->with(['getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

        }


    }

    //post订单查询

    public function orderSearchForHotel(Request $request){
        $hotelId       = $request->input('get-hotel-id');
        if($hotelId){
            $searchResult = $this->orderManage->hotelOrderSearchResult($request);

            $jsonResult = new MessageResult();

            if($searchResult){
                $jsonResult->statusCode =1;
                $jsonResult->extra = $searchResult;
            }else{
                $jsonResult->statusCode =2;
            }

            return response($jsonResult->toJson());
        }else{
            $searchResult = $this->orderManage->orderSearchResult($request);

            $jsonResult = new MessageResult();

            if($searchResult){
                $jsonResult->statusCode =1;
                $jsonResult->extra = $searchResult;
            }else{
                $jsonResult->statusCode =2;
            }

            return response($jsonResult->toJson());
        }
    }

    //获取面包屑导航菜单
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

    //查看订单详情
    public function detailOrderInfo($orderSn){

        Session::put('currentPath_','/admin/manageOrders/hotelordersearch');
        //获取路由
        $currentUrl     = $this->commonService->getCurrentUrl();
        //父级菜单
        $getMenuName    = $this->commonService->getMenuName($currentUrl);

        //订单信息
        $getDetailInfo  = $this->orderManage->getDetailInfo($orderSn);

        $SecondMenuName = $getDetailInfo->hotelDetail->name.'订单详情';


        return view('admin.Order.detailOrderDisplay')->with(['getDetailInfo' => $getDetailInfo,'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);
    }

    //未处理订单
    public function unprocessedOrders($hotelId){

        //判断当前管理酒店状态
        $currentUsername = session('adminusername');
        $getHotelType    = $this->commonService->getHotelType($currentUsername);
        if($getHotelType->hotel_type == 1){

            Session::put('currentPath_','/admin/manageOrders/unprocessedorders');
            $nav =  $this->getCurrentNav();

            $unprocessedOrders = $this->orderManage->hotelUnprocessedOrders($hotelId);

            if($unprocessedOrders != null){
                //该订单数量
                $countOrders = $this->orderManage->countOrders($hotelId);
            }else{
                $countOrders = 0;
            }

            return view('admin.Order.hotelUnprocessedOrders',compact('unprocessedOrders'))->with(['countOrders'=>$countOrders ,'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);

        }

        if($getHotelType->hotel_type == 2){

            Session::put('currentPath_','/admin/manageOrders/hotellist');
            //获取路由
            $currentUrl     = $this->commonService->getCurrentUrl();
            //父级菜单
            $getMenuName    = $this->commonService->getMenuName($currentUrl);

            $SecondMenuName = '未处理订单';

            $unprocessedOrders = $this->orderManage->hotelUnprocessedOrders($hotelId);

            if($unprocessedOrders != null){
                //该订单数量
                $countOrders = $this->orderManage->countOrders($hotelId);
            }else{
                $countOrders = 0;
            }

            return view('Admin.Order.hotelUnprocessedOrders',compact('unprocessedOrders'))->with(['countOrders' => $countOrders,'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

        }



    }

    //今日订单
    public function todayOrders($hotelId){

        //判断当前管理酒店状态
        $currentUsername = session('adminusername');
        $getHotelType    = $this->commonService->getHotelType($currentUsername);
        if($getHotelType->hotel_type == 1){
            Session::put('currentPath_','/admin/manageOrders/todayorders');
            $nav =  $this->getCurrentNav();

            $todayOrders = $this->orderManage->getTodayOrders($hotelId);

            if($todayOrders != null){
                //该订单数量
                $countOrders = $this->orderManage->todayOrdersCount($hotelId);

            }else{

                $countOrders = 0;

            }

            return view('admin.Order.todayOrders',compact('todayOrders'))->with(['countOrders' => $countOrders,'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);
        }

        if($getHotelType->hotel_type == 2){

            Session::put('currentPath_','/admin/manageOrders/hotellist');
            //获取路由
            $currentUrl     = $this->commonService->getCurrentUrl();
            //父级菜单
            $getMenuName    = $this->commonService->getMenuName($currentUrl);

            $SecondMenuName = '今日订单';

            $todayOrders = $this->orderManage->getTodayOrders($hotelId);

            if($todayOrders != null){
                //该订单数量
                $countOrders = $this->orderManage->todayOrdersCount($hotelId);

            }else{

                $countOrders = 0;

            }

            return view('Admin.Order.todayOrders',compact('todayOrders'))->with(['countOrders' => $countOrders,'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

        }


    }

    //所有订单
    public function allOrders($hotelId){

        //判断当前管理酒店状态
        $currentUsername = session('adminusername');
        $getHotelType    = $this->commonService->getHotelType($currentUsername);

        if($getHotelType->hotel_type == 1){
            Session::put('currentPath_','/admin/manageOrders/allorders');
            $nav =  $this->getCurrentNav();

            //酒店订单信息

            $hotelOrderInfo = $this->orderManage->hotelOrderInfo($hotelId);

            if($hotelOrderInfo != null){
                //该订单数量
                $countOrders = $this->orderManage->countOrders($hotelId);
            }else{
                $countOrders = 0;
            }

            return view('Admin.Order.allOrders',compact('hotelOrderInfo'))->with(['countOrders' => $countOrders,'getMenuName' => $nav['menuName'], 'firstMenuName' => $nav['firstMenuName']]);

        }

        if($getHotelType->hotel_type == 2){

            Session::put('currentPath_','/admin/manageOrders/hotellist');
            //获取路由
            $currentUrl     = $this->commonService->getCurrentUrl();
            //父级菜单
            $getMenuName    = $this->commonService->getMenuName($currentUrl);

            $SecondMenuName = '所有订单';

            $hotelOrderInfo = $this->orderManage->hotelOrderInfo($hotelId);

            if($hotelOrderInfo != null){
                //该订单数量
                $countOrders = $this->orderManage->countOrders($hotelId);
            }else{
                $countOrders = 0;
            }

            return view('Admin.Order.allOrders',compact('hotelOrderInfo'))->with(['countOrders' => $countOrders,'getMenuName' => $getMenuName, 'SecondMenuName' => $SecondMenuName]);

        }

    }

}
