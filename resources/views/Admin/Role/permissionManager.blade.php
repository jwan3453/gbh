@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('admin.partial.breadcrumbTrail')
        <div class="container-action" style="margin-top: 60px;margin-bottom: 40px;">
            {{--<p>当前用户总数:{{ $countRes }}</p>--}}
            <button class="standard modal">添加权限</button>
        </div>
        <div class="user-table">

            <ul style="margin-top: 30px;">
                <li class="first-cols" style="margin-left: -38px;">
                    <span style="text-align: left;"><p style="margin-left: 100px;margin-top: 0px;">权限功能列表</p></span>
                    <span>描述</span>
                    <span>操作</span>
                </li>
                @foreach( $permissionRes as $permissionList)
                <li>
                    <div class="currentPerms">
                        <span id="{{ $permissionList->id }}" style="display: none;"></span>
                        <span style="text-align: left;"><p style="margin-left: 100px;margin-top: 0px;"><i class="add square icon firstPerms" style="cursor:pointer;"></i>{{ $permissionList->display_name }}</p></span>
                        <span>{{ $permissionList->description }}</span>
                        <span>
                            <span id="editBtn_" onclick="editPermission({{ $permissionList->id }})"><i class="edit icon"></i>修改</span>
                            <span id="removeBtn" onclick="removePermission({{ $permissionList->id }})"><i class="remove circle outline icon"></i>删除</span>
                        </span>
                    </div>
                    <ul class="second-perms navContents secondMenu">
                        @if(count($permissionList->secondPerm) > 0)
                            @foreach($permissionList->secondPerm as $key => $secondPermList)
                                <li>
                                    <span style="display: none;">{{$secondPermList->id}}</span>
                                    <span style="text-align: left;"><p style="margin-top: 0px;">|--{{$secondPermList->display_name}}</p></span>
                                    <span>{{$secondPermList->description}}</span>
                                    <span>
                                        <span id="editBtn_" onclick="editPermission({{ $secondPermList->id }})"><i class="edit icon"></i>修改</span>
                                        <span id="removeBtn" onclick="removePermission({{ $secondPermList->id }})"><i class="remove circle outline icon"></i>删除</span>
                                    </span>
                                </li>
                            @endforeach
                        @endif
                    </ul>
                </li>
                @endforeach

            </ul>


        </div>
    </div>

    {{--添加模块--}}

    <div class="ui modal add perm-group-modal">
        <i class="close icon"></i>
        <div class="header">
            添加新权限
        </div>
        <div class="contents">
            <div class="form-group-box_">
                <form id="addGroupForms" class="editPerms addPerms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <ul style="margin-top: -20px;">
                        <li>
                            <div><span>权限名</span><input type="text" name="permissionName" placeholder="请输入权限名"></div>
                        </li>
                        <li style="margin-left: 30px;">
                            <div><span>英文名</span><input type="text" name="englishName" id="englishName" placeholder="请输入英文名"></div>
                        </li>
                        <li>
                            <div><span style="vertical-align: middle;">描述</span><textarea style="vertical-align: middle; width: 180px;" id="descriptions" name="description" placeholder="描述内容"></textarea></div>
                        </li>
                        <li style="margin-left: 30px;">
                            <div><span>路由</span><input text="type" id="routeUrl" name="routeUrl"></div>
                        </li>
                        <li style="margin: 0px;">
                            <div style="margin-right: 330px;margin-top: 20px;">
                                <span>权限组</span>
                                <select name="selectPermType" id="selectPermType" onchange="permType();">
                                    <option value="0" selected>尚未选择类型</option>
                                    <option value="1">选择权限组</option>
                                    <option value="2">独立权限组</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div>
                                <span>绑定菜单</span>
                                <select name="selectMenuType" id="selectMenuType" onchange="menuType()" style="outline: none;cursor:pointer;">
                                    <option value="0" selected>不绑定菜单</option>
                                    <option value="1">绑定一级菜单</option>
                                    <option value="2">绑定二级菜单</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div id="permShowLists" style="margin-top:-50px;padding-top: 10px;margin-left: 30px;">

                            </div>
                        </li>
                        <li>
                            <div id="MenuShowLists" style="margin-top:-30px;padding-top: 10px;margin-left: 30px;">
                                <div class="showMenu_" id="showMenu_">
                                    <span>一级菜单</span>
                                    <select name="menuLists" id="menuLists" style="margin-left: 20px;">
                                        <option value="0">请选择需要绑定的菜单</option>
                                        @foreach($getFirstMenu as $getMenuList)
                                            <option value="{{$getMenuList->id}}">{{$getMenuList->menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="showSecond_" id="showSecond_">
                                    <span>二级菜单</span>
                                    <select name="secondMenuList" id="secondMenuList" style="margin-left: 20px;">
                                        <option value="0">请选择需要绑定的菜单</option>
                                        @foreach($getSecondMenu as $getSecondMenus)
                                            <option value="{{$getSecondMenus->id}}">{{$getSecondMenus->menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div id="addUserGroup" style="margin-left: 170px;">
                        <div class="add-group-btn" style="margin-left: 15px;"><div id="addPermissionBtn">确认添加</div><div class="ui active inline loader loader_"></div></div>
                        <input type="reset" value="重置">
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--修改模块--}}

    <div class="ui modal edit perm-group-modal">
        <i class="close icon"></i>
        <div class="header">
            权限修改
        </div>
        <div class="contents">
            <div class="form-group-box_">
                <form id="editGroupForms" class="editPerms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="permissionId" id="permissionId">
                    <ul>
                        <li>
                            <div><span>权限名</span><input type="text" id="permissionName_" name="permissionName_" placeholder="请输入权限名"></div>
                        </li>
                        <li style="margin-left: 30px;">
                            <div><span>英文名</span><input text="text" id="englishName_" name="englishName_" placeholder="请输入英文名"></div>
                        </li>
                        <li>
                            <div><span style="vertical-align: middle;">描述</span><textarea style="vertical-align: middle; width: 180px;" id="description_" name="description_" placeholder="描述内容"></textarea></div>
                        </li>
                        <li style="margin-left: 30px;">
                            <div><span>路由</span><input type="text" id="routeUrl_" name="routeUrl_"></div>
                        </li>
                        <li style="margin-right: 300px;">
                            <div>
                                <span>权限组</span>
                                <select name="selectPermType_" id="selectPermType_" onchange="permType_()" style="outline: none;cursor:pointer;">
                                    <option value="0" selected>尚未选择权限组</option>
                                    <option value="1">绑定权限组</option>
                                    <option value="2">独立权限组</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div>
                                <span>绑定菜单</span>
                                <select name="selectMenuType_" id="selectMenuType_" onchange="menuType_()" style="outline: none;cursor:pointer;">
                                    <option value="0" selected>不绑定菜单</option>
                                    <option value="1">绑定一级菜单</option>
                                    <option value="2">绑定二级菜单</option>
                                </select>
                            </div>
                        </li>
                        <li>
                            <div id="editPermShowLists" style="margin-top:-50px;padding-top: 10px;margin-left: 30px;">

                            </div>
                        </li>
                        <li>
                            <div id="editMenuShowLists" style="margin-top:-30px;padding-top: 10px;margin-left: 30px;">
                                <div class="showMenu" id="showMenu">
                                <span>菜单列表</span>
                                <select name="menuListsForEdit" id="menuListsForEdit" style="margin-left: 20px;">
                                    <option value="0">请选择需要绑定的菜单</option>
                                    @foreach($getFirstMenu as $getMenuList)
                                        <option value="{{$getMenuList->id}}">{{$getMenuList->menu_name}}</option>
                                    @endforeach
                                </select>
                                </div>
                                <div class="showSecond" id="showSecond">
                                    <span>二级菜单</span>
                                    <select name="secondMenuListForEdit" id="secondMenuListForEdit" style="margin-left: 16px;">
                                        <option value="0">请选择需要绑定的菜单</option>
                                        @foreach($getSecondMenu as $getSecondMenus)
                                            <option value="{{$getSecondMenus->id}}">{{$getSecondMenus->menu_name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </li>
                    </ul>
                    <div id="editUserGroup" style="margin-left: 190px;">
                        <div class="edit-group-btn"><div id="editPermissionBtn">确认修改</div><div class="ui active inline loader loader_"></div></div>
                        <input type="reset" value="重置">
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--alert弹窗层--}}
    <div class="ui small modal">
        <div class="content">
            <p>确认要移除该用户吗?</p>
            <input type="hidden" id="permId_" name="permId_">
        </div>
        <div class="actions">
            <span class="ui basic cancel inverted button">
                取消
            </span>
            <span class="ui ok inverted button" onclick="doDelete()">
                确认
            </span>
        </div>
    </div>


@stop

@section('script')

    <script>

        //add选择绑定类型
        function permType(){

            if($("#selectPermType").val() == 1){

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/permtype',
                    data:{type:$("#selectPermType").val()},
                    dataType: 'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode===1){
                            if($( "#permShowLists:has(span)" ).length==0){
                                var options = "";
                                for(var i=0; i < data.extra.length ; i++){
                                    for(var j = 0; j < data.statusMsg.length ; j++){
                                        if(i == j){
                                            options += '<option value="'+data.statusMsg[j]+'">'+data.extra[i]+'</option>';
                                        }
                                    }
                                }
                                var html = '<span>权限列表</span>'+
                                        '<select name="permLists" id="permLists" style="margin-left: 20px;">'+
                                        '<option value="0">'+"请选择所属权限组"+'</option>'+
                                        options+
                                        '</select>';

                                $("#permShowLists").append(html);
                            }
                        }else{
                            toastAlert('error',2);
                            return false;
                        }
                    }
                });
            }else{
                $("#permShowLists").children().remove();
            }
        }
        //edit选择绑定类型
        function permType_(){

            if($("#selectPermType_").val() == 1){

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/permtypeforedit',
                    data:{type:$("#selectPermType_").val()},
                    dataType: 'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode===1){
                            if($( "#editPermShowLists:has(span)" ).length==0){
                                var options = "";
                                for(var i=0; i < data.extra.length ; i++){
                                    for(var j = 0; j < data.statusMsg.length ; j++){
                                        if(i == j){
                                            options += '<option value="'+data.statusMsg[i]+'">'+data.extra[j]+'</option>';
                                        }
                                    }
                                }
                                var html = '<span>权限列表</span>'+
                                        '<select name="permListsForEdit" id="permListsForEdit" style="margin-left: 20px;">'+
                                        '<option value="0">'+"请选择需要绑定的酒店"+'</option>'+
                                        options+
                                        '</select>';

                                $("#editPermShowLists").append(html);

                                $("#permListsForEdit").find('option[value="'+id+'"]').attr("selected",true);
                            }
                        }else{
                            toastAlert('error',2);
                            return false;
                        }
                    }
                });
            }else{
                $("#editPermShowLists").children().remove();
            }
        }


        //menu
        function menuType(){
            if($("#selectMenuType").val() == 1){

                $("#showMenu_").addClass('showMenu_').removeClass('showMenu_');
                $("#showSecond_").removeClass('showSecond_').addClass('showSecond_');

            }else if($("#selectMenuType").val() == 2){
                $("#showMenu_").removeClass('showMenu_').addClass('showMenu_');
                $("#showSecond_").addClass('showSecond_').removeClass('showSecond_');
            }else{
                $("#showMenu_").removeClass('showMenu_').addClass('showMenu_');
                $("#showSecond_").removeClass('showSecond_').addClass('showSecond_');
            }
        }

        function menuType_(){

            if($("#selectMenuType_").val() == 1){

                $("#showMenu").addClass('showMenu').removeClass('showMenu');
                $("#showSecond").removeClass('showSecond').addClass('showSecond');

            }else if($("#selectMenuType_").val() == 2){
                $("#showMenu").removeClass('showMenu').addClass('showMenu');
                $("#showSecond").addClass('showSecond').removeClass('showSecond');
            }else{
                $("#showMenu").removeClass('showMenu').addClass('showMenu');
                $("#showSecond").removeClass('showSecond').addClass('showSecond');
            }

        }

        //Model

        function editPermission(id){


            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailpermission',
                data:{id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data.extra){

                        $("#permissionId").val(data.extra.id);
                        $("#permissionName_").val(data.extra.display_name);
                        $("#description_").val(data.extra.description);
                        $("#englishName_").val(data.extra.name);
                        $("#routeUrl_").val(data.extra.route);

                        if(data.extra.parent_id){
                            $("#selectPermType_ option:eq(1)").attr("selected",true);
                            permType_();
                            $("#permListsForEdit").find('option[value="'+data.extra.parent_id+'"]').attr("selected",true);
                        }else{
                            $("#selectPermType_").find('option[value="2"]').attr("selected",true);
                            $("#editPermShowLists").children().remove();
                        }

                        //是否绑定菜单
                        if(data.extra.menu_type == 1){
                            $("#selectMenuType_").find('option[value="1"]').attr("selected",true);
                            $("#showSecond").removeClass('showSecond').addClass('showSecond');
                            $("#showMenu").addClass('showMenu').removeClass('showMenu');
                            $("#menuListsForEdit").find('option[value="'+data.extra.menu_id+'"]').attr("selected",true);
                        }else if(data.extra.menu_type == 2){
                            $("#selectMenuType_").find('option[value="2"]').attr("selected",true);
                            $("#showSecond").addClass('showSecond').removeClass('showSecond');
                            $("#showMenu").removeClass('showMenu').addClass('showMenu');
                            $("#editMenuShowLists").find('option[value="'+data.extra.menu_id+'"]').attr("selected",true);
                        }
                        else{
                            $("#showMenu").removeClass('showMenu').addClass('showMenu');
                            $("#showSecond").removeClass('showSecond').addClass('showSecond');
                        }


                        $('.ui.modal.edit').modal('show');


                    }else{
                        toastAlert('error',2);
                        return false;
                    }
                }
            });

        }

        function removePermission(id){

            $("#permId_").val(id);

            $('.small.modal').modal('show');

        }

        function doDelete(){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/removepermission',
                data:{id:$("#permId_").val()},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    if(data.statusCode == 1){
                        toastAlert('删除成功',1);
                        window.location.href = '/admin/administrator/permissionmanager';
                    }else{
                        toastAlert('删除失败',2);
                        return false;
                    }

                }
            });
        }

        //提交验证
        $(function(){

            //层级下拉
            $(".firstPerms").click(function(){

                if($(this).hasClass('add')){
                    $(this).removeClass('add').addClass('minus');
                }else{
                    $(this).removeClass('minus').addClass('add');
                }
                $(this).parents().parents().next(".navContents").slideToggle(1000).siblings(".navContent").slideUp(1000);

                AdjustHeights_();

            });


            //新增用户弹窗层
            $(".standard.modal").click(function(){

                $('.ui.modal.add').modal('show');
            });

            //add提交
            $("#addPermissionBtn").click(function(){

                var permissionName = $("input[name='permissionName']").val();
                var description    = $("#descriptions").val();
                var englishName    = $("#englishName").val();


                if(permissionName == ""){
                    toastAlert('权限名不能为空',2);
                    $("input[name='permissionName']").focus();
                    return false;
                }
                if(description == ""){
                    toastAlert('描述不能为空',2);
                    $("input[name='description']").focus();
                    return false;
                }
                if(englishName == ""){
                    toastAlert('英文名不能为空',2);
                    $("input[name='englishName']").focus();
                    return false;
                }

                if($("#selectPermType").val() == 1 && $("#permLists").val() == 0){
                    toastAlert('请选择需要绑定的权限组',2);
                    $("#permLists").focus();
                    return false;
                }
                if($("#selectMenuType").val() == 1 && $("#menuLists").val() == 0){
                    toastAlert('请选择需要绑定的菜单',2);
                    $("#menuLists").focus();
                    return false;
                }


                $(this).html("提交中");
//                $(".loader").removeClass('loader_');

                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checknewpermissions',
                    data:{permissionName:permissionName,englishName:englishName},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){
                            //验证成功,添加数据


                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/createpermissions',
                                data:$(".addPerms").serialize(),
                                dataType:'json',
                                headers:{
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                                success:function(data){
                                    if(data.statusCode == 1){

                                        toastAlert('添加成功',1);
                                        $("#addUserBtn").html("确认添加");
//                                        $(".loader").removeClass('loader_');

                                        function jumLogin(){
                                            window.location.href = '/admin/administrator/permissionmanager';
                                        }
                                        setTimeout(jumLogin,2000);

                                    }else{
                                        $(this).html("确认添加");
                                        $(".loader").addClass('loader_');
                                        return false;
                                    }
                                }
                            });
                        }else{
                            toastAlert('很抱歉:已有用户名',2);
                            $("#addUserBtn").html("确认添加");
                            $(".loader").addClass('loader_');
                            return false;
                        }
                    },
                    error:function(){
                        toastAlert('error',2);
                        $("#addUserBtn").html("确认添加");
                        $(".loader").addClass('loader_');
                        return false;
                    }

                });


            });



            //edit模块验证
            $("#editPermissionBtn").click(function(){


                var permissionName = $("input[name='permissionName_']").val();
                var englishName_   = $("#englishName_").val();
                var description    = $("#description_").val();
                var routeUrl_      = $("#routeUrl_").val();
                var id = $("#permissionId").val();


                if(permissionName == ""){
                    toastAlert('权限名不能为空',2);
                    $("input[name='username_']").focus();
                    return false;
                }
                if(englishName_ == ""){
                    toastAlert('权限英文名不能为空',2);
                    $("input[name='englishName_']").focus();
                    return false;
                }

                if(description == ""){
                    toastAlert('描述不能为空',2);
                    $("input[name='truename_']").focus();
                    return false;
                }

                if(routeUrl_ == ""){
                    toastAlert('路由地址不能为空',2);
                    $("input[name='routeUrl_']").focus();
                    return false;
                }

                if($('#selectPermType_').val() == 1 && $('#permListsForEdit').val() ==0 ){
                    toastAlert('请选择需要绑定的权限组',2);
                    $('#permListsForEdit').focus();
                    return false;
                }
                if($("#selectMenuType_").val() == 1 && $("#menuListsForEdit").val() == 0){
                    toastAlert('请选择绑定的菜单',2);
                    $("#menuListsForEdit").focus();
                    return false;
                }

                $(this).html("提交中");
//                $(".loaders").removeClass('edit-loader');



                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checkeditpermission',
                    data:{permissionName:permissionName,id:id},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){
                            //验证成功,添加数据

                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/updatepermission',
                                data:$("#editGroupForms").serialize(),
                                dataType:'json',
                                headers:{
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                                success:function(data){
                                    if(data.statusCode == 1){

                                        toastAlert('修改成功',1);
                                        $("#editUserBtn").html("提交中");
                                        $(".loaders").removeClass('edit-loader');

                                        function jumLogin(){
                                            window.location.href = '/admin/administrator/permissionmanager';
                                        }
                                        setTimeout(jumLogin,2000);

                                    }else{
                                        toastAlert('修改失败',1);
                                        $("#editUserBtn").html("确认修改");
                                        $(".loaders").addClass('edit-loader');
                                        return false;
                                    }
                                }
                            });
                        }else{
                            toastAlert('很抱歉:已有用户名',2);
                            $("#addUserBtn").html("确认修改");
                            $(".loaders").addClass('loaders');
                            return false;
                        }
                    },
                    error:function(){
                        toastAlert('error',2);
                        $("#addUserBtn").html("确认修改");
                        $(".loaders").addClass('loaders');
                        return false;
                    }

                });


            });

            function AdjustHeights_() {

                var heightMenu = document.getElementById('menuBox').offsetHeight;

                var heightHotel = document.getElementById('containerUser').offsetHeight;

                $('#menuBox').css('height',heightHotel*8+60);

            }

        });
        function toastAlert(Msg,status)
        {

            if(status === 1)
            {
                $('#alertBox').removeClass('wrong-input').addClass('wrong-input');
            }
            if(status === 2){
                $('#alertBox').removeClass('success-toast').addClass('success-toast');
            }
            $('#alertBox').text(Msg).fadeIn();

            setTimeout(function () {
                $('#alertBox').fadeOut();
            }, 2000);
        }


    </script>

@stop