<div class="col-auto">
    <a class="btn mb-2 btn-primary btn-sm" href="{{route('admin.top')}}">メニューに戻る</a>
</div>
{{--@if(isset($target_historyBack_inf_array[1]))--}}
{{$target_historyBack_inf_array[0]}}
{{--$target_historyBack_inf_array[1]--}}
@if(isset($target_historyBack_inf_array) && $target_historyBack_inf_array[0]<>'top')
    @if($target_historyBack_inf_array[0]!=='admin')
        <div class="col-auto">
            @if(isset( $target_day ))
                <form method="POST" action="{{route($target_historyBack_inf_array[2])}}">@csrf
                    <input name="target_day" type="hidden" value="{{$target_day}}"/>
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="{{$target_day}}">{{$target_historyBack_inf_array[1]}}に戻る</button>
                </form>
            @elseif(isset( $today ))
                <form method="POST" action="{{route($target_historyBack_inf_array[2])}}">@csrf
                    <input name="year_month_day" type="hidden" value="{{$today}}"/>
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="{{$today}}">{{$target_historyBack_inf_array[1]}}に戻る</button>
                </form>
            @elseif(isset($target_historyBack_inf_array[1]) && $target_historyBack_inf_array[1]=="契約リスト") 
                {{--<form method="GET" action="{{route($target_historyBack_inf_array[2])}}/{{ $UserSerial }}">@csrf--}}
                <form method="GET" action="{{route($target_historyBack_inf_array[2])}}/{{$target_historyBack_inf_array[4]}}">@csrf
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="">{{$target_historyBack_inf_array[1]}}に戻る</button>
                </form>
            @elseif(isset($target_historyBack_inf_array[2])) 
                <form method="GET" action="{{route($target_historyBack_inf_array[2])}}">@csrf
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="{{$target_historyBack_inf_array[3]}}">{{$target_historyBack_inf_array[1]}}に戻る</button>
                </form>
            @endif
            <input name="back_flg" type="hidden" value="true"/>
        </div>
    @endif
@endif
{{--@endif--}}