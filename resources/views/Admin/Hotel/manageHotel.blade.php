@extends('Admin.site')


@section('resources')


    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dimmer.css') }}>
    <script src={{ asset('semantic/dimmer.js') }}></script>

@stop


@section('content')
    @include('admin.partial.breadcrumbTrail')
    <div class="h-content">
        <div class="hotel-search-bar" >
            <div class="add-hotel-btn f-left" onclick="location.href='/admin/manageHotel/create'">
               <i class="icon plus "></i> 添加酒店
            </div>
            <input type="text"  placeholder="请输入你想搜索的酒店"/>
            <i class="icon search "></i>
        </div>

        {{--<div class="hotel-list-header">--}}
            {{--<div class="select-all f-left">--}}
                {{--<label><input type="checkbox" onclick="checkAll(this)" />全选</label>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left" onclick="selectUpOrDown('up')">--}}

                {{--<img src = '/Admin/img/上架.png'/>--}}
                {{--<span>批量上架</span>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left" onclick="selectUpOrDown('down')">--}}

                {{--<img src = '/Admin/img/下架.png'/>--}}
                {{--<span>批量下架</span>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left">--}}

                {{--<img src = '/Admin/img/垃圾桶.png'/>--}}
                {{--<span>批量删除</span>--}}
            {{--</div>--}}
        {{--</div>--}}

        <table class="hotel-table ui table primary striped selectable   " id="orderTable" style="margin:0 auto;">

            <thead>
               <tr>
                    <th>酒店图片</th>
                   <th>酒店名称</th>
                   <th>酒店地址</th>
                   <th>操作</th>
               </tr>
            </thead>

            <tbody>

            @foreach($manageHotelList as $hotelItem)
            <tr>
                {{--<td class="s-td"><input type="checkbox" value="{{$hotelItem->id}}"></td>--}}
                <td class="m-td"> <img class="hotel-img" src = '{{$hotelItem->firstCoverImage->link}}'></td>
                <td class="m-td">{{$hotelItem->name}}</td>
                <td><i class="icon marker large"></i><span>{{$hotelItem->addressInfo}}</span></td>
                <td class="l-td">

                    {{--<div class="header-option f-left">--}}
                        {{--<a href="/admin/manageHotel/editHotel/{{$hotelitem->id}}">--}}
                            {{--<img src = '/Admin/img/编辑.png'/>--}}
                            {{--<span class="edit">编辑</span>--}}
                        {{--</a>--}}
                    {{--</div>--}}
                    @if($hotelItem->status == 0)
                        <div class="header-option f-left" onclick="itemUpOrDown('up',{{$hotelItem->id}})">
                            <img src = '/Admin/img/上架.png'/>
                            <span>上架</span>
                        </div>
                    @elseif($hotelItem->status == 1)
                        <div class="header-option f-left" onclick="itemUpOrDown('down',{{$hotelItem->id}})">

                            <img src = '/Admin/img/下架.png'/>
                            <span>下架</span>
                        </div>
                    @endif



                    <div class="header-option f-left">
                        <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelItem->id.'/maintainHotelBasicInfo')}}">
                            <img src = '/Admin/img/维护.png'/>
                            <span>信息维护</span>
                        </a>
                    </div>

                    <div class="header-option f-left">
                        <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelItem->id.'/maintainHotelImage')}}">
                            <img src = '/Admin/icon/photos-manage.png'/>
                            <span>图片管理</span>
                        </a>
                    </div>

                    <div class="header-option f-left delete-hotel " data-input="{{$hotelItem->id}}">
                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>删除</span>
                    </div>

                    <div class="header-option f-left stick " data-input="{{$hotelItem->id}}">

                        <span>置顶</span>
                    </div>

                </td>
            </tr>

            @endforeach

        </tbody>
        </table>

        <div class="ui page dimmer confirm-request" id="confirmRequest">

            <h3>是否删除该酒店</h3>
            <div class="confirm-btns">
                <div class="regular-btn blue-btn confirm" id="confirm">
                    确定
                    <div class="ui active inline  small  loader" id="loader"></div>
                </div>
                <div class="regular-btn red-btn cancel" id="cancel">取消</div>
            </div>

        </div>


    </div>
@stop

@section('script')

<script type="text/javascript">
    
    function checkAll(_this) {
        if ($(_this).is(':checked')) {
            $("#orderTable").find(":checkbox").each(function(i){
                $(this).prop("checked",true);
            })
        }else{
            $("#orderTable").find(":checkbox").each(function(i){
                $(this).attr("checked",false);
            })
        }
        
    }

    function selectUpOrDown(type) {
        var selectArr = new Array();
        $("#orderTable").find(":checkbox").each(function(i){
            if($(this).is(':checked'))
            {
                selectArr.push($(this).val());
            }
        })

        $.ajax({
            type: 'POST',
            url: '/admin/manageHotel/selectUpOrDown',
            data: {selectArr : selectArr , type : type},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                if (data.statusCode == 1) {
                    alert(data.statusMsg);
                    location.reload();
                }else{
                    alert(data.statusMsg);
                }
            }
        })
    }

    function itemUpOrDown(type,id) {
        $.ajax({
            type: 'POST',
            url: '/admin/manageHotel/itemUpOrDown',
            data: {hotelId : id , type : type},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success:function(data){
                if (data.statusCode == 1) {
                    alert(data.statusMsg);
                    location.reload();
                }else{
                    alert(data.statusMsg);
                }
            }
        })
    }


    $(document).ready(function() {

        //删除酒店
        var hotelId = '';
        var deleteRowItem;
        $('.delete-hotel').click(function () {
            hotelId = $(this).attr('data-input');
            deleteRowItem = $(this).parents('tr');
            $('#confirmRequest').dimmer('show');
        })

        //置顶推荐酒店
        $('.stick').click(function(){
            $.ajax({
                type: 'POST',
                url: '/admin/manageHotel/toTop',
                data: {hotelId:  $(this).attr('data-input')},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    if (data.statusCode === 1) {
                        //成功删除酒店 动态删除列表
                        toastAlert(data.statusMsg, 1);

                    }
                    else {
                        toastAlert(data.statusMsg, 2);
                    }
                    $('#confirmRequest').dimmer('hide');
                }
            })
        })

        //确认删除酒店
        $('#confirm').click(function () {
            $.ajax({
                type: 'POST',
                url: '/admin/manageHotel/deleteHotel',
                data: {hotelId: hotelId},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function (data) {
                    if (data.statusCode === 1) {
                        //成功删除酒店 动态删除列表
                        toastAlert(data.statusMsg, 1);
                        deleteRowItem.remove();
                    }
                    else {
                        toastAlert(data.statusMsg, 2);
                    }
                    $('#confirmRequest').dimmer('hide');
                }
            })

        })
    })

</script>

@stop