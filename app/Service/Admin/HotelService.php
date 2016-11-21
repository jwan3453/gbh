<?php
namespace App\Service\Admin;

use App\Models\BedType;

use App\Models\RoomStatusBatchLog;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Requests;


use App\Models\Hotel;
Use App\Models\Bed;
use App\Models\Room;
use App\Models\Address;
use App\Models\hotelPolicy;
use App\Models\CreditCard;
use App\Models\HotelExtra;
use App\Models\HotelContact;
use App\Models\ExtraService;
use App\Models\HotelSectionImage;
use App\Models\RoomPrice;
use App\Models\RoomPriceBatchRequest;
use App\Models\RoomStatus;
use App\Models\HotelSurrounding;
use App\Models\HotelSection;
use App\Models\HotelImage;
use App\Models\HotelFacility;
use App\Models\HotelFacilityList;
use App\Models\HotelFacilityCategory;
use App\Models\Category;
use App\Models\HotelCategory;
use App\Models\HotelCateringService;
use App\Models\HotelRecreationService;
use App\Service\Admin\ImageService;

use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

use Qiniu\Auth as QiniuAuth;
use Qiniu\Storage\UploadManager;
use Qiniu\Storage\BucketManager;
use App\Tool\MessageResult;



class HotelService {


    private $accessKey = 'aavEmxVT7o3vsFMGKUZbJ1udnoAbucqXPmk3tdRX';
    private $secretKey ='nDQPr1L7pcurdV8_7iLIICNjSME2EmCiokHXTGTX';
    private $bucket = 'gbhchina';
    private $auth;

    public function getHotelList()
    {
        $list = Hotel::select('id','name','address_id','status')->get();
        foreach ($list as $hotelItem) {
            $hotelItem->address = Address::select('province_code','city_code','district_code','detail','type')->where('id',$hotelItem->address_id)->first();
        }
        return $list;
    }

    //创建或更新酒店(第一步)
    public function createHotel(Request $request)
    {
        $isSuccess = false;

        $createOrupdate = $request->input('createOrupdate');

        //储存酒店地址
        if ($createOrupdate == "update") {
            $newAddress = Address::find($request->input('addressId'));
        }else{
            $newAddress = new Address();
        }
        $newAddress->type = $request->input('addressType');
        $newAddress->province_code = $request->input('provinceCode');
        $newAddress->city_code = $request->input('cityCode');
        if($newAddress->type == 2)
        {
            $newAddress->district_code = '';
        }
        else{
            $newAddress->district_code = $request->input('districtCode');
        }

        $newAddress->detail = $request->input('hotelAddress');
        $newAddress->detail_en = $request->input('hotelAddressEn');
        if($newAddress->save())
        {



            //酒店明细
            if ($createOrupdate == "update") {
                $newHotel = Hotel::find($request->input('hotelId'));
            }else{
                $newHotel = new Hotel();
            }
            $newHotel->code = $request->input('hotelCode');
            $newHotel->name = $request->input('hotelName');
            $newHotel->name_en = $request->input('hotelNameEn');

            $newHotel->phone =$request->input('hotelPhone');//-------总机
            $newHotel->fax  = $request->input('hotelFax');//--------商务传真
            $newHotel->postcode  = $request->input('hotelPostcode');
            $newHotel->website =  $request->input('hotelWebsite');
            $newHotel->total_rooms = $request->input('hotelTotalRooms');
            $newHotel->hotel_features = $request->input('hotelFeature');
            $newHotel->hotel_features_en = $request->input('hotelFeatureEn');
            $newHotel->description = $request->input('hotelDescription');
            $newHotel->description_en = $request->input('hotelDescriptionEn');
            $newHotel->address_id = $newAddress->id;//------获取上一步新增地址所插入数据库的ID

            if ($newHotel->save()) {
                $isSuccess = $newHotel->id;
            }

            //处理酒店分类列表
            $cateList = explode('|',$request->input('selectCateList'));
            $cateList =array_filter($cateList);
            $newHotel->categories()->sync($cateList);


        }

        return $isSuccess;
    }

    // 创建或更新酒店政策
    public function insertPolicy(Request $request)
    {


        $hotelId = $request->input('hotelId');
        $checkinTime = $request->input('checkinTime');// . " | " . $request->input('checkinTimeTo');
        $checkoutTime = $request->input('checkoutTime');// . " | " . $request->input('checkoutTimeTo');

        // dd($request['createOrupdate']);


        $createOrupdate = $request['createOrupdate'];
        $policyId = $request['policyId'];


//
//
//        if ($createOrupdate == "update") {
//            $hotelPolicy = hotelPolicy::find($policyId);
//            if($hotelPolicy == null)
//            {
//                $hotelPolicy = new hotelPolicy();
//            }
//        }else{
//            $hotelPolicy = new hotelPolicy();
//        }

        $hotelPolicy = hotelPolicy::where('hotel_id',$hotelId)->first();

        if($hotelPolicy == null)
        {
            $hotelPolicy = new hotelPolicy();
            $hotelPolicy->hotel_id = $hotelId;
        }


        $hotelPolicy->checkin_time = $checkinTime;
        $hotelPolicy->checkout_time = $checkoutTime;
        $hotelPolicy->prepaid_deposit = $request->input('prepaidDeposit');
        $hotelPolicy->prepaid_deposit_en = $request->input('prepaidDepositEn');

        $hotelPolicy->airport_transfer = $request->input('airportTransfer');
        $hotelPolicy->airport_transfer_en = $request->input('airportTransferEn');

        $hotelPolicy->pay_policy = $request->input('payPolicy');
        $hotelPolicy->pay_policy_en = $request->input('payPolicyEn');

        $hotelPolicy->pet_policy = $request->input('petPolicy');
        $hotelPolicy->pet_policy_en = $request->input('petPolicyEn');

        $hotelPolicy->catering_arrangements = $request->input('cateringArrangements');
        $hotelPolicy->catering_arrangements_en = $request->input('cateringArrangementsEn');

        $hotelPolicy->service_fee_policy = $request->input('serviceFeePolicy');
        $hotelPolicy->service_fee_policy_en = $request->input('serviceFeePolicyEn');

        $hotelPolicy->other_policy = $request->input('otherPolicy');
        $hotelPolicy->other_policy_en = $request->input('otherPolicyEn');

//        if ($hotelPolicy->save()) {
////            $newHotel = Hotel::find($request['hotelId']);
////            $newHotel->surrounding_environment = $request['surrounding'];
//////            $newHotel->longitude = $request['longitude'];
//////            $newHotel->latitude = $request['latitude'];
////            $newHotel->policy_id = $hotelPolicy->id;
////
////            if ($newHotel->save()) {
////                $isInsert = $request['hotelId'];
////            }
//
//        }

        return $hotelPolicy->save();
    }

