

<div class="container-header">
    {{--<i class="marker icon"></i>--}}
    @if(isset($firstMenuName))
    <span><a style="color: #253942;" href="#">{{$firstMenuName->menu_name}}</a></span>
    <i class="angle right icon"></i>
    <span style="padding-left: 0px;"><a style="color: #253942;" href="{{url($getMenuName->menu_chaining)}}">{{$getMenuName->menu_name}}</a></span>
    @elseif(isset($SecondMenuName))
        <span><a style="color: #253942;" href="{{url($getMenuName->menu_chaining)}}">{{$getMenuName->menu_name}}</a></span>
        <i class="angle right icon"></i>
        <span style="padding-left: 0px;"><a style="color: #253942;" href="#">{{$SecondMenuName}}</a></span>
    @elseif(!$firstMenuName)
        <i class="angle right icon" style="padding-left: 10px;"></i>
        <span style="padding-left: 10px;"><a style="color: #253942;" href="{{url($getMenuName->menu_chaining)}}">{{$getMenuName->menu_name}}</a></span>
    @endif
    <span style="float: right; padding-right: 20px;cursor: pointer;" onclick="history.go(-1)"><a>返回</a></span>
</div>