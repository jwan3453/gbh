<?php
namespace App\Http\Controllers\GbhMobile\Hotel;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class HotelController extends Controller
{
    //

    public function __construct()
    {

    }

    public function hotelDetail($hotelID)
    {

        return view('GbhMobile.hotel.hotelDetail');
    }


    public function booking($hotelId,$roomId)
    {
        return view('GbhMobile.hotel.booking');

    }
}

?>