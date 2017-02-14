<?php
/**
 * Created by PhpStorm.
 * User: benfoo
 * Date: 17/2/7
 * Time: 下午4:15
 */

namespace App\Service\Admin;

use App\Models\Orders;
use App\Models\Hotel;
use App\Models\Role\AdminUser;
use App\Models\Address;
use App\Models\HotelImage;
use App\Models\Room;
use App\Service\Common\CommonService;
use Illuminate\Support\Facades\Session;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Tool\MessageResult;

class OrderService{


    public function getAllOrder(){

//        $currentUser = session('adminusername');dd($currentUser);


        return Order::all();
    }

    public function getHotelList(){

        //当前用户
        $currentUsername = session('adminusername');
        //受否管理所有酒店
        $getHotel        = AdminUser::where('username',$currentUsername)->first();
        if($getHotel->hotel_type == 2){
            $list = Hotel::select('id','name','address_id','status')->get();
            foreach ($list as $hotelItem) {
                $hotelItem->address = Address::select('province_code','city_code','district_code','detail','type')->where('id',$hotelItem->address_id)->first();
            }
        }else{
            $list = null;
        }

        if($list!=null){
            //酒店封面图片
            foreach($list as $hotel)
            {
                $hotel->firstCoverImage = $this->getHotelFirstImage($hotel->id);
            }
        }

        return $list;

    }

    //获取酒店首张封面图片
    public function getHotelFirstImage($hotelId)
    {
        $image = HotelImage::where(['hotel_id'=>$hotelId,'is_cover'=> 2])->first();
        if($image == null)
            $image = HotelImage::where('hotel_id',$hotelId)->orderBy('updated_at','desc')->first();
        return $image;
    }


