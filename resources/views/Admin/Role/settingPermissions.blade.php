@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('admin.partial.breadcrumbTrail')
        <div class="role-table" style="margin-top: 100px;">
            <ul style="margin-top: 40px;">
                <form id="settingForm">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="detailRoleId" name="detailRoleId" value="{{ $detailRole->id }}">
                {{--<li id="{{ $detailRole->id }}" class="get-id"></li>--}}
                    <li id="rolesBlock" style="vertical-align: middle;">
                        <span style="vertical-align: middle;display: inline-block;width:62px;">角色</span><input readonly type="text" value="{{ $detailRole->display_name }}">
                        <span style="margin-left: 20px;vertical-align: middle;">描述</span><input readonly type="text" value="{{ $detailRole->description }}" style="width: 200px;">
                        <p><a class="back-manager" href="{{ url('/admin/administrator/permissionassignment') }}">返回</a></p>
                    </li>
                    <li id="permBlock">
                        <div id="selectListBox">
                            <p style="font-size: 12px;">当前权限</p>
                            <div>
                                @foreach( $currentPermission as $currentList )
                                    <span data-id="{{$currentList->id}}"><i class="icon remove remove-select" onclick="removeAlready({{ $currentList->id }})"></i>{{$currentList->display_name}}</span>
                                    <div style="display: none;" data-value="{{$currentList->id}}" id="currentPermIds"></div>
                                @endforeach
                                <input type="hidden" id="selectPerList" name="selectPerList"/>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="user-table" style="margin-top: -8px;margin-left: -3px;">
                        <table class="ui table group setting-prems">
                            <div id="authorityList" >
                                <p style="font-size: 12px;margin-left: 2px;">权限列表</p>
                                <tr style="background: #414D5B; color:#fff; border-top-left-radius: 10px;border-top-right-radius: 10px;">
                                    <td style="padding: 0px;"><p class="add-roles">添加权限(多选)</p></td>
                                    <td style="padding: 0px;">权限名</td>
                                    <td style="padding: 0px;">描述</td>
                                </tr>
                                @foreach($permissions as $permissionsList)
                                    <tr>
                                        <td>
                                            <div id="checkBoxStyle">
                                                <input style="opacity: 0;" type="checkbox" name="selectPermList" id="{{$permissionsList->permission_id}}" value="{{$permissionsList->permission_id}}" onclick="checkHasPerms({{$permissionsList->permission_id}})" style="cursor: pointer;">
                                                <label for="{{$permissionsList->permission_id}}"></label>
                                            </div>
                                        </td>
                                        <td><span data-id="{{$permissionsList->permission_id}}">{{$permissionsList->menu_name}}</span></td>
                                        <td>{{$permissionsList->description}}</td>
                                    </tr>
                                @endforeach
                            </div>
                        </table>
                        </div>
                    </li>
                    <li id="lastBtnBlock">
                        <div id="selectListBtn" onclick="subSelectPerms()">确认添加</div>
                    </li>
                </form>
            </ul>
        </div>
    </div>

    {{--alert弹窗层--}}
    <div class="ui small modal">
        <div class="content">
            <p>确认要移除已经存在的权限吗?</p>
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

        function checkHasPerms(id){
            $("#selectListBox span").each(function(){
                if($(this).attr('data-id') == id){
                    toastAlert("权限已有",2);
                    $("#"+id).prop("checked",false);
                    return false;
                }
            });
        }

        function subSelectPerms(){

            this.disabled = true;
            var check_id = document.getElementsByName("selectPermList");
            var per_id = "";
            for( var i=0; i < check_id.length; i ++){
                if( check_id[i].checked){
                    per_id += check_id[i].value + ',';
                }
            }
            $("#selectPerList").val(per_id);

            if(per_id == ""){
                toastAlert('权限为空,提交无效',2);
                return false;
            }

            var settingForm = $("#settingForm").serialize();
            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/settingpermission',
                data:settingForm,
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data.statusCode == 1){
                        toastAlert("权限绑定成功",1)
                        function jumLogin(){
                            window.location.reload();
                        }
                        setTimeout(jumLogin,1000);
                    }else{
                        toastAlert("权限已有",2)
                        return false;
                    }
                }
            });

        }

        var permIds = $("#currentPermId").attr('data-value');

        var detailRoleId = $("#detailRoleId").val();
        function removeAlready(permId){

            $("#permId_").val(permId);
            $("#detailRoleId_").val(detailRoleId);

            $('.small.modal').modal('show');

        }

        function removeSelect(id){

            $("#"+id).remove();

        }

        function doDelete(){

            $.ajax({
                type:'POST',
                async:false,
                url:'/admin/administrator/removealreadyperm',
                data:{roleId:$("#detailRoleId_").val(),permId:$("#permId_").val()},
                dataType:'json',
                headers:{
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success:function(data){
                    if(data.statusCode == 1){
                        toastAlert("删除成功",1);
                        function jumLogin(){
                            window.location.reload();
                        }
                        setTimeout(jumLogin,1000);
                    }else{
                        toastAlert("删除失败",2);
                        return false;
                    }
                }
            });

        }

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