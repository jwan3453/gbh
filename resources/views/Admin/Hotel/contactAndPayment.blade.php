@extends('Admin.site')



@section('resources')
@stop

@section('content')

<div class="h-c-steps">
	<div class="step s-active ">1</div>
	<div class="s-line s-l-active "></div>
	<div class="s-line s-l-active"></div>
	<div class="step s-active">2</div>
	<div class="s-line s-l-active"></div>
	<div class="s-line s-l-active"></div>
	<div class="step s-active">3</div>
	<div class="s-line s-l-active"></div>
	<div class="s-line "></div>
	<div class="step ">4</div>
</div>


{{-- 直接使用酒店设置页的部分css样式  --}}
<div class="facility-box">
<form id="hotelBasicInfo" action='{{url("/admin/manageHotel/insertContactPayment")}}' method="Post">
<input type="hidden" value="{{csrf_token()}}" name="_token"/>
<input type="hidden" value="{{$hotelId}}" name="hotelId" />
<input type="hidden" value="{{$createOrUpdate}}" id="createOrupdate" name="createOrupdate" />
	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>联系方式</span>
		</div>

		<div class="item-box">
			@if(count($hotelInfo->contactList) > 0)
				@foreach($hotelInfo->contactList as $contact)
					<div class="contact-box">
						<input type="hidden" name="contactId[{{$contact->id}}]" value="{{$contact->id}}">
						<div class="contact-box-row">
							<label>姓名：</label>
							<input type="text" class="contact-input" name="contactName[{{$contact->id}}]" value="{{$contact->name}}">

							<label>电话：</label>
							<input type="text" class="contact-input" name="contactTel[{{$contact->id}}]" value="{{$contact->tel}}">

							<label>手机：</label>
							<input type="text" class="contact-input" name="contactPhone[{{$contact->id}}]" value="{{$contact->phone}}">
						</div>
						<div class="contact-box-row">
							<label>职务：</label>
							<input type="text" class="contact-input" name="contactDuties[{{$contact->id}}]" value="{{$contact->duties}}">

							<label>传真：</label>
							<input type="text" class="contact-input" name="contactFax[{{$contact->id}}]" value="{{$contact->fax}}">

							<span>Email   ：</span>
							<input type="text" class="contact-input" name="contactEmail[{{$contact->id}}]" value="{{$contact->email}}">
						</div>
						<div class="remove-contact-row" onclick="removeContactRow(this)">
							<img src="/Admin/icon/menu-retract.png">
						</div>
					</div>
				@endforeach
			@else
				<div class="contact-box">
					<input type="hidden" name="contactId[]">				
					<div class="contact-box-row">
						<label>姓名：</label>
						<input type="text" class="contact-input" name="contactName[]">				

						<label>电话：</label>
						<input type="text" class="contact-input" name="contactTel[]">				

						<label>手机：</label>
						<input type="text" class="contact-input" name="contactPhone[]">
					</div>
					<div class="contact-box-row">
						<label>职务：</label>
						<input type="text" class="contact-input" name="contactDuties[]">				

						<label>传真：</label>
						<input type="text" class="contact-input" name="contactFax[]">				

						<span>Email   ：</span>
						<input type="text" class="contact-input" name="contactEmail[]">
					</div>

					

				</div>
			@endif
			<input type="hidden" value="@if(count($hotelInfo->contactList) > 0) {{count($hotelInfo->contactList)}} @else 1 @endif" name="contactCount" id="contactCount" />

			<div class="item-block width-200 border-blue" onclick="addContact(this)">
				<img src="/Admin/icon/add.png" class="margin-right-20">
				添加联系人
			</div>
			
		</div>
	</div>


	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>信用卡</span>
		</div>

		<div class="item-box">

			<div class="item-block width-200" onclick="notCredit(this)">
				不支持信用卡
			</div>
			
		</div>
	</div>


	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>国内信用卡</span>
		</div>

		<div class="item-box">
			<div class="credit-row">
				<div class="item-block pandding-20 " onclick="creditItems(this)">
					<span>国内发行银联卡</span>
				</div>
			</div>

			@foreach ($domesticCardList as $domesticCard)
			<div class="item-block pandding-20 @if($domesticCard->ispay == 1) click-item-block @endif" id="serviceItems" onclick="@if($domesticCard->ispay == 1) unCreditItems(this) @else creditItems(this) @endif">
				<input type="checkbox" class="display-none" value="{{$domesticCard->id}}" name="serviceItems[]" @if($domesticCard->ispay == 1) checked="checked" @endif>
				<span>{{$domesticCard->credit_name}}</span>
			</div>

			@endforeach
		</div>
	</div>

	<div class="facility-items-box">
		<div class="facility-item-title">
			<span>国外信用卡</span>
		</div>

		<div class="item-box">

			@foreach ($internationalCardList as $internationalCard)
			<div class="item-block pandding-20 @if($internationalCard->ispay == 1) click-item-block @endif" id="serviceItems" onclick="@if($internationalCard->ispay == 1) unCreditItems(this) @else creditItems(this) @endif">
				<input type="checkbox" class="display-none" value="{{$internationalCard->id}}" name="serviceItems[]" @if($internationalCard->ispay == 1) checked="checked" @endif>
				<span>{{$internationalCard->credit_name}}</span>
			</div>

			@endforeach
		</div>
	</div>


	<div class="hotel-policy-row height-80">
      	<div type="submit" class = "next-step-btn auto-margin" id="nsBtn">下一步</div>
    </div>

