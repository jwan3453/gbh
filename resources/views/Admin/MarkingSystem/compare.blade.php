@extends('Admin.MarkingSystem.layout')


@section('resources')
    <script src={{ asset('js/jquery.form.js') }}></script>
    <link  rel="stylesheet" type="text/css"  href ={{ asset('semantic/loader.css') }}>
@stop

@section('content')

    <?php

    ?>


    <div id="loader" class="ui active centered inline loader large " style="display: none; position: fixed;top:30%;left:calc(50% - 50px)"></div>
    <div>
        <h2 style="text-align: center">酒店运营检查系统</h2>


        {{--<div style="margin:20px 0" >--}}
            {{--<a href="/admin/markingSystem/exportExcel/{{$recordInfo->id}}"><div class="regular-btn blue-btn auto-margin" id="exportExcel">导出excel</div></a>--}}
        {{--</div>--}}


        <input type="hidden" id="status" value="old">
        <div style="display:none">{{$loop = 0}}</div>
        @foreach( $compareResult as $section)
            <div style="display:none">{{$loop++}}</div>

            @if($loop > 1)
                <form style="display: none;" class="section-from section_{{$section->id}}" data-field="{{$section->id}}" enctype="multipart/form-data"  >
                    @else
                        <form   class="section-from section_{{$section->id}}" data-field="{{$section->id}}" enctype="multipart/form-data"  >
                            @endif


                            <div >
                                <div class="regular-btn red-btn  next-item  f-left previous" style="display: inline-block"> 上一区 </div>
                                <div class="regular-btn red-btn  next-item f-right next" style="display: inline-block"> 下一区 </div>
                            </div>


                            <div class="s-name">{{$loop .'. '.$section->name}}</div>

                            <ul class="marking-table" >
                                <li class="head">

                                    <span>项目</span>


                                    @foreach($recordList as $key=> $record)

                                    <span style="text-align: center">{{$record}}</span>

                                        <div style="display: none">{{$evalKey  = 'eval_'.$key}}</div>
                                    @endforeach


                                </li>



                                @foreach( $section->standards as $index=> $standard)
                                    <li>
                                        <div  class="s-des">{{($index+1).'. '. $standard->description }}</div>


                                            @foreach($recordList as $key => $record)
                                            <div class="s-points">

                                                <div style="display: none">{{$evalKey  = 'eval_'.$key}}</div>
                                                <span  style="display:inline-block; width:100%; height:24px" >{{  ($section[$evalKey][$index]->points)}}</span>

                                            </div>
                                            @endforeach



                                    </li>
                                @endforeach


                                <li >

                                    <div>总分</div>


                                    @foreach($recordList as $key => $record)

                                        <div style="display: none">{{$pointsKey  = 'totalPoints_'.$key}}</div>
                                        <div >{{$section[$pointsKey]->total}}</div>

                                    @endforeach


                                </li>

                            </ul>


                            <div>
                                <div class="regular-btn red-btn  next-item  f-left previous" style="display: inline-block"> 上一区 </div>
                                <div class="regular-btn red-btn  next-item f-right next" style="display: inline-block"> 下一区 </div>

                            </div>
                        </form>
                @endforeach





    </div>
@stop


@section('script')

    <script type="text/javascript">
        $(document).ready(function() {





        });




        //获取分区id列表
        var formList = [];
        var initialIndex = 0;
        var initialForm = 0;
        $('.section-from').each(function(){

            formList.push( $(this).attr('data-field'));
        })


        $('.previous').click(function(){

            if(initialIndex === 0)
            {
                toastAlert('没有上一区了',2);
            }
            else{
                initialIndex--;
                initialForm= formList[initialIndex];
                $('.section-from').each(function(){

                    if($(this).hasClass('section_'+initialForm))
                    {
                        $(this).show();
                        //$('#status').val('old');
                        //$(this).find('.s-hotel-name').val($('#hotelName').val());
                        //$(this).find('.s-status').val($('#status').val());
                        //$(this).find('.s-record').val(recordId);

                    }
                    else{
                        $(this).hide();
                    }
                })
            }
            //var form =  $(this).parents('form').prev('form');

            //orm.show();
        })

        $('.next').click(function(){

            if(initialIndex === (formList.length - 1))
            {
                toastAlert('没有下一区了',2);
            }
            else{
                initialIndex++;
                initialForm= formList[initialIndex];
                $('.section-from').each(function(){

                    if($(this).hasClass('section_'+initialForm))
                    {
                        $(this).show();
                        //$('#status').val('old');
                        //$(this).find('.s-hotel-name').val($('#hotelName').val());
                        //$(this).find('.s-status').val($('#status').val());
                        //$(this).find('.s-record').val(recordId);

                    }
                    else{
                        $(this).hide();
                    }
                })
            }

        })

    </script>
@stop