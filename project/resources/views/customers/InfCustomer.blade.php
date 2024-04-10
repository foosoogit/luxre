@extends('layouts.appUser')
@section('content')
<script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
<style type="text/css">
input,textarea{
	border: 1px solid #aaa;
}
.auto-style1 {
	color: #FF0000;
}
</style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                {{-- 
                <div class="row">
                    @include('layouts.header')
                </div>
                 --}}
                 <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <input type="submit" value="ログアウト">
                  </form>
                <div class="mb-2 bg-success text-white">お客様情報</div>
				<form action="{{ route('saveStaff.post') }}" method="POST" class="h-adr" id="save_staff" name="save_staff">@csrf
	            	{!! QrCode::size(100)->generate($serial_user)!!}
                    <div class="row">
                		<div class="col-auto d-flex align-items-center">
							<label for="serial_student" class="max-w-7xl font-large">会員番号</label>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                        	{{ $user_inf->serial_user }}
                        </div>
                     </div>
                     <div class="row">
                		<div class="col-auto d-flex align-items-center">
							<label for="serial_student" class="max-w-7xl font-large">現在のポイント</label>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                        	{{ $point_total }}
                        </div>
                     </div>
                     <div class="row"> 
                            <div class="col-4">
                                <label for="name_sei" class="form-label">姓</label>
                                {{ $user_inf->name_sei }}
                            </div>
                            <div class="col-4">
                                <label for="name_mei" class="form-label">名</label>
                                {{ $user_inf->name_mei }}
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-4">
                            	<label for="name_sei_kana" class="form-label">せい</label>
                                {{ $user_inf->name_sei_kana }}
                            </div>
                            <div class="col-4">
	                            <label for="name_mei_kana" class="form-label">めい</label>
                                {{ $user_inf->name_mei_kana }}
                            </div>
                        </div><br>
                        <div class="row">
                            <div class="col-4">
                            	<label for="mail" class="form-label">e-mail</label>
                                {{ $user_inf->email }}
                            </div>
                            <div class="col-4">
	                            <label for="phone" class="form-label">電話</label>
                                {{ $user_inf->phone }}
                            </div>
                        </div><br>
                        生年月日
                        <div class="row">
                            <div class="col-auto">
                                {{ $user_inf->birth_year }}
                            </div>
                            <div class="col-auto">
                                <label for="year" class="form-label">年</label>
                            </div>
                            <div class="col-auto">
                                {{ $user_inf->birth_month }}
                            </div>
                            <div class="col-auto">
                                <label for="month" class="form-label">月</label>
                            </div>
                            <div class="col-auto">
	                            {{ $user_inf->birth_day }}
                                
                            </div>
                            <div class="col-auto">
                                <label for="day" class="form-label">日</label>
                            </div>
                        </div><br>					
						{{--<input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$saveFlg}}"/>--}}
					{{--  ubmit" class="btn btn-primary btn-sm">{{$btnDisp}}</button>--}}
					</form>
            </div>
        </div>
    </div>
@endsection