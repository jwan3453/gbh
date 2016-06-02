@extends('Admin.site')

@section('resources')
	<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
    <script src={{ asset('semantic/modal.js') }}></script>
    <script src={{ asset('semantic/dimmer.js') }}></script>
@stop

@section('content')
<div class="menusetting-box">
	<div class="menusetting-upper">
		<div class="menusetting-add">
			<img src="../Admin/icon/menu-setting-add.png">
			<span>添加菜单</span>
		</div>
		<div class="menusetting-open">
			<span>展开全部</span>
			<img src="../Admin/icon/open-retract.png">
		</div>
	</div>

	<div class="menusetting-content">

		@foreach($menuList as $menulist)

		<div class="menu-colmun">
			<div class="one-level-menu-colmun">
				<img src="{{$menulist->icon_img_1}}" class="menu-icon">
				<span>{{$menulist->menu_name}}<span class="menusetting-desc-text">({{$menulist->menu_description}})</span></span>
				<img src="../Admin/icon/menu-edit.png" class="menu-edit">
				<img src="../Admin/icon/menu-delete.png" class="menu-delete">

				<img src="../Admin/icon/menu-open.png" class="menu-open" onclick="openMenu('{{$menulist->menu_name_eg}}',{{$menulist->id}},this)">
			</div>

			<div class="second-level-box" id="{{$menulist->menu_name_eg}}">
				
			</div>
		</div>

		@endforeach


		<div class="menu-colmun">
			<div class="one-level-menu-colmun">
				<img src="../Admin/icon/menu-setting.png" class="menu-icon">
				<span>菜单设置<span class="menusetting-desc-text">(此处是备注信息)</span></span>
				<img src="../Admin/icon/menu-edit.png" class="menu-edit">
				<img src="../Admin/icon/menu-delete.png" class="menu-delete">

				<img src="../Admin/icon/menu-open.png" class="menu-open">
			</div>
		</div>


	</div>
</div>


<div class="edit-add-box modal ui"> 
	<div class="edit-add-box-title"></div>
</div>



@stop

@section('script')
<script type="text/javascript">
	function openMenu(menuName = '' , menuId = 0 , _this) {
	
		if (menuName == '' || menuId == 0) {
			alert("菜单配置错误！");
		}

		$(_this).attr('src','../Admin/icon/menu-retract.png');
		$(_this).attr('onclick','retractMenu(this,"'+menuName+'",'+menuId+')');

		$.ajax({
			type: 'POST',
            url: '/menuSetting/getSecondMenu',
            data: {menuId : menuId},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
            
            	var a = ''
            	for (var i = 0; i < data.getSecondMenu.length; i++) {
            		
            		a += '<div class="second-level-colmun">';
            		a += '<img src="'+data.getSecondMenu[i].icon_img_1+'" class="second-level-menu-icon">';
            		a += '<span>'+data.getSecondMenu[i].menu_name+'<span class="menusetting-desc-text">('+data.getSecondMenu[i].menu_description+')</span></span>';
            		a += '<img src="../Admin/icon/menu-edit.png" class="menu-edit">';
            		a += '<img src="../Admin/icon/menu-delete.png" class="menu-delete">';
            		a += '</div>';

            	}

            	$("#"+menuName).append(a);
            }
		})

	}

	function retractMenu(_this , menuName = '' , menuId = 0) {
		$("#"+menuName).html("");
		$(_this).attr('src','../Admin/icon/menu-open.png');
		$(_this).attr('onclick','openMenu("'+menuName+'",'+menuId+',this)');
	}

	$(".menusetting-add").click(function(){
		$('.edit-add-box').modal('show');
	})
</script>
@stop