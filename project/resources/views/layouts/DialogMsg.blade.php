@extends('layouts.appCustomer')
@section('content')
<div class="container">
	<div class="row justify-content-center">
		<div class="col-md-8">
			<div class="card">
				<div class="card-header">新規顧客登録完了メッセージ</div>
				<div class="card-body">
					{!!$msg!!}
					<ul class="my-3">
						<li>
							<form method="GET" action="/customers/ShowInpContract/{{$targetSerial}}">@csrf
								<button class="btn btn-primary" type="submit">続けて契約書を作成</button>
							</form>
						</li>
						<li class="my-3">
							<button type="button" class="btn btn-primary" onClick="history.back()">前画面に戻る</button>
						</li>
						{{-- 
						<li>
							<form method="GET" action="/customers/ShowInpContract/{{$targetSerial}}">@csrf
								<button class="btn btn-primary btn-sm" type="submit">顧客一覧</button>
							</form>
						</li><br>
						 --}}
						<li class="my-3">
							<form method="GET" action="{{route('customers.ShowInpNewCustomer')}}">@csrf
								<button class="btn btn-primary" type="submit">新規顧客追加</button>
							</form>
						</li>
						<li class="my-3">
							<form method="GET" action="{{ route('customers.CustomersList.show') }}">@csrf
								<button class="btn btn-primary btn-sm" type="submit">顧客一覧</button>
							</form>
						</li>
						<li class="my-3">
							<form method="GET" action="{{route('admin.top')}}">@csrf
								<button class="btn btn-primary" type="submit">メニューに戻る</button>
							</form>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection