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
		



<div class="container-fluid ml-5">
    <div class="py-12 row justify-content-center">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="pb-4 align-middle">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-secondary text-white">入退勤履歴</div>
                <div class="col">
                    {{-- <input type="button" name="show_calender" id="tshow_calender" value='カレンダー表示'> --}}
                    <input type="button" name="csv_download" id="csv_download" class="btn btn-success" value='ファイルのダウンロード' wire:click="csv_download()">
                </div>
                <div class="col-auto">
                    <div class="d-flex flex-row gap-2">
                        <div class="p-2"><button onclick="change_serch_month_manage()" wire:click="search_month()" class='btn btn-primary btn-sm rounded'>月検索</button>： {!!$html_working_list_year_slct!!}{!!$html_working_list_month_slct!!}</div>
                        <div class="p-2"> <label>日付検索：<input name="TDay" id="TDay" type="date" wire:model.live="searchDay" onchange="change_serch_day_manage(this)"/></label></div>
                        <div class="p-2"><label>スタッフ検索：<select name="year_slct" id="year_slct" class="form-select" wire:model.change="target_staff_serial">{!!$html_staff_inout_slct!!}</select></label></div>
                        <div class="p-2"><button onclick="serch_Clear_manage();" wire:click="searchClear()" class='btn btn-primary btn-sm rounded'>検索解除</button> </div>
                    </div>
                    <div class="col">※:Enterで更新</div>

					<p><livewire:staff-in-out-list/></p>
					@livewireScripts

				</div>
            </div>
        </div>
    </div>
</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<script src="https://code.jquery.com/jquery-3.5.0.min.js" integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
		{{-- <script type="text/javascript" src="https://code.jquery.com/ui/1.12.0/jquery-ui.min.js"></script> --}}
		<script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
		<script type="text/javascript" src="{{asset('/js/bootstrap-datetimepicker.min.js')}}"></script>
		<script type="text/javascript" src="{{asset('/js/ListStaffInOutHistories.js?20230127')}}"></script>
		
	</body>
</html>