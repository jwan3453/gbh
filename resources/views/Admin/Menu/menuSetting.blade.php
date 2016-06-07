@extends('Admin.site')

@section('resources')
<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/modal.css') }}>
<script src={{ asset('semantic/modal.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
<script src={{ asset('semantic/dimmer.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/checkbox.css') }}>
<script src={{ asset('semantic/checkbox.js') }}></script>

<link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
<script src={{ asset('semantic/dropdown.js') }}></script>

<script src={{ asset('js/jquery.form.js') }}></script>
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
			<img src="../Admin/icon/open-retract.png"></div>
	</div>

	<div class="menusetting-content">
		@foreach($menuList as $menulist)
		<div class="menu-colmun">
			<div class="one-level-menu-colmun">
				<img src="{{$menulist->
				icon_img_1}}" class="menu-icon">
				<span>
					{{$menulist->menu_name}}
					<span class="menusetting-desc-text">({{$menulist->menu_description}})</span>
				</span>
				<img src="../Admin/icon/menu-edit.png" class="menu-edit"  onclick="menuEdit({{$menulist->id}})">
				<img src="../Admin/icon/menu-delete.png" class="menu-delete" onclick="menuDelete({{$menulist->id}})">

				<img src="../Admin/icon/menu-open.png" class="menu-open" onclick="openMenu('{{$menulist->menu_name_eg}}',{{$menulist->id}},this)"></div>

			<div class="second-level-box" id="{{$menulist->menu_name_eg}}"></div>
		</div>
		@endforeach
		<div class="menu-colmun">
			<div class="one-level-menu-colmun">
				<img src="../Admin/icon/menu-setting.png" class="menu-icon">
				<span>
					菜单设置
					<span class="menusetting-desc-text">(此处是备注信息)</span>
				</span>
				<img src="../Admin/icon/menu-edit.png" class="menu-edit">
				<img src="../Admin/icon/menu-delete.png" class="menu-delete">

				<img src="../Admin/icon/menu-open.png" class="menu-open"></div>
		</div>

	</div>
</div>

<div class="edit-add-box modal ui">
	<form id="edit-add-form">
		<div class="edit-add-title">
			<div class="ui radio checkbox first-menu">
				<input type="radio" name="menuLevel" value="1" id="MenuFirst">
				<label>一级菜单</label>
			</div>
			<div class="ui radio checkbox second-menu">
				<input type="radio" name="menuLevel" id="MenuSecond" value="2">
				<label>二级菜单</label>
			</div>
		</div>

		<div class="edit-add-content">
			<div class="content-colmun">
				<div class="content-colmun-left">
					<label>菜单状态</label>
					<select class="ui dropdown select-box" name="menuStatus" id="menuStatus">
						<option value="1">开启</option>
						<option value="0">关闭</option>
					</select>
				</div>
				<div class="content-colmun-right" id="parentIdBox" style="display: none;">
					<label>所属一级</label>
					<select class="ui dropdown select-box" name="parentId" id="parentId">
						<option value="0">请选择</option>
						@foreach($menuList as $menulist)
						<option value="{{$menulist->id}}">{{$menulist->menu_name}}</option>
						@endforeach
					</select>
				</div>
			</div>

			<div class="content-colmun field">
				<div class="content-colmun-left">
					<label>菜单名称</label>
					<input type="text" name="menuName" id="menuName" class="content-input"></div>
				<div class="content-colmun-right">
					<label>菜单英文</label>
					<input type="text" name="menuNameEg" id="menuNameEg" class="content-input" readonly=""></div>
			</div>

			<div class="content-colmun field">
				<label>描述信息</label>
				<input type="text" name="menuDescription" id="menuDescription" class="content-input overall-length"></div>

			<div class="content-colmun field">
				<label>跳转地址</label>
				<input type="text" name="menuChaining" id="menuChaining" class="content-input overall-length"></div>

			<div class="content-upload-colmun">
				<label>上传图标</label>
				<div class="upload-box" id="uploadBoxOne">
					<img src="../Admin/img/plus.png">
				</div>
				<input type="file" class="upload-input" id="uploadBoxOneInput" name="uploadBoxOneInput" />
				<input type="hidden" name="iconImg1" id="iconImg1" />

				<div class="upload-box" id="uploadBoxTwo">
					<img src="../Admin/img/plus.png">
				</div>
				<input type="file" class="upload-input" id="uploadBoxTwoInput" name="uploadBoxTwoInput" />
				<input type="hidden" name="iconImg2" id="iconImg2" />

				<div class="upload-tip-box">
					<span>一级菜单图标为24×24</span>
					<span>第一张为未选中状态</span>
					<span>第二张为选中状态</span>
				</div>
			</div>

			<div class="content-button-colmun">
				<input type="hidden" id="EditOrAdd" name="EditOrAdd" value="add" />
				<input type="hidden" id="menuId" name="menuId" value="0">
				<div class="currency-btu" onclick="submitMenu()">
					<span>确认添加</span>
				</div>
			</div>

		</div>
	</form>
</div>
@stop

@section('script')
<script type="text/javascript">

	//-----展开二级菜单-------
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
            		a += '<img src="../Admin/icon/menu-edit.png" class="menu-edit" onclick="menuEdit('+data.getSecondMenu[i].id+')">';
            		a += '<img src="../Admin/icon/menu-delete.png" class="menu-delete" onclick="menuDelete('+data.getSecondMenu[i].id+')">';
            		a += '</div>';

            	}

            	$("#"+menuName).append(a);
            }
		})

	}
	//-------展开二级菜单--end------

	//-----收起二级菜单------------
	function retractMenu(_this , menuName = '' , menuId = 0) {
		$("#"+menuName).html("");
		$(_this).attr('src','../Admin/icon/menu-open.png');
		$(_this).attr('onclick','openMenu("'+menuName+'",'+menuId+',this)');
	}
	//-----收起二级菜单---end-----

	//--------添加菜单弹窗--------
	$(".menusetting-add").click(function(){
		$("#EditOrAdd").val('add');
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#menuName").val("");
      			$("#menuNameEg").val("");
      			$("#menuDescription").val("");
      			$("#menuChaining").val("");
      			$("#uploadBoxOne").val("");
      			$("#uploadBoxTwo").val("");
      			$("#iconImg1").val("");
      			$("#iconImg2").val("");
    		}
  		}).modal('show');
	})
	//--------添加菜单弹窗---end-----

	//----------上传图标1-------
	$("#uploadBoxOne").click(function(){
		$(this).siblings('#uploadBoxOneInput').val('').trigger('click');
		$("#uploadBoxOneInput").wrap("<form id='myupload' action='/menuSetting/uploadIcon' method='post' enctype='multipart/form-data'></form>");
	})

	$("#uploadBoxOneInput").change(function(){
		$("#myupload").ajaxSubmit({
			dataType : 'json',
			data : {menuLevel : 1 , filename : 'uploadBoxOneInput'},
			headers : {
				'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
			},
			success : function(data){
				console.log(data);
				$("#menuNameEg").val(data.name);
				$("#uploadBoxOne").html("<img src='"+data.imgPath+"'/>");
				$("#iconImg1").val(data.imgPath);
				$("#uploadBoxOneInput").unwrap();
			}
		})
	})

	//-------上传图标2-------
	$("#uploadBoxTwo").click(function(){
		$(this).siblings('#uploadBoxTwoInput').val('').trigger('click');
		$("#uploadBoxTwoInput").wrap("<form id='myupload' action='/menuSetting/uploadIcon' method='post' enctype='multipart/form-data'></form>");
	})

	$("#uploadBoxTwoInput").change(function(){
		$("#myupload").ajaxSubmit({
			dataType : 'json',
			data : {menuLevel : 2 , filename : 'uploadBoxTwoInput'},
			headers : {
				'X-CSRF-TOKEN' : $('meta[name="_token"]').attr('content')
			},
			success : function(data){
				console.log(data);
				$("#uploadBoxTwo").html("<img src='"+data.imgPath+"'/>");
				$("#iconImg2").val(data.imgPath);
				$("#uploadBoxTwoInput").unwrap();
			}
		})
	})

	//-----提交增加/修改 数据-----
	function submitMenu() {
		$.ajax({
			type: 'POST',
            url: '/menuSetting/createMenu',
            data: $("#edit-add-form").serialize(),
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
            	console.log(data);
            	alert(data.statusMsg);
            	location.reload();
            }
		})
	}

	//--------点击二级菜单
	$("#MenuSecond").click(function(){
		$("#parentIdBox").css('display','block');
		$("#uploadBoxTwo").css('display','none');
		a = '<span>一级菜单图标为12×12</span>';
		$(".upload-tip-box").html(a);
	})

	//-----点击一级菜单----
	$("#MenuFirst").click(function(){
		$("#parentIdBox").css('display','none');
		$("#uploadBoxTwo").css('display','block');
		a = '<span>一级菜单图标为24×24</span>';
		a += '<span>第一张为未选中状态</span>';
		a += '<span>第二张为选中状态</span>';
		$(".upload-tip-box").html(a);
	})


	//-------修改菜单信息弹窗------
	function menuEdit(id) {
		$("#EditOrAdd").val('edit');
		$.ajax({
			type: 'POST',
            url: '/menuSetting/getMenuInfo',
            data: {menuId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
            	$("#menuId").val(id);
            	$("#menuName").val(data.menu_name);
      			$("#menuNameEg").val(data.menu_name_eg);
      			$("#menuDescription").val(data.menu_description);
      			$("#menuChaining").val(data.menu_chaining);
      			$("#uploadBoxOne").html("<img src='"+data.icon_img_1+"'/>");
      			$("#uploadBoxTwo").html("<img src='"+data.icon_img_2+"'/>");
      			$("#iconImg1").val(data.icon_img_1);
      			$("#iconImg2").val(data.icon_img_2);

      			// $("input[name=menuLevel][value="+data.menu_level+"]").attr("checked",true);

      			$("#menuStatus option[value='"+data.menu_status+"']").attr("selected", true);
      			$("#parentId option[value='"+data.parent_id+"']").attr("selected", true);


      			if (data.menu_level == 2) {
      				$("#MenuFirst").attr("checked",false);
					$("#MenuSecond").attr("checked","checked");

      				$("#parentIdBox").css('display','block');
					$("#uploadBoxTwo").css('display','none');
					a = '<span>一级菜单图标为12×12</span>';
					$(".upload-tip-box").html(a);
      			}

      			if (data.menu_level == 1) {
					$("#MenuSecond").attr("checked",false);
					$("#MenuFirst").attr("checked","checked");

      				$("#parentIdBox").css('display','none');
					$("#uploadBoxTwo").css('display','block');
					a = '<span>一级菜单图标为24×24</span>';
					a += '<span>第一张为未选中状态</span>';
					a += '<span>第二张为选中状态</span>';
					$(".upload-tip-box").html(a);
      			}
            }
		})
		$('.edit-add-box').modal({
			closable  : true,
	    	onHide : function() {
      			$("#menuName").val("");
      			$("#menuNameEg").val("");
      			$("#menuDescription").val("");
      			$("#menuChaining").val("");
      			$("#uploadBoxOne").val("");
      			$("#uploadBoxTwo").val("");
      			$("#iconImg1").val("");
      			$("#iconImg2").val("");
      			// $("input[name=menuLevel][value=1]").attr("checked",true);

      			$("#menuStatus option[value=1]").attr("selected", true);
      			$("#parentId option[value=0]").attr("selected", true);
    		}
  		}).modal('show');
	}

	//---------删除菜单-----
	function menuDelete(id) {
		$.ajax({
			type: 'POST',
            url: '/menuSetting/menuDelete',
            data: {menuId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success : function(data){
            	console.log(data);
            	alert(data.statusMsg);
            	location.reload();
            }
		})
	}
	
</script>
@stop