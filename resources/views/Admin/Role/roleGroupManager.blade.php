@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('admin.partial.breadcrumbTrail')
        <div class="container-action" >

            <button class="standard modal">添加角色组</button>
        </div>
        <div class="user-table">
            <table class="ui table user-group">
                <thead>
                <tr>
                    <th>角色组</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $roleRes as $roleList)
                    <tr>
                        <td id="{{ $roleList->id }}" class="get-id"></td>
                        <td>{{ $roleList->display_name }}</td>
                        <td>{{ $roleList->description }}</td>
                        <td>
                            <ul style="width: 300px;">
                                <li id="editBtn_" onclick="editRole({{ $roleList->id }})"><i class="edit icon"></i>修改</li>
                                <li id="removeBtn" onclick="removeRole({{ $roleList->id }})"><i class="remove circle outline icon"></i>删除</li>
                                <li id="detailBtn" onclick="hasUser({{ $roleList->id }})" style="padding-top: 0px;"><i class="share alternate icon"></i>查看包含用户</li>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div id="pageBox"><div class="pages" style="float: right;">{!! $pageNum->render() !!}</div></div>--}}
        </div>
    </div>

    {{--添加模块--}}

    <div class="ui modal add group-modal">
        <i class="close icon"></i>
        <div class="header">
            添加角色组
        </div>
        <div class="contents">
            <div class="form-group-box">
                <form id="addGroupForms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <ul>
                        <li>
                            <div><span>组名:</span><input type="text" name="rolename" placeholder="请输入组名"></div>
                        </li>
                        <li>
                            <div><span>描述:</span><textarea name="description" placeholder="描述内容"></textarea></div>
                        </li>
                    </ul>
                    <div id="addUserGroup">
                        <div class="add-group-btn"><div id="addGroupBtn">确认添加</div><div class="ui active inline loader loader_"></div></div>
                        <input type="reset" value="重置">
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--修改模块--}}

    <div class="ui modal edit group-modal">
        <i class="close icon"></i>
        <div class="header">
            修改
        </div>
        <div class="contents">
            <div class="form-group-box">
                <form id="editGroupForms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="roleIdForEdit" id="roleIdForEdit">
                    <ul>
                        <li>
                            <div><span>组名:</span><input type="text" id="rolename_" name="rolename_" placeholder="请输入组名"></div>
                        </li>
                        <li>
                            <div><span>描述:</span><textarea id="description_" name="description_" placeholder="描述内容" style="margin-left: 20px;"></textarea></div>
                        </li>
                    </ul>
                    <div id="editUserGroup">
                        <div class="edit-group-btn"><div id="editGroupBtn">确认修改</div><div class="ui active inline loader loader_"></div></div>
                        <input type="reset" value="重置">
                    </div>

                </form>
            </div>
        </div>
    </div>

    {{--获取绑定用户信息--}}

    <div class="ui modal detail binding">
        <i class="close icon"></i>
        <div class="header">
            绑定用户
        </div>
        <div class="contents">
            <div class="form-binding-box">
                <form id="detailGroupForms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="roleIdInfo" id="roleIdInfo">
                    <ul>
                        <li>
                            <div><span>角色名:</span><input readonly type="text" id="role-name" name="role-name" style=";height: 30px"></div>
                        </li>
                        <li>
                            <div><span>绑定用户 :</span><textarea readonly id="bindUserList" style=""></textarea></div>
                        </li>

                    </ul>
                </form>
            </div>
        </div>
    </div>

    {{--alert弹窗层--}}
    <div class="ui small modal">
        <div class="content">
            <p>确认要移除已经存在的角色组吗?</p>
            <input type="hidden" id="permId_" name="permId_">
            <input type="hidden" id="detailRoleId_" name="detailRoleId_">
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

        function editRole(id){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailrole',
                data:{role_id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data){

                        $("#roleIdForEdit").val(data.extra.id);
                        $("#rolename_").val(data.extra.display_name);
                        $("#description_").val(data.extra.description);

                        $('.ui.modal.edit.group-modal').modal('show');


                    }else{
                        toastAlert('error',2);
                        return false;
                    }
                }
            });

        }

        function removeRole(roleId){

            $("#permId_").val(roleId);
            $('.small.modal').modal('show');

        }

        function doDelete(){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/removerole',
                data:{roleId:$("#permId_").val()},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    if(data.statusCode == 1){
                        toastAlert('删除成功',1);
                        window.location.href = '/admin/administrator/rolegroupmanager';
                    }else{
                        toastAlert('删除失败',2);
                        return false;
                    }

                }
            });
        }

        //获取绑定用户信息
        function hasUser(id){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailhasuser',
                data:{role_id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data.extra){

                        var userList  = data.extra.split(",");
                        userList = String(userList);
                        userList = userList.substring(0,userList.length-1);

                        $("#role-name").val(data.statusMsg.display_name);
                        $("#bindUserList").val(userList);
                        $('.ui.modal.detail.binding').modal('show');


                    }else{
                        toastAlert('该组未绑定角色',2);
                        return false;
                    }
                },error:function(){
                    alert('ajax:error');
                    return false;
                }
            });


        }


        $(function(){


            //新增用户弹窗层
            $(".standard.modal").click(function(){
                $('.ui.modal.add').modal('show');
            });

            //add提交
            $("#addGroupBtn").click(function(){

                var rolename = $("input[name='rolename']").val();
                var description = $("input[name='description']").val();


                if(rolename == ""){
                    toastAlert('组名不能为空',2);
                    $("input[name='username']").focus();
                    return false;
                }
                if(description == ""){
                    toastAlert('描述不能为空',2);
                    $("input[name='password']").focus();
                    return false;
                }

                $(this).html("提交中");
//                $(".loader").removeClass('loader_');

                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checknewrole',
                    data:{rolename:rolename},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){
                            //验证成功,添加数据


                            var groupData = $("#addGroupForms").serialize();
                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/creategroup',
                                data:groupData,
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
                                            window.location.href = '/admin/administrator/rolegroupmanager';
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
                            toastAlert('很抱歉:用户组已存在',2);
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
            $("#editGroupBtn").click(function(){

                var id = $("#roleIdForEdit").val();
                var rolename = $("input[name='rolename_']").val();
                var description = $("input[name='description_']").val();


                if(rolename == ""){
                    toastAlert('用户名不能为空',2);
                    $("input[name='username_']").focus();
                    return false;
                }
                if(description == ""){
                    toastAlert('真实姓名不能为空',2);
                    $("input[name='truename_']").focus();
                    return false;
                }

                $(this).html("提交中");
                $(".loaders").removeClass('edit-loader');



                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checkeditrole',
                    data:{rolename:rolename,id:id},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){
                        if(data.statusCode == 0){


                            //验证成功,添加数据
                            var editData = $("#editGroupForms").serialize();
                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/updaterole',
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
                                            window.location.href = '/admin/administrator/rolegroupmanager';
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
                            toastAlert('很抱歉:已有角色组',2);
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