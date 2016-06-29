<?php

namespace App\Http\Controllers\Admin\Hotel;


use App\Tool\MessageResult;
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
        // $is = $this->isRolePermission("hotel-manage");

        // if (!$is) {
        //     return redirect(url('admin/Error/NotPermission'));
        // }

        $manageHotelList = $this->hotelService->getHotelList();
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
        // $hotelInfo = new collect([]);
        return view('Admin.Hotel.createHotel')->with('geoData',$geoData)->with('hotelInfo',$hotelInfo);
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
        $isCreate =  $this->hotelService->createHotel($request);
        
        if ($isCreate) {
            $province = $this->commonService->getAdressInfo('province',$request->input('provinceCode'));
            $city = $this->commonService->getAdressInfo('city',$request->input('cityCode'));
            $district = $this->commonService->getAdressInfo('district',$request->input('districtCode'));
            $detail = $request->input('hotelAddress');

            $addressInfo = $province.$city.$district.$detail;

            return view('Admin.Hotel.geoLocation')->with('address',$addressInfo)->with('hotelId',$isCreate);
        }
        else{
            return redirect(url('admin/manageHotel/createHotelError/1/0'));
        }

    }

    public function geolocation($hotelId)
    {
        $address = "福建省厦门市思明区凡悦咖啡厅";
        return view('Admin.Hotel.geoLocation')->with('address',$address)->with('hotelId',$hotelId);
    }

    public function insertPolicy(Request $request)
    {
        $isCreate = $this->hotelService->insertPolicy($request->input());
        
        $hotelId = $request->input('hotelId');

        if ($isCreate) {
            $InternalList = $this->hotelService->getCreditList(1);
            $AbroadList = $this->hotelService->getCreditList(2);

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
        $InternalList = $this->hotelService->getCreditList(1);
        $AbroadList = $this->hotelService->getCreditList(2);
        return view('Admin.Hotel.contactAndPayment')->with('InternalList',$InternalList)->with('AbroadList',$AbroadList)->with('hotelId',$hotelId);
    }

    public function insertContactPayment(Request $request)
    {
        $isCreate = $this->hotelService->insertContactPayment($request->input());
   
        $hotelId = $request->input('hotelId');
        if ($isCreate) {
            $ExtraServiceList = $this->hotelService->getExtraService();
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
        $roomList = $this->hotelService->getRoomList($hotelId);
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



}
