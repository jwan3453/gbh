@extends('Admin.site')



@section('content')

    <div >
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
                    <td class="m-td">{{$hotelitem->name}}</td>
                    <td><i class="icon marker large"></i><span>{{$hotelitem->addressInfo}}</span></td>
                    <td class="l-td">

                        <div class="header-option f-left">
                            <a href="/admin/manageRoomPrice/edit/{{$hotelitem->id}}">
                                <img src = '/Admin/img/编辑.png'/>
                                <span class="edit">管理房态</span>
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
        $(document).ready(function(){


        })
    </script>
@stop