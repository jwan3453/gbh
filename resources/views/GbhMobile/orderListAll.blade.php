@extends('GbhMobile.site')

@section('resources')
 <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/rating.css') }}>
 <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
 <script type="text/javascript" src="{{ asset('semantic/rating.js') }}"></script>
@stop


@section('content')
<div class="ui container orderlist-wrapper" >
	<div class="nav-header">
		<img src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);"/>
		<span class="nav-header-text">订单列表</span>
	</div>

	<div class="order-menu" id="orderMenu">
		<div class="menu-element" id="elementOne">
			<a class="item menu-select-color" onclick="selectAll()">全部</a>
		</div>
		<div class="menu-element" id="elementTwo">
			<a class="item" onclick="selectUnpaid()">需预付</a>
		</div>
		<div class="menu-element" id="elementThree">
			<a class="item" onclick="selectOrderSuccess()">订购成功</a>
		</div>
		<div class="menu-element" id="elementFour">
			<a class="item" onclick="selectFinished()">已完成</a>
		</div>

		<div class="scroll-line" id="scrollLine"></div>

	</div>

	<div class="menu-separate-colmun"></div>

	<div class="order-list-box" id="orderList">

		<div class="order-colmun">
			<div class="order-number-time">
				<span>订单号：302091000000001</span>
				<span class="order-list-time">
					<img src="../GbhMobile/img/clock.png">2016-05-25</span>
			</div>

			<div class="order-colmun-img-text">
				<div class="order-colmun-img">
					<img src="../GbhMobile/personnelportrait/order-img.png"></div>
				<div class="order-colmun-text">
					<div class="order-colmun-room-name">古典2公寓</div>
					<div class="order-colmun-arrive-time">到店时间：2016-05-25 14:30</div>
				</div>

			</div>

			<div class="order-colmun-foot">
				<span>订单状态：需支付</span>
				<div class="order-colmun-button regular-btn">
					<span class="mobile-code-text">立即支付</span>
				</div>
			</div>
		</div>


		<div class="order-colmun">
			<div class="order-number-time">
				<span>订单号：302091000000001</span>
				<span class="order-list-time">
					<img src="../GbhMobile/img/clock.png">2016-05-25</span>
			</div>

			<div class="order-colmun-img-text">
				<div class="order-colmun-img">
					<img src="../GbhMobile/personnelportrait/order-img.png"></div>
				<div class="order-colmun-text">
					<div class="order-colmun-room-name">古典2公寓</div>
					<div class="order-colmun-arrive-time">到店时间：2016-05-25 14:30</div>
				</div>

			</div>

			<div class="order-colmun-foot">
				<span>订单状态：已取消</span>
				<div class="order-status-cancle order-colmun-button regular-btn" onclick="location.href='orderDetail/abc123123'">
					<span class="mobile-code-text">查看详情</span>
				</div>
			</div>
		</div>

		<div class="order-colmun">
			<div class="order-number-time">
				<span>订单号：302091000000001</span>
				<span class="order-list-time">
					<img src="../GbhMobile/img/clock.png">2016-05-25</span>
			</div>

			<div class="order-colmun-img-text">
				<div class="order-colmun-img">
					<img src="../GbhMobile/personnelportrait/order-img.png"></div>
				<div class="order-colmun-text">
					<div class="order-colmun-room-name">古典2公寓</div>
					<div class="order-colmun-arrive-time">到店时间：2016-05-25 14:30</div>
				</div>

			</div>

			<div class="order-colmun-foot">
				<span>订单状态：已完成</span>
				<div class="order-colmun-rating">
					<div class="ui star rating" data-rating="3" data-max-rating="5"></div>
				</div>
			</div>
		</div>



	</div>

	<div class="ui segment">
		<p></p>
	</div>
</div>
@stop


