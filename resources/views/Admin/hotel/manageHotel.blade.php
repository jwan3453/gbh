@extends('Admin.site')



@section('content')

    <div class="hotel-search-bar">
        <div class="add-hotel-btn f-left">
           <i class="icon plus "></i> 添加酒店
        </div>
        <input type="text"  placeholder="请输入你想搜索的酒店"/>
        <i class="icon search "></i>
    </div>

    <div class="hotel-list-header">
        <div class="select-all f-left">
            <label><input type="checkbox"/>全选</label>
        </div>

        <div class="header-option f-left">

            <img src = '/Admin/img/上架.png'/>
            <span>批量上架</span>
        </div>

        <div class="header-option f-left">

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
            <tr>
                <td class="s-td"><input type="checkbox"></td>
                <td class="m-td"> <img class="hotel-img" src = '../GbhMobile/img/tu2.png'></td>
                <td class="m-td">厦门市美都酒店</td>
                <td><i class="icon marker large"></i><span>厦门市思明区官邸大厦</span></td>
                <td class="l-td">

                    <div class="header-option f-left">

                        <img src = '/Admin/img/上架.png'/>
                        <span>修改</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/下架.png'/>
                        <span>批量下架</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                </td>
            </tr>
            <tr>
                <td class="s-td"><input type="checkbox"></td>
                <td class="m-td"> <img class="hotel-img" src = '../GbhMobile/img/tu2.png'></td>
                <td class="m-td">厦门市美都酒店</td>
                <td><i class="icon marker large"></i><span>厦门市思明区官邸大厦</span></td>
                <td class="l-td">

                    <div class="header-option f-left">

                        <img src = '/Admin/img/上架.png'/>
                        <span>修改</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/下架.png'/>
                        <span>批量下架</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                </td>
            </tr>

            <tr>
                <td class="s-td"><input type="checkbox"></td>
                <td class="m-td"> <img class="hotel-img" src = '../GbhMobile/img/tu2.png'></td>
                <td class="m-td">厦门市美都酒店</td>
                <td><i class="icon marker large"></i><span>厦门市思明区官邸大厦</span></td>
                <td class="l-td">

                    <div class="header-option f-left">

                        <img src = '/Admin/img/上架.png'/>
                        <span>修改</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/下架.png'/>
                        <span>批量下架</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                </td>
            </tr>

            <tr>
                <td class="s-td"><input type="checkbox"></td>
                <td class="m-td"> <img class="hotel-img" src = '../GbhMobile/img/tu2.png'></td>
                <td class="m-td">厦门市美都酒店</td>
                <td><i class="icon marker large"></i><span>厦门市思明区官邸大厦</span></td>
                <td class="l-td">

                    <div class="header-option f-left">

                        <img src = '/Admin/img/上架.png'/>
                        <span>修改</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/下架.png'/>
                        <span>批量下架</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span>批量删除</span>
                    </div>

                </td>
            </tr>




        </tbody>
    </table>
@stop