@extends('Admin.site')

@section('resources')
	<script type="text/javascript" src="http://echarts.baidu.com/build/dist/echarts.js"></script>
@stop

@section('content')
<div class="home-center">
	<div class="colmun-upper">
		<div class="currency-box order-colmun">
			<div class="order-colmun-title">
				<img src="../Admin/icon/order-title.png" class="home-currency-title-icon">
				<span class="home-currency-text">订单数：<span class="home-currency-number-text">2048</span></span>
				<img src="../Admin/icon/more.png" class="title-more">
			</div>

			<div class="order-colmun-content">

				<div class="untreated-order-colmun">
					<div class="order-currency-background">
						<div class="order-currency-num">( 40 )</div>
						<div class="order-currency-text">未处理订单</div>
					</div>
				</div>

				<div class="separate"></div>

				<div class="new-user-colmun">
					<div class="order-currency-background">
						<div class="order-currency-num">( 40 )</div>
						<div class="order-currency-text">今日新增用户</div>
					</div>
				</div>

			</div>
		</div>

		<div class="currency-box comment-colmun">
			<div class="currency-colmun-title">
				<img src="../Admin/icon/new-comment.png" class="home-currency-title-icon">
				<span class="home-currency-text">最新点评</span>
				<img src="../Admin/icon/more.png" class="title-more">
			</div>

			<div class="currency-content-box">
				<div class="currency-content-colmun">
					<span class="comment-content-title">高级豪华大床房</span>
					<span class="comment-content-description">
						太脏了.....洗手池里还有纸
					</span>
					<span class="comment-content-comment">3分</span>
				</div>

				<div class="currency-content-colmun">
					<span class="comment-content-title">高级豪华大床房</span>
					<span class="comment-content-description">
						太脏了.....洗手池里还有纸
					</span>
					<span class="comment-content-comment">3分</span>
				</div>

				<div class="currency-content-colmun">
					<span class="comment-content-title">高级豪华大床房</span>
					<span class="comment-content-description">
						太脏了.....洗手池里还有纸
					</span>
					<span class="comment-content-comment">3分</span>
				</div>

				<div class="currency-content-colmun">
					<span class="comment-content-title">高级豪华大床房</span>
					<span class="comment-content-description">
						太脏了.....洗手池里还有纸
					</span>
					<span class="comment-content-comment">3分</span>
				</div>

				<div class="currency-content-colmun">
					<span class="comment-content-title">高级豪华大床房</span>
					<span class="comment-content-description">
						太脏了.....洗手池里还有纸
					</span>
					<span class="comment-content-comment">3分</span>
				</div>


			</div>

		</div>

		<div class="currency-box interlocution-colmun">
			<div class="currency-colmun-title">
				<img src="../Admin/icon/new-interlocution.png" class="home-currency-title-icon">
				<span class="home-currency-text">最新问答</span>
				<img src="../Admin/icon/more.png" class="title-more">
			</div>

			<div class="currency-content-box">
				<div class="currency-content-colmun">
					<span class="interlocution-content-title">大家都说这里午餐很好，具体什么餐种呢？</span>
					<span class="interlocution-content-comment">
					<img src="../Admin/icon/answer.png">
					</span>
				</div>

				<div class="currency-content-colmun">
					<span class="interlocution-content-title">大家都说这里午餐很好，具体什么餐种呢？</span>
					<span class="interlocution-content-comment">
					<img src="../Admin/icon/answer.png">
					</span>
				</div>

				<div class="currency-content-colmun">
					<span class="interlocution-content-title">大家都说这里午餐很好，具体什么餐种呢？</span>
					<span class="interlocution-content-comment">
					<img src="../Admin/icon/answer.png">
					</span>
				</div>

				<div class="currency-content-colmun">
					<span class="interlocution-content-title">大家都说这里午餐很好，具体什么餐种呢？</span>
					<span class="interlocution-content-comment">
					<img src="../Admin/icon/answer.png">
					</span>
				</div>

				<div class="refresh-content-colmun">
					<span class="home-box-refresh">
						换一批
					</span>
					<img src="../Admin/icon/refresh.png" class="home-box-refresh-icon">
				</div>
			</div>
		</div>
	</div>


	<div class="colmun-below">
		<div class="currency-box echarts-box">
			<div class="echarts-colmun-title">
				<img src="../Admin/icon/echarts.png" class="home-currency-title-icon">
				<span class="home-currency-text">流水总汇</span>
				<div class="echarts-switch">
					<div class="echarts-switch-currency">
						<div class="switch-circle red"></div>
						<span class="switch-circle-text">退款订单</span>
					</div>
					<div class="echarts-switch-currency">
						<div class="switch-circle green"></div>
						<span class="switch-circle-text">新增用户</span>
					</div>
					<div class="echarts-switch-currency">
						<div class="switch-circle violet"></div>
						<span class="switch-circle-text">流水总计</span>
					</div>
					<div class="echarts-switch-currency">
						<div class="switch-circle blue"></div>
						<span class="switch-circle-text">成交订单</span>
					</div>
				</div>
			</div>
		</div>

		<div class="currency-box discount-colmun">
			<div class="currency-colmun-title">
				<img src="../Admin/icon/discount-title.png" class="home-currency-title-icon">
				<span class="home-currency-text">优惠促销</span>
				<img src="../Admin/icon/more.png" class="title-more">
			</div>

			<div class="currency-content-box">
				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

				<div class="currency-content-colmun">
					<span class="discount-content discount-hotel">悦华酒店</span>
					<span class="discount-content discount-comment">高级双人床</span>
					<span class="discount-content discount-percentage">-33%</span>
					<span class="discount-content discount-price">￥998.00</span>
				</div>

			</div>

		</div>
	</div>

</div>
@stop

@section('script')

@stop