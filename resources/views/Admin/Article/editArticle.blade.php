@extends('Admin.site')
@include('UEditor::head')


@section('resources')
    <script src="{{ asset('/js/jquery.form.js') }}"></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>
@stop


@section('content')
    @include('admin.partial.breadcrumbTrail')
    <div class="margin">
    </div>

    <div style="background-color: #f8f8f8; padding:10px;" id="editArticle_">
        <form action="{{url('/admin/manageArticle/edit/'.$article->id)}}" method="post" id="articleForm">

            @include('Admin.Article.editorForm')

        </form>

        <div class="article-input-field">
            <form method="POST" action="{{url('/upload/image')}}"  enctype="multipart/form-data" id="uploadForm" >
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="coverImageFilePath" id="coverImageFilePath" value="">

                <div class="upload-article-image" id="uploadImageShow" >
                    <span>上传封面图片</span>
                    <img src=""/>
                </div>
                <span class="article-error" style="padding:10px 0  0 50px ">文章封面不能为空</span>
                <input type="file"  id="uploadImage" name="uploadImage" class="upload-image" multiple/>

            </form>
        </div>


        <div class="article-input-field align-center">
            <div class="article-btn-section">
                <div  class="regular-btn blue-btn auto-margin" id="submitArticle">
                    发布
                </div>
                {{--<div class="regular-btn blue-btn f-left">--}}
                {{--保存为草稿--}}
                {{--</div>--}}
            </div>
        </div>
        <div class="margin">
        </div>

    </div>

    <script>

        $(function(){
            function AdjustEditHeights() {

                $('#menuBox').css('height',4791+60);

            }

            AdjustEditHeights();
        });

    </script>
@stop


