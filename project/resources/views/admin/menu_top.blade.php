@extends('layouts.top')
@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">{{ __('Dashboard') }}</div>--}}
					<div class="card-header">
						<div class="container">
							<div class="row">
								<div class="col-10">
									{{ config('app.name', 'Laravel') }}Menu
								</div>
								<div class="col-2">
									<form method="POST" action="{{ route('admin.login.destroy') }}">
										@method('DELETE')
										@csrf
										<button type="submit" class="btn btn-outline-dark btn-sm">ログアウト</button>
									</form>
								</div>
							</div>
						</div>
					</div>
                    <div class="card-body">
                        @if (session('status'))
                            <div class="alert alert-success" role="alert">
                                {{ session('status') }}
                            </div>
                        @endif
                        <ul>
							<li>
								<button type="button" id="ReservationBirthdayModalBtn" class="btn btn-info modalBtn btn-sm" data-toggle="modal" data-target="#ReservationBirthdayModal" >
									予約・誕生日確認
								</button>
							</li>
                        	<li>
								<form method="POST" action="{{ route('customers.CustomersList.show.post') }}">@csrf
									<button class="btn btn-primary btn-sm" type="submit" >顧客一覧</button>&nbsp;修正・新規登録・契約
								</form>
								支払い不履行者
								<p><span style="color:red;">
									<form method="POST" action="{{route('customers.CustomersList.show')}}">@csrf
										{!!$default_customers!!}
									</form>
								</span></p>
								最終支払いから一ヶ月以上支払いしていない顧客（現金契約者のみ・契約支払い未完了）<br>
								<p><form method="GET">@csrf
									{!!$not_coming_customers!!}
								</form></p>
							</li>
							<li>
								<form method="GET" action="{{route('customers.ShowInpNewCustomer')}}">@csrf
									<p><button class="btn btn-primary btn-sm" type="submit" value="new" name="CreateCustomer">顧客新規登録</button></p>
								</form>
							</li>
                			<li>
								<form method="GET" action="/customers/ContractList/all">@csrf<button class="btn btn-primary btn-sm" type="submit" >契約一覧</button>&nbsp;修正・新規登録・契約</form>
							</li>
							<li>
								<form method="GET" action="{{route('admin.CustomerStandbyDisplay.get')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">顧客受付待ち受け</button>
								</form>
							</li>
							<div class="row">
								<div class="col-auto">
									<li>
										<form method="GET" action="{{ route('admin.ListPoints.get') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">ポイント管理</button>
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="GET" action="/workers/ShowCampaigns">@csrf
											<button class="btn btn-primary btn-sm" type="submit" disabled>キャンペーン</button>
										</form>
									</li>
								</div>
							<li>
								<a href="{{ route('admin.show_setting') }}" class="btn btn-primary btn-sm">環境設定</a>
							</li>
							<div class="row">
								<div class="col-auto">
									<li>
										<form method="GET" action="{{route('admin.DailyReport.get')}}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">日報</button>
										</form>
									</li>
								</div>

								<div class="col-auto">
									<li>
										<form method="POST" action="{{route('admin.MonthlyReport.post')}}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">月報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select>
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="POST" action="{{route('admin.ContractReport.post')}}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">契約金額集計</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> <select name="month"><option  value="0" >選択</option>{!!$html_month_slct!!}</select>
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="POST" action="{{route('admin.YearlyReport.post')}}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">年報</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> &nbsp;決算月<select name="kesan_month" onchange="save_kessan_month(this);"><option  value="0" >選択</option>{!!$htm_kesanMonth!!}</select>&emsp;契約達成率、前年度比等
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="POST" action="{{route('admin.YearlyReport.post')}}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">入金チェック</button>&emsp;<select name="year">{!!$html_year_slct!!}</select> &nbsp;決算月<select name="kesan_month" onchange="save_kessan_month(this);"><option  value="0" >選択</option>{!!$htm_kesanMonth!!}</select>&emsp;契約達成率、前年度比等
										</form>
									</li>
								</div>
							</div>
							<li>
								<form method="POST" action="{{route('admin.TreatmentList.post')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">施術登録</button>
								</form>
							</li>
							<div class="row">
								<div class="col-auto">
									<li> 
										<form method="GET" action="{{ route('admin.StaffStandbyDisplay.get') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">スタッフ入出勤受付待ち受け</button>
										</form>
									</li>
								</div>
								
								<div class="col-auto">
									<li>
										<form method="GET" action="{{ route('StaffsList.show') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">スタッフ登録</button>
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="GET" action="{{ route('admin.show_staff_in_out_rireki.get') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit" onclick="return pass_ctrl();">管理</button>
										</form>
									</li>
								</div>
							</div>
							
							<li>
								<form method="POST" action="{{ route('admin.CashBookList.post') }}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">出納帳</button>
								</form>
							</li>
							
							<li>
								<form method="GET" action="/workers/ShowGoodsList">@csrf
									<button class="btn btn-primary btn-sm" type="submit" disabled>商品登録</button>
								</form>
							</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>

	<div class="modal" id="ReservationBirthdayModal" tabindex="-1">
		<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<div class="modal-header">
			<button type="button" class="close btn-sm btn-secondary" data-dismiss="modal"><span>×</span>閉じる</button>
			<h4 class="modal-title">予約・誕生日確認</h4>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-auto bg-info">
						【予約チェック】
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<span id="Reservation"></span>
					</div>
				</div>
				<div class="row">
					<div class="col-auto bg-info">
						【誕生日チェック】
					</div>
				</div>
				<div class="row">
					<div class="col-auto">
						<span id="Birthday"></span>
					</div>
				</div>
			</div>
			<div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">閉じる</button>
			</div>
		</div>
		</div>
	</div>
@endsection