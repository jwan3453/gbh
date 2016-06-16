<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="coverImage" id="coverImage" value="{{$article->cover_image}}">
<input type="hidden" id="article_content" value="{{ $article->content_raw }}">


{{--<div class="alert alert-danger content-empty" role="alert">文章内容不能为空</div>--}}
<script type="text/plain" id="editor" style="width:1000px;height:400px;">

</script>



<div class="article-input-field">
    <label>分类:</label>
    <select class=" ui dropdown article-cate">
        @foreach(  $articleCategories as $articleCategory )

            <option value="{{$articleCategory->id}}">{{$articleCategory->category_name}}</option>

        @endforeach
    </select>
    <input type="hidden" name="selectedCate" id="selectedCate" value="1">
</div>

<div class="article-input-field">
    <label>标题:</label>
    <input type="text" class="long-input" name="title" id="title" value={{ $article->title }}>
    <span class="article-error">标题不能为空</span>
</div>


<div class="article-input-field">
    <label>描述:</label>
    <textarea   class="long-input" name="brief" id="brief" value={{ $article->title }}>{{ $article->title }}</textarea>
    <span class="article-error">标题不能为空</span>
</div>

<div class="article-input-field">
    <label>标签:</label>
        <input type="text" class="long-input" placeholder="标签之间用逗号隔开" name="tags"/>
</div>


@section('script')
    <script type="text/javascript">
        //实例化编辑器
        var ue = UE.getEditor('editor');
        var content =$('#article_content').val();


        var lang = ue.getOpt('lang');


        //设置form token, 跟新文章时设置内容
        ue.addListener("ready", function () {
            ue.execCommand('serverparam','_token','{{csrf_token()}}');
            ue.setContent(content);
        })

        //文章分类下拉菜单
        $(' .article-cate').dropdown({
            onChange: function(value, text, $selectedItem) {
                $('#selectedCate').val(value);
            }
        })

        //设置默认选中
        $(' .article-cate option:first').attr("selected", 'selected');
        $('#selectedCate').val($(' .article-cate option:selected').val());


        //设置封面图片
        if($('#coverImage').val() !== '')
        {
            $('#uploadImageShow').removeClass('upload-article-image').addClass('upload-article-image-show').find('img').attr('src', $.trim($('#coverImage').val()));

        }

        $('#uploadImageShow').click(function(){
            $('#uploadImage').click();
        })

        $('#uploadImage').change(function (){

            //用ajax 上传封面图片
            $('#uploadForm').ajaxSubmit({
                dataType:  'json', //数据格式为json
                beforeSend: function() { //开始上传

                },
                uploadProgress: function() {

                },
                success: function(data) { //成功

                    if(data.status === 0)
                    {

                        $('#uploadImageShow').removeClass('upload-article-image').addClass('upload-article-image-show').find('img').attr('src',data.img);
                        $('#coverImage').val(data.img);
                        $('#coverImageFilePath').val(data.imgFilePath);

                    }
                },
                error:function(xhr){ //上传失败

                }
            });


        });

        //上传文章
        $('#submitArticle').click(function()
        {

            var post= true;
            if(!ue.hasContents())
            {

                $('html, body').animate({scrollTop:0}, 'slow');
                $('.content-empty').fadeIn(2000).fadeToggle();
                post =false;
            }

            if($('#title').val() ==='')
            {
                $('#title').siblings('.article-error').fadeIn();
                post=false;
            }

            if($('#coverImage').val() ==='')
            {
                $('#uploadForm').find('.article-error').fadeIn();
                post=false;
            }
            else{
                $('#uploadForm').find('.article-error').fadeOut();
            }
            if(post === true)
            {
                $('#articleForm').submit();
            }else{
                return false;
            }

        })

    </script>
@stop