<?php
namespace App\Service\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Hotel;
use App\Models\Address;
use App\Models\hotelPolicy;
use App\Models\CreditCard;
use App\Models\HotelExtra;
use App\Models\HotelContact;
use App\Models\ExtraService;



class HotelService {

    public function createHotel(Request $request)
    {
        $isSuccess = false;

        //储存酒店地址
        $newAddress = new Address();
        $newAddress->province_code = $request->input('provinceCode');
        $newAddress->city_code = $request->input('cityCode');
        $newAddress->district_code = $request->input('districtCode');
        $newAddress->detail = $request->input('hotelAddress');
        if($newAddress->save())
        {
            $newHotel = new Hotel();
            $newHotel->hotel_name = $request->input('hotelName');
            $newHotel->switchboard =$request->input('hotelPhone');//-------总机
            $newHotel->business_center_fax  = $request->input('hotelFax');//--------商务传真
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

        $checkTime = $request['checkTimeFrom'] . " - " . $request['checkTimeTo'];
        $checkoutTime = $request['checkoutTimeFrom'] . " - " . $request['checkoutTimeTo'];

        $hotelPolicy = new hotelPolicy();
        $hotelPolicy->check_time = $checkTime;
        $hotelPolicy->checkout_time = $checkoutTime;
        $hotelPolicy->prepaid_deposit = $request['prepaidDeposit'];
        $hotelPolicy->catering_arrangements = $request['cateringArrangements'];
        $hotelPolicy->other_policy = $request['otherPolicy'];
        $hotelPolicy->hotel_id = $request['hotelId'];

        if ($hotelPolicy->save()) {
            $newHotel = Hotel::find($request['hotelId']);
            $newHotel->surrounding_environment = $request['surrounding'];
            $newHotel->longitude = $request['longitude'];
            $newHotel->latitude = $request['latitude'];
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
        $insertData = array();
        $json = '[';
        for ($i=0; $i < $count; $i++) { 

            $insertData[$i]['hotel_id'] = $request['hotelId'];
            $insertData[$i]['name'] = $request['contactName'][$i];
            $insertData[$i]['tel'] = $request['contactTel'][$i];
            $insertData[$i]['phone'] = $request['contactPhone'][$i];
            $insertData[$i]['duties'] = $request['contactDuties'][$i];
            $insertData[$i]['fax'] = $request['contactFax'][$i];
            $insertData[$i]['email'] = $request['contactEmail'][$i];

            $json .= '{';
            $json .= '"name" : "'.$request['contactName'][$i].'",';
            $json .= '"tel" : "'.$request['contactTel'][$i].'",';
            $json .= '"phone" : "'.$request['contactPhone'][$i].'",';
            $json .= '"duties" : "'.$request['contactDuties'][$i].'",';
            $json .= '"fax" : "'.$request['contactFax'][$i].'",';
            $json .= '"email" : "'.$request['contactEmail'][$i].'"';
            $json .= '}';

            if ($i != $count - 1) {
                $json .= ",";
            }

        }

        $json .= ']';

        $isInsert = HotelContact::insert($insertData);

        $paymentItem = '';
        $paymentCount = count($request['serviceItems']);
        for ($i=0; $i < $paymentCount; $i++) { 
            $paymentItem .= $request['serviceItems'][$i];
            if ($i != $paymentCount - 1) {
                $paymentItem .= ",";
            }
        }

        $insertExtra = HotelExtra::insert(["hotel_id"=>$request['hotelId'],"contacts_json"=>$json,"payment_json"=>$paymentItem]);

        if ($isInsert && $insertExtra) {
            $isSuccess = $request['hotelId'];
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

        $isSuccess = false;

        $a = '';
        $serviceItems = $insertData['serviceItems'];
        for ($i=0; $i < count($serviceItems); $i++) { 

            $a .= $serviceItems[$i];
            if ($i != count($serviceItems) - 1) {
                $a .= ",";
            }
        }

        unset($insertData['serviceItems']);
        unset($insertData['_token']);
        unset($insertData['hotelId']);

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

        $insertFacility = HotelExtra::where('hotel_id',$hotelId)->update(["facilities_checkbox"=>$a,"facilities_radio"=>$b]);

        if ($insertFacility) {
            $isSuccess = $hotelId;
        }

        return $isSuccess;
    }

    public function createNewRoom(Request $request)
    {
        

    }


}