    public function getCreditList($creditType)
    {
        $list = CreditCard::select('id','credit_name')->where('credit_type',$creditType)->get();
      
        return $list;
    }

    public function insertContactPayment($request)
    {
        $isSuccess = false;

        $count = $request['contactCount'];
        
        if ($request['createOrupdate'] == "update") {

            $hotelId = $request['hotelId'];
            $contactIdArr = $request['contactId'];

            $contactIdlist = HotelContact::where('hotel_id',$hotelId)->select('id')->get();

            $updateDate = array();
            foreach ($contactIdlist as $contactid) {
                $id = $contactid->id;

                //----数据库中的联系人ID若有在提交的ID数组中，则修改
                if (in_array($contactid->id, $contactIdArr)) {
                    $updateDate['hotel_id'] = $request['hotelId'];
                    $updateDate['name'] = $request['contactName'][$id];
                    $updateDate['tel'] = $request['contactTel'][$id];
                    $updateDate['phone'] = $request['contactPhone'][$id];
                    $updateDate['duties'] = $request['contactDuties'][$id];
                    $updateDate['fax'] = $request['contactFax'][$id];
                    $updateDate['email'] = $request['contactEmail'][$id];

                    HotelContact::where('id',$id)->update($updateDate);
                }else{
                    //------否则删除----
                    HotelContact::where('id',$id)->delete();
                }

                //------将处理过的数据从数组中移除
                unset($request['contactName'][$id]);
                unset($request['contactTel'][$id]);
                unset($request['contactPhone'][$id]);
                unset($request['contactDuties'][$id]);
                unset($request['contactFax'][$id]);
                unset($request['contactEmail'][$id]);

                $count = $count - 1;
            }
            //---------是否还有剩余的数据，如果有则插入新的联系人
            if ($count > 0) {
                //------剩余的联系人数组重新排序----
                shuffle($request['contactName']);
                shuffle($request['contactTel']);
                shuffle($request['contactPhone']);
                shuffle($request['contactDuties']);
                shuffle($request['contactFax']);
                shuffle($request['contactEmail']);

                //-----构成插入数据数组----
                $newInsertData = array();
                for ($i=0; $i < $count; $i++) { 
                    $newInsertData[$i]['hotel_id'] = $request['hotelId'];
                    $newInsertData[$i]['name'] = $request['contactName'][$i];
                    $newInsertData[$i]['tel'] = $request['contactTel'][$i];
                    $newInsertData[$i]['phone'] = $request['contactPhone'][$i];
                    $newInsertData[$i]['duties'] = $request['contactDuties'][$i];
                    $newInsertData[$i]['fax'] = $request['contactFax'][$i];
                    $newInsertData[$i]['email'] = $request['contactEmail'][$i];
                }

                HotelContact::insert($newInsertData);
            }

            $updatePaymentItem = '';
            $paymentCount = count($request['serviceItems']);
            for ($i=0; $i < $paymentCount; $i++) { 
                $updatePaymentItem .= $request['serviceItems'][$i];
                if ($i != $paymentCount - 1) {
                    $updatePaymentItem .= ",";
                }
            }

            HotelExtra::where('hotel_id',$hotelId)->update(["payment_json"=>$updatePaymentItem]);
            
            $isSuccess = $request['hotelId'];

        }else{

            $insertData = array();

            for ($i=0; $i < $count; $i++) { 

                $insertData[$i]['hotel_id'] = $request['hotelId'];
                $insertData[$i]['name'] = $request['contactName'][$i];
                $insertData[$i]['tel'] = $request['contactTel'][$i];
                $insertData[$i]['phone'] = $request['contactPhone'][$i];
                $insertData[$i]['duties'] = $request['contactDuties'][$i];
                $insertData[$i]['fax'] = $request['contactFax'][$i];
                $insertData[$i]['email'] = $request['contactEmail'][$i];
               
            }

            $isInsert = HotelContact::insert($insertData);

            $paymentItem = '';
            $paymentCount = count($request['serviceItems']);
            for ($i=0; $i < $paymentCount; $i++) { 
                $paymentItem .= $request['serviceItems'][$i];
                if ($i != $paymentCount - 1) {
                    $paymentItem .= ",";
                }
            }

            $insertExtra = HotelExtra::insert(["hotel_id"=>$request['hotelId'],"payment_json"=>$paymentItem]);

            if ($isInsert && $insertExtra) {
                $isSuccess = $request['hotelId'];
            }
        }

        return $isSuccess;
    }

    public function getExtraService()
    {
        $extraServiceList = ExtraService::select('id','extra_name','service_type')->get();

        $extraServiceList = $extraServiceList->groupBy('service_type');

        return $extraServiceList;
    }

    public function insertFacility($insertData)
    {
        $hotelId = $insertData['hotelId'];
        // $createOrupdate = $insertData['createOrupdate'];

        $isSuccess = false;

        $a = '';
        $serviceItems = $insertData['serviceItems'];
        for ($i = 0; $i < count($serviceItems); $i++) {

            $a .= $serviceItems[$i];
            if ($i != count($serviceItems) - 1) {
                $a .= ",";
            }
        }

        unset($insertData['serviceItems']);
        unset($insertData['_token']);
        unset($insertData['hotelId']);
        unset($insertData['createOrupdate']);

        $b = '';
        $radioCount = count($insertData);
        $s = 0;
        foreach ($insertData as $key => $radioData) {
            $b .= $radioData;
            if ($s != $radioCount - 1) {
                $b .= ",";
            }
            $s++;
        }

        $insertFacility = HotelExtra::where('hotel_id', $hotelId)->update(["facilities_checkbox" => $a, "facilities_radio" => $b]);

        if ($insertFacility) {
            $isSuccess = $hotelId;
        }

        return $isSuccess;
    }

    public function getAllBedType(){
        return BedType::all();
    }



    //////////////////////////////////////////////////////////////////
    //获取房型列表
    public function getRoomTypeList($hotelId,$roomId = 0){

        $query['hotel_id'] =$hotelId;
        if($roomId != 0 )
        {
            $query['id'] =$roomId;
        }
        return Room::where($query )->select('id','room_name','rack_rate','num_of_people','acreage')->get();
    }

    public function getRoomTypeByRoomId($hotelId,$roomId){
        return Room::where(['hotel_id'=>$hotelId,'id'=>$roomId])->select('id','room_name')->get();
    }


    //获得房前时间10天内所有房型的房态
    public function getRoomStatusList($hotelId,$roomTypeList,$date)
    {
        //页面一行显示几天的数据(10天)
        $selectCount  = 10;
        $statusList = [];
        //当月的开始 结束时间段
        $startDate = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m",strtotime($date)),date("d",strtotime($date)),date("Y",strtotime($date))));
        $endDate = date("Y-m-d H:i:s",mktime(23,59,59,date("m",strtotime($date)),date("d",strtotime($date))+($selectCount-1),date("Y",strtotime($date))));
        foreach($roomTypeList as $roomType )
        {
            $statusList[$roomType->room_name] = RoomStatus::where(['hotel_id'=>$hotelId,'room_id'=>$roomType->id])->whereBetween('date',array($startDate,$endDate))->select('room_id','room_status','num_of_blocked_room','num_of_sold_room','prepaid_room_status','prepaid_num_of_blocked_room','prepaid_num_of_sold_room','date')->get();

            $validStatusCount = count($statusList[$roomType->room_name]);

            //如果选出来的有效数据不到10,向数组中冲入空白数组

            for($i = 0; $i< $selectCount -$validStatusCount; $i++ )
            {
                $emptyRoomStatus = new  RoomStatus();
                $emptyRoomStatus->date = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")+$validStatusCount+$i,date("Y")));
                $emptyRoomStatus->room_status = '暂无设置';
                $emptyRoomStatus->prepaid_room_status = '暂无设置';
                $emptyRoomStatus->emptyStatus = true;

                $statusList[$roomType->room_name] [] =  $emptyRoomStatus;
            }

        }

        return $statusList;
    }

    //获取批量修改房态记录列表
    public function getRoomStatusBatchLogList($hotelId)
    {
        return RoomStatusBatchLog::where('hotel_id',$hotelId)->get();
    }



    //提交处理批量修改房态请求
    public function roomStatusBatchRequestSubmit(Request $request)
    {

        $hotelId = $request->input('hotelId');

        //选择的房型
        $roomTypeList = explode(' ', trim($request->input('selectedRoomType')));

        //付款方式
        $payType = $request->input('payType');

        //改房态日期范围
        $dateFrom = $request->input('dateRangeFrom');
        $dateTo = $request->input('dateRangeTo');

        //获取房间状态
        $roomStatus = $request->input('roomStatus');

        //获取保留房数量
        $numOfBlockedRoom= $request->input('numOfBlockedRoom');

        //时间差的天数
        $daysRange=round((strtotime($dateTo)-strtotime( $dateFrom))/86400)+1;

        foreach($roomTypeList as $room) {

            $newRoomStatusChangeLog = new RoomStatusBatchLog();
            $newRoomStatusChangeLog->hotel_id = $hotelId;
            $newRoomStatusChangeLog->room_id = $room;
            $newRoomStatusChangeLog->pay_type = $payType;
            $newRoomStatusChangeLog->date_from = $dateFrom;
            $newRoomStatusChangeLog->date_to = $dateTo;
            $newRoomStatusChangeLog->room_status = $roomStatus;
            $newRoomStatusChangeLog->num_of_blocked_room = $numOfBlockedRoom;
            $newRoomStatusChangeLog->is_guarantee = 1;
            $newRoomStatusChangeLog->request_date = date('Y-m-d');

            //log 存入数据库
            if(!$newRoomStatusChangeLog->save())
            {
                //return false;
            }


            //循环处理房态更改请求 --房价的更改需要审批，但是房态不用 可直接修改
            //每次循环日期 + 1
            for($i=0; $i<$daysRange; $i++)
            {
                $date = date('Y-m-d', strtotime($dateFrom) + (86400 * $i));

                $oldStatus = RoomStatus::where(['hotel_id' => $hotelId,
                    'room_id' => $room,
                    'date' => $date])->first();


                //价格记录不存在, 创建新的价格
                if($oldStatus == null)
                {
                    $newRoomStatus = new RoomStatus();
                    $newRoomStatus->hotel_id = $hotelId;
                    $newRoomStatus->room_id = $room;

                    //跟新现付 还是 预付
                    if($payType == 1)
                    {

                        $newRoomStatus->room_status = $roomStatus;
                        $newRoomStatus->num_of_blocked_room = $numOfBlockedRoom;


                    }
                    else if($payType == 2){
                        $newRoomStatus->prepaid_room_status = $roomStatus;
                        $newRoomStatus->prepaid_num_of_blocked_room = $numOfBlockedRoom;
                    }
                    //现付预付都更新
                    else{

                        $newRoomStatus->room_status = $roomStatus;
                        $newRoomStatus->num_of_blocked_room = $numOfBlockedRoom;
                        $newRoomStatus->prepaid_room_status = $roomStatus;
                        $newRoomStatus->prepaid_num_of_blocked_room = $numOfBlockedRoom;
                    }

                    //$newRoomStatus->is_guarantee = 1;//默认
                    $newRoomStatus->date = $date;
                    $newRoomStatus->save();
                }
                //跟新房态记录
                else{

                    //跟新现付 还是 预付
                    if($payType == 1)
                    {

                        $oldStatus->room_status = $roomStatus;
                        $oldStatus->num_of_blocked_room = $numOfBlockedRoom;


                    }
                    else if($payType == 2){
                        $oldStatus->prepaid_room_status = $roomStatus;
                        $oldStatus->prepaid_num_of_blocked_room = $numOfBlockedRoom;
                    }
                    //现付预付都更新
                    else{

                        $oldStatus->room_status = $roomStatus;
                        $oldStatus->num_of_blocked_room = $numOfBlockedRoom;
                        $oldStatus->prepaid_room_status = $roomStatus;
                        $oldStatus->prepaid_num_of_blocked_room = $numOfBlockedRoom;
                    }

                    //$newRoomStatus->is_guarantee = 1;//默认
                    $oldStatus->save();
                }
            }
        }

        return true;
    }



    //获取当时间10天内所有房型的价格
    public function getRoomPriceList($hotelId,$roomTypeList,$date)
    {

        //页面一行显示几天的数据(10天)
        $selectCount  = 10;
        $priceList = [];
        //当月的开始 结束时间段
        $startDate = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m",strtotime($date)),date("d",strtotime($date)),date("Y",strtotime($date))));
        $endDate = date("Y-m-d H:i:s",mktime(23,59,59,date("m",strtotime($date)),date("d",strtotime($date))+($selectCount-1),date("Y",strtotime($date))));
        foreach($roomTypeList as $roomType )
        {
            $priceList[$roomType->room_name] = RoomPrice::where(['hotel_id'=>$hotelId,'room_id'=>$roomType->id])->whereBetween('date',array($startDate,$endDate))->select('room_id','rate','prepaid_rate','commission','prepaid_commission','num_of_breakfast','prepaid_num_of_breakfast','date')->get();

            $validPriceCount = count($priceList[$roomType->room_name]);

            //如果选出来的有效数据不到10,向数组中冲入空白数组

            for($i = 0; $i< $selectCount -$validPriceCount; $i++ )
            {
                $emptyRoomPrice = new  RoomPrice();
                $emptyRoomPrice->date = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d")+$validPriceCount+$i,date("Y")));
                $emptyRoomPrice->rate = '暂无房价';
                $emptyRoomPrice->prepaid_rate = '暂无房价';
                $emptyRoomPrice->emptyPrice = true;

                $priceList[$roomType->room_name] [] =  $emptyRoomPrice;
            }

        }

        return $priceList;
    }



    //获取批量修改房价申请列表
    public function getRoomPriceBatchRequestList($hotelId)
    {
        return RoomPriceBatchRequest::where('hotel_id',$hotelId)->get();
    }



    //提交单次房态修改请求
    public function roomStatusUpdateSubmit(Request $request)
    {
        $hotelId = $request->input('hotelId');
        $roomId = $request->input('roomId');
        $payType= $request->input('payType');
        $date = $request->input('date');
        $numOfBlockedRoom = $request->input('numOfBlockedRoom');
        $roomStatus = $request->input('roomStatus');

        $updateRoomStatus=  RoomStatus::where(['hotel_id'=>$hotelId,
            'room_id'=>$roomId,
            'date'=>$date])->first();
        if($payType==1)
        {
            $updateRoomStatus->num_of_blocked_room =$numOfBlockedRoom;
            $updateRoomStatus->room_status = $roomStatus;

        }
        else{
            $updateRoomStatus->prepaid_num_of_blocked_room =$numOfBlockedRoom;
            $updateRoomStatus->prepaid_room_status = $roomStatus;
        }

        return $updateRoomStatus->save();
    }



    //提交单次房价修改请求
    public function roomPriceUpdateSubmit(Request $request)
    {

        $hotelId = $request->input('hotelId');
        $roomId = $request->input('roomId');
        $payType= $request->input('payType');
        $date = $request->input('date');
        $roomRate = $request->input('roomRate');
        $roomComm = $request->input('roomComm');
        $breakfast = $request->input('breakfast');

         $roomPrice =  RoomPrice::where(['hotel_id'=>$hotelId,
                                        'room_id'=>$roomId,
                                        'date'=>$date])->first();
        if($payType==1)
        {
            $roomPrice->rate =$roomRate;
            $roomPrice->commission = $roomComm;
            $roomPrice->num_of_breakfast = $breakfast;
        }
        else{
            $roomPrice->prepaid_rate =$roomRate;
            $roomPrice->prepaid_commission = $roomComm;
            $roomPrice->prepaid_num_of_breakfast = $breakfast;
        }
        return $roomPrice->save();
    }






    //记录批量修改申请
    public function roomPriceBatchRequestSubmit(Request $request){

        $hotelId = $request->input('hotelId');

        //选择的房型
        $roomTypeList = explode(' ', trim($request->input('selectedRoomType')));

        //付款方式
        $payType = $request->input('payType');

        //改价日期范围
        $dateFrom = $request->input('dateRangeFrom');
        $dateTo = $request->input('dateRangeTo');

        //早餐份数
        $breakfast = $request->input('breakfast');

        //是否包括整个周
        $weekAll =  is_null($request->input('weekAll')) ?  '' : 1;


        //有效天
        $validWeekDay = '';


        //是否区分周末
        $weekendOn=  is_null($request->input('weekendOn')) ? '' : 1 ;


        if($weekAll == null)
        {
            if($request->input('mon'))
            {
                $validWeekDay = '1';
            }
            if($request->input('tue'))
            {
                $validWeekDay = $validWeekDay.'|2';
            }
            if($request->input('wed'))
            {
                $validWeekDay = $validWeekDay.'|3';
            }
            if($request->input('thr'))
            {
                $validWeekDay = $validWeekDay.'|4';
            }
            if($request->input('fri'))
            {
                $validWeekDay = $validWeekDay.'|5';
            }
            if($request->input('sat'))
            {
                $validWeekDay = $validWeekDay.'|6';
            }
            if($request->input('sun'))
            {
                $validWeekDay = $validWeekDay.'|0';
            }
        }


        foreach($roomTypeList as $room)
        {
            $newRoomPriceBatchRequest= New RoomPriceBatchRequest();
            $newRoomPriceBatchRequest->hotel_id = $hotelId;
            $newRoomPriceBatchRequest->room_id = $room;
            $newRoomPriceBatchRequest->pay_type = $payType;
            $newRoomPriceBatchRequest->request_date_from = $dateFrom;
            $newRoomPriceBatchRequest->request_date_to = $dateTo;
            $newRoomPriceBatchRequest->breakfast = $breakfast;
            $newRoomPriceBatchRequest->is_all_week = $weekAll;
            $newRoomPriceBatchRequest->selected_week_day = $validWeekDay;
            $newRoomPriceBatchRequest->is_weekend = $weekendOn;
            //平时价格和佣金
            $newRoomPriceBatchRequest->week_day_rate = $request->input($room.'_weekdayRate');
            $newRoomPriceBatchRequest->week_day_comm = $request->input($room.'_weekdayComm');
            //周末价格和佣金
            $newRoomPriceBatchRequest->weekend_rate = $request->input($room.'_weekendRate');
            $newRoomPriceBatchRequest->weekend_comm = $request->input($room.'_weekendComm');
            $newRoomPriceBatchRequest->status = 0;
            $newRoomPriceBatchRequest->comment = '';
            $newRoomPriceBatchRequest->request_date = date('Y-m-d');
            $newRoomPriceBatchRequest->approve_date = '';
            if(!$newRoomPriceBatchRequest->save())
            {
                return false;
            }
        }

        return true;
    }


    public function confirmRoomPriceRequest(Request $request){
        $requestId = $request->input('requestId');

        $requestDetail = RoomPriceBatchRequest::find($requestId);


        $hotelId = $requestDetail->hotel_id;
        //房型
        $roomType = $requestDetail->room_id;
        //付款方式
        $payType = $requestDetail->payType;

        //改价日期范围
        $dateFrom = $requestDetail->request_date_from;
        $dateTo = $requestDetail->request_date_to;

        //早餐份数
        $breakfast = $requestDetail->breakfast;

        //是否包括整个周
        $weekAll =  $requestDetail->is_all_week;

        //有效天
        $validWeekDay = explode('|',$requestDetail->selected_week_day);


        //是否区分周末
        $weekendOn=  $requestDetail->is_weekend;

        //平时价格和佣金
        $weekdayRate  = $requestDetail->week_day_rate;
        $weekdayComm  = $requestDetail->week_day_comm;

        //周末价格和佣金
        $weekendRate = $requestDetail->weekend_rate;
        $weekendComm = $requestDetail->weekend_comm;

//
//        if($weekAll == 0)
//        {
//            if($request->input('mon'))
//            {
//                $validWeekDay[] = 1;
//            }
//            if($request->input('tue'))
//            {
//                $validWeekDay[] = 2;
//            }
//            if($request->input('wed'))
//            {
//                $validWeekDay[] = 3;
//            }
//            if($request->input('thr'))
//            {
//                $validWeekDay[] = 4;
//            }
//            if($request->input('fri'))
//            {
//                $validWeekDay[] = 5;
//            }
//            if($request->input('sat'))
//            {
//                $validWeekDay[] = 6;
//            }
//            if($request->input('sun'))
//            {
//                $validWeekDay[] = 0;
//            }
//        }


        //时间差的天数
        $daysRange=round((strtotime($dateTo)-strtotime( $dateFrom))/86400)+1;

        //判断价格是否更新
        $update =false;
        //是否是周末
        $isWeekEnd = false;
        //更新房型列表
        $roomTypeList = [];


        $roomTypeList = $this->getRoomTypeByRoomId($hotelId,$roomType);

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
                    $newRoomPrice = new RoomPrice();
                    $newRoomPrice->hotel_id = $hotelId;
                    $newRoomPrice->room_id = $room->id;
                    if($update)
                    {
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

                    }
                    //插入空数据
                    else{
                        $newRoomPrice->date = $date;
                    }
                    $newRoomPrice->save();

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
        //标记状态为已处理
        $requestDetail->status =1;
        $requestDetail->approve_date = date('Y-m-d');
        $requestDetail->save();
        return true;
    }


//////////////////////////////////////////////////////////////////////

    public function createNewRoom(Request $request)
    {
        //创建新房间

        $newRoom = new Room();
        $newRoom->hotel_id = $request->input('hotelId');
        $newRoom->room_name = $request->input('roomName');
        $newRoom->room_name_en = $request->input('roomNameEn');
        $newRoom->rack_rate = $request->input('rackRate');
        $newRoom->num_of_people = $request->input('numOfPeople');
        $newRoom->num_of_children = $request->input('numOfChildren');
        $newRoom->num_of_rooms = $request->input('numOfRooms');
        $newRoom->num_of_breakfast = $request->input('numOfBreakFast');
        $newRoom->acreage = $request->input('acreage');
        $newRoom->floor = $request->input('floor');

        $newRoom->location_info = $request->input('locationInfo');
        $newRoom->location_info_en = $request->input('locationInfoEn');

        $newRoom->other_info = $request->input('otherInfo');
        $newRoom->other_info_en = $request->input('otherInfoEn');


        $newRoom->room_description = $request->input('description');
        $newRoom->room_description_en = $request->input('descriptionEn');

        $newRoom->is_extra_bed = $request->input('extraBed');
        $newRoom->wifi =  $request->input('wifi');
        $newRoom->smoke= $request->input('smoke');

//        $new
        if($newRoom->save())
        {
            $this->createNewBeds($request,$newRoom->id);
            return true;
        }
        else
            return false;

    }

    public function editRoom($hotelId, $roomId){
        $room =  Room::where('id',$roomId)->firstOrFail();
        $room->doubleBed = Bed::where(['room_id'=>$roomId, 'room_bed_category'=>'doubleBed'])->first();
        $room->singleBed = Bed::where(['room_id'=>$roomId, 'room_bed_category'=>'singleBed'])->first();
        $room->largeBed = Bed::where(['room_id'=>$roomId, 'room_bed_category'=>'largeBed'])->first();
        $room->multiBed = Bed::where(['room_id'=>$roomId, 'room_bed_category'=>'multiBed'])->get();

        return $room;

    }


    public function updateRoom(Request $request)
    {

        $room = Room::where('id',$request->input('roomId'))->firstOrFail();


        $room->room_name = $request->input('roomName');
        $room->room_name_en = $request->input('roomNameEn');
        $room->rack_rate = $request->input('rackRate');
        $room->num_of_people = $request->input('numOfPeople');
        $room->num_of_children = $request->input('numOfChildren');
        $room->num_of_rooms = $request->input('numOfRooms');
        $room->num_of_breakfast = $request->input('numOfBreakfast');
        $room->acreage = $request->input('acreage');
        $room->floor = $request->input('floor');

        $room->location_info = $request->input('locationInfo');
        $room->location_info_en = $request->input('locationInfoEn');

        $room->other_info = $request->input('otherInfo');
        $room->other_info_en = $request->input('otherInfoEn');

        $room->room_description = $request->input('description');
        $room->room_description_en = $request->input('descriptionEn');

        $room->is_extra_bed = $request->input('extraBed');
        $room->wifi =  $request->input('wifi');
        $room->smoke= $request->input('smoke');

        if($room->save())
        {
            //先删除之前的保存的床
            Bed::where('room_id',$request->input('roomId'))->delete();
            $this->createNewBeds($request,$request->input('roomId'));

        }
        return $room;
    }


    //删除
    public function deleteRoom(Request $request)
    {

        //todo 删除房间图片
        Bed::where('room_id',$request->input('roomId'))->delete();
        return Room::where('id',$request->input('roomId'))->delete();
    }

    public function createNewBeds(Request $request,$roomId)
    {


        if($request->input('doubleBed')!= null && $request->input('doubleBed') == 'on')
        {
            $newBed = new Bed();
            $newBed->hotel_id = $request->input('hotelId');
            $newBed->room_id = $roomId;
            $newBed->room_bed_category = 'doubleBed';
            $newBed->bed_type_id= $request->input('doubleBedType');
            $newBed->length = $request->input('lengthOfDoubleBed');
            $newBed->width = $request->input('widthOfDoubleBed');
            $newBed->num_of_beds = $request->input('numOfDoubleBed');
            $newBed->save();
        }

        if($request->input('singleBed')!= null && $request->input('singleBed') == 'on')
        {
            $newBed = new Bed();
            $newBed->hotel_id = $request->input('hotelId');
            $newBed->room_id = $roomId;
            $newBed->room_bed_category = 'singleBed';
            $newBed->bed_type_id = $request->input('singleBedType');
            $newBed->length = $request->input('lengthOfSingleBed');
            $newBed->width = $request->input('widthOfSingleBed');
            $newBed->num_of_beds = $request->input('numOfSingleBed');
            $newBed->save();

        }
        if($request->input('largeBed')!= null && $request->input('largeBed') == 'on')
        {
            $newBed = new Bed();
            $newBed->hotel_id = $request->input('hotelId');
            $newBed->room_id = $roomId;
            $newBed->room_bed_category = 'largeBed';
            $newBed->bed_type_id = $request->input('largeBedType');
            $newBed->length = $request->input('lengthOfLargeBed');
            $newBed->width = $request->input('widthOfLargeBed');
            $newBed->num_of_beds = $request->input('numOfLargeBed');
            $newBed->save();
        }
        if($request->input('multiBed')!= null && $request->input('multiBed') == 'on')
        {

            $MultiBedCount =  count($request->input('widthOfMultiBed'));
            for( $i=0; $i<$MultiBedCount; $i++)
            {
                $newBed = new Bed();
                $newBed->hotel_id = $request->input('hotelId');
                $newBed->room_id =$roomId;
                $newBed->room_bed_category = 'multiBed';
                $newBed->bed_type_id = $request->input('multiBedType')[$i];
                $newBed->length = $request->input('lengthOfMultiBed')[$i];
                $newBed->width = $request->input('widthOfMultiBed')[$i];
                $newBed->num_of_beds = $request->input('numOfMultiBed')[$i];
                $newBed->save();
            }
        }
    }



    public function selectUpOrDown($request)
    {
        $selectArr = $request['selectArr'];
        $type = $request['type'] == 'up' ? 1 : 0;
        $isUpdate = true;
        foreach ($selectArr as $item) {
            $update = Hotel::where('id',$item)->update(['status'=>$type]);
            if (!$update) {
                $isUpdate = false;
            }
        }

        return $isUpdate;
    }

    public function itemUpOrDown($request)
    {
        $type = $request['type'] == 'up' ? 1 : 0;
        $hotelId = $request['hotelId'];
        $isUpdate = false;

        $update = Hotel::where('id',$hotelId)->update(['status'=>$type]);

        if ($update) {
            $isUpdate = true;
        }

        return $isUpdate;
    }

    //置顶酒店
    public function toTop( $request)
    {
        $hotelId = $request->input('hotelId');
        $hotel = Hotel::where('id',$hotelId)->first();
        $hotel->updated_at =Carbon::now();
        return $hotel->save();
    }

    //删除酒店
    public function deleteHotel( $request)
    {
        $hotelId = $request->input('hotelId');

        $hotel = Hotel::where('id',$hotelId)->first();


        if($hotel != null)
        {
            //删除酒店地址
            Address::where('id',$hotel->address_id)->delete();

            //删除酒店周边环境项目
            HotelSurrounding::where('hotel_id',$hotelId)->delete();

            //删除酒店政策
            HotelPolicy::where('hotel_id',$hotelId)->delete();

            //删除酒店联系人
            HotelContact::where('hotel_id',$hotelId)->delete();

            //删除酒店设施配置
            HotelFacility::where('hotel_id',$hotelId)->delete();

            //删除酒店图片
           $hotelImages =  HotelImage::where('hotel_id',$hotelId)->get();

            //从云端删除图片
            $imageService = new ImageService();
            foreach($hotelImages  as $image)
            {
                $result = $imageService->deleteImage($image->link);
                if($result->statusCode == 1)
                {
                    $image->delete();
                }
            }

            //删除酒店房间信息
            $rooms = Room::where('hotel_id',$hotelId)->get();
            foreach($rooms as $room)
            {
                if( Bed::where('room_id',$room->id)->delete())
                {
                    $room->delete();
                }
            }

        }

        return $hotel->delete();

    }


    //获取酒店基本信息
    public function getHotelBasicInfo($hotelId)
    {
        $hotelInfo = Hotel::where('id',$hotelId)->select('code','name','name_en','address_id','postcode','phone','fax','website','total_rooms','hotel_features','hotel_features_en','description','description_en')->first();

        $hotelInfo->address = Address::where('id',$hotelInfo->address_id)->select('province_code','city_code','district_code','detail','detail_en','type')->first();

        return $hotelInfo;

    }
    //获取酒店地址
    public function getHotelAddress($hotelId = 0)
    {
        $addressId ='';
        $hotel= Hotel::where('id',$hotelId)->select('address_id')->first();

        if($hotel != null)
        {
            $addressId =$hotel->address_id;
        }
        else{
            abort(404);
        }


        return Address::where('id',$addressId)->select('province_code','city_code','district_code','detail')->first();
    }

    //todo 修改
    public function getStepTwoInfo($hotelId)
    {
        $surrounding_environment = Hotel::where('id',$hotelId)->select('surrounding_environment')->first()->surrounding_environment;

        $itemArr = explode('|', $surrounding_environment);

        $hotelPolicy = hotelPolicy::where('hotel_id',$hotelId)->select('id','check_time','checkout_time','prepaid_deposit','catering_arrangements','other_policy')->first();


        if($hotelPolicy != null)
        {
            $check_time = explode(' | ', $hotelPolicy->check_time);


            $hotelPolicy->checkTimeFrom = $check_time[0];
            if(count($check_time) ==2)
                $hotelPolicy->checkTimeTo = $check_time[1];

            $checkout_time = explode(' | ', $hotelPolicy->checkout_time);

            $hotelPolicy->checkoutTimeFrom = $checkout_time[0];
            if(count($checkout_time) ==2)
                $hotelPolicy->checkoutTimeTo = $checkout_time[1];
        }



        $StepTwoInfo = new Hotel();
        $StepTwoInfo->itemArr = $itemArr;
        $StepTwoInfo->hotelPolicy = $hotelPolicy;
        $StepTwoInfo->surrounding_environment = $surrounding_environment;

        return $StepTwoInfo;
    }


