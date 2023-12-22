@extends('layouts.appCustomer')
@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">契約登録メッセージ</div>
				<div class="card-body">
					{!!$msg!!}
					<ul>
						<li class="my-3">
							<form method="GET" action="/customers/ShowInpRecordVisitPayment/{{$SerialKeiyaku}}/{{$SerialUser}}">@csrf
								<button class="btn btn-primary" type="submit">続けて来店記録を作成</button>
							</form>
						</li>
						<li class="my-3">
							<form method="GET" action="{{route('customers.ShowInpNewCustomer')}}">@csrf
								<button class="btn btn-primary" type="submit">新規顧客追加</button>
							</form>
						</li>
						<li class="my-3">
							<form method="GET" action="{{ route('customers.CustomersList.show') }}">@csrf
								<button class="btn btn-primary" type="submit">顧客一覧</button>
							</form>
						</li>
						<li class="my-3">
							<form method="GET" action="{{$GoBackToPlace}}">@csrf
								<button class="btn btn-primary" type="submit">戻る</button>
							</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection