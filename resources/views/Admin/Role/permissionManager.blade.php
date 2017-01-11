@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('admin.partial.breadcrumbTrail')
        <div class="container-action" style="margin-top: 60px;margin-bottom: 20px;">
            {{--<p>当前用户总数:{{ $countRes }}</p>--}}
            <button class="standard modal">添加权限</button>
        </div>
        <div class="user-table" >
            <table class="ui table">
                <thead>
                <tr>
                    <th>权限</th>
                    <th>描述</th>
                    <th>操作</th>
                </tr>
                </thead>
                <tbody>
                @foreach( $permissionRes as $permissionList)
                    <tr>
                        <td id="{{ $permissionList->id }}" class="get-id"></td>
                        <td>{{ $permissionList->display_name }}</td>
                        <td>{{ $permissionList->description }}</td>
                        <td>
                            <ul>
                                <li id="editBtn_" onclick="editPermission({{ $permissionList->id }})"><i class="edit icon"></i>修改</li>
                                <li id="removeBtn" onclick="removePermission({{ $permissionList->id }})"><i class="remove circle outline icon"></i>删除</li>
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
            添加新权限
        </div>
        <div class="contents">
            <div class="form-group-box">
                <form id="addGroupForms">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <ul>
                        <li>
                            <div><span>权限:</span><input type="text" name="permissionName" placeholder="请输入权限名"></div>
                        </li>
                        <li>
                            <div><span>描述:</span><textarea id="descriptions" name="description" placeholder="描述内容"></textarea></div>
                        </li>
                    </ul>
                    <div id="addUserGroup">
                        <div class="add-group-btn" style="margin-left: 15px;"><div id="addPermissionBtn">确认添加</div><div class="ui active inline loader loader_"></div></div>
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
                    <input type="hidden" name="permissionId" id="permissionId">
                    <ul>
                        <li>
                            <div><span>权限:</span><input type="text" id="permissionName_" name="permissionName_" placeholder="请输入权限名"></div>
                        </li>
                        <li>
                            <div><span>描述:</span><textarea id="description_" name="description_" placeholder="描述内容" style="margin-left: 20px;"></textarea></div>
                        </li>
                    </ul>
                    <div id="editUserGroup">
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
                    if(data){

                        $("#permissionId").val(data.extra.id);
                        $("#permissionName_").val(data.extra.display_name);
                        $("#description_").val(data.extra.description);

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


        $(function(){


            //新增用户弹窗层
            $(".standard.modal").click(function(){
                $('.ui.modal.add').modal('show');
            });

            //add提交
            $("#addPermissionBtn").click(function(){

                var permissionName = $("input[name='permissionName']").val();
                var description = $("#descriptions").val();


                if(permissionName == ""){
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

                //验证用户名是否重复
                $.ajax({
                    type:'POST',
                    async:false,
                    url:'/admin/administrator/checknewpermissions',
                    data:{permissionName:permissionName},
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
                                data:{permissionName:permissionName,description:description},
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
                var description = $("#description_").val();
                var id = $("#permissionId").val();


                if(permissionName == ""){
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
                                data:{permissionName:permissionName,description:description,id:id},
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