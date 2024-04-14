@extends('layouts.appCustomer')
    @section('content')
    {{-- <script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script> --}}
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
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-success text-white">環境設定</div>
                <form action="{{ route('admin.setting.update') }}" method="POST" id="save_setting" name="save_setting">@csrf
                    <div class="row"> 
                        <div class="col-4">
                            <label for="UserPointVisit" class="form-label">来店付加ポイント</label>
                            <input id="UserPointVisit" name="UserPointVisit" type="text" class="form-control" value="{{ $configration_array["UserPointVisit"] }}" required autofocus />
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-4">
                            <label for="UserPointReferral" class="form-label">紹介付加ポイント</label>
                            <input id="UserPointReferral" name="UserPointReferral" type="text" class="form-control" value="{{ $configration_array["UserPointReferral"] }}" required autofocus />
                        </div>
                    </div>
                            {{--  
                            <div class="col-4">
                                    <label for="name_mei" class="form-label">名</label>
                                    <input id="name_mei" name="name_mei" type="text" class="form-control" value="{{old('name_mei',optional($StaffInf)->first_name_kanji)}}" required autofocus />
                                </div>
                            --}}
                        {{-- 
                        </div><br>
                            
                            <div class="row">
                                <div class="col-4">
                                    <label for="name_sei_kana" class="form-label">せい</label>
                                    <input id="name_sei_kana" name="name_sei_kana" type="text" class="form-control" value="{{old('name_sei_kana',optional($StaffInf)->last_name_kana)}}" required autofocus />
                                </div>
                                <div class="col-4">
                                    <label for="name_mei_kana" class="form-label">めい</label>
                                    <input id="name_mei_kana" name="name_mei_kana" type="text" class="form-control" value="{{old('name_mei_kana',optional($StaffInf)->first_name_kana)}}" required autofocus />
                                </div>
                            </div><br>
                            <div class="row">
                                <div class="col-4">
                                    <label for="mail" class="form-label">e-mail</label>
                                    <input id="mail" name="mail" type="text" class="form-control" value="{{old('email',optional($StaffInf)->email)}}"/>
                                </div>
                                <div class="col-4">
                                    <label for="phone" class="form-label">電話</label>
                                    <input id="phone" name="phone" type="text" class="form-control" value="{{old('phone',optional($StaffInf)->phone)}}"/>
                                </div>
                            </div><br>
                            生年月日
                            <div class="row">
                                <div class="col-auto">
                                    {!!$html_birth_select['year'] !!}
                                </div>
                                <div class="col-auto">
                                    <label for="year" class="form-label">年</label>
                                </div>
                                <div class="col-auto">
                                    {!!$html_birth_select['month'] !!}
                                </div>
                                <div class="col-auto">
                                    <label for="month" class="form-label">月</label>
                                </div>
                                <div class="col-auto">
                                    {!!$html_birth_select['day'] !!}
                                    
                                </div>
                                <div class="col-auto">
                                    <label for="day" class="form-label">日</label>
                                </div>
                            </div><br>
                            --}}				
                            {{--<input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$saveFlg}}"/>--}}
                    <div class="row"> 
                        <div class="col-auto">
                            <button type="submit" class="btn btn-primary btn-sm">保存</button>
                        </div>
                        {{-- 
                        @if(session('message'))
                            <div class="col-auto">
                                {{session('message')}}
                            </div>
                        @endif
                         --}}
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection