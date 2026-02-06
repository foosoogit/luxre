<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<title>契約リスト</title>
		<link rel="icon" type="image/png" href="{{asset('/images/icon.png')}}">
		<link rel="stylesheet" type="text/css" href="{{asset('css/table_list.css')}}">
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">
		<link rel="stylesheet" type="text/css" href="{{asset('css/MedicalRecord.css')}}">
		@livewireStyles
        <!-- Scripts -->
    </head>
    <body>
		<p><livewire:visit-history-list /></p>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
		<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
		<script src="{{asset('/js/ListVisit.js')}}?date=20230622"></script>
		@livewireScripts
		<script  type="text/javascript" src="{{ asset('/js/ContractList.js?2024120418')}}"></script>
		<script type="text/javascript">var base_url = '{{ asset('') }}';</script>
	</body>
</html>