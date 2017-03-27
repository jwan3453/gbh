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
            </tr>
            </thead>
            <tbody>
            @foreach( $recordList as $record)
                <tr>
                    <td  class="s-des">{{ $record->name }}</td>

                    <td> {{ $record->evaluator }} </td>
                    <td> <a href="/admin/markingSystem/checkEvaluate/{{$record->id}}" style="display: inline-block"><div class="regular-btn red-btn auto-margin " >查看详情</div></a>
                        <a href="/admin/markingSystem/exportExcel/{{$record->id}}" style="display: inline-block"><div class="regular-btn blue-btn auto-margin" id="exportExcel">导出excel</div></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@stop