@section('script')
<script type="text/javascript">

	$('.rating').rating('disable');

	$("#elementOne").click(function(){
		$("#scrollLine").animate({left:'0'},'fast','linear');
		$("#orderMenu .menu-element .menu-select-color").removeClass("menu-select-color");
		$(this).children().addClass("menu-select-color");
	})

	$("#elementTwo").click(function(){
		$("#scrollLine").animate({left:'25%'},'fast','linear');
		$("#orderMenu .menu-element .menu-select-color").removeClass("menu-select-color");
		$(this).children().addClass("menu-select-color");
	})

	$("#elementThree").click(function(){
		$("#scrollLine").animate({left:'50%'},'fast','linear');
		$("#orderMenu .menu-element .menu-select-color").removeClass("menu-select-color");
		$(this).children().addClass("menu-select-color");
	})

	$("#elementFour").click(function(){
		$("#scrollLine").animate({left:'75%'},'fast','linear');
		$("#orderMenu .menu-element .menu-select-color").removeClass("menu-select-color");
		$(this).children().addClass("menu-select-color");
	})

	function selectAll() {
		// body...
	}

	function selectUnpaid(){
		$.ajax({
            type: 'POST',
            url: '/order/selectUnpaid',
            data: {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend : function(){
            	$("#orderList").html("");
            	var s = '';
            	s += '<div class="ui active inverted dimmer order-loading">';
            	s += 	'<div class="ui text loader">Loading</div>';
            	s += '</div>'
            	$("#orderList").html(s);

            	var windowh = $(window).height();
            	var footerh = $(".footer-section").height();
            	var loadingh = windowh - footerh ;
            	$(".order-loading").css('height',loadingh+'px');
            },
            success: function(data){
            	
            	$("#orderList").html("");
            	var order = data.order;
	            for (var i = 0; i < order.length; i++) {
	            	var a = "";
	            	a += '<div class="order-colmun">';
	            	a += 	'<div class="order-number-time">';
	            	a +=		'<span>订单号：'+order[i].orderSN+'</span>';
	            	a +=		'<span class="order-list-time">';
	            	a +=			'<img src="../GbhMobile/img/clock.png">'+order[i].ordertime;
	            	a +=		'</span>';
	            	a +=	'</div>';

	            	a +=	'<div class="order-colmun-img-text">';
	            	a +=		'<div class="order-colmun-img">';
	            	a +=			'<img src="../GbhMobile/personnelportrait/order-img.png">';
	            	a +=		'</div>';
	            	a +=		'<div class="order-colmun-text">';
	            	a +=			'<div class="order-colmun-room-name">'+order[i].hotelName+'</div>';
	            	a +=			'<div class="order-colmun-arrive-time">到店时间：'+order[i].arriveTime+'</div>';
	            	a +=		'</div>';
	            	a += 	'</div>';

	            	a +=	'<div class="order-colmun-foot">';
	            	a +=		'<span>订单状态：需支付</span>';
	            	a +=		'<div class="order-colmun-button regular-btn">';
					a +=			'<span class="mobile-code-text">立即支付</span>';
					a +=		'</div>';
					a +=	'</div>';
					a += '</div>';

					$("#orderList").append(a);
	            	
	            }
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
	}


	function selectOrderSuccess() {
		$.ajax({
            type: 'POST',
            url: '/order/selectOrderSuccess',
            data: {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend : function(){
            	$("#orderList").html("");
            	var s = '';
            	s += '<div class="ui active inverted dimmer order-loading">';
            	s += 	'<div class="ui text loader">Loading</div>';
            	s += '</div>'
            	$("#orderList").html(s);

            	var windowh = $(window).height();
            	var footerh = $(".footer-section").height();
            	var loadingh = windowh - footerh ;
            	$(".order-loading").css('height',loadingh+'px');
            },
            success: function(data){
            	
            	$("#orderList").html("");
            	var order = data.order;
	            for (var i = 0; i < order.length; i++) {
	            	var a = "";
	            	a += '<div class="order-colmun">';
	            	a += 	'<div class="order-number-time">';
	            	a +=		'<span>订单号：'+order[i].orderSN+'</span>';
	            	a +=		'<span class="order-list-time">';
	            	a +=			'<img src="../GbhMobile/img/clock.png">'+order[i].ordertime;
	            	a +=		'</span>';
	            	a +=	'</div>';

	            	a +=	'<div class="order-colmun-img-text">';
	            	a +=		'<div class="order-colmun-img">';
	            	a +=			'<img src="../GbhMobile/personnelportrait/order-img.png">';
	            	a +=		'</div>';
	            	a +=		'<div class="order-colmun-text">';
	            	a +=			'<div class="order-colmun-room-name">'+order[i].hotelName+'</div>';
	            	a +=			'<div class="order-colmun-arrive-time">到店时间：'+order[i].arriveTime+'</div>';
	            	a +=		'</div>';
	            	a += 	'</div>';

	            	a +=	'<div class="order-colmun-foot">';
	            	a +=		'<span>订单状态：未出行</span>';
	            	a +=		'<div class="order-colmun-button regular-btn">';
					a +=			'<span class="mobile-code-text">查看详情</span>';
					a +=		'</div>';
					a +=	'</div>';
					a += '</div>';

					$("#orderList").append(a);
	            	
	            }
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
	}

	function selectFinished() {
		$.ajax({
            type: 'POST',
            url: '/order/selectFinished',
            data: {},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            beforeSend : function(){
            	$("#orderList").html("");
            	var s = '';
            	s += '<div class="ui active inverted dimmer order-loading">';
            	s += 	'<div class="ui text loader">Loading</div>';
            	s += '</div>'
            	$("#orderList").html(s);

            	var windowh = $(window).height();
            	var footerh = $(".footer-section").height();
            	var loadingh = windowh - footerh ;
            	$(".order-loading").css('height',loadingh+'px');
            },
            success: function(data){
            	
            	$("#orderList").html("");
            	var order = data.order;
	            for (var i = 0; i < order.length; i++) {
	            	var a = "";
	            	a += '<div class="order-colmun">';
	            	a += 	'<div class="order-number-time">';
	            	a +=		'<span>订单号：'+order[i].orderSN+'</span>';
	            	a +=		'<span class="order-list-time">';
	            	a +=			'<img src="../GbhMobile/img/clock.png">'+order[i].ordertime;
	            	a +=		'</span>';
	            	a +=	'</div>';

	            	a +=	'<div class="order-colmun-img-text">';
	            	a +=		'<div class="order-colmun-img">';
	            	a +=			'<img src="../GbhMobile/personnelportrait/order-img.png">';
	            	a +=		'</div>';
	            	a +=		'<div class="order-colmun-text">';
	            	a +=			'<div class="order-colmun-room-name">'+order[i].hotelName+'</div>';
	            	a +=			'<div class="order-colmun-arrive-time">到店时间：'+order[i].arriveTime+'</div>';
	            	a +=		'</div>';
	            	a += 	'</div>';

	            	a +=	'<div class="order-colmun-foot">';
	            	a +=		'<span>订单状态：已完成</span>';
	            	a +=		'<div class="order-colmun-rating">';
					a +=			'<div class="ui star rating" data-rating="'+order[i].orderRating+'" data-max-rating="5"></div>';
					a +=		'</div>';
					a +=	'</div>';
					a += '</div>';

					$("#orderList").append(a);
	            	
	            }
	            $('.rating').rating('disable');
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
	}


</script>
@stop