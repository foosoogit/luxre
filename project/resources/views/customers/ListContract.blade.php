<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>顧客一覧</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		{{-- <link rel="stylesheet" href="css/style.css"> --}}
		{{-- <link href="{{asset('css/app.css')}}" rel="stylesheet">--}}
		<link rel="stylesheet" type="text/css" href="{{asset('css/table_list.css')}}">
		@livewireStyles
        <!-- Scripts -->
        {{-- <script src="{{ mix('js/app.js') }}" defer></script> --}}
    </head>
    <body>
{{-- 
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-md-12">
					<div class="card">
					<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='../../top'">メニュー</button>
					<button class="bg-blue-500 text-white rounded px-3 py-1" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button>
					<div class="font-semibold text-2xl text-slate-600">[契約リスト]</div>
 --}}
		<p><livewire:contract-list></p>
						{{-- 
					</div>
				</div>
			</div>
		</div>
		 --}}
	</body>
</html>