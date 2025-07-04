<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		{{-- <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script> --}}
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
		{{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>--}}
		<script src="{{asset('/js/menu_top.js')}}?date=20230212" defer></script>
		<script>
			window.setTimeout(() => {
				$(".error").slideUp();
				$(".success").slideUp();
			}, 1500);
		</script>
		<title>{{ config('app.name', 'Laravel') }}</title>
		<link rel="icon" href="{{asset('/images/icon.png')}}">
		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
		<!-- Styles -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		{{--<link rel="stylesheet" href="{{ mix('css/app.css') }}">--}}
		@livewireStyles
		<!-- Scripts -->
		{{--<script src="{{ mix('js/app.js') }}" defer></script>--}}

		<style>
			li {
			  line-height: 3.5em;
			}
		</style>

	</head>
	<body class="font-sans antialiased mt-3">
		@if (session('flash_message'))
			<div class="flash_message">
				{{ session('flash_message') }}
			</div>
		@endif
		@yield('content')
			<main>
				{{--{{ $slot }}--}}
			</main>
		<!--</div> -->
	    @stack('modals')
		{{--@livewireScripts--}}
		{{--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>--}}
	</body>
	@if ($errors->any())
		{{-- エラーメッセージ --}}
		<div class="error">
			{!! implode('<br>', $errors->all()) !!}
		</div>
	@elseif (session()->has('success'))
		{{-- 成功メッセージ --}}
		<div class="success">
			{{ session()->get('success') }}
		</div>
	@endif
</html>