</form>
</div>
@stop

@section('script')

<script type="text/javascript">
	function creditItems(_this) {
		$(_this).addClass("click-item-block");
		$(_this).children("input").attr("checked",'true');

		$(_this).attr('onclick','unCreditItems(this)');
	}

	function unCreditItems(_this) {
		$(_this).removeClass("click-item-block");
		$(_this).children("input").removeAttr("checked");

		$(_this).attr('onclick','creditItems(this)');
	}

	function addContact(_this) {
		var html =
		 	 '<div class="contact-box">'
			 '		<div class="contact-box-row">'
			 '			<label>姓名：</label>'
		a += '			<input type="text" class="contact-input" name="contactName[]">'

		a += '			<label>电话：</label>'
		a += '			<input type="text" class="contact-input" name="contactTel[]">'

		a += '			<label>手机：</label>'
		a += '			<input type="text" class="contact-input" name="contactPhone[]">'
		a += '		</div>';
		a += '		<div class="contact-box-row">'
		a += '			<label>职务：</label>'
		a += '			<input type="text" class="contact-input" name="contactDuties[]">'

		a += '			<label>传真：</label>';
		a += '			<input type="text" class="contact-input" name="contactFax[]">';

		a += '			<span>Email   ：</span>';
		a += '			<input type="text" class="contact-input" name="contactEmail[]">';
		a += '		</div>';
		a += '		<div class="remove-contact-row" onclick="removeContactRow(this)">'
		a += '			<img src="/Admin/icon/menu-retract.png">'
		a += '		</div>'
		a += '	</div>';

		$(_this).before(a);

		var s = $("#contactCount").val();
		$("#contactCount").val(parseInt(s) + 1);
	}

	function notCredit(_this) {
		$(".item-block").each(function(i){
			if ($(this).hasClass('click-item-block')) {
				$(this).removeClass('click-item-block');
			}
			$(this).addClass('unclick-item-block');

			$(this).removeAttr("onclick");
		})

		$(_this).attr('onclick','checkCredit(this)');
	}

	function checkCredit(_this) {
		$(".item-block").each(function(i){
			
			$(this).removeClass('unclick-item-block');

			$(this).attr("onclick","creditItems(this)");
		})
		$(_this).attr('onclick','notCredit(this)');
	}

	$('#nsBtn').click(function(){

		var isSubmit = false;
        $("form").find(":text").each(function(i){
            if ( $(this).val() ) {
                isSubmit = true;
            }
            if ( !$(this).val() ) {
                alert($(this).prev().html() + "   不能为空");
                isSubmit = false;
                return false;
            }

        })
        if (isSubmit) {
            $('#hotelBasicInfo').submit();
        }
        // $('#hotelBasicInfo').submit();

    })

    function removeContactRow(_this) {
    	$(_this).parent().remove();
    	var s = $("#contactCount").val();
		$("#contactCount").val(parseInt(s) - 1);
    }
</script>

@stop