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
					{{ $header }} 
					@yield('content')
				<!--</div>-->
			<!--</header>-->
			<!-- Page Content -->
			<main>
				{{ $slot }}
			</main>
		<!--</div> -->
	        @stack('modals')
		{{--@livewireScripts--}}
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
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