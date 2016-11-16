@extends('Admin.Hotel.maintainHotelInfo')

@section('resources')

@stop

@section('infoContent')

    <div class="info-content ">
        <form class="hotel-info" id="hotelPolicyForm" action='{{url("/admin/manageHotel/hotelInfo/createOrUpdatePolicy")}}' method="Post">

            <input type="hidden" value="{{csrf_token()}}" name="_token"/>
            <input type="hidden" value="{{$hotelId}}" name="hotelId" />

                <div class="header">酒店政策</div>


            <div class="hotel-policy-row height-40">
                <span class="policy-title-font ">入住时间</span>
                <select class="hotel-policy-input  margin-right-10" name="checkinTime" id="checkinTime">
                    @foreach($timespans as $timespan)
                        <option value="{{$timespan}}">{{$timespan}}</option>
                    @endforeach
                </select>


                <span class="policy-tips-font ">在该时间之后</span>
            </div>


            <div class="hotel-policy-row height-40">
                <span class="policy-title-font  ">离店时间</span>
                <select class=" hotel-policy-input   margin-right-10" name="checkoutTime"  id="checkoutTime">
                    @foreach($timespans as $timespan)
                        <option value="{{$timespan}}">{{$timespan}}</option>
                    @endforeach
                </select>

                <span class="policy-tips-font  ">在该时间之前</span>
            </div>


            <div class="hotel-policy-row height-80">
                <span class="policy-title-font ">接送机</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="airportTransfer">{{$hotelPolicy ==null?'':$hotelPolicy->airport_transfer}}</textarea>
                 <span class="policy-tips-font ">在此输入酒店接送机服务信息</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">接送机(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="airportTransferEn">{{$hotelPolicy ==null?'':$hotelPolicy->airport_transfer_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店接送机服务信息</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font ">支付政策</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="payPolicy">{{$hotelPolicy ==null?'':$hotelPolicy->pay_policy}}</textarea>
                <span class="policy-tips-font ">在此输入酒店支付信息</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">支付政策(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="payPolicyEn">{{$hotelPolicy ==null?'':$hotelPolicy->pay_policy_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店支付信息</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font ">宠物政策</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="petPolicy">{{$hotelPolicy ==null?'':$hotelPolicy->pet_policy}}</textarea>
                <span class="policy-tips-font ">在此输入酒店宠物政策</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">宠物政策(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="petPolicyEn">{{$hotelPolicy ==null?'':$hotelPolicy->pet_policy_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店宠物政策</span>
            </div>




            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">押金预付</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="prepaidDeposit">{{$hotelPolicy ==null?'':$hotelPolicy->prepaid_deposit}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店押金入住信息</span>

            </div>


            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">押金预付(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="prepaidDepositEn">{{$hotelPolicy ==null?'':$hotelPolicy->prepaid_deposit_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店押金入住信息</span>

            </div>


            <div class="hotel-policy-row height-80">
                <span class="policy-title-font ">服务费</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="serviceFeePolicy">{{$hotelPolicy ==null?'':$hotelPolicy->airport_transfer}}</textarea>
                <span class="policy-tips-font ">在此输入酒店接送机服信息</span>
            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">服务费(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="serviceFeePolicyEn">{{$hotelPolicy ==null?'':$hotelPolicy->service_fee_policy}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店接送机服信息</span>
            </div>



            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">膳食安排</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="cateringArrangements">{{$hotelPolicy ==null?'':$hotelPolicy->service_fee_policy_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>

            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">膳食安排(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="cateringArrangementsEn">{{$hotelPolicy ==null?'':$hotelPolicy->catering_arrangements_en}}</textarea>
                <span class="policy-tips-font  ">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>

            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">其他政策</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="otherPolicy">{{$hotelPolicy==null?'':$hotelPolicy->other_policy}}</textarea>
                <span class="policy-tips-font  ">酒店其他政策，包括加床，儿童床等</span>

            </div>

            <div class="hotel-policy-row height-80">
                <span class="policy-title-font  ">其他政策(英文)</span>
                <textarea class="hotel-policy-textarea margin-right-10" name="otherPolicyEn">{{$hotelPolicy==null?'':$hotelPolicy->other_policy_en}}</textarea>
                <span class="policy-tips-font  ">酒店其他政策，包括加床，儿童床等</span>
            </div>


            <div class="hotel-policy-row height-80">
                <div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
            </div>
        </form>
    </div>

@stop


@section('infoScript')
    <script type="text/javascript">


        $(document).ready(function() {



            $('.ui.dropdown').dropdown();


            $('#nsBtn').click(function(){

                $('#hotelPolicyForm').submit();

            })


            $('#checkinTime').find('option[value='+'"{{$hotelPolicy==null?'':$hotelPolicy->checkin_time}}"'+']').attr("selected",true);

            $('#checkoutTime').find('option[value='+'"{{$hotelPolicy==null?'':$hotelPolicy->checkout_time}}"'+']').attr("selected",true);
        })
    </script>
@stop










