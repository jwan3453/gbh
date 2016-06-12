<input type="hidden" name="_token" value="{{csrf_token()}}">
<input type="hidden" name="coverImage" id="coverImage" value="{{$article->page_image}}">
<input type="hidden" id="article_content" value="{{ $article->content_raw }}">


{{--<div class="alert alert-danger content-empty" role="alert">文章内容不能为空</div>--}}
<script type="text/plain" id="editor" style="width:1000px;height:400px;">

</script>

<div class="article-input-field">
    <label>标题:</label>
    <input type="text" class="long-input" name="title" id="title" value={{ $article->title }}>
    <span class="article-error">标题不能为空</span>
</div>


<div class="article-input-field">
    <label>分类:</label>
    <select class=" ui dropdown article-cate">
        <option value="1">精品酒店</option>
        <option value="2">精品民宿</option>
        <option value="3">杂志</option>
        <option value="4">视频</option>
    </select>
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
        $('.ui.dropdown')
                .dropdown()
        ;

        //设置封面图片
        if($('#coverImage').val() !== '')
        {
            $('#uploadImageShow').find('img').attr('src', $.trim($('#coverImage').val()));

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
        $('#submitPost').click(function()
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
            if(post === true)
            {
                $('#articleForm').submit();
            }else{
                return false;
            }

        })

    </script>
@stop