    //获取已分配的酒店分类
    public function getCategories($hotelId)
    {
        return Hotel::find($hotelId)->Categories;
    }



    //获取酒店周边交通信息
    public function getHotelSurrounding($hotelId)
    {
        $hotelSurrounding = HotelSurrounding::where('hotel_id',$hotelId)->get();
        return $hotelSurrounding;
    }

    //添加或修改酒店周边环境
    public function createOrUpdateSurrounding(Request $request)
    {

        $createOrUpdate  = $request->input('createOrUpdate');
        if($createOrUpdate == 'create')
        {
            $surrounding = new HotelSurrounding();
            $surrounding->hotel_id = $request->input('hotelId');
            $surrounding->name = $request->input('name');
            $surrounding->name_en = $request->input('nameEn');
            $surrounding->distance = $request->input('distance');
            $surrounding->by_taxi = $request->input('byTaxi');
            $surrounding->by_walk = $request->input('byWalk');
            $surrounding->by_bus = $request->input('byBus');
            $surrounding->by_Sub = $request->input('bySub');
            $surrounding->save();
            return $surrounding->id;
        }
        else{

            $surrounding =  HotelSurrounding::find($request->input('surroundingId'));
            $surrounding->name = $request->input('name');
            $surrounding->name_en = $request->input('nameEn');
            $surrounding->distance = $request->input('distance');
            $surrounding->by_taxi = $request->input('byTaxi');
            $surrounding->by_walk = $request->input('byWalk');
            $surrounding->by_bus = $request->input('byBus');
            $surrounding->by_Sub = $request->input('bySub');
            return $surrounding->save();

        }

    }


    //删除周边环境项目
    public function deleteSurroundingItem(Request $request){
        return HotelSurrounding::where('id',$request->input('surroundingId'))->delete();
    }


    //获得酒店政策
    public function getHotelPolicy($hotelId)
    {

        $hotelPolicy = hotelPolicy::where('hotel_id',$hotelId)->first();


//        if($hotelPolicy != null)
//        {
//            $check_time = explode(' | ', $hotelPolicy->checkin_time);
//
//
//            $hotelPolicy->checkinTimeFrom = $check_time[0];
//            if(count($check_time) ==2)
//                $hotelPolicy->checkinTimeTo = $check_time[1];
//
//            $checkout_time = explode(' | ', $hotelPolicy->checkout_time);
//
//            $hotelPolicy->checkoutTimeFrom = $checkout_time[0];
//            if(count($checkout_time) ==2)
//                $hotelPolicy->checkoutTimeTo = $checkout_time[1];
//        }


        return $hotelPolicy;

    }


    //获得酒店联系人列表
    public function getHotelContactList($hotelId)
    {
        $contactList = HotelContact::where('hotel_id', $hotelId)->get();
        return $contactList;
    }

    //创建或更新酒店联系人
    public function createOrUpdateContact(Request $request)
    {
        $createOrUpdate  = $request->input('createOrUpdate');
        if($createOrUpdate == 'create')
        {
            $surrounding = new HotelContact();
            $surrounding->hotel_id = $request->input('hotelId');
            $surrounding->name = $request->input('name');
            $surrounding->telephone = $request->input('telephone');
            $surrounding->mobile = $request->input('mobile');
            $surrounding->position = $request->input('position');
            $surrounding->fax = $request->input('fax');
            $surrounding->email = $request->input('email');
            $surrounding->save();
            return $surrounding->id;
        }
        else{

            $surrounding =  HotelContact::find($request->input('contactId'));
            $surrounding->name = $request->input('name');
            $surrounding->telephone = $request->input('telephone');
            $surrounding->mobile = $request->input('mobile');
            $surrounding->position = $request->input('position');
            $surrounding->fax = $request->input('fax');
            $surrounding->email = $request->input('email');
            return $surrounding->save();

        }
    }


    //删除酒店联系人
    public function deleteHotelContact(Request $request){
        return HotelContact::where('id',$request->input('contactId'))->delete();
    }


    //获取酒店设施列表
    public function getHotelFacilities($hotelId)
    {
        $facilities = [];
        $facilities['settings'] = HotelFacility::where('hotel_id', $hotelId)->select('facilities_checkbox')->first();

        $facilities['category'] =  HotelFacilityCategory::all();
        $facilitiesList = [];
        foreach($facilities['category'] as $category)
        {
            $facilitiesList[$category->id] = HotelFacilityList::where('category',$category->id)->get();

        }
        $facilities['list'] = $facilitiesList;
        return $facilities;


    }

    //新增或修改酒店设施
    public function createOrUpdateHotelFacilities(Request $request)
    {


        $createOrUpdate = $request->input('createOrUpdate');
        $hotelId = $request->input('hotelId');
        $selectedFacilityArray =  $request->input('facilityItem');
        $selectedFacilityList = '';
        for($i = 0; $i<count($selectedFacilityArray); $i++)
        {
            $selectedFacilityList = $selectedFacilityList.$selectedFacilityArray[$i];
            if($i != count($selectedFacilityArray) -1 )
            {
                $selectedFacilityList = $selectedFacilityList.',';
            }
        }



        if ($createOrUpdate == "update") {
            $hotelFacility = HotelFacility::where('hotel_id',$hotelId)->first();
            $hotelFacility->facilities_checkbox = $selectedFacilityList;

            return $hotelFacility->save();
        }else{
            $newHotelFacility = new HotelFacility();
            $newHotelFacility -> hotel_id  = $hotelId;
            $newHotelFacility -> facilities_checkbox = $selectedFacilityList;
            return $newHotelFacility->save();
        }

    }



    //获取酒店餐饮服务列表
    public function getHotelCateringServiceList($hotelId)
    {
        return HotelCateringService::where('hotel_id',$hotelId)->get();
    }



    //创建或更酒店餐饮服务项目
    public function createOrUpdateHotelCateringItem(Request $request)
    {
        $createOrUpdate  = $request->input('createOrUpdate');
        if($createOrUpdate == 'create')
        {
            $cateringItem = new HotelCateringService();
            $cateringItem->hotel_id = $request->input('hotelId');
            $cateringItem->name = $request->input('name');
            $cateringItem->name_en = $request->input('nameEn');
            $cateringItem->size = $request->input('size');
            $cateringItem->num_of_table = $request->input('numOfTable');
            $cateringItem->description = $request->input('description');
            $cateringItem->description_en = $request->input('descriptionEn');
            $cateringItem->business_hour = $request->input('businessHour');
            $cateringItem->save();
            return $cateringItem->id;
        }
        else{

            $cateringItem =  HotelCateringService::find($request->input('cateringId'));
            $cateringItem->name = $request->input('name');
            $cateringItem->name_en = $request->input('nameEn');
            $cateringItem->size = $request->input('size');
            $cateringItem->num_of_table = $request->input('numOfTable');
            $cateringItem->description = $request->input('description');
            $cateringItem->description_en = $request->input('descriptionEn');
            $cateringItem->business_hour = $request->input('businessHour');
            return $cateringItem->save();

        }
    }


