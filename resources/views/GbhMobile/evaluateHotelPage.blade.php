@extends('GbhMobile.site')

@section('resources')
 	<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/rating.css') }}>
 	<script type="text/javascript" src="{{ asset('semantic/rating.js') }}"></script>
 	<style type="text/css">
 	body{
 		background-color: #e6e6e6;
 	}
 	*:focus {outline: none;}
 	</style>
@stop


@section('content')

<div class="ui container evaluate-hotel-wrapper" >
	<div class="nav-header">
		<img src="../GbhMobile/img/left-icon.png" class="nav-header-left" onclick="javascript:history.go(-1);"/>
		<span class="nav-header-text">酒店评价</span>
		<span class="evaluate-hotel-nav">发表</span>
	</div>


	<div class="evaluate-hotel-total-score">
		<span>总评价</span>
		<div class="ui star rating" data-rating="4" data-max-rating="5" id="totalScore"></div>
	</div>

	<div class="evaluate-hotel-detail-box">
		
		<div class="evaluate-hotel-colmun">
			<div class="evaluate-name">风景</div>
			<div class="ui star rating" data-rating="4" data-max-rating="5" id="sceneryScore"></div>
			<span class="evaluate-describe">风景宜人 4.0分</span>
		</div>

		<div class="evaluate-hotel-colmun">
			<div class="evaluate-name">趣味</div>
			<div class="ui star rating" data-rating="4" data-max-rating="5" id="interestScore"></div>
			<span class="evaluate-describe">趣味十足 4.0分</span>
		</div>

		<div class="evaluate-hotel-colmun">
			<div class="evaluate-name">性价比</div>
			<div class="ui star rating" data-rating="4" data-max-rating="5" id="ratioScore"></div>
			<span class="evaluate-describe">物有所值 4.0分</span>
		</div>

	</div>

	<div class="evaluate-hotel-textarea-box">
	<textarea class="evaluate-hotel-textarea" placeholder="请输入您对此酒店的评价（可不填）"></textarea>
	</div>


</div>

@stop

@section('script')

<script type="text/javascript">

	$('#totalScore').rating('disable');

	$('#sceneryScore').rating('setting','onRate',function(value){
		
		var a = $(this).rating('get rating');
		var b = $('#interestScore').rating('get rating');
		var c = $('#ratioScore').rating('get rating');

		var sum = parseInt(a) + parseInt(b) + parseInt(c);

		var average = Math.round( sum / 3);

		$('#totalScore').attr('data-rating',average).rating().rating('disable');
		
	})

	$('#interestScore').rating('setting','onRate',function(value){
		
		var a = $(this).rating('get rating');
		var b = $('#sceneryScore').rating('get rating');
		var c = $('#ratioScore').rating('get rating');

		var sum = parseInt(a) + parseInt(b) + parseInt(c);

		var average = Math.round( sum / 3);

		$('#totalScore').attr('data-rating',average).rating().rating('disable');
	})

	$('#ratioScore').rating('setting','onRate',function(value){
		
		var a = $(this).rating('get rating');
		var b = $('#interestScore').rating('get rating');
		var c = $('#sceneryScore').rating('get rating');

		var sum = parseInt(a) + parseInt(b) + parseInt(c);

		var average = Math.round( sum / 3);

		$('#totalScore').attr('data-rating',average).rating().rating('disable');
	})
	
</script>

@stop