    //酒店订单信息
    public function AllHotelOrderInfo(){
        return DB::table('orders')->leftJoin('room','orders.room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->get();
    }

    //酒店订单信息
    public function hotelOrderInfo($hotelId){
        return DB::table('orders')->where('orders.hotel_id',$hotelId)->leftJoin('room','orders.room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->get();
    }

    //房间信息
    public function roomInfo($roomId){
        return Room::where('id',$roomId)->first();
    }

    //订单信息
    public function getDetailInfo($orderSn){

        $order =  Orders::where('order_sn',$orderSn)->first();

        if($order != null){

            //获取酒店基本信息
            $hotelDetail = Hotel::where('id',$order->hotel_id)->firstOrFail();

            $hotelDetail->address = Address::where('id',$hotelDetail->address_id)->first();
            if($hotelDetail->address != null)
            {
                $hotelDetail->province  = (new CommonService())->getAdressInfo('province',$hotelDetail->address->province_code,$hotelDetail->address->type);
                $hotelDetail->city  = (new CommonService())->getAdressInfo('city',$hotelDetail->address->city_code,$hotelDetail->address->type);
                $hotelDetail->district  = (new CommonService())->getAdressInfo('district',$hotelDetail->address->district_code,$hotelDetail->address->type);
            }

            //获取房间基本信息
            $roomDetail = Room::where('id',$order->room_id)->firstOrFail();
            $roomDetail->imageLink  =  HotelImage::where(['section_id'=> $roomDetail->id,'hotel_id' => $order->hotel_id,'type'=>2])->first();

            $order->hotelDetail = $hotelDetail;
            $order->roomDetail  = $roomDetail;

        }

        $order->dateDiff = $this->diffBetweenTwoDays($order->check_in_date, $order->check_out_date);


        return $order;

    }


    //入住天数
    public function diffBetweenTwoDays ($day1, $day2)
    {
        $second1 = strtotime($day1);
        $second2 = strtotime($day2);

        if ($second1 < $second2) {
            $tmp = $second2;
            $second2 = $second1;
            $second1 = $tmp;
        }
        return ($second1 - $second2) / 86400;
    }


    //未处理订单
    public function hotelUnprocessedOrders($hotelId){

        return DB::table('orders')->where(['orders.hotel_id'=>$hotelId ,'order_status' => 0])->leftJoin('room','orders.room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->get();

    }

    //今日订单
    public function getTodayOrders($hotelId){

        $todayTime  = date('Y-m-d');
        return DB::table('orders')->where(['orders.hotel_id'=>$hotelId])->whereBetween('orders.created_at',array($todayTime.' 00:00:00',$todayTime.' 23:59:59'))->leftJoin('room','orders.room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->get();

    }

    //今日订单数量
    public function todayOrdersCount($hotelId){

        $todayTime  = date('Y-m-d');
        return Orders::where(['orders.hotel_id'=>$hotelId])->whereBetween('orders.created_at',array($todayTime.' 00:00:00',$todayTime.' 23:59:59'))->count();

    }

    //订单数量
    public function countOrders($hotelId){

        return Orders::where('hotel_id',$hotelId)->count('id');

    }

    //房型
    public function getRoomType(){

        return DB::table('room')->distinct('room_name')->select('room_name')->get();

    }

    //条件查询订单
    public function orderSearchResult(Request $request){

        $dateTimeType  = $request->input('order-date');           //日期类型
        $orderSn       = $request->input('order-sn');             //订单号
        $orderPerson   = $request->input('order-person');         //预定人
        $roomType      = $request->input('choice-room-type');     //房型
        $OrderStatus   = $request->input('choice-order-status');  //订单状态
        $resultSort    = $request->input('result-sort');          //结果顺序

        $orderDatetimeStart = $request->input('order-datetime-start');
        $orderDatetimeStop = $request->input('order-datetime-stop');

        if($resultSort == 0){
            $sortType  =  'asc';
        }else{
            $sortType  =  'desc';
        }

        $query = (new Orders());
        $whereStr = $query->leftJoin('room','room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->orderBy('created_at',$sortType);
        if($orderSn != ""){
            $whereStr->where('order_sn','like','%'.$orderSn.'%');
        }
        if($roomType != 0){
            if($roomType == 1){
                $room_name = '海景双人房';
            }elseif($roomType == 2){
                $room_name = '海景大人房';
            }elseif($roomType == 3){
                $room_name = '海景大床房';
            }else{
                $room_name = '海景双床房';
            }

            $whereStr->where('room_name',$room_name);
        }
        if($OrderStatus != 2){
            $whereStr->where('pay_status','like','%'.$OrderStatus.'%');
        }
        if($orderPerson){
            $whereStr->where('guest_list','like','%'.$orderPerson.'%');
        }
        if($dateTimeType == 1){
            $whereStr->whereBetween('orders.created_at',array($orderDatetimeStart.' 00:00:00',$orderDatetimeStop.' 23:59:59'));
        }
        if($dateTimeType == 2){
            $whereStr->whereBetween('orders.check_in_date',array($orderDatetimeStart.' 00:00:00',$orderDatetimeStop.' 23:59:59'));
        }

        $result = $whereStr->get();
        if($result){
            return $result;
        }

    }

    public function hotelOrderSearchResult(Request $request){

        $hotelId       = $request->input('get-hotel-id');
        $dateTimeType  = $request->input('order-date');           //日期类型
        $orderSn       = $request->input('order-sn');             //订单号
        $orderPerson   = $request->input('order-person');         //预定人
        $roomType      = $request->input('choice-room-type');     //房型
        $OrderStatus   = $request->input('choice-order-status');  //订单状态
        $resultSort    = $request->input('result-sort');          //结果顺序

        $orderDatetimeStart = $request->input('order-datetime-start');
        $orderDatetimeStop  = $request->input('order-datetime-stop');


        if($resultSort == 0){
            $sortType  =  'asc';
        }else{
            $sortType  =  'desc';
        }

        $whereStr = DB::table('orders')->where('orders.hotel_id',$hotelId)->leftJoin('room','orders.room_id','=','room.id')->select('orders.*','room.room_name','room.num_of_people','room.num_of_rooms')->orderBy('created_at',$sortType);
        if($orderSn != ""){
            $whereStr->where('order_sn','like','%'.$orderSn.'%');
        }
        if($OrderStatus != 2){
            $whereStr->where('pay_status',$OrderStatus);
        }
        if($orderPerson){
            $whereStr->where('guest_list','like','%'.$orderPerson.'%');
        }
        if($dateTimeType == 1){
            $whereStr->whereBetween('orders.created_at',array($orderDatetimeStart.' 00:00:00',$orderDatetimeStop.' 23:59:59'));
        }
        if($dateTimeType == 2){
            $whereStr->whereBetween('orders.check_in_date',array($orderDatetimeStart.' 00:00:00',$orderDatetimeStop.' 23:59:59'));
        }
        if($roomType != 0){

            if($roomType == 1){
                $room_name = '海景双人房';
            }elseif($roomType == 2){
                $room_name = '海景大人房';
            }elseif($roomType == 3){
                $room_name = '海景大床房';
            }else{
                $room_name = '海景双床房';
            }

            $whereStr->where('room_name',$room_name);
        }

        $result = $whereStr->get();
        if($result){
            return $result;
        }
    }
}