    //删除酒店餐饮服务项目
    public function deleteHotelCateringItem(Request $request){
        return HotelCateringService::where('id',$request->input('cateringId'))->delete();
    }




    //获取酒店健身娱乐列表
    public function getHotelRecreationServiceList($hotelId)
    {
        return HotelRecreationService::where('hotel_id',$hotelId)->get();
    }


    //创建或更酒店健身娱乐项目
    public function createOrUpdateHotelRecreationItem(Request $request)
    {
        $createOrUpdate  = $request->input('createOrUpdate');
        if($createOrUpdate == 'create')
        {
            $recreationItem = new HotelRecreationService();
            $recreationItem->hotel_id = $request->input('hotelId');
            $recreationItem->name = $request->input('name');
            $recreationItem->name_en = $request->input('nameEn');
            $recreationItem->num = $request->input('num');
            $recreationItem->description = $request->input('description');
            $recreationItem->description_en = $request->input('descriptionEn');
            $recreationItem->business_hour = $request->input('businessHour');
            $recreationItem->save();
            return $recreationItem->id;
        }
        else{

            $recreationItem =  HotelRecreationService::find($request->input('recreationId'));
            $recreationItem->name = $request->input('name');
            $recreationItem->name_en = $request->input('nameEn');
            $recreationItem->num= $request->input('num');
            $recreationItem->description = $request->input('description');
            $recreationItem->description_en = $request->input('descriptionEn');
            $recreationItem->business_hour = $request->input('businessHour');
            return $recreationItem->save();

        }
    }


    //删除酒店健身娱乐项目
    public function deleteHotelRecreationItem(Request $request){
        return HotelRecreationService::where('id',$request->input('recreationId'))->delete();
    }


    //获得酒店图片
    public function getHotelImages($hotelId)
    {

        $hotelSectionAndImage = [];

        $hotelSectionAndImage['sectionList'] = HotelSection::select('id','name','type')->get();

        $hotelSectionAndImage['roomList'] = Room::where('hotel_Id',$hotelId)->select('id','room_name')->get();


        $hotelSectionAndImage['image'] = HotelImage::select('id','image_key','is_cover','desc','link','status')->where('hotel_id',$hotelId)->where('section_id',1)->get();


        return $hotelSectionAndImage;
    }

    //获取酒店区图片
    public function getSectionImage(Request $request)
    {
        return HotelImage::select('id','is_cover','image_key','desc','link','status')->where('hotel_id',$request->input('hotelId'))->where('section_id',$request->input('sectionId'))->where('type',$request->input('type'))->get();
    }


    //设置酒店封面照片
    public function setHotelImageCover(Request $request)
    {

        $hotelId = $request->input('hotelId');
        $imageId = $request->input('imageId');
        $coverCount = HotelImage::where(['hotel_id'=>$hotelId,'is_cover'=>1])->count();
        if($coverCount <= 16)
        {
            if(HotelImage::where(['hotel_id'=>$hotelId,'id'=>$imageId])->update(['is_cover'=> 1]))
            {
                return 1;
            }
            else{
                return 2;
            }
        }
        else{
            return 3;//已达到封面最大值
        }
    }

    //取消酒店封面图片
    public function cancelHotelCoverImage(Request $request)
    {
        $hotelId = $request->input('hotelId');
        $imageId = $request->input('imageId');
        return HotelImage::where(['hotel_id'=>$hotelId,'id'=>$imageId])->update(['is_cover'=> 0]);
    }

    //获取酒店封面图片
    public function getHotelCoverImage(Request $request)
    {
        $hotelId = $request->input('hotelId');
        $coverImageList = HotelImage::where('hotel_id', $hotelId)->where('is_cover','<>',0)->orderBy('updated_at','DESC')->get();


        $sectionList = HotelSection::select('id','name','type')->get();

        $roomList= Room::where('hotel_Id',$hotelId)->select('id','room_name')->get();

        foreach($coverImageList as $image)
        {
            //图片属于酒店公共区域
            if($image->type  ==1)
            {
                foreach($sectionList as  $section)
                {
                    if($section->id ==$image->section_id )
                    {
                        $image->section_name = $section->name;
                    }
                }
            }
            //图片属于房间
            else if($image->type ==2)
            {
                foreach($roomList as  $room)
                {
                    if($room->id ==$image->section_id )
                    {
                        $image->section_name = $room->room_name;
                    }
                }
            }
        }
        return $coverImageList;
    }



    //设置酒店封面照片
    public function setHotelFirstImage(Request $request)
    {

        $hotelId = $request->input('hotelId');
        $imageId = $request->input('imageId');

        //把之前设置状态改为普通封面
        HotelImage::where(['hotel_id'=>$hotelId,'is_cover'=> 2])->update(['is_cover'=> 1]);
        return HotelImage::where(['hotel_id'=>$hotelId,'id'=>$imageId])->update(['is_cover'=> 2]);
    }

    public function getStepThreeInfo($hotelId)
    {
        $contactList = HotelContact::where('hotel_id',$hotelId)->get();
        $payment = HotelExtra::where('hotel_id',$hotelId)->select('payment_json')->first()->payment_json;

        $paymentArr = explode(',', $payment);

        $StepThreeInfo = new Hotel();
        $StepThreeInfo->paymentArr = $paymentArr;
        $StepThreeInfo->contactList = $contactList;

        return $StepThreeInfo;

    }

    public function getStepFourInfo($hotelId)
    {
        return HotelExtra::where('hotel_id',$hotelId)->select('facilities_checkbox','facilities_radio')->first();
    }

    public function gethotelImageManageCategory($hotelId)
    {
        $list = HotelSectionImage::select('id','section_name','section_type','section_name_eg')->get();

        foreach ($list as $item) {
            $item->piclist = HotelImage::select('id','key','link','status')->where('hotel_id',$hotelId)->where('section_id',$item->id)->get();
        }

        return $list;
    }




}




