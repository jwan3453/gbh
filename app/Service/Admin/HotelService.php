<?php
namespace App\Service\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;

use App\Models\Hotel;
use App\Models\Address;



class HotelService {

    public function createHotel(Request $request)
    {
        //储存酒店地址
        $newAddress = new Address();
        $newAddress->province_code = $request->input('provinceCode');
        $newAddress->city_code = $request->input('cityCode');
        $newAddress->district_code = $request->input('districtCode');
        $newAddress->detail = $request->input('addressDetail');
        if($newAddress->save())
        {
            $newHotel = new Hotel();
            $newHotel->name = $request->input('hotelName');
            $newHotel->phone =$request->input('hotelPhone');
            $newHotel->fax  = $request->input('hotelFax');
            $newHotel->postcode  = $request->input('hotelPostcode');
            $newHotel->website =  $request->input('hotelWebsite');
            $newHotel->total_rooms = $request->input('hotelTotalRooms');
            $newHotel->hotel_feature = $request->input('hotelFeature');

        }


      //  $newAddress->



    }


}


