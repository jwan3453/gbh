@extends('Admin.site')



@section('content')

    <div>
        <div class="article-search-bar">
            <a class="add-article-btn f-left" href="/admin/manageArticle/create">
                <i class="icon plus "></i> 创建新文章
            </a>
            <input type="text"  placeholder="请输入你想搜索的酒店"/>
            <i class="icon search "></i>
        </div>

        <div class="article-list-header">
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
        <table class="ui primary striped selectable table article-table " id="orderTable">


            <tbody>

            @foreach($articles as $article )
            <tr>
                <td class="s-td"><input type="checkbox"></td>
                <td class="m-td"> <img class="article-img" src = '{{$article->cover_image}}'></td>
                <td class="m-td">{{$article->title}}</td>
                <td><span>{{$article->category_name}}</span></td>
                <td class="l-td">

                    <div class="header-option f-left">

                        <img src = '/Admin/img/上架.png'/>
                        <span class="on-line">上线</span>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/下架.png'/>
                        <span class="off-line">下线</span>
                    </div>

                    <div class="header-option f-left">

                        <a href="/admin/manageArticle/edit/{{$article->id}}">
                            <img src = '/Admin/img/编辑.png'/>
                            <span class="edit">编辑</span>
                        </a>
                    </div>

                    <div class="header-option f-left">

                        <img src = '/Admin/img/垃圾桶.png'/>
                        <span class="delete">删除</span>
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

            $()

        </script>
@stop