<?php

namespace App\Http\Controllers\Admin\Hotel;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Service\Common\CommonService;
use App\Service\Admin\HotelService;

class HotelController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    private $commonService;
    private $hotelService;

    public function __construct(CommonService $commonService, HotelService $hotelService){

        $this->commonService = $commonService;
        $this->hotelService = $hotelService;
    }

    public function index()
    {
        $is = $this->isRolePermission("hotel-manage");

        if (!$is) {
            return redirect(url('admin/Error/NotPermission'));
        }

        return view('Admin.Hotel.manageHotel');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createHotel()
    {


        $geoData = $this->commonService->getGeoDetail();

        return view('Admin.Hotel.createHotel')->with('geoData',$geoData);
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeHotel(Request $request)
    {
        //
        $this->hotelService->createHotel($request);

    }

    public function geolocation()
    {
        $address = "福建省厦门市思明区凡悦咖啡厅";
        return view('Admin.Hotel.geoLocation')->with('address',$address);
    }

    public function facility()
    {
        return view('Admin.Hotel.facility');
    }

    public function contactAndPayment()
    {
        return view('Admin.Hotel.contactAndPayment');
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
}
