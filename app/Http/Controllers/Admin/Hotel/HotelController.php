<?php

namespace App\Http\Controllers\Admin\Hotel;


use App\Tool\MessageResult;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Common\CommonService;
use App\Service\Admin\HotelService;
use App\Service\Admin\ImageService;
use App\Models\Hotel;

use App\Models\RoomPrice;

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

    public function __construct(CommonService $commonService, HotelService $hotelService , ImageService $imageService){

        $this->commonService = $commonService;
        $this->hotelService = $hotelService;
        $this->imageService = $imageService;
    }

    public function index()
    {
        $is = $this->isRolePermission("hotel-manage");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }

        $manageHotelList = $this->hotelService->getHotelList();

        // dd($manageHotelList);
        foreach ($manageHotelList as $hotelList) {

            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code);
            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code);
            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code);
            $detail = $hotelList->address->detail;

            $hotelList->addressInfo = $province.$city.$district.$detail;


        }

        return view('Admin.Hotel.manageHotel')->with('manageHotelList',$manageHotelList);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHotel()
    {
        $geoData = $this->commonService->getGeoDetail();
        $hotelInfo = new Hotel();
        $createOrUpdate = "create";
        return view('Admin.Hotel.createHotel')->with('geoData',$geoData)->with('hotelInfo',$hotelInfo)->with('createOrUpdate',$createOrUpdate);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    //
    public function storeHotel(Request $request)
    {
        //
        $isCreate =  $this->hotelService->createHotel($request);
        //判断是创建酒店 还是更新酒店
        $createOrUpdate = $request->input('createOrupdate');
        if ($isCreate) {
            $province = $this->commonService->getAdressInfo('province',$request->input('provinceCode'));
            $city = $this->commonService->getAdressInfo('city',$request->input('cityCode'));
            $district = $this->commonService->getAdressInfo('district',$request->input('districtCode'));
            $detail = $request->input('hotelAddress');

            $addressInfo = $province.$city.$district.$detail;

            if ($createOrUpdate == "update") {
                return redirect(url('admin/manageHotel/editGeoLocation/'.$isCreate));
            }else{
                $hotelInfo = new Hotel();
                return view('Admin.Hotel.geoLocation')->with('createOrUpdate',$createOrUpdate)->with('hotelInfo',$hotelInfo)->with('address',$addressInfo)->with('hotelId',$isCreate);
            }
            
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/1/0'));
        }

    }

    public function geolocation($hotelId)
    {
        $address = "福建省厦门市思明区凡悦咖啡厅";
        $hotelInfo = new Hotel();
        return view('Admin.Hotel.geoLocation')->with('address',$address)->with('hotelId',$hotelId)->with('hotelInfo',$hotelInfo);
    }

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

    //编辑酒店基本信息
    public function editHotel($hotelId)
    {
        $geoData = $this->commonService->getGeoDetail();
        $hotelInfo = $this->hotelService->getStepOneInfo($hotelId);

        $province = $this->commonService->getAdressInfo('province',$hotelInfo->address->province_code);
        $city = $this->commonService->getAdressInfo('city',$hotelInfo->address->city_code);
        $district = $this->commonService->getAdressInfo('district',$hotelInfo->address->district_code);

        $hotelInfo->addressInfo = $province . "-" .$city . "-" . $district;
        $hotelInfo->detail = $hotelInfo->address->detail;

        $hotelInfo->id = $hotelId;

        $createOrUpdate = "update";

        return view('Admin.Hotel.createHotel')->with('geoData',$geoData)->with('hotelInfo',$hotelInfo)->with('createOrUpdate',$createOrUpdate);
    }


    //创建编辑酒店地理信息
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

    public function deleteHotelImage(Request $request)
    {
        return $this->imageService->deleteHotelImage($request->input());
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



    //管理房间
    public function manageRoom($hotelId){
        $roomList = $this->hotelService->getRoomTypeList($hotelId);
        $bedTypes = $this->hotelService->getAllBedType();
        return view('Admin.Hotel.manageRoom')->with('bedTypes', $bedTypes)->with('roomList',$roomList)->with('hotelId',$hotelId);
    }

    //创建新房型
    public function createNewRoom(Request $request)
    {

        $this->hotelService->createNewRoom($request);
        $jsonResult = new MessageResult();
        $jsonResult->statusCode = 1;
        $jsonResult->statusMsg='创建成功';

        return response($jsonResult->toJson());
    }


    public function editRoom($hotelId, $roomId)
    {

        $room = $this->hotelService->editRoom($hotelId,$roomId);
        $bedTypes = $this->hotelService->getAllBedType();
        return view('Admin.Hotel.editRoom')->with('room',$room)->with('bedTypes', $bedTypes)->with('hotelId',$hotelId)->with('roomId',$roomId);
    }

    public function updateRoom(Request $request)
    {
        $room = $this->hotelService->updateRoom($request);
        return redirect('/admin/manageHotel/hotelInfo/'.$request->input('hotelId').'/manageRoom');
    }

    public function manageHotelImage($hotelId)
    {
        $list = $this->hotelService->gethotelImageManageCategory($hotelId);
        
        return view('Admin.Hotel.manageHotelImagePage')->with('list',$list)->with('hotelId',$hotelId);
    }

    //管理酒店房态，主要显示酒店列表
    public function manageRoomStatus()
    {

        $manageHotelList = $this->hotelService->getHotelList();

        // dd($manageHotelList);
        foreach ($manageHotelList as $hotelList) {

            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code);
            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code);
            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code);
            $detail = $hotelList->address->detail;
            $hotelList->addressInfo = $province.$city.$district.$detail;

        }

        return view('Admin.RoomStatus.manageRoomStatus')->with('manageHotelList',$manageHotelList);
    }

    //编辑跟新酒店房态
    public function editRoomStatus($hotelId){

        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        return view('Admin.RoomStatus.editRoomStatus')->with('manageHotelList',$roomTypeList);
    }

    //管理酒店房价，主要显示酒店列表
    public function manageRoomPrice()
    {

        $manageHotelList = $this->hotelService->getHotelList();

        // dd($manageHotelList);
        foreach ($manageHotelList as $hotelList) {

            $province = $this->commonService->getAdressInfo('province',$hotelList->address->province_code);
            $city = $this->commonService->getAdressInfo('city',$hotelList->address->city_code);
            $district = $this->commonService->getAdressInfo('district',$hotelList->address->district_code);
            $detail = $hotelList->address->detail;
            $hotelList->addressInfo = $province.$city.$district.$detail;

        }

        return view('Admin.RoomPrice.manageRoomPrice')->with('manageHotelList',$manageHotelList);
    }

    //编辑跟新酒店房态
    public function editRoomPrice($hotelId){

//
//
//        //测试插入数据
//        for($i= 0 ; $i<31; $i++)
//        {
//            $test = new RoomPrice();
//            $test->hotel_id = 1;
//            $test->room_id = 34;
//            $test->rate = 199;
//            $test->prepaid_rate=189;
//            $test->num_of_breakfast = 2;
//            $test->date =  date("Y-m-d",mktime(0, 0 , 0,date("m"),$i+1,date("Y")));;
//            $test->save();
//        }
//
//
        $weekDayList=[];

        //往后10天的周
        for($i= 0 ; $i<10; $i++){



            $weekDay['weekDay'] = $this->getWeek(date("w",strtotime('+'.$i. 'day')));
            $weekDay['date'] = date("m-d",strtotime('+'.$i. 'day'));

            $weekDayList[] = $weekDay;

        }
        //dd($weekDayList);

        //获取房型列表
        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);

        //获取当月房价列表(所有房型)
        $roomPriceMonthList =  $this->hotelService->getRoomCurrentMonthPriceList($hotelId,$roomTypeList);


        return view('Admin.RoomPrice.editRoomPrice')->with('roomTypeList',$roomTypeList)->with('roomPriceMonthList',$roomPriceMonthList)->with('weekDayList',$weekDayList)->with('hotelId',$hotelId);
    }


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

        $roomTypeList = $this->hotelService->getRoomTypeList($hotelId);
        $requestList= $this->hotelService->getRoomPriceBatchRequestList($hotelId);
        return view('Admin.RoomPrice.roomPriceBatch')->with('hotelId',$hotelId)->with('roomTypeList',$roomTypeList)->with('requestList',$requestList);

    }

    //提交批量修改房价请求
    public function roomPriceBatchRequestSubmit(Request $request)
    {

        $jsonResult = new MessageResult();
        $result =  $this->hotelService->roomPriceBatchRequestSubmit($request);
        if($request)
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


    public function roomPriceBatchProcess(Request $request)
    {


        $jsonResult = new MessageResult();

        $hotelId = $request->input('hotelId');
        //房型
        $roomType = $request->input('roomType');
        //付款方式
        $payType = $request->input('payType');

        //改价日期范围
        $dateFrom = $request->input('dateRangeFrom');
        $dateTo = $request->input('dateRangeTo');

        //早餐份数
        $breakfast = $request->input('breakfast');

        //是否包括整个周
        $weekAll =  $request->input('weekAll');

        //有效天
        $validWeekDay = [];


        //是否区分周末
        $weekendOn=  $request->input('weekendOn');

        //平时价格和佣金
        $weekdayRate  = $request->input('weekdayRate');
        $weekdayComm  = $request->input('weekdayComm');

        //周末价格和佣金
        $weekendRate = 0;
        $weekendComm = 0;

        if($weekendOn != null)
        {

            //平时价格和佣金
            $weekendRate  = $request->input('weekendRate');
            $weekendComm  = $request->input('weekendComm');

        }

        if($weekAll == null)
        {
            if($request->input('mon'))
            {
                $validWeekDay[] = 1;
            }
            if($request->input('tue'))
            {
                $validWeekDay[] = 2;
            }
            if($request->input('wed'))
            {
                $validWeekDay[] = 3;
            }
            if($request->input('thr'))
            {
                $validWeekDay[] = 4;
            }
            if($request->input('fri'))
            {
                $validWeekDay[] = 5;
            }
            if($request->input('sat'))
            {
                $validWeekDay[] = 6;
            }
            if($request->input('sun'))
            {
                $validWeekDay[] = 0;
            }
        }


        //时间差的天数
        $daysRange=round((strtotime($dateTo)-strtotime( $dateFrom))/86400)+1;

        //当天的价格是否更新
        $update =false;
        //是否是周末
        $isWeekEnd = false;
        //更新房型列表
        $roomTypeList = [];

        if($roomType ==0)
        {
            $roomTypeList =  $this->hotelService->getRoomTypeList($hotelId);
        }
        else{
            $roomTypeList = $this->hotelService->getRoomTypeByRoomId($hotelId,$roomType);
        }


        foreach( $roomTypeList as $room) {

            for($i=0; $i<$daysRange; $i++)
            {

                //每次循环日期 + 1
                $date = date('Y-m-d',strtotime($dateFrom) + (86400 * $i));

                $oldPrice = RoomPrice::where(['hotel_id'=>$hotelId,
                    'room_id' =>$room->id,
                    'date'=>$date])->first();


                //根据选择的天数来更新价格
                //整个周末都更新
                if($weekAll != null)
                {
                    $update =true;
                }
                //用户没有选择 默认更新全部
                else if($weekAll ==null && count($validWeekDay) == 0 ) {
                    $validWeekDay = true;
                }else{

                    //只更新选择的平时天
                    if(in_array(date('w',strtotime($date)),$validWeekDay))
                    {
                        $update =true;

                    }
                    else{
                        $update =false;
                    }
                }
                //判断是否为周末
                if($update)
                {

                    if(in_array(date('w',strtotime($date)),array(5,6)))
                    {
                        $isWeekEnd = true;
                    }
                    else{
                        $isWeekEnd = false;
                    }

                }


                //价格记录不存在, 创建新的价格
                if($oldPrice == null)
                {

                    if($update)
                    {
                        $newRoomPrice = new RoomPrice();
                        $newRoomPrice->hotel_id = $hotelId;
                        $newRoomPrice->room_id = $room->id;
                        //跟新现付 还是 预付
                        if($payType == 1)
                        {
                            //如果有区分平时跟周末

                            if($weekendOn !=null &&  $isWeekEnd)
                            {

                                $newRoomPrice->rate  = $weekendRate;
                                $newRoomPrice->commission = $weekendComm;
                            }
                            else{
                                $newRoomPrice->rate  = $weekdayRate;
                                $newRoomPrice->commission = $weekdayComm;
                            }

                            $newRoomPrice->num_of_breakfast = $breakfast;

                        }
                        else{
                            if($weekendOn !=null &&  $isWeekEnd)
                            {
                                $newRoomPrice->prepaid_rate  = $weekendRate;
                                $newRoomPrice->prepaid_commission = $weekendComm;
                            }
                            else{
                                $newRoomPrice->prepaid_rate  = $weekdayRate;
                                $newRoomPrice->prepaid_commission = $weekdayComm;
                            }

                            $newRoomPrice->prepaid_num_of_breakfast = $breakfast;
                        }

                        $newRoomPrice->date = $date;
                        $newRoomPrice->save();
                    }

                }
                //跟新价格记录
                else{


                    if($update) {

                        if ($payType == 1) {

                            //如果有区分平时跟周末
                            if($weekendOn !=null &&  $isWeekEnd)
                            {
                                $oldPrice->rate  = $weekendRate;
                                $oldPrice->commission = $weekendComm;
                            }
                            else{
                                $oldPrice->rate  = $weekdayRate;
                                $oldPrice->commission = $weekdayComm;
                            }
                            $oldPrice->num_of_breakfast = $breakfast;
                        }
                        else
                        {
                            if($weekendOn !=null &&  $isWeekEnd)
                            {
                                $oldPrice->prepaid_rate  = $weekendRate;
                                $oldPrice->prepaid_commission = $weekendComm;
                            }
                            else{
                                $oldPrice->prepaid_rate  = $weekdayRate;
                                $oldPrice->prepaid_commission = $weekdayComm;
                            }

                            $oldPrice->prepaid_num_of_breakfast = $breakfast;
                        }

                        $oldPrice->save();
                    }
                }
            }


        }

        $jsonResult->statusMsg = '更新完成';
        $jsonResult->statusCode = 1;
        return response($jsonResult->toJson());

    }

}
