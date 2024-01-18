<div class="container text-center">
	<div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
			<div class="pb-4 justify-content-center align-middle">
                @include('layouts.header')
				<div class="row mb-2">
                    <div class="col-auto">
                        <a class="btn mb-2 btn-primary" href="{{route('admin.top')}}">メニューに戻る</a>
                    </div>
                </div>
                <div class="mb-2 bg-info text-white">月報</div>
					    {{--
                        <form method="GET" action="/customers/ShowInputCustomer">@csrf
						    <p style="text-indent:20px" class="py-1.5">
						        <button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" name="CustomerListCreateBtn" value="CustomerList">新規顧客登録</button>
						    </p>
					    </form>	
                        --}}
				<div class="card-header">
                            {{--<form method="POST" action="/admin/ShowMonthlyReport" name="ChangeTargetMonth_fm" id="ChangeTargetMonth_fm">@csrf--}}
                    <form method="POST" action="{{route('admin.MonthlyReport.post')}}" name="ChangeTargetMonth_fm" id="ChangeTargetMonth_fm">@csrf
                        <h3>売上単価・現金比率<select name="year" onchange="ChangeTargetMonth();">{!!$html_year_slct!!}</select> <select name="month" onchange="ChangeTargetMonth();"><option  value="0" >選択</option>{!!$html_month_slct!!}</select></h3>
                    </form>
				</div>
				<div class="card-body">
					{!! $RaitenReason !!}
					{{--<form method="POST" action="/admin/ShowDailyReport_from_monthly_report">@csrf--}}
                    <form method="POST" action="{{route('admin.DailyReport.post')}}">@csrf
					    {!! $monthly_report_table !!}
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
