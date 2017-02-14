@extends('Admin.site')



@section('content')
    @include('admin.partial.breadcrumbTrail')
    <div class="h-content">

        <div class="article-search-bar">
            <a class="add-article-btn f-left" href="/admin/manageArticle/create">
                <i class="icon plus "></i> 创建新文章
            </a>
            <input type="text"  placeholder="请输入你想搜索的酒店"/>
            <i class="icon search "></i>
        </div>

        {{--<div class="article-list-header">--}}
            {{--<div class="select-all f-left">--}}
                {{--<label><input type="checkbox"/>全选</label>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left">--}}

                {{--<img src = '/Admin/img/上架.png'/>--}}
                {{--<span>批量上架</span>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left">--}}

                {{--<img src = '/Admin/img/下架.png'/>--}}
                {{--<span>批量下架</span>--}}
            {{--</div>--}}

            {{--<div class="header-option f-left">--}}

                {{--<img src = '/Admin/img/垃圾桶.png'/>--}}
                {{--<span>批量删除</span>--}}
            {{--</div>--}}
        {{--</div>--}}
        <table class="ui primary striped selectable table article-table " id="orderTable">
            <thead>
            <tr>
                <th>文章图片</th>
                <th>文章标题</th>
                <th>文章类别</th>
                <th>操作</th>
            </tr>
            </thead>

            <tbody>

            @foreach($articles as $article )
            <tr>
                {{--<td class="s-td"><input type="checkbox"></td>--}}
                <td class="m-td">
                    @if(isset($article->cover_image))
                    <img class="article-img" src = '{{$article->cover_image}}'>
                    @else
                        <img class="article-img" src = '/Admin/img/default-image-gbh.jpg'>
                    @endif
                </td>
                <td class="m-td">{{$article->title}}</td>
                <td><span>{{$article->category_name}}</span></td>
                <td class="l-td">

                @if($article->is_draft == 1)
                    <div class="header-option f-left" onclick="online({{$article->id}})">
                        <img src = '/Admin/img/上架.png'/>
                        <span class="on-line">上线</span>
                    </div>
                @endif

                @if($article->is_draft == 0)
                    <div class="header-option f-left" onclick="offline({{$article->id}})">
                        <img src = '/Admin/img/下架.png'/>
                        <span class="off-line">下线</span>
                    </div>
                @endif

                @if($article->sort == 0)
                    <div class="header-option f-left" onclick="toTop({{$article->id}})">
                        <img src = '/Admin/img/top.png'/>
                        <span class="off-line">置顶</span>
                    </div>
                @else
                    <div class="header-option f-left" onclick="cancelTop({{$article->id}})">
                        <img src = '/Admin/img/toped.png'/>
                        <span class="off-line">取消</span>
                    </div>
                @endif

                    <div class="header-option f-left">
                        <a href="/admin/manageArticle/edit/{{$article->id}}">
                            <img src = '/Admin/img/编辑.png'/>
                            <span class="edit">编辑</span>
                        </a>
                    </div>

                    <div class="header-option f-left" onclick="delArticle({{$article->id}},this)">

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

    function online(id) {
        $.ajax({
            type: 'POST',
            url: '/admin/manageArticle/articleOnline',
            data: {articleId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);

                alert(data.statusMsg);
                    location.reload();
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }


    function offline(id) {
        $.ajax({
            type: 'POST',
            url: '/admin/manageArticle/articleOffline',
            data: {articleId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);

                alert(data.statusMsg);
                location.reload();
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }

    function delArticle(id,_this) {
        if (confirm("确定删除  ? ")) {
            $.ajax({
                type: 'POST',
                url: '/admin/manageArticle/delArticle',
                data: {articleId : id},
                dataType: 'json',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                },
                success: function(data){
                    if (data.statusCode == 0) {
                        alert('删除失败');
                    }else{
                        $(_this).parent().parent().remove();
                        alert("删除成功");
                    }
                },
                error: function(xhr, type){
                    alert('Ajax error!')
                }
            });
        }
    }

    function toTop(id) {
        $.ajax({
            type: 'POST',
            url: '/admin/manageArticle/articleToTop',
            data: {articleId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);

                alert(data.statusMsg);
                location.reload();
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }

    function cancelTop(id) {
        $.ajax({
            type: 'POST',
            url: '/admin/manageArticle/articleCancelTop',
            data: {articleId : id},
            dataType: 'json',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            },
            success: function(data){
                console.log(data);

                alert(data.statusMsg);
                location.reload();
            },
            error: function(xhr, type){
                alert('Ajax error!')
            }
        });
    }

</script>
@stop