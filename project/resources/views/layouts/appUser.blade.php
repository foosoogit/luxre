<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
		<script>
			window.setTimeout(() => {
				$(".error").slideUp();
				$(".success").slideUp();
			}, 1500);
		</script>
		<title>{{ config('app.name', 'Laravel') }}</title>
		<link rel="icon" type="image/png" href="{{asset('/images/icon.png')}}">
		<!-- Fonts -->
		<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
		<!-- Styles -->
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"/>
		 {{--<link rel="stylesheet" href="{{ mix('css/app.css') }}"> --}}
		@livewireStyles
		<!-- Scripts -->
		{{--  <script src="{{ mix('js/app.js') }}" defer></script>--}}
	</head>
	<body class="font-sans antialiased mt-3">
		<!--<div class="min-h-screen bg-gray-100">-->
			{{--@livewire('navigation-dropdown')--}}
			<!-- Page Heading -->
			<!--<header class="bg-white shadow">-->
				<!--<div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">-->
					<!-- フラッシュメッセージ -->
					@if (session('flash_message'))
						<div class="flash_message">
							{{ session('flash_message') }}
						</div>
					@endif
					@yield('content')
				<!--</div>-->
			<!--</header>-->
			<!-- Page Content -->
			{{-- 
				<main>
				{{ $slot }}
				</main>
			 --}}
		<!--</div> -->
	        @stack('modals')
		{{--@livewireScripts--}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
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