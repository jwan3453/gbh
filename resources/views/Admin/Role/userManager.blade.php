@extends('Admin.site')

@section('resources')

@stop

@section('content')

<div id="containerUser">
    @include('admin.partial.breadcrumbTrail')
    <div class="container-action" >

        <button class="standard modal">添加用户</button>

    </div>
    <div class="user-table">
        <table class="ui table">
            <thead>
            <tr>
                <th>用户名</th>
                <th>所属角色组</th>
                <th>真实姓名</th>
                <th>注册时间</th>
                <th>电话</th>
                <th>所属酒店</th>
                <th>职位</th>
                <th>备注</th>
                <th>操作</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $dataRes as $userList)
            <tr>
                <td id="{{ $userList->user_id }}" class="get-id"></td>
                <td>{{ $userList->username }}</td>
                <td>{{ $userList->display_name }}</td>
                <td>{{ $userList->truename }}</td>
                <td>{{ $userList->updated_at }}</td>
                <td>{{ $userList->mobile }}</td>
                <td>{{ $userList->name }}</td>
                <td>{{ $userList->position }}</td>
                <td>{{ $userList->remarks }}</td>
                <td>
                    <ul>
                        <li id="editBtn_" onclick="editUser({{ $userList->user_id }})"><i class="edit icon"></i>修改</li>
                        <li id="removeBtn" onclick="removeUser({{ $userList->user_id }})"><i class="remove circle outline icon"></i>删除</li>
                        <li id="removeBtn" onclick="bindRole({{ $userList->user_id }})" style="padding-top: 10px;"><i class="share alternate icon"></i>角色组绑定</li>
                    </ul>
                </td>
            </tr>
            @endforeach
            </tbody>
        </table>
        <div id="pageBox"><div class="pages" style="float: right;">{!! $pageNum->render() !!}</div></div>
    </div>
</div>

{{--添加模块--}}

<div class="ui modal add test">
    <i class="close icon"></i>
    <div class="header">
        添加新用户
    </div>
    <div class="contents">
        <div class="form-box">
            <form id="addForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <ul>
                    <li>
                        <div><span>用户名:</span><input type="text" name="username" placeholder="请输入用户名"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;"><span>真实姓名 :</span><input type="text" name="truename" placeholder="请输入真实姓名"></div>
                    </li>
                    <li>
                        <div><span>联系方式: </span><input type="text" name="mobile" placeholder="请输入联系方式"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;"><span>输入密码 :</span><input type="password" name="password" placeholder="请输入密码"></div>
                    </li>
                    <li>
                        <div><span>确认密码 :</span><input type="password" id="pwd" placeholder="请确认密码"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;"><span>所任职位 :</span><input type="text" name="position" placeholder="请输入所任职位"></div>
                    </li>
                    <li>
                        <div>
                           <span> 所属酒店 :</span>
                            {{--<input type="text" name="hotel_id" placeholder="请输入酒店名">--}}
                            <select name="hotel_type" id="hotel_type" onchange="hotelType();">
                                <option value="0">无所属酒店</option>
                                <option value="1">管理部分酒店</option>
                                <option value="2">管理所有酒店</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div  id="selectHotelList" style="margin-left: 50px;">
                            <span>酒店选择 :</span>
                            {{--<input type="text" name="hotel_id" placeholder="请输入酒店名">--}}
                            <select name="hotelId" id="hotelId" disabled>
                                <option value="0">尚未选择酒店</option>
                                @foreach($hotelRes as $hotelResLists)
                                    <option value="{{$hotelResLists->id}}">{{$hotelResLists->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                </ul>
                <div id="addUserBox">
                    <div class="add-user-btn"><div id="addUserBtn">确认添加</div><div class="ui active inline loader loader_"></div></div>
                    <input type="reset" value="重置">
                </div>

            </form>
        </div>
    </div>
</div>

{{--修改模块--}}

<div class="ui modal edit">
    <i class="close icon"></i>
    <div class="header">
        修改
    </div>
    <div class="contents">
        <div class="form-box">
            <form id="editForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="userId" id="userId">
                <ul>
                    <li>
                        <div><span>用户名: </span><input type="text" id="username_" name="username_" placeholder="请输入用户名"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;"><span>真实姓名 :</span><input type="text" id="truename_" name="truename_" placeholder="请输入真实姓名"></div>
                    </li>
                    <li>
                        <div><span>联系方式 :</span><input type="text" id="mobile_" name="mobile_" placeholder="请输入联系方式"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;"><span>所任职位 :</span><input type="text" id="position_" name="position_" placeholder="请输入所任职位"></div>
                    </li>
                    <li>
                        <div><span>备注 :</span><input type="text" name="position_" placeholder="请输入所任职位"></div>
                    </li>
                    <li>
                        <div style="margin-left: 50px;">
                            <span>所属酒店 :</span>
                            <select name="edit_hotel_type" id="edit_hotel_type" onchange="hotelType_();" style="width:190px;">
                                <option value="0">无所属酒店</option>
                                <option value="1">管理部分酒店</option>
                                <option value="2">管理所有酒店</option>
                            </select>
                        </div>
                    </li>
                    <li>
                        <div id="editSelectHotel" >
                            <span>酒店选择 :</span>
                            {{--<input type="text" name="hotel_id" placeholder="请输入酒店名">--}}
                            <select name="editHotelId" id="editHotelId" disabled>
                                <option value="0">尚未选择酒店</option>
                                @foreach($hotelRes as $hotelResLists)
                                    <option value="{{$hotelResLists->id}}">{{$hotelResLists->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </li>
                </ul>
                <div id="editUserBox">
                    <div class="edit-user-btn"><div id="editUserBtn">确认修改</div><div class="ui active inline loader loaders edit-loader"></div></div>
                    <input type="reset" value="重置">
                </div>

            </form>
        </div>
    </div>
</div>

    {{--角色绑定--}}
<div class="ui modal role-bind">
    <i class="close icon"></i>
    <div class="header">
        角色绑定
    </div>
    <div class="contents">
        <div class="form-box-bind">
            <form id="bindForm">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="userIdForRole" id="userIdForRole">
                <ul>
                    <li>
                        <div><span>用户名 :</span><input type="text" id="username_role" name="username_role" placeholder="请输入用户名"></div>
                    </li>
                    <li style="margin-bottom: 40px;">
                        <div style="margin-top: 10px;">
                            <span>所属角色组 :</span>
                            <select id="selectBox_">
                                <option id="currentRole" value="0" selected="selected">尚未绑定角色组</option>
                                @foreach( $roleRes as $roleList)
                                    <option value="{{ $roleList->id }}">{{ $roleList->display_name }}</option>
                                @endforeach
                            </select>
                            <input type="hidden" id="roleInput" name="roleInput">
                        </div>
                    </li>
                </ul>
                <div id="bindRoleBox" style="margin-top: 30px;">
                    <div class="bind-role-btn"><div id="bindRoleBtn">确认修改</div><div class="ui active inline loader loaders edit-loader"></div></div>
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

        //酒店类型
        function hotelType(){
            if($("#hotel_type").val() == 1){
                $("#hotelId").attr('disabled',false);
            }else{
                $("#hotelId").attr('disabled',true);
            }
        }

        function hotelType_(){
            if($("#edit_hotel_type").val() == 1){
                $("#editHotelId").attr('disabled',false);
            }else{
                $("#editHotelId").attr('disabled',true);
            }
        }

        function editUser(id){


            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailuser',
                data:{id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data){

                        $("#userId").val(data.extra.user_id);
                        $("#username_").val(data.extra.username);
                        $("#truename_").val(data.extra.truename);
                        $("#mobile_").val(data.extra.mobile);
                        $("#hotel_").val(data.extra.hotel);
                        $("#position_").val(data.extra.position);

                        if(data.statusMsg){
                            $("#selectBox_").find('option[value="'+data.statusMsg.id+'"]').attr("selected",true);
                            $("#roleInput").val(data.statusMsg.id);
                        }else{
                            $("#selectBox_ option:eq(0)").attr("selected",true);
                        }

                        $('.ui.modal.edit').modal('show');


                    }else{
                        toastAlert('error',2);
                        return false;
                    }
                }
            });

        }

        function removeUser(id){

            $("#permId_").val(id);

            $('.small.modal').modal('show');

        }

        function doDelete(){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/removeuser',
                data:{userId:$("#permId_").val()},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    if(data.statusCode == 1){
                        toastAlert('删除成功',1);
                        window.location.href = '/admin/administrator/usermanager';
                    }else{
                        toastAlert('删除失败',2);
                        return false;
                    }

                }
            });

        }

        function bindRole(id){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailcurrentbind',
                data:{id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data){

                        $("#userIdForRole").val(data.extra.user_id);
                        $("#username_role").val(data.extra.username);
                        if(data.statusMsg){
                            $("#selectBox_").find('option[value="'+data.statusMsg.id+'"]').attr("selected",true);
                            $("#roleInput").val(data.statusMsg.id);
                        }else{
                            $("#selectBox_ option:eq(0)").attr("selected",true);
                        }

                        $('.ui.modal.role-bind').modal('show');


                    }else{
                        toastAlert('error',2);
                        return false;
                    }
                }
            });

        }


        $(function(){


            //新增用户弹窗层
            $(".standard.modal").click(function(){
                $('.ui.modal.add').modal('show');
            });

            //add提交
            $("#addUserBtn").click(function(){

                var username = $("input[name='username']").val();
                var password = $("input[name='password']").val();
                var truename = $("input[name='truename']").val();
                var mobile = $("input[name='mobile']").val();
                var hotel = $("input[name='hotel']").val();
                var position = $("input[name='position']").val();
                var pwd = $("#pwd").val();


                if(username == ""){
                    toastAlert('用户名不能为空',2);
                    $("input[name='username']").focus();
                    return false;
                }
                if(password == ""){
                    toastAlert('密码不能为空',2);
                    $("input[name='password']").focus();
                    return false;
                }
                if(pwd == ""){
                    toastAlert('密码不能为空',2);
                    $("#pwd").focus();
                    return false;
                }
                if(password != pwd){
                    toastAlert('两次密码输入不一致',2);
                    $("#pwd").focus();
                    return false;
                }
                if(truename == ""){
                    toastAlert('真实姓名不能为空',2);
                    $("input[name='truename']").focus();
                    return false;
                }
                if(mobile == ""){
                    toastAlert('联系方式不能为空',2);
                    $("input[name='mobile']").focus();
                    return false;
                }
                if(hotel == ""){
                    toastAlert('酒店名不能为空',2);
                    $("input[name='hotel']").focus();
                    return false;
                }
                if(position == ""){
                    toastAlert('职位不能为空',2);
                    $("input[name='position']").focus();
                    return false;
                }
                if($("#hotel_type").val() == 1 && $("#hotelId").val() == 0){
                    toastAlert('酒店选择不能为空',2);
                    $("#hotelId").focus();
                    return false;
                }


                $(this).html("提交中");
                $(".loader").removeClass('loader_');

                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checknewuser',
                    data:{username:username},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){
                            //验证成功,添加数据


                            var userData = $("#addForm").serialize();
                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/createuser',
                                data:userData,
                                dataType:'json',
                                headers:{
                                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                                },
                                success:function(data){
                                    if(data.statusCode == 1){

                                        toastAlert('添加成功',1);
                                        $("#addUserBtn").html("确认添加");
                                        $(".loader").removeClass('loader_');

                                        function jumLogin(){
                                            window.location.href = '/admin/administrator/usermanager';
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
            $("#editUserBtn").click(function(){


                var username_ = $("input[name='username_']").val();
                var truename_ = $("input[name='truename_']").val();
                var mobile_ = $("input[name='mobile_']").val();
                var hotel_ = $("input[name='hotel_']").val();
                var position_ = $("input[name='position_']").val();
                var id = $("#userId").val();


                if(username_ == ""){
                    toastAlert('用户名不能为空',2);
                    $("input[name='username_']").focus();
                    return false;
                }
                if(truename_ == ""){
                    toastAlert('真实姓名不能为空',2);
                    $("input[name='truename_']").focus();
                    return false;
                }
                if(mobile_ == ""){
                    toastAlert('联系方式不能为空',2);
                    $("input[name='mobile_']").focus();
                    return false;
                }
                if(hotel_ == ""){
                    toastAlert('酒店名不能为空',2);
                    $("input[name='hotel_']").focus();
                    return false;
                }
                if(position_ == ""){
                    toastAlert('职位不能为空',2);
                    $("input[name='position_']").focus();
                    return false;
                }
                if($("#edit_hotel_type").val() == 1 && $("#editHotelId").val() == 0){
                    toastAlert('酒店选择不能为空',2);
                    $("#editHotelId").focus();
                    return false;
                }

                $(this).html("提交中");
                $(".loaders").removeClass('edit-loader');



                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checkedituser',
                    data:{username:username_,id:id},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){
                            //验证成功,添加数据

                            var editData = $("#editForm").serialize();
                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/updateuser',
                                data:editData,
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
                                            window.location.href = '/admin/administrator/usermanager';
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


            //bind验证
            $("#bindRoleBtn").click(function(){
                if($("#selectBox_").val() == '0'){
                    toastAlert('未绑定角色,无法提交',2);
                    return false;
                }

                $("#roleInput").val($("#selectBox_").val());

                var bindInfo = $("#bindForm").serialize();
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/bindingrole',
                    data:bindInfo,
                    dataType: 'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){

                            toastAlert('绑定成功',1);
                            function jumLogin(){
                                window.location.href = '/admin/administrator/usermanager';
                            }
                            setTimeout(jumLogin,2000);

                        }else{
                            toastAlert('角色已经绑定',2);
                            return false;
                        }
                    }
                });


            });
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
