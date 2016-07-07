@extends('Admin.site')



@section('content')

    <div>
    <div class="hotel-search-bar">
        <div class="add-hotel-btn f-left" onclick="location.href='/admin/manageHotel/create'">
           <i class="icon plus "></i> 添加酒店
        </div>
        <input type="text"  placeholder="请输入你想搜索的酒店"/>
        <i class="icon search "></i>
    </div>

    <div class="hotel-list-header">
        <div class="select-all f-left">
            <label><input type="checkbox" onclick="checkAll(this)" />全选</label>
        </div>

        <div class="header-option f-left" onclick="selectUpOrDown('up')">

            <img src = '/Admin/img/上架.png'/>
            <span>批量上架</span>
        </div>

        <div class="header-option f-left" onclick="selectUpOrDown('down')">

            <img src = '/Admin/img/下架.png'/>
            <span>批量下架</span>
        </div>

        <div class="header-option f-left">

            <img src = '/Admin/img/垃圾桶.png'/>
            <span>批量删除</span>
        </div>
    </div>
    <table class="ui primary striped selectable table hotel-table " id="orderTable">


        <tbody>

            @foreach($manageHotelList as $hotelitem)
            <tr>
                <td class="s-td"><input type="checkbox" value="{{$hotelitem->id}}"></td>
                <td class="m-td"> <img class="hotel-img" src = '../GbhMobile/img/tu2.png'></td>
                <td class="m-td">{{$hotelitem->hotel_name}}</td>
                <td><i class="icon marker large"></i><span>{{$hotelitem->addressInfo}}</span></td>
                <td class="l-td">

                    <div class="header-option f-left">
                        <a href="/admin/manageHotel/editHotel/{{$hotelitem->id}}">
                            <img src = '/Admin/img/编辑.png'/>
                            <span class="edit">编辑</span>
                        </a>
                    </div>
                    @if($hotelitem->status == 0)
                        <div class="header-option f-left" onclick="itemUpOrDown('up',{{$hotelitem->id}})">
                            <img src = '/Admin/img/上架.png'/>
                            <span>上架</span>
                        </div>
                    @elseif($hotelitem->status == 1)
                        <div class="header-option f-left" onclick="itemUpOrDown('down',{{$hotelitem->id}})">

                            <img src = '/Admin/img/下架.png'/>
                            <span>下架</span>
                        </div>
                    @endif

                    <div class="header-option f-left">
                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>删除</span>
                    </div>

                    <div class="header-option f-left">
                        <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelitem->id.'/manageRoom')}}">
                            <img src = '/Admin/img/维护.png'/>
                            <span>信息维护</span>
                        </a>
                    </div>

                    <div class="header-option f-left">
                        <a href="{{url('admin/manageHotel/hotelInfo/'.$hotelitem->id.'/manageHotelImage')}}">
                            <img src = '/Admin/icon/photos-manage.png'/>
                            <span>图片管理</span>
                        </a>
                    </div>

                </td>
            </tr>

            @endforeach

        </tbody>
    </table>

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

</script>

@stop