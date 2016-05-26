<?php

namespace App\Http\Controllers\GbhMobile\Order;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Tool\MessageResult;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function orderListAll()
    {
        return view('GbhMobile.orderListAll');
    }

    public function selectUnpaid()
    {
        $jsonResult = new MessageResult();

        for ($i=0; $i < 5; $i++) { 
            $orderColmun = array();

            $orderColmun['orderSN'] = "3020".rand(10,99)."000000000".rand(10,99);
            $orderColmun['ordertime'] = date('Y-m-d');
            $orderColmun['hotelName'] = "悦泉".rand(10,99);
            $orderColmun['arriveTime'] = date('Y-m-d H:i');
            $orderColmun['orderStatus'] = 1;

            $jsonResult->order[$i] = $orderColmun;

        }

        return response($jsonResult->toJson());
    }

    public function selectOrderSuccess()
    {
        $jsonResult = new MessageResult();

        for ($i=0; $i < 5; $i++) { 
            $orderColmun = array();

            $orderColmun['orderSN'] = "3020".rand(10,99)."000000000".rand(10,99);
            $orderColmun['ordertime'] = date('Y-m-d');
            $orderColmun['hotelName'] = "悦泉".rand(10,99);
            $orderColmun['arriveTime'] = date('Y-m-d H:i');
            $orderColmun['orderStatus'] = 2;

            $jsonResult->order[$i] = $orderColmun;

        }

        return response($jsonResult->toJson());
    }

    public function selectFinished()
    {
        $jsonResult = new MessageResult();

        for ($i=0; $i < 5; $i++) { 
            $orderColmun = array();

            $orderColmun['orderSN'] = "3020".rand(10,99)."000000000".rand(10,99);
            $orderColmun['ordertime'] = date('Y-m-d');
            $orderColmun['hotelName'] = "悦泉".rand(10,99);
            $orderColmun['arriveTime'] = date('Y-m-d H:i');
            $orderColmun['orderStatus'] = 3;
            $orderColmun['orderRating'] = rand(1,5);

            $jsonResult->order[$i] = $orderColmun;

        }

        return response($jsonResult->toJson());
    }

    public function orderInfo()
    {
        return view('GbhMobile.orderInfo');
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
}
