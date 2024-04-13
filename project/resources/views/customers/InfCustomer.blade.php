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
                {{--<div class="mb-2 bg-success text-white">お客様情報</div>--}}
	            	
            <ol class="list-group list-group-numbered" style="max-width: 400px;">
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="row">
                            <div class="fw-bold col-auto">お客様情報</div>
                            <div class="fw-bold col-auto">
                                <form action="{{ route('logout') }}" method="post">@csrf
                                    <input type="submit" class="btn btn-primary me-md-2 btn-sm" value="ログアウト">
                                </form>
                            </div>
                        </div>
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                    <div class="ms-2 me-auto">
                        <div class="fw-bold">来院受付用QRコード</div>
                        {!! QrCode::size(100)->generate($serial_user)!!}
                    </div>
                </li>
                <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">会員番号</div>
                                {{ $user_inf->serial_user }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">現在のポイント</div>
                                {{ $point_total }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">氏名</div>
                                {{ $user_inf->name_sei }}&nbsp;{{ $user_inf->name_mei }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">e-mail</div>
                                {{ $user_inf->email }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">電話</div>
                                {{ $user_inf->phone }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">生年月日</div>
                                {{ $user_inf->birth_year }}年&nbsp;{{ $user_inf->birth_month }}月&nbsp;{{ $user_inf->birth_day }}日
                            </div>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
@endsection