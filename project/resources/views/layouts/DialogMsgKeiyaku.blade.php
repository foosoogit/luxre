@extends('layouts.appCustomer')
@section('content')

<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">{{ __('Dashboard') }}</div>
				<div class="card-body">
					{!!$msg!!}
					<ul>
					<li><form method="GET" action="/customers/ShowInpRecordVisitPayment/{{$SerialKeiyaku}}/{{$SerialUser}}">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">続けて来店記録を作成</button>
					</form></li><br>
					{{--
					<li><form method="GET" action="/customers/ShowSyuseiContract/{{$SerialKeiyaku}}/{{$UserSerial}}">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">契約を修正</button>
					</form></li><br>
					--}}
					<li><form method="GET" action="{{$GoBackToPlace}}">@csrf
						<button class="bg-blue-500 text-white rounded px-3 py-1" type="submit">戻る</button>
					</form></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection