@extends('Admin.site')


@section('resources')
@stop

@section('content')
<div class="h-c-steps">
	<div class="step s-active ">1</div>
	<div class="s-line s-l-active "></div>

	@if($errorId >= 2)
	<div class="s-line s-l-active"></div>
	<div class="step s-active">2</div>
	<div class="s-line s-l-active"></div>
	@else
	<div class="s-line"></div>
	<div class="step">2</div>
	<div class="s-line"></div>
	@endif

	@if($errorId >= 3)
	<div class="s-line s-l-active"></div>
	<div class="step s-active">3</div>
	<div class="s-line s-l-active"></div>
	@else
	<div class="s-line"></div>
	<div class="step">3</div>
	<div class="s-line"></div>
	@endif

	@if($errorId >= 4)
	<div class="s-line s-l-active"></div>
	<div class="step s-active">4</div>
	@else
	<div class="s-line"></div>
	<div class="step">4</div>
	@endif
</div>

<div class="facility-box height-280">
	<div class="error-tip-box">
		@if($errorId == 1)
			<label>步骤一数据插入时发生了错误</label>
		@elseif($errorId == 2)
			<label>步骤二数据插入时发生了错误</label>
		@elseif($errorId == 3)
			<label>步骤三数据插入时发生了错误</label>
		@elseif($errorId == 4)
			<label>步骤四数据插入时发生了错误</label>
		@else
			<label>所有步骤完成</label>
		@endif


		@if($errorId == 5)
			<a href="/admin/manageHotel">完成</a>
		@else
			@if($errorId == 1)
				<a href="/admin/manageHotel/create">返回重新填写</a>
			@elseif($errorId == 2)
				<a href="/admin/manageHotel/create/geolocation/{{$hotelId}}">返回重新填写</a>
			@elseif($errorId == 3)
				<a href="/admin/manageHotel/create/contactAndPayment/{{$hotelId}}">返回重新填写</a>
			@elseif($errorId == 4)
				<a href="/admin/manageHotel/create/facility/{{$hotelId}}">返回重新填写</a>
			@endif
		@endif
	</div>
</div>
@stop

@section('script')
<script type="text/javascript">

$(function(){
	console.log(randomChar(32));
})


function  randomChar(c)  {
	var  x="0123456789qwertyuioplkjhgfdsazxcvbnmQWERTYUIOPASDFGHJKLZXCVBNM";
	var  tmp="";
	var timestamp = new Date().getTime();
	for(var  i=0;i<  c;i++)  {
		tmp  +=  x.charAt(Math.ceil(Math.random()*100000000)%x.length);
	}
	// return  timestamp+tmp;
	return tmp;
}

	
</script>
@stop