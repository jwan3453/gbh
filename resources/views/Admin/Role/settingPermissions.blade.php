@extends('Admin.site')

@section('resources')

@stop


@section('content')

    <div id="containerUser">
        @include('Admin.partial.breadcrumbTrail')
        <div class="role-table" style="margin-top: 20px;">


            <form id="settingForm" class="setting-form">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <input type="hidden" id="detailRoleId" name="detailRoleId" value="{{ $detailRole->id }}">
                {{--<li id="{{ $detailRole->id }}" class="get-id"></li>--}}
                    <div id="rolesBlock" >
                        <span style="vertical-align: middle;display: inline-block;width:40px;">角色:</span><input readonly type="text" value="{{ $detailRole->display_name }}">
                        <span style="margin-left: 20px;vertical-align: middle;display:inline-block;width:40px;">描述:</span><input readonly type="text" value="{{ $detailRole->description }}" style="width: 200px;">
                        {{--<p><a class="back-manager" href="{{ url('/admin/administrator/permissionassignment') }}">返回</a></p>--}}
                    </div>
                    <div id="permBlock" style="display: none;">
                        <div id="selectListBox">
                            {{--<p style="font-size: 12px;">当前权限</p>--}}
                            <div >
                                @foreach( $currentPermission as $currentList )
                                    <span data-id="{{$currentList->id}}"><i class="icon remove remove-select" onclick="removeAlready({{ $currentList->id }})"></i>{{$currentList->display_name}}</span>
                                    <div style="display: none;" data-value="{{$currentList->id}}" id="currentPermIds"></div>
                                @endforeach
                                <input type="hidden" id="selectPerList" name="selectPerList"/>
                            </div>
                        </div>
                    </div>
                    <div >
                        <table class="ui table group setting-prems">
                            {{--<div id="authorityList" >--}}
                            <thead>
                                <tr >
                                    <th >添加权限(多选)</th>
                                    <th >功能列表</th>
                                    <th >描述</th>
                                </tr>
                            </thead>
                                @foreach($permissions as $permissionList)
                                    <tr>
                                        <td style="border-right: 1px solid #ccc;width: 180px;" class="checkAllBox">
                                            <div class="checkBoxStyle">
                                                <input style="opacity: 0; cursor: pointer;" class="selectPermList selectPermList{{$permissionList->id}}" type="checkbox" name="selectPermList" id="{{$permissionList->id}}" value="{{$permissionList->id}}">
                                                <label for="{{$permissionList->id}}" ><span>{{$permissionList->display_name}}</span></label>
                                            </div>
                                        </td>
                                        <td style="border-right: 1px solid #ccc;width: 450px; float: left" class="selectPermList_ selectPermList_{{$permissionList->id}}" data-id="{{$permissionList->id}}">
                                            <div style="margin-top: -10px;" class="checkBoxStyle_">
                                                <ul>
                                        @if(count($permissionList->secondPerm) > 0)
                                            @foreach($permissionList->secondPerm as $key => $secondPermList)
                                                <li>
                                                    <div class="checkBoxStyle" style=" margin-left: 0px;margin-top: 10px; float: left;">
                                                    <input style="opacity: 0; cursor: pointer;" type="checkbox" class="permList_ permList_{{$permissionList->id}}" data-id="{{$permissionList->id}}" name="permList_" id="{{$secondPermList->id}}" value="{{$secondPermList->id}}">
                                                    <label for="{{$secondPermList->id}}"><span style="margin-top: -1px;">{{$secondPermList->display_name}}</span></label>
                                                    </div>
                                                </li>
                                            @endforeach
                                        @endif
                                                </ul>
                                            </div>
                                        </td>
                                        <td>
                                            {{$permissionList->description}}
                                        </td>
                                    </tr>
                                @endforeach
                            {{--</div>--}}
                        </table>

                    </div>
                    <div id="lastBtnBlock">
                        <div id="selectListBtn" onclick="subSelectPerms()">保存</div>
                    </div>


            </form>
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

        $(function(){
            $(".selectPermList").click(function(){
                if(this.checked){
                    $(this).parents().parents().siblings(".selectPermList_").find("input[name='permList_']").each(function(){this.checked=true;});

                }else{
                    $(this).parents().parents().siblings(".selectPermList_").find("input[name='permList_']").each(function(){this.checked=false;});
                }
            });

            $("input[name='permList_']").click(function(){

                var temp_id  =  $(this).attr('data-id');
                var list     =  document.getElementsByClassName('permList_'+temp_id).length;
                if(list  ==  $(".selectPermList_"+temp_id).find("input[name='permList_']:checked").length ){
                    $(".selectPermList"+temp_id).prop("checked",true);
                }else{
                    $(".selectPermList"+temp_id).prop("checked",false);
                }

                if($(".selectPermList_"+temp_id).find("input[name='permList_']:checked").length > 0){
                    $(".selectPermList"+temp_id).prop("checked",true);
                }

            });

        });


        //已有权限
        function checkHasPerms(){


            $("#selectListBox span").each(function(){

                var obj = $(this);
                $(".selectPermList").each(function(){
                    if(obj.attr('data-id') == $(this).attr('id')){
                        $(this).prop("checked",true);
                    }
                });

                $(".permList_").each(function(){

                    if(obj.attr('data-id') == $(this).attr('id')){
                        $(this).prop("checked",true);
                    }

                    var id = $(this).attr('data-id');
                    if($(".selectPermList_"+id).find("input[name='permList_']:checked").length > 0){
                        $(".selectPermList"+id).prop("checked",true);
                    }
//                    var list  =  document.getElementsByClassName('permList_'+id).length;
//                    if(list  ==  $(".selectPermList_"+id).find("input[name='permList_']:checked").length ){
//                        $(".selectPermList"+id).prop("checked",true);
//                    }else{
//                        $(".selectPermList"+id).prop("checked",false);
//                    }

                });

            });

        }
        checkHasPerms();

        function subSelectPerms(){

            this.disabled = true;
            var check_id = document.getElementsByName("selectPermList");
            var per_id = "";
            for( var i=0; i < check_id.length; i ++){
                if( check_id[i].checked){
                    per_id += check_id[i].value + ',';
                }
            }

            var second_id = document.getElementsByName('permList_');
            for(var j=0; j < second_id.length; j++){
                if(second_id[j].checked){
                    per_id += second_id[j].value + ',';
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