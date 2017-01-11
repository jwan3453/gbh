@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('admin.partial.breadcrumbTrail')
        <div class="container-action" style="margin-top: 60px;margin-bottom: 20px;">
        </div>
        <div class="user-table" >
            <table class="ui table group" style="margin-top: -10px;">
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
                            <ul>
                                {{--<li id="detailBtn" onclick="permissionBind({{ $groupList->group_id }})"><i class="share alternate icon"></i>权限绑定</li>--}}
                                <a style="color: #000;" href="{{ url('/admin/administrator/assignpermissions')}}/{{ $roleList->id }}"><i class="share alternate icon"></i>权限绑定</a>
                            </ul>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
            {{--<div id="pageBox"><div class="pages" style="float: right;">{!! $pageNum->render() !!}</div></div>--}}
        </div>
    </div>


    {{--权限分配--}}

    <div class="ui modal assign group-modal">
        <i class="close icon"></i>
        <div class="header">
            绑定权限
        </div>
        <div class="contents">
            <div class="form-assign-box">
                <form>
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" name="groupId" id="groupId">
                    <ul>
                        <li>
                            <div><span>当前组:</span><input readonly type="text" id="groupname" name="groupname"></div>
                        </li>
                        <li style="margin-top: 20px;">
                            <div id="PermisListItem">
                                <span>权限列表:</span>
                                <div id="permissionsList">
                                    @foreach($firstMenuInfo as $firstMenuList)
                                        <label><input type="checkbox" data-id="{{$firstMenuList->id}}"><span>{{$firstMenuList->menu_name}}</span></label>
                                    @endforeach
                                </div>
                            </div>
                            <div id="currentPermItem">
                                <span>当前权限:</span>
                                <div id="currentPerm"></div>
                            </div>
                        </li>
                    </ul>
                    <div id="assignPerms">
                        <div class="assign-perm-btn"><div>确认修改</div><div class="ui active inline loader loader_"></div></div>
                    </div>

                </form>
            </div>
        </div>
    </div>

@stop

@section('script')

    <script>

        function permissionBind(id){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailgroup',
                data:{group_id:id},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){

                    $("#groupId").val(data.extra.group_id);
                    $("#groupname").val(data.extra.group_name);
                    if(data.statusMsg){
                        var html = '<span data-perm-id="'+data.statusMsg.id+'"><i class="icon remove remove-select" onclick="removeSelect('+data.statusMsg.id+')"></i>'+data.statusMsg.display_name+'</span>';
                        $("#currentPerm").append(html);
                    }

                    $('.ui.modal.group-modal.assign').modal('show');
                },
                error:function(){
                    alert("ajax:error");
                    return false;
                }
            });

        }

        function removeRole(id){
            if(confirm(" 确认删除 ? ")){

                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/removerole',
                    data:{id:id},
                    dataType:'json',
                    headers:{
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success:function(data){

                        if(data.statusCode == 1){
                            toastAlert('删除成功',1);
                            window.location.href = '/admin/administrator/permissionassignment';
                        }else{
                            toastAlert('删除失败',2);
                            return false;
                        }

                    }
                });

            }else{
                toastAlert('取消删除',2);
                return false;
            }

        }

        function assignPermissions(id){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/detailrole',
                data:{id:id},
                dataType: 'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data){

                        $("#roleId").val(data.extra.id);
                        $("#rolenames").val(data.extra.display_name);
                        $("#permissionsList").val(data.statusMsg.display_name);

                        $('.ui.modal.assign').modal('show');


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
            $("#addRoleBtn").click(function(){

                var rolename = $("input[name='rolename']").val();
                var description = $("#description").val();


                if(rolename == ""){
                    toastAlert('用户名不能为空',2);
                    $("input[name='username']").focus();
                    return false;
                }
                if(description == ""){
                    toastAlert('密码不能为空',2);
                    $("input[name='password']").focus();
                    return false;
                }


                $(this).html("提交中");
                $(".loader").removeClass('loader_');

                //验证角色是否重复
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


                            $.ajax({
                                type:'POST',
                                async:false,
                                url:'/admin/administrator/createrole',
                                data:{rolename:rolename,description:description},
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
                                            window.location.href = '/admin/administrator/permissionassignment';
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
                            toastAlert('很抱歉:角色已存在',2);
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
            $("#editRoleBtn").click(function(){


                var rolename_ = $("input[name='rolename_']").val();
                var description_ = $("#description_").val();
                var id = $("#roleId").val();


                if(rolename_ == ""){
                    toastAlert('权限名不能为空',2);
                    $("input[name='username_']").focus();
                    return false;
                }
                if(description_ == ""){
                    toastAlert('描述不能为空',2);
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
                    data:{rolename:rolename_,id:id},
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
                                            window.location.href = '/admin/administrator/permissionassignment';
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
                            toastAlert('很抱歉:角色已存在',2);
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