@extends('Admin.MarkingSystem.layout')


@section('content')

    <div>
        <h2 style="text-align: center">酒店评估列表</h2>

        <table class="ui table group marking-table" >
            <thead>
            <tr>
                <th>酒店名称</th>

                <th >评估员</th>
                <th >详情</th>

                <th>对比</th>
            </tr>
            </thead>
            <tbody>
            @foreach( $recordList as $record)
                <tr>
                    <td  class="s-des">{{ $record->name }}</td>

                    <td> {{ $record->evaluator }} </td>
                    <td> <a href="/admin/markingSystem/checkEvaluate/{{$record->id}}" style="display: inline-block"><div class="regular-btn red-btn auto-margin " >查看详情</div></a>
                        <a href="/admin/markingSystem/exportExcel/{{$record->id}}" style="display: inline-block"><div class="regular-btn blue-btn auto-margin" id="exportExcel">导出excel</div></a></td>
                    <td><input class="compare-evl" type="checkbox" data-field="{{$record->id}}"></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <div class="regular-btn red-btn f-right " id="compare" >对比结果</div>
    </div>
@stop

@section('script')

    <script type="text/javascript">
        $(document).ready(function() {

            $('.compare-evl').click(function(){


                var count = 0;
                $('.compare-evl').each(function(){

                    if($(this).prop('checked') == true)
                    {
                        count++;
                    }

                })


                if(count >= 4)
                    return false;

            })


            $('#compare').click(function(){


                var comparedEvl ='';
                $('.compare-evl').each(function() {

                    var choose = $(this);

                    if(choose.prop('checked') == true)
                    {
                        comparedEvl +=  choose.attr('data-field')+' ';
                    }
                })


                    location.href= '/admin/markingSystem/compare/'+comparedEvl;
            })

        });


    </script>
@stop