@extends('layouts.appCustomer')
@section('content')
<script type="text/javascript" src="{{ asset('/js/CreateContract.js?20230106') }}"></script>
<style type="text/css">
.auto-style1 {margin-left: 40px;}
table td {border: 1px solid #aaa;}
input,textarea{border: 1px solid #aaa;}
.auto-style2 {
	color: #FF0000;
}
</style>
    <div class="container">
        {{-- <div class="row justify-content-center"> --}}
            <div class="col-md-12 py-4">
            	<div class="container-fluid">
					<div class="row mb-2">
						<div class="col-auto">
							<a href="../../../ShowMenuCustomerManagement" class="btn bg-blue-500 text-white rounded px-3 py-2">メニュー</a>
						</div>
	            		<div class="col-auto">
							<a href="/customers/ShowContractList/{{$targetUser->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">戻る</a>
						</div>
	            		<div class="col-auto">
							<a href="/customers/ShowInpRecordVisitPayment/{{optional($targetContract)->serial_keiyaku}}/{{optional($targetContract)->serial_user}}" class="btn bg-blue-500 text-white rounded px-3 py-2">来店・支払い記録</a>
						</div>
						<div class="col-auto">
							<form action="/workers/ContractCancellation/{{optional($targetContract)->serial_keiyaku}}/{{$targetUser->serial_user}}" method="POST" name="KaiyakuFm"  id="KaiyakuFm">@csrf
								@if(optional($targetContract)->cancel===null)
									<input name="KaiyakuBtn" type="submit" value="解約" class="btn bg-blue-500 text-white rounded px-3 py-1.5" onclick="return cancel_validate();"/>
									解約日<input name="KaiyakuDate" id="KaiyakuDate" type="date" value="{{optional($targetContract)->cancel}}"/>
								@else
									<input name="KaiyakuModosuBtn" type="submit" value="契約を復活"  class="btn bg-blue-500 text-white rounded px-3 py-1.5" onclick="return modosu_cancel();"/>解約日：{{optional($targetContract)->cancel}}
								@endif
							</form>
						</div>
						<a href="/workers/MakeContractPDF/{{optional($targetContract)->serial_keiyaku}}" class="btn bg-blue-500 text-white rounded px-3 py-2">契約書ダウンロード・印刷</a>
					</div>
					<form id="ContractFm" action="{{route('customers.insertContract')}}" method="POST" >@csrf
						<p><div class="mark">契約の登録</div></p>
						<div class="container-fluid">
							<div class="row border-bottom border-primary" style="padding-bottom:10px;">
								<div class="col-auto">
									氏名：<input type="text" name="serial_user" value="{{ $targetUser->name_sei }} {{ $targetUser->name_mei }}" class="form-control form-control-sm" readonly>
								</div>
								<div class="col-auto align-items-center">
									顧客番号：<input type="text" name="serial_user" value="{{ $targetUser->serial_user}}" class="form-control form-control-sm" readonly>
								</div>
								<div class="col-auto">
									契約番号：<input type="text" name="ContractSerial" value="{{$newKeiyakuSerial}}" class="form-control form-control-sm" readonly>
								</div>
								<div class="col-auto"></div>
								@if(!(optional($targetContract)->cancel===null))解約済み@endif
							</div>
							<div class="py-2"><span class="auto-style2">*</span><span class="font-semibold text-1xl text-slate-600">:必須項目</span></div>
							<div class="py-2">●<span class="auto-style2">*</span>契約締結日：<input name="ContractsDate" id="ContractsDate" type="date" value="{{optional($targetContract)->keiyaku_bi}}"/></div>
							<div class="py-2">●<span class="auto-style2">*</span>契約名：<input name="ContractName" id="ContractName" type="text" class="form-control col-5" value="{{ optional($targetContract)->keiyaku_name }}"/></div>
							<div class="py-3">●<span class="auto-style2">*</span>担当者：{!!$html_staff_slct!!}</div>
							<div>●<span class="auto-style2">*</span>契約形態</div>
							<div class="form-check" style="text-indent: 1em">
								<input class="form-check-input" type="radio" name="contract_type" id="contract_type_subscription" value="subscription" onclick="contract_type_manage();">
								<label class="form-check-label" for="contract_type_subscription">サブスクリプション</label>
								<div class="py-2"><span class="auto-style2">*</span>支払金額/月：<input type="text" name="inpMonthlyAmount" id="inpMonthlyAmount" value="" class="form-control col-5 subsc"></div>
							</div>
							<div class="form-check" style="text-indent: 1em">
								<input class="form-check-input" type="radio" name="contract_type" id="contract_type_cyclic" value="cyclic" onclick="contract_type_manage();">
								<label class="form-check-label" for="contract_type_cyclic">回数、期間指定</label>
								<div class="py-2"><span class="auto-style2">*</span>契約金（チェック用入力）：
									@if(isset($targetContract->keiyaku_kingaku))
										<input type="text" name="inpTotalAmount" id="inpTotalAmount" value="{{number_format($targetContract->keiyaku_kingaku)}}" class="form-control col-5 cyclic">
									@else
										<input type="text" name="inpTotalAmount" id="inpTotalAmount" value="" class="form-control col-5 cyclic">
									@endif
								</div>
							</div>
							<div class="py-2">
								●役務契約期間：<span class="auto-style2">*</span><input name="ContractsDateStart" id="ContractsDateStart" type="date"  value="{{optional($targetContract)->keiyaku_kikan_start}}"/> ～ <input name="ContractsDateEnd" id="ContractsDateEnd" type="date" class="cyclic" value="{{optional($targetContract)->keiyaku_kikan_end}}"/>
							</div>
							<p class="cyclic">●<span class="auto-style2">*</span>施術回数 {!!$TreatmentsTimes_slct!!}</p>
						</div>
						<table style="width: 100%;border-collapse: collapse;border: 1px solid #aaa;" class="table-auto border-solid cyclic">
							<tr>
							<td>契約内容明細&nbsp;&nbsp;<input name="toroku_treatment_btn" type="button" class="btn btn-success btn-sm cyclic" value="施術内容登録" onclick="location.href='/workers/ShowTreatmentContents'"></td>
							<td>回数</td>
							<td>単価</td>
							<td>料金(税抜き)</td>
						</tr>
						<tr>
							<td>
								<span class="auto-style2">*</span><select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[0]" onchange="ContractNaiyoSlctManage(this)" class="cyclic">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
								<input type="text" name="ContractNaiyo[]" id="ContractNaiyo0" value="{{optional($KeiyakuNaiyouArray)[0]}}" class="form-control col-8 form-control-sm my-2 cyclic">
							</td>
							<td>
								<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct1" onchange="total_amount();" class="cyclic"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[0]!!}}</select>
							</td>
							<td>
								@if($KeiyakuTankaArray[0]=="")
									<input type="text" name="AmountPerNum[]" id="AmountPerNum1" value="" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@else
									<input type="text" name="AmountPerNum[]" id="AmountPerNum1" value="{{number_format($KeiyakuTankaArray[0])}}" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@endif
							</td>
							<td>
								@if($KeiyakuPriceArray[0]=="")
									<input type="text" name="subTotalAmount[]" id="subTotalAmount1" class="form-control col-8 form-control-sm my-2 cyclic" value="" onchange="ck_total_amount()">
								@else
									<input type="text" name="subTotalAmount[]" id="subTotalAmount1" class="form-control col-8 form-control-sm my-2 cyclic" value="{{$KeiyakuPriceArray[0]}}" onchange="ck_total_amount()">
								@endif
							</td>
						</tr>
						<tr>
							<td>
								<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[1]" onchange="ContractNaiyoSlctManage(this)" class="cyclic">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
								<input type="text" name="ContractNaiyo[]" id="ContractNaiyo1" value="{{optional($KeiyakuNaiyouArray)[1]}}" class="form-control col-8 form-control-sm my-2 cyclic">
							</td>
							<td>
								<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct2" onchange="total_amount();" class="cyclic"><option value="0" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[1]!!}}</select>
							</td>
							<td>
								@if($KeiyakuTankaArray[1]=="")
									<input type="text" name="AmountPerNum[]" id="AmountPerNum2" value="" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@else
									<input type="text" name="AmountPerNum[]" id="AmountPerNum2" value="{{number_format($KeiyakuTankaArray[1])}}" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@endif	
							</td>
							<td>
								@if($KeiyakuPriceArray[1]=="")
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount2" class="form-control col-8 form-control-sm my-2 cyclic" value="" onchange="ck_total_amount()">
								@else
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount2" class="form-control col-8 form-control-sm my-2 cyclic" value="{{$KeiyakuPriceArray[1]}}" onchange="ck_total_amount()">
								@endif
							</td>
						</tr>
						<tr>
							<td>
								<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[2]" onchange="ContractNaiyoSlctManage(this)" class="cyclic">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
								<input type="text" name="ContractNaiyo[]" id="ContractNaiyo2"  value="{{optional($KeiyakuNaiyouArray)[2]}}" class="form-control col-8 form-control-sm my-2 cyclic">
							</td>
							<td>
								<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct3" onchange="total_amount();" class="cyclic"><option value="0" class="cyclic" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[2]!!}}</select>
							</td>
							<td>
								@if($KeiyakuTankaArray[2]=="")
									<input type="text" name="AmountPerNum[]" id="AmountPerNum3" value="" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@else
									<input type="text" name="AmountPerNum[]" id="AmountPerNum3" value="{{optional($KeiyakuTankaArray)[2]}}" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@endif
							</td>
							<td>
								@if($KeiyakuPriceArray[2]=="")
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount3" class="form-control col-8 form-control-sm my-2 cyclic" value="" onchange="ck_total_amount()">
								@else
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount3" class="form-control col-8 form-control-sm my-2 cyclic" value="{{number_format($KeiyakuPriceArray[2])}}" onchange="ck_total_amount()">
								@endif
							</td>
						</tr>
						<tr>
							<td>
								<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[3]" onchange="ContractNaiyoSlctManage(this)" class="cyclic">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
								<input type="text" name="ContractNaiyo[]" id="ContractNaiyo3" value="{{optional($KeiyakuNaiyouArray)[3]}}" class="form-control col-8 form-control-sm my-2 cyclic">
							</td>
							<td>
								<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct4" onchange="total_amount();" class="cyclic"><option value="0" class="cyclic" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[3]!!}}</select>
							</td>
							<td>
								@if($KeiyakuTankaArray[3]=="")
									<input type="text" name="AmountPerNum[]" id="AmountPerNum4" value="" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@else
									<input type="text" name="AmountPerNum[]" id="AmountPerNum4" value="{{optional($KeiyakuTankaArray)[3]}}" class="form-control col-8 form-control-sm my-2 cyclic cyclic" onchange="total_amount()">
								@endif
							</td>
							<td>
								@if($KeiyakuPriceArray[3]=="")
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount4" class="form-control col-8 form-control-sm my-2 cyclic" value="" onchange="ck_total_amount()">
								@else
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount4" class="form-control col-8 form-control-sm my-2 cyclic" value="{{number_format($KeiyakuPriceArray[3])}}" onchange="ck_total_amount()">
								@endif
							</td>
						</tr>
						<tr>
							<td>
								<select name="ContractNaiyoSlct[]" id="ContractNaiyoSlct[4]" onchange="ContractNaiyoSlctManage(this)" class="cyclic">{!!$KeiyakuNaiyouSelectArray[0]!!}</select>
								<input type="text" name="ContractNaiyo[]" id="ContractNaiyo4" value="{{optional($KeiyakuNaiyouArray)[5]}}" class="form-control col-8 form-control-sm my-2 cyclic"></td>
							<td>
								<select name="KeiyakuNumSlct[]" id="KeiyakuNumSlct5" onchange="total_amount();" class="cyclic"><option value="0" class="cyclic" selected>--選択してください--</option>{{!!optional($KeiyakuNumSlctArray)[4]!!}}</select>
							</td>
							<td>
								@if($KeiyakuTankaArray[4]=="")
									<input type="text" name="AmountPerNum[]" id="AmountPerNum5" value="" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@else
									<input type="text" name="AmountPerNum[]" id="AmountPerNum5" value="{{optional($KeiyakuTankaArray)[4]}}" class="form-control col-8 form-control-sm my-2 cyclic" onchange="total_amount()">
								@endif
							</td>
							<td>
								@if($KeiyakuPriceArray[4]=="")
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount5" class="form-control col-8 form-control-sm my-2 cyclic" value="" onchange="ck_total_amount()">
								@else
									<input type="text" name="subTotalAmount[]"  id="subTotalAmount5" class="form-control col-8 form-control-sm my-2 cyclic" value="{{number_format($KeiyakuPriceArray[4])}}" onchange="ck_total_amount()">
								@endif
							</td>
						</tr>
						<tr>
							<td colspan="3">契約金合計</td>
							<td>
								@if(isset($targetContract->keiyaku_kingaku_total))
									@if($targetContract->keiyaku_kingaku_total=="")
										<input type="text" name="TotalAmount" id="TotalAmount" class="form-control col-8 form-control-sm my-2 cyclic" value="">
									@else
									<input type="text" name="TotalAmount" id="TotalAmount" class="form-control col-8 form-control-sm my-2 cyclic" value="{{number_format($targetContract->keiyaku_kingaku_total)}}">
									@endif
								@else
									<input type="text" name="TotalAmount" id="TotalAmount" class="form-control col-8 form-control-sm my-2 cyclic" value="">
								@endif
							</td>
						</tr>
					</table>
				</div>
			</div>
					
				<p class="cyclic"><span class="auto-style2">*</span>お支払い方法・期間：</p>                      
				<p class="cyclic"><label><input name="HowPayRdio" id="HowPayRdio_genkin" type="radio" onchange="HowPayRdioManage()" value="現金" {!!optional($HowToPay)['cash']!!} class="cyclic"/>現金支払い</label>
				<select name="HowManyPaySlct" id="HowManyPaySlct" class="cyclic">
					{!!optional($HowManyPay)['CashSlct']!!}
				</select>回</p>
				<div class="auto-style1 cyclic"><span>1回目：<input name="DateFirstPay" id="DateFirstPay" type="date" value="{{optional($targetContract)->date_first_pay_genkin}}" class="cyclic"/><input type="text" name="AmountPaidFirst" id="AmountPaidFirst" class="form-control col-2 form-control-sm my-2 cyclic" value="{{optional($targetContract)->amount_first_pay_cash}}">円</span></div> 
				<p class="auto-style1 cyclic">2回目：<input name="DateSecondtPay" id="DateSecondtPay" type="date" value="{{optional($targetContract)->date_second_pay_genkin}}" class="cyclic"/><span>(<input type="text" name="AmountPaidSecond" id="AmountPaidSecond" class="form-control col-2 form-control-sm my-2 cyclic" value="{{optional($targetContract)->amount_second_pay_cash}}">円)</p>
				<p><label class="cyclic"><input name="HowPayRdio" id="HowPayRdio_card" type="radio" value="Credit Card" onchange="HowPayRdioManage()" {!!optional($HowToPay)['card']!!} class="cyclic"/>クレジットカード</label>　<label>カード会社</label>
				<select name="CardCompanyNameSlct" id="CardCompanyNameSlct">
					<option value="未選択">選択してください</option>
					{!!$CardCompanySelect!!}
				</select></p>
				<p class="cyclic"><label>
					<input name="HowmanyCard" id="HowmanyCard_OneTime" type="radio" value="一括" class="auto-style1 cyclic" onchange="HowPayRdioManage()" {!!optional($HowManyPay)['one']!!}/>一括支払い：支払日<input name="DatePayCardOneDay" id="DatePayCardOneDay" type="date" value="{{optional($targetContract)->date_pay_card}}" class="cyclic"/>
				
				</label></p>
				<p class="cyclic"><label>
					<input name="HowmanyCard" id="HowmanyCard_Bunkatsu" type="radio" value="分割" class="auto-style1 cyclic" onchange="HowPayRdioManage()" {!!optional($HowManyPay)['bunkatu']!!} style="width: 20px"/>分割支払
					<select name="HowManyPayCardSlct" id="HowManyPayCardSlct" class="cyclic">
						{!!$HowManyPay['CardSlct']!!}
					</select>回払い
				</label></p>                      
				<p>メモ：<textarea cols="20" name="memo" id="memo" rows="2" class="bg-white-500 text-black rounded px-3 py-1">{{optional($targetContract)->remarks}}</textarea></p>
				<p style="text-align: center">
					@if(optional($targetContract)->cancel===null)
						<button  class="btn btn-primary" type="submit" type="submit" onclick="return validate();">　　登　録　　</button>
					@else
						<button  class="btn btn-primary" type="submit" type="submit" onclick="return canceled_message();" style="background-color:gray">　　登　録　　</button>
					@endif
				</p>
				</form>
			<script>
				@if ($errors->any())
					alert("{{ implode('\n', $errors->all()) }}");
				@elseif (session()->has('success'))
					alert("{{ session()->get('success') }}");
				@endif
			</script>
            </div>
        {{-- </div> --}}
    </div>
@endsection