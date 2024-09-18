<div class="container text-center">
    <script src="{{  asset('/js/ContractsReport.js') }}" defer></script>
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="row">
                    {{-- 
                    <div class="col-auto">
                        <a class="btn mb-2 btn-primary" href="{{route('admin.top')}}">メニューに戻る</a>
                    </div>
                     --}}
                    {{-- @if(isset($target_historyBack_inf_array[1])) --}}
                        @if(isset($target_historyBack_inf_array[1]) && $target_historyBack_inf_array[2]!=='admin.top')
                            <div class="col-auto">
                                <form method="POST" action="{{route($target_historyBack_inf_array[2])}}">@csrf
                                    @if(isset( $target_day ))
                                        <input name="target_day" type="hidden" value="{{$target_day}}"/>
                                        <button type="submit" name="target_date" class="btn btn-primary" value="{{$target_day}}">{{$target_historyBack_inf_array[1]}}に戻る</button>
                                    @endif
                                    @if(isset( $today ))
                                        <input name="year_month_day" type="hidden" value="{{$today}}"/>
                                        <button type="submit" name="target_date" class="btn btn-primary" value="{{$today}}">{{$target_historyBack_inf_array[1]}}に戻る</button>
                                    @endif
                                    <input name="back_flg" type="hidden" value="true"/>
                                </form>
                            </div>
                        @endif
                    {{-- @endif --}}
				</div>
                <div class="mb-2 bg-success text-white">契約金額集計</div>
				<div class="row justify-content-center">
					<div class="col-md-12">
						<form method="POST" action="/admin/ContractsReport" name="ChangeTargetMonth_fm" id="ChangeTargetMonth_fm">@csrf
							<h3>売上単価・現金比率<select name="year" onchange="ChangeTargetMonth();">{!!$html_year_slct!!}</select> <select name="month" onchange="ChangeTargetMonth();"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></h3>
						</form>契約金額合計：{{ number_format($ruikei_keiyaku_amount) }}円  契約人数合計：{{ $ruikei_contract_cnt }}<br> 目標金額{{ number_format((float) $TargetSales ) }}円  目標達成率{!!$rate!!}%
					</div>
					<div class="card-body">
						{!! $contract_report_table !!}
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
