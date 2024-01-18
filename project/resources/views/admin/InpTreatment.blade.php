@extends('layouts.appCustomer')
@section('content')
{{--<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>--}}
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
<script type="text/javascript" src="{{asset('/js/InpTreatement.js?20230106')}}"></script>
{{--<script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>--}}
<script>
	@if($errors->any())
		alert("{{ implode('\n', $errors->all()) }}");
	@elseif(session()->has('success'))
		alert("{{ session()->get('success') }}");
	@endif
</script>
<style type="text/css">
input,textarea{
	border: 1px solid #aaa;
}
.auto-style1 {
	color: #FF0000;
}
</style>
<div class="container">
	@include('layouts.header')
    <div class="row justify-content-center">
        <div class="col-md-12">
			{{--<button class="btn btn-primary" type="button" onclick="location.href='{{$GoBackPlace}}'">戻る</button>--}}
			<form action="{{route('admin.saveTreatment.post')}}" method="POST" name="inp_Treatment_fm" id="inp_Treatment_fm" class="h-adr">@csrf
	        	@if ($btnDisp=="修正")
					<p><div class="mb-2 bg-secondary text-white">施術データ修正</div></p>
					<p  style="text-indent:20px" class="py-1.5">施術番号<input type="text" name="serial_TreatmentContent" value="{{$TreatmentSerial}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" readonly></p>
					{{--<p>施術番号<input type="text" name="serial_user" value="{{optional($target_user)->serial_user}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" readonly></p>--}}
				@else
					<p><div class="mb-2 bg-secondary text-white">新規施術登録</div> </p>
					<p  style="text-indent:20px" class="py-1.5">施術番号<input type="text" name="serial_TreatmentContent" value="{{$TreatmentSerial}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" readonly></p>
					{{--<p>施術番号<input type="text" name="serial_user" value="{{$target_user['serial_user']}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" readonly></p>	--}}
				@endif
				{{--<div class="font-semibold text-1xl text-slate-600">[商品{{$btnDisp}}]</div>--}}
				<span class="auto-style1">*</span><span class="py-1.5">必須項目</span>
				<p style="text-indent:20px" class="py-1.5">
					施術名
					<span class="auto-style1">*</span>
					<input type="text" name="TreatmentContent_name" id="TreatmentContent_name" value="{{optional($TreatmentContentInf)->name_treatment_contents}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" >
					<span id="TreatmentContent_name_for_error" class="text-danger fw-bold"></span>
				</p>
				<p style="text-indent:20px" class="py-1.5">
					施術名(かな)
					<span class="auto-style1">*</span><input type="text" name="TreatmentContent_name_kana" id="TreatmentContent_name_kana" value="{{optional($TreatmentContentInf)->name_treatment_contents_kana}}" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" tabindex="1" >
					<span id="TreatmentContent_name_kana_for_error" class="text-danger fw-bold"></span>
				</p>
				<p style="text-indent:20px" class="py-1.5">
					施術内容説明
					<textarea cols="20" name="TreatmentContent_details" id="TreatmentContent_details" rows="2">{{ optional($TreatmentContentInf)->treatment_details }}</textarea>
				</p>
				<p style="text-indent:20px" class="py-1.5">
					メモ
					<textarea cols="20" name="memo" id="memo" rows="2">{{ optional($TreatmentContentInf)->memo }}</textarea>
				</p>
				
				{{--&nbsp;<p style="text-align: center"><button class="bg-blue-500 text-white rounded px-3 py-1" type="submit" id="SubmitBtn" value="{{$btnDisp}}" onclick="return validate();">{{$btnDisp}}</button></p>--}}
				<button class="btn btn-primary w-100 my-3" type="submit" id="SubmitBtn" value="{{$btnDisp}}">{{$btnDisp}}</button>
			</form>
			<div style="py-3.5"><input name="TorokuMessageFlg" id="TorokuMessageFlg" type="hidden" value="{{$btnDisp}}"/></div>
        </div>
    </div>
</div>
@endsection