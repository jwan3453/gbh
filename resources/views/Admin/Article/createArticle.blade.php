@extends('Admin.site')
@include('UEditor::head')


@section('resources')
    <script src="{{ asset('/js/jquery.form.js') }}"></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/dropdown.css') }}>
    <script src={{ asset('semantic/dropdown.js') }}></script>
@stop


@section('content')

    <div class="margin">
    </div>

    <div style="background-color: #f8f8f8; padding:10px;" >
        <form action="{{url('/admin/manageArticle/store')}}" method="post" id="articleForm">

            @include('admin.Article.editorform')

        </form>

        <div class="article-input-field">
            <form method="POST" action="{{url('/upload/image')}}"  enctype="multipart/form-data" id="uploadForm">
                <input type="hidden" name="_token" value="{{csrf_token()}}">
                <input type="hidden" name="coverImageFilePath" id="coverImageFilePath" value="">
                <div class="upload-article-image" id="uploadImageShow" >
                    <span>上传封面图片</span>
                    <img src=""/>
                </div>
                <input type="file"  id="uploadImage" name="uploadImage" class="upload-image" multiple/>
            </form>
        </div>


        <div class="article-input-field align-center">
            <div class="article-btn-section">
                <div  class="btn-base btn-reg left" id="submitPost">
                    发布
                </div>
                <div class="btn-base btn-reg right">
                    保存为草稿
                </div>
            </div>
        </div>
        <div class="margin">
        </div>

    </div>
@stop