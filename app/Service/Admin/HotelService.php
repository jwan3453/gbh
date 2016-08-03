<?php
namespace App\Service\Admin;

use App\Models\BedType;
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
use App\Models\HotelImage;
use App\Models\RoomPrice;
use App\Models\RoomPriceBatchRequest;

class HotelService {

    public function getHotelList()
    {
        $list = Hotel::select('id','name','address_id','status')->get();
        foreach ($list as $hotelitem) {
            $hotelitem->address = Address::select('province_code','city_code','district_code','detail')->where('id',$hotelitem->address_id)->first();
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
        $newAddress->province_code = $request->input('provinceCode');
        $newAddress->city_code = $request->input('cityCode');
        $newAddress->district_code = $request->input('districtCode');
        $newAddress->detail = $request->input('hotelAddress');
        if($newAddress->save())
        {
            if ($createOrupdate == "update") {
                $newHotel = Hotel::find($request->input('hotelId'));
            }else{
                $newHotel = new Hotel();
            }
            $newHotel->name = $request->input('hotelName');
            $newHotel->phone =$request->input('hotelPhone');//-------总机
            $newHotel->fax  = $request->input('hotelFax');//--------商务传真
            $newHotel->postcode  = $request->input('hotelPostcode');
            $newHotel->website =  $request->input('hotelWebsite');
            $newHotel->total_rooms = $request->input('hotelTotalRooms');
            $newHotel->hotel_features = $request->input('hotelFeature');
            $newHotel->description = $request->input('hotelBrief');
            $newHotel->address_id = $newAddress->id;//------获取上一步新增地址所插入数据库的ID

            if ($newHotel->save()) {
                $isSuccess = $newHotel->id;
            }

        }

        return $isSuccess;
    }

    public function insertPolicy($request)
    {

        $isInsert = false;

        $checkTime = $request['checkTimeFrom'] . " | " . $request['checkTimeTo'];
        $checkoutTime = $request['checkoutTimeFrom'] . " | " . $request['checkoutTimeTo'];

        // dd($request['createOrupdate']);


        $createOrupdate = $request['createOrupdate'];
        $policyId = $request['policyId'];




        if ($createOrupdate == "update") {
            $hotelPolicy = hotelPolicy::find($policyId);
            if($hotelPolicy == null)
            {
                $hotelPolicy = new hotelPolicy();
            }
        }else{
            $hotelPolicy = new hotelPolicy();
        }
        
        $hotelPolicy->check_time = $checkTime;
        $hotelPolicy->checkout_time = $checkoutTime;
        $hotelPolicy->prepaid_deposit = $request['prepaidDeposit'];
        $hotelPolicy->catering_arrangements = $request['cateringArrangements'];
        $hotelPolicy->other_policy = $request['otherPolicy'];
        $hotelPolicy->hotel_id = $request['hotelId'];

        if ($hotelPolicy->save()) {
            $newHotel = Hotel::find($request['hotelId']);
            $newHotel->surrounding_environment = $request['surrounding'];
//            $newHotel->longitude = $request['longitude'];
//            $newHotel->latitude = $request['latitude'];
            $newHotel->policy_id = $hotelPolicy->id;

            if ($newHotel->save()) {
                $isInsert = $request['hotelId'];
            }

        }

        return $isInsert;
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

    public function getRoomTypeList($hotelId){
        return Room::where('hotel_id',$hotelId)->select('id','room_name')->get();
    }

    public function getRoomTypeByRoomId($hotelId,$roomId){
        return Room::where(['hotel_id'=>$hotelId,'id'=>$roomId])->select('id','room_name')->get();
    }


    //获取当时间10天内所有房型的价格
    public function getRoomCurrentMonthPriceList($hotelId,$roomTypeList)
    {

        //页面一行显示几天的数据(10天)
        $selectCount  = 10;
        $priceList = [];
        //当月的开始 结束时间段
        $startDate = date("Y-m-d H:i:s",mktime(0, 0 , 0,date("m"),date("d"),date("Y")));
        $endDate = date("Y-m-d H:i:s",mktime(23,59,59,date("m"),date("d")+($selectCount-1),date("Y")));
        foreach($roomTypeList as $roomType )
        {
            $priceList[$roomType->room_name] = RoomPrice::where(['hotel_id'=>$hotelId,'room_id'=>$roomType->id])->whereBetween('date',array($startDate,$endDate))->select('room_id','rate','prepaid_rate','num_of_breakfast','prepaid_num_of_breakfast','date')->get();

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
            $newRoomPriceBatchRequest->paid_type = $payType;
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


    public function createNewRoom(Request $request)
    {
        //创建新房间

        $newRoom = new Room();
        $newRoom->hotel_id = $request->input('hotelId');
        $newRoom->room_name = $request->input('roomName');
        $newRoom->rack_rate = $request->input('rackRate');
        $newRoom->num_of_people = $request->input('numOfPeople');
        $newRoom->num_of_children = $request->input('numOfChildren');
        $newRoom->num_of_rooms = $request->input('numOfRooms');
        $newRoom->acreage = $request->input('acreage');
        $newRoom->floor = $request->input('floor');
//        $new
        if($newRoom->save())
        {
            $this->createNewBeds($request,$newRoom->id);
        }

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
        $room->rack_rate = $request->input('rackRate');
        $room->num_of_people = $request->input('numOfPeople');
        $room->num_of_children = $request->input('numOfChildren');
        $room->num_of_rooms = $request->input('numOfRooms');
        $room->acreage = $request->input('acreage');
        $room->floor = $request->input('floor');

        if($room->save())
        {
            //先删除之前的保存的床
            Bed::where('room_id',$request->input('roomId'))->delete();
            $this->createNewBeds($request,$request->input('roomId'));

        }
        return $room;
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

    public function getStepOneInfo($hotelId)
    {
        $hotelInfo = Hotel::where('id',$hotelId)->select('name','address_id','postcode','phone','fax','website','total_rooms','hotel_features','description')->first();

        $hotelInfo->address = Address::where('id',$hotelInfo->address_id)->select('province_code','city_code','district_code','detail')->first();

        return $hotelInfo;

    }

    public function getHotelAddress($hotelId = 0)
    {
        $addressId = Hotel::where('id',$hotelId)->select('address_id')->first()->address_id;

        return Address::where('id',$addressId)->select('province_code','city_code','district_code','detail')->first();
    }

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




