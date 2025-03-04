@extends('layouts.appCustomer')
@section('content')
<script type="text/javascript" src="{{ asset('/js/PaymentRegistration.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/MediaRecord.js?20230129') }}"></script>
<link rel="stylesheet" type="text/css" href="{{asset('css/iflame.css')}}">
<style type="text/css">
input{border: 1px solid #aaa;}
table td {border: 1px solid #aaa;}
</style>
<div class="container-fluid">
	<div class="row">
		@include('layouts.header')
	</div>
	<div class="row">
		契約番号:&nbsp;{{$KeiyakuInf->serial_keiyaku}}&nbsp;/&nbsp;契約名:&nbsp;{{$KeiyakuInf->keiyaku_name}}
	</div>
	<div class="row">
		顧客番号:&nbsp;{{$UserInf->serial_user}}&nbsp;/&nbsp;顧客名: {{$UserInf->name_sei}}&nbsp;{{$UserInf->name_mei}}&nbsp;({{$UserInf->name_sei_kana}}&nbsp;{{$UserInf->name_mei_kana}})
	</div>
</div>
	<div class="d-flex flex-nowrap">
		<iframe class="pull-right pr-5" width="100%" height="100%" id="sub_VisitHistory" onload="func_VisitHistory()" src="{{ route('customers.VisitHistory.post') }}"></iframe>
		<iframe class="pull-left"  width="100%" height="100%" id="sub_PaymentHistory" onload="func_PaymentHistory()" src="{{ route('customers.PaymentHistory.post') }}"></iframe>
	</div>
<script>
	const sub_VisitHistory = document.getElementById("sub_VisitHistory");
    function func_VisitHistory() {
		//sub_VisitHistory.style.width = sub_VisitHistory.contentWindow.document.body.scrollWidth + "px";
		sub_VisitHistory.style.height = sub_VisitHistory.contentWindow.document.body.scrollHeight + "px";
    }
	const sub_PaymentHistory = document.getElementById("sub_PaymentHistory");
	function func_PaymentHistory() {
		//sub_PaymentHistory.style.width = sub_PaymentHistory.contentWindow.document.body.scrollWidth + "px";
		sub_PaymentHistory.style.height = Number(sub_PaymentHistory.contentWindow.document.body.scrollHeight)+10 + "px";
    }
</script>
@endsection