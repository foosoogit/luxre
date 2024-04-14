@extends('layouts.top')
@section('content')
<script src="{{  asset('/js/MenuCustomerManagement.js') }}" defer></script>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    {{--<div class="card-header">{{ __('Dashboard') }}</div>--}}
					<div class="card-header">
						<div class="container">
							<div class="row">
								<div class="col-10">
									{{ config('app.name', 'Laravel') }}メニュー
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
								{{-- <form method="GET" action="{{ route('CustomersList') }}/customers/ShowCustomersList_livewire">@csrf --}}
								{{--<form method="GET" action="{{ route('customers.CustomersList.show') }}">@csrf--}}
								<form method="POST" action="{{ route('customers.CustomersList.show.post') }}">@csrf
									<button class="btn btn-primary btn-sm" type="submit" >顧客一覧</button>&nbsp;修正・新規登録・契約
								</form>
								支払い不履行者
								<p><span style="color:red;">
									{{--<form method="POST" action="/customers/ShowCustomersList_livewire_from_top_menu">@csrf--}}
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
							<li>
								<form method="GET" action="/workers/ShowCampaigns">@csrf
									<button class="btn btn-primary btn-sm" type="submit" disabled>キャンペーン</button>
								</form>
							</li>
							<li>
								<a href="{{ route('admin.show_setting') }}" class="btn btn-primary btn-sm">環境設定</a>
								{{-- 
								<form method="GET" action="/workers/ShowCampaigns">@csrf
									<button class="btn btn-primary btn-sm" type="submit" disabled>環境設定</button>
								</form>
								 --}}
							</li>
							<div class="row">
								<div class="col-auto">
									<li>
										{{--<form method="GET" action="admin/ShowDailyReport">@csrf--}}
										{{--<form method="GET" action="{{route('ShowDailyReport')}}">@csrf--}}
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
							</div>
							{{--
							<li>
								<form method="GET" action="{{route('admin.InOutStandbyDisplay.get')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">スタッフ入退出待ち受け</button>
								</form>
							</li>
							--}}
							<li>
								<form method="POST" action="{{route('admin.TreatmentList.post')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">施術登録</button>
								</form>
							</li>
							<div class="row">
								<div class="col-auto">
									<li> 
										{{--<form method="GET" action="{{route('admin.CustomerStandbyDisplay.get')}}">@csrf   --}}
										<form method="GET" action="{{ route('admin.StaffStandbyDisplay.get') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">スタッフ入退社受付待ち受け</button>
										</form>
									</li>
								</div>
								<div class="col-auto">
									<li>
										<form method="GET" action="{{ route('StaffsList.show') }}">@csrf
											<button class="btn btn-primary btn-sm" type="submit">スタッフ出勤履歴</button>
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
							</div>
							<li>
								<form method="GET" action="/workers/ShowGoodsList">@csrf
									<button class="btn btn-primary btn-sm" type="submit" disabled>商品登録</button>
								</form>
							</li>
							{{--
							<li>
								<form method="GET" action="{{route("admin.get_imagick_info.get")}}>@csrf
									<button class="btn btn-primary btn-sm" type="submit" disabled>get_imagick_info</button>
								</form>
							</li>
							--}}
							{{--
							<li>
								<form method="GET" action="{{route('admin.QRcode')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">QRcode</button>
								</form>
							</li>
							--}}
							{{--
							<li>
								<form method="GET" action="{{route('admin.QRcode')}}">@csrf
									<button class="btn btn-primary btn-sm" type="submit">暗号化チェック</button>
								</form>
							</li>
							--}}
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection