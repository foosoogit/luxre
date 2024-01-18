<div class="container text-center">
    <script src="{{  asset('/js/YearlyReport.js') }}" defer></script>
	<div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 justify-content-center align-middle">
                @include('layouts.header')
                {{--
                <div class="row">
                    <div class="col-auto">
                        <a class="btn mb-2 btn-primary" href="{{route('admin.top')}}">メニューに戻る</a>
                    </div>
                    @if(isset($target_historyBack_inf_array[1]))
                    @if($target_historyBack_inf_array[1]!=='admin.top')
                        <div class="col-auto">
                            <form method="POST" action="{{route($target_historyBack_inf_array[1])}}">@csrf
                                @if(isset( $target_day ))
                                    <input name="target_day" type="hidden" value="{{$target_day}}"/>
                                    <button type="submit" name="target_date" class="btn btn-primary" value="{{$target_day}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                                @endif
                                @if(isset( $today ))
                                    <input name="year_month_day" type="hidden" value="{{$today}}"/>
                                    <button type="submit" name="target_date" class="btn btn-primary" value="{{$today}}">{{$target_historyBack_inf_array[0]}}に戻る</button>
                                @endif
                                <input name="back_flg" type="hidden" value="true"/>
                            </form>
                        </div>
                    @endif
                    @endif
                </div>
                --}}
                <div class="mb-2 bg-info text-white">契約金額集計</div>
                <div class="row justify-content-center">
                    <div class="col-md-12">
        				<table class="table-auto" border-solid>
		        			<tr>
                                <td class="border px-4 py-2">&nbsp;</td>
                                <td colspan="9" class="border px-4 py-2">{{$target_year_array[0]}}年度</td>
                                <td colspan="3" class="border px-4 py-2">{{$target_year_array[1]}}年度</td>
                                <td colspan="3" class="border px-4 py-2">{{$target_year_array[2]}}年度</td>
                            </tr>
                            {!! $yearly_report_table !!}
                        </table>
                    </div>
                </div>
			</div>
		</div>
	</div>
</div>
