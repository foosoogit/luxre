@extends('layouts.appCustomer')
@section('content')
<script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
{{--
<script>
	@if ($errors->any())
		alert("{{ implode('\n', $errors->all()) }}");
	@elseif (session()->has('success'))
		alert("{{ session()->get('success') }}");
	@endif
</script>
--}}
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
                <div class="col-auto">
	                <button class="btn btn-primary btn-sm" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button>
	            </div>
				<form action="{{ route('saveStaff.post') }}" method="POST" class="h-adr">@csrf
	            	<div class="row">
                		<div class="col-auto d-flex align-items-center">
							<label for="serial_student" class="max-w-7xl font-large">スタッフ番号</label>
                        </div>
                        <div class="col-auto d-flex align-items-center">
                        	<input id="serial_staff" name="serial_staff" type="text" class="form-control" value="{{$TargetStaffSerial}}" readonly/>
                        </div>
                     </div>
                     <div class="row"> 
                            <div class="col-4">
                                <label for="name_sei" class="form-label">姓</label>
                                		<input id="name_sei" name="name_sei" type="text" class="form-control" value="{{old('name_sei',optional($StaffInf)->last_name_kanji)}}" required autofocus />
                            </div>
                            <div class="col-4">
                                <label for="name_mei" class="form-label">名</label>
                                <input id="name_mei" name="name_mei" type="text" class="form-control" value="{{old('name_mei',optional($StaffInf)->first_name_kanji)}}" required autofocus />
                            </div>
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
						{{--<input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$saveFlg}}"/>--}}
						<button class="btn btn-primary btn-sm" type="submit">{{$btnDisp}}</button>
					</form>
            </div>
        </div>
    </div>
@endsection