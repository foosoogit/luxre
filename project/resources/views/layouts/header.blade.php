<div class="col-auto">
    <a class="btn mb-2 btn-primary btn-sm" href="{{route('admin.top')}}">メニューに戻る</a>
</div>
{{--@if(isset($target_historyBack_inf_array[1]))--}}
@if(isset($target_historyBack_inf_array))
    @if($target_historyBack_inf_array[1]!=='admin.top')
        <div class="col-auto">
            <form method="POST" action="{{route($target_historyBack_inf_array[1])}}">@csrf
                @if(isset( $target_day ))
                    <input name="target_day" type="hidden" value="{{$target_day}}"/>
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="{{$target_day}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                @elseif(isset( $today ))
                    <input name="year_month_day" type="hidden" value="{{$today}}"/>
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="{{$today}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                @else
                    <button type="submit" name="target_date" class="btn btn-primary btn-sm" value="">{{$target_historyBack_inf_array[0]}}に戻る</button>
                @endif
                <input name="back_flg" type="hidden" value="true"/>
            </form>
        </div>
    @endif
@endif
{{--@endif--}}