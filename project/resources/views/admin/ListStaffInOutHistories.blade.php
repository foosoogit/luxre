<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta name="csrf-token" content="{{ csrf_token() }}">
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>入退勤一覧</title>
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="http://code.jquery.com/ui/1.12.1/themes/pepper-grinder/jquery-ui.css">
		<link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/themes/ui-darkness/jquery-ui.css">
		<link rel="stylesheet" href="{{asset('/css/bootstrap-datetimepicker.min.css')}}">
		{{-- <link rel="stylesheet" href="css/style.css"> --}}
		{{-- <link href="{{asset('css/app.css')}}" rel="stylesheet">--}}
		<link rel="stylesheet" type="text/css" href="{{asset('css/table_list.css')}}">
		@livewireStyles
	</head>
	<body>
		{{-- <div class="table-responsive"> --}}
		<p><livewire:staff-in-out-list/></p>
		@livewireScripts
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		{{-- <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> --}}
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script type="text/javascript" src="{{asset('/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('/js/ListStaffInOutHistories.js?20230119')}}"></script>
		
	</body>
</html>