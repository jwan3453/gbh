@extends('Admin.MarkingSystem.layout')


@section('resources')
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/icon.css') }}>
@stop


@section('content')


    <div class="new-section">
        <h3>创建酒店分区</h3>
        <div class="section-list">
            @foreach($sectionList as $section)
                <span><i class="icon remove remove-section small" data-field="{{$section->id}}"></i>{{$section->name}}</span>
            @endforeach
        </div>
        <input class="f-left" name="new-section " id="newSection" type ="text" />
        <div class="regular-btn red-btn f-left " id="createSection">创建分区</div>

    </div>

    <div class="new-marking-items">
        <h3>创建频分项目</h3>

            <label >选择分区</label>
            <select id="selectedSection">
                <option value ="0">选择分区</option>
                @foreach($sectionList as $section)
                    <option value ="{{$section->id}}">{{$section->name}}</option>
                @endforeach
            </select>

            <div style="margin-top:20px; ">
                <label >新评分项目</label>
                <textarea id="newMarkingItems"></textarea>
            </div>

        <div class="regular-btn red-btn f-left " id="createMarkingItem" style="margin:10px 0 0 113px">创建评分项目</div>
    </div>


    <div class="marking-item-list">
        <h3>评分项目列表</h3>
        @foreach($standerList as $section)
            <label> ----------------------------------{{$section->name}} ---------------------------------- </label>
            <div>
                @foreach($section->standards as $standard)
                    <span><i class="icon remove small remove-standard" data-field="{{$standard->id}}" ></i>{{$standard->description}}</span>
                @endforeach
            </div>
        @endforeach

    </div>
@stop

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {
            $('#createSection').click(function(){

                if($('#newSection').val() == '')
                {
                    return;
                }


                $.ajax({

                        type: 'POST',
                        url: '/admin/markingSystem/createMarkingSection',
                        data: {newSection:$('#newSection').val()},
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                        },
                        success: function(data){
                            if(data.statusCode === 1)
                            {
                                //动态删除项目
                                toastAlert(data.statusMsg,1);
                                location.reload();
                            }
                            else{
                                    toastAlert(data.statusMsg,2);
                                }
                            }
                    })
            })


            $('.remove-section').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/admin/markingSystem/deleteMarkingSection',
                    data: {section:$(this).attr('data-field')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            toastAlert(data.statusMsg,1);
                            location.reload();
                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                    }
                })
            })



            $('#createMarkingItem').click(function(){
                if($('#newMarkingItems').val() == '')
                {
                    return;
                }

                if($('#selectedSection').val() == '0')
                {
                    toastAlert('请选择分区',2);
                    return;
                }

                $.ajax({

                    type: 'POST',
                    url: '/admin/markingSystem/createMarkingItems',
                    data: {newMarkingItems:$('#newMarkingItems').val(),section:$('#selectedSection').val()},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            toastAlert(data.statusMsg,1);
                            location.reload();
                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                    }
                })
            })

            $('.remove-standard').click(function(){

                $.ajax({
                    type: 'POST',
                    url: '/admin/markingSystem/deleteMarkingStandard',
                    data: {standard:$(this).attr('data-field')},
                    dataType: 'json',
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    success: function(data){
                        if(data.statusCode === 1)
                        {
                            //动态删除项目
                            toastAlert(data.statusMsg,1);
                            location.reload();
                        }
                        else{
                            toastAlert(data.statusMsg,2);
                        }
                    }
                })
            })



        })

    </script>
@stop