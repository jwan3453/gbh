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
                <span class="policy-title-font float-left">入住时间</span>
                <select class="hotel-policy-input float-left margin-right-10" name="checkinTime" id="checkinTime">
                    @foreach($timespans as $timespan)
                        <option value="{{$timespan}}">{{$timespan}}</option>
                    @endforeach
                </select>


                <span class="policy-tips-font float-left">在该时间之后</span>
            </div>

            <div class="hotel-policy-row height-40">
                <span class="policy-title-font float-left ">离店时间</span>
                <select class=" hotel-policy-input float-left margin-right-10" name="checkoutTime"  id="checkoutTime">
                    @foreach($timespans as $timespan)
                        <option value="{{$timespan}}">{{$timespan}}</option>
                    @endforeach
                </select>

                <span class="policy-tips-font float-left">在该时间之前</span>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">押金预付</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="prepaidDeposit">{{$hotelPolicy ==null?'':$hotelPolicy->prepaid_deposit}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">在此输入酒店押金入住信息</span>
                </div>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">押金预付(英文)</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="prepaidDepositEn">{{$hotelPolicy ==null?'':$hotelPolicy->prepaid_deposit_en}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">在此输入酒店押金入住信息</span>
                </div>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">膳食安排</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="cateringArrangements">{{$hotelPolicy ==null?'':$hotelPolicy->catering_arrangements}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>
                </div>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">膳食安排(英文)</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="cateringArrangementsEn">{{$hotelPolicy ==null?'':$hotelPolicy->catering_arrangements_en}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">在此输入酒店的餐食与时间，如早餐自助午餐AM10:00等</span>
                </div>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">其他政策</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="otherPolicy">{{$hotelPolicy==null?'':$hotelPolicy->other_policy}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">酒店其他政策，包括加床，儿童床等</span>
                </div>
            </div>

            <div class="hotel-policy-row height-80">
                <div class="title-font-box height-40 margin-right-10 width-80">
                    <span class="policy-title-font float-left">其他政策(英文)</span>
                </div>
                <textarea class="hotel-policy-textarea margin-right-10" name="otherPolicyEn">{{$hotelPolicy==null?'':$hotelPolicy->other_policy_en}}</textarea>
                <div class="title-font-box height-40">
                    <span class="policy-tips-font float-left">酒店其他政策，包括加床，儿童床等</span>
                </div>
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










