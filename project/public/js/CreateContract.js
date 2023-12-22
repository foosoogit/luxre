window.onload = function(){
	contract_type_manage();
}

function contract_type_manage(){
    subscription_obj=document.getElementById("contract_type_subscription");
    cyclic_obj=document.getElementById("contract_type_cyclic");
	var obj_subsc_array = document.getElementsByClassName("subsc");
	var obj_cyclic_array = document.getElementsByClassName("cyclic");
	var CyclicDipNon='';
	if(subscription_obj.checked==true){
		CyclicDipNon='none';
		for(var i=0;i<obj_cyclic_array.length;i++){
			obj_cyclic_array[i].disabled = subscription_obj.checked;
			if(obj_cyclic_array[i].type=="text"){
				//obj_cyclic_array[i].value="";
			}else if(obj_cyclic_array[i].nodeName=="SELECT"){
				obj_cyclic_array[i].options[0].selected=true;
			}else if(obj_cyclic_array[i].nodeName=="TABLE" || obj_cyclic_array[i].nodeName=="P" || obj_cyclic_array[i].nodeName=="DIV" || obj_cyclic_array[i].nodeName=="DATE" || obj_cyclic_array[i].nodeName=="LABEL"){
				obj_cyclic_array[i].style.display=CyclicDipNon;
			}
		}
	}else{
		for(var i=0;i<obj_subsc_array.length;i++){
			obj_subsc_array[i].disabled = cyclic_obj.checked;
			if(obj_subsc_array[i].type=="text"){
				//obj_subsc_array[i].value="";
			}else if(obj_subsc_array[i].nodeName=="SELECT"){
				obj_subsc_array[i].options[0].selected=true;
			}else if(obj_subsc_array[i].nodeName=="TABLE" || obj_subsc_array[i].nodeName=="P" || obj_subsc_array[i].nodeName=="DIV" || obj_subsc_array[i].nodeName=="DATE" || obj_subsc_array[i].nodeName=="LABEL"){
				obj_subsc_array[i].style.display=CyclicDipNon;
			}
		} 
	}
	for(var i=0;i<obj_subsc_array.length;i++){
		obj_subsc_array[i].disabled = !subscription_obj.checked;
	}
	/*
	for(var i=0;i<obj_cyclic_array.length;i++){
		obj_cyclic_array[i].disabled = subscription_obj.checked;
		if(obj_cyclic_array[i].type=="text"){
			obj_cyclic_array[i].value="";
		}else if(obj_cyclic_array[i].nodeName=="SELECT"){
			obj_cyclic_array[i].options[0].selected=true;
		}else if(obj_cyclic_array[i].nodeName=="TABLE" || obj_cyclic_array[i].nodeName=="P" || obj_cyclic_array[i].nodeName=="DIV" || obj_cyclic_array[i].nodeName=="DATE" || obj_cyclic_array[i].nodeName=="LABEL"){
			obj_cyclic_array[i].style.display=CyclicDipNon;
		}
	}
	*/
}

function ContractNaiyoSlctManage(obj){
	var num = obj.id.replace(/[^0-9]/g, '');
	var objId='ContractNaiyo'+num;
	document.getElementById(objId).value=obj.value;
}

function reason_coming_sonota_manage(){
	console.log('reason_coming_sonota_manage');
	if(document.getElementById("reason_coming_cbx_sonota").checked==true){
		document.getElementById("reason_coming_txt").disabled=false;
	}else{
		document.getElementById("reason_coming_txt").disabled=true;
		document.getElementById("reason_coming_txt").value="";
	}
}

jQuery(document).ready(function($){
	console.log("test");
	$("#ContractFm").validate({
		rules : {
			ContractsDate: {
				required: true
			},
			ContractName: {
				required: true
			},
			staff_slct: {
				required: true
			},
			ContractsDateStart: {
				required: true
			},
			contract_type: {
				required: true
			},
			
			inpMonthlyAmount: {
				required: "#contract_type_subscription:checked"
			},
			/*,
			inpTotalAmount: {
				required: "#contract_type_cyclic:checked"
			},

			TreatmentsTimes_slct: {
				required: "#contract_type_cyclic:checked"
			},
			"ContractNaiyoSlct[0]":{
				required: "#contract_type_cyclic:checked"
			},
			"KeiyakuNumSlct[0]":{
				required: "#contract_type_cyclic:checked"
			},
			HowPayRdio:{
				required: "#contract_type_cyclic:checked"
			}
			*/
		},
		messages: {
			ContractsDate: {
				required: "「契約締結日」を入力してください。"
			},
			ContractName: {
				required: "「契約名」を入力してください。"
			},
			staff_slct: {
				required: "「担当者」を選択してください。"
			},
			ContractsDateStart:{
				required: "「役務契約開始期間」を入力してください。"
			},
			contract_type:{
				required: "「契約形態」を選択してください。"
			},
			inpMonthlyAmount:{
				required: "「支払金額/月」を入力してください。"
			},
			/*,
			name_sei_kana:{
				required: "「せい」を入力してください。"
			},
			name_mei_kana:{
				required: "「めい」を入力してください。"
			},
			GenderRdo:{
				required: "&nbsp;「性別」を選択してください。"
			},
			email: {
				email: "&nbsp;正しいemailを入力してください。"
			},
			phone: {
		        required: "&nbsp;「電話番号」を入力してください。"
			}
			*/
	  	},
		errorPlacement: function(error, element) {
			if (element.is(':radio, :checkbox')) {
				//alert("TEST");
				if(element.attr("name")=='contract_type'){
					error.appendTo($('#contract_type_for_error'));
					//error.appendTo(element.parent());
				}
			}else if(element.attr("name")=="ContractsDate"){
				error.appendTo($('#ContractsDate_for_error'));
			}else if(element.attr("name")=="ContractName"){
				error.appendTo($('#ContractName_for_error'));
			}else if(element.attr("name")=="staff_slct"){
				error.appendTo($('#staff_slct_for_error'));
			}else if(element.attr("name")=="ContractsDateStart"){
				error.appendTo($('#ContractsDateStart_for_error'));
			}else if(element.attr("name")=="inpMonthlyAmount"){
				error.appendTo($('#inpMonthlyAmount_for_error'));
			}else if(element.attr("name")=="name_mei_kana"){
				error.appendTo($('#name_mei_kana_for_error'));
			}else if(element.attr("name")=="email"){
				error.appendTo($('#email_for_error'));
			}else{
				error.insertAfter(element);
			}
		}
	});

	$.validator.addMethod('phone_vdt', function(value, element) {
		return this.optional(element) || /^[0-9\-]+$/.test(value);
 	},  $.validator.format("正しい電話番号を入力してください。<br>"));

});

function getTodayForTypeDate() {
    var today = new Date();
    today.setDate(today.getDate());
    var yyyy = today.getFullYear();
    var mm = ("0"+(today.getMonth()+1)).slice(-2);
    var dd = ("0"+today.getDate()).slice(-2);
    return yyyy+'-'+mm+'-'+dd;
}

function cancel_validate(){
	console.log(document.getElementById("KaiyakuDate").value);
	if(document.getElementById("KaiyakuDate").value==""){
		alert("解約日を入力してください。");
		return false;
	}else{
		let pass = window.prompt('パスワードの入力');
		if(pass=='0927'){
			return true;
		}else{
			alert("パスワードが違います。");
			return false;
		}
	}
	return true;
}

function modosu_cancel(){
	//console.log(document.getElementById("KaiyakuDate").value);
	let pass = window.prompt('パスワードの入力');
	if(pass=='0927'){
		return true;
	}else{
		alert("パスワードが違います。");
		return false;
	}
}

function canceled_message(){
	//console.log(document.getElementById("KaiyakuDate").value);
	alert("契約が解約されてます。保存できません。");
	return false;
}

function HowPayRdioManage(){
	var today = new Date();
	var HowPay=document.getElementsByName("HowPayRdio").value;
	console.log(document.getElementById("HowPayRdio_genkin").checked);
	if(document.getElementById("HowPayRdio_genkin").checked==true){
		document.getElementById("HowManyPaySlct").disabled=false;
		document.getElementById("DateFirstPay").disabled=false;
		document.getElementById("DateFirstPay").value=getTodayForTypeDate();
		document.getElementById("DateSecondtPay").disabled=false;

		document.getElementById("CardCompanyNameSlct").selectedIndex=0;
		document.getElementById("CardCompanyNameSlct").disabled=true;

		document.getElementById("HowmanyCard_OneTime").checked=false;
		document.getElementById("HowmanyCard_OneTime").disabled=true;

		document.getElementById("DatePayCardOneDay").disabled=true;
		document.getElementById("DatePayCardOneDay").value="yyyy/mm/dd";
		
		document.getElementById("HowmanyCard_Bunkatsu").checked=false;
		document.getElementById("HowmanyCard_Bunkatsu").disabled=true;
		document.getElementById("HowManyPayCardSlct").selectedIndex=0;
		document.getElementById("HowManyPayCardSlct").disabled=true;
	}else{
		document.getElementById("HowManyPaySlct").selectedIndex=0;
		document.getElementById("HowManyPaySlct").disabled=true;

		document.getElementById("DateFirstPay").disabled=true;
		document.getElementById("DateFirstPay").value="yyyy/mm/dd";
		document.getElementById("AmountPaidFirst").value="";
		document.getElementById("AmountPaidSecond").value="";
		document.getElementById("DateSecondtPay").disabled=true;

		document.getElementById("CardCompanyNameSlct").disabled=false;
		document.getElementById("CardCompanyNameSlct").selectedIndex=0;

		document.getElementById("HowmanyCard_OneTime").disabled=false;
		
		document.getElementById("DatePayCardOneDay").disabled=false;
		document.getElementById("DatePayCardOneDay").value=getTodayForTypeDate();
		
		document.getElementById("HowmanyCard_Bunkatsu").disabled=false;
		document.getElementById("HowManyPayCardSlct").disabled=false;
		if(document.getElementById("HowmanyCard_OneTime").checked==true){
			document.getElementById("DatePayCardOneDay").disabled=false;
			document.getElementById("DatePayCardOneDay").value=getTodayForTypeDate();
			
			document.getElementById("HowManyPayCardSlct").disabled=true;
			document.getElementById("HowManyPayCardSlct").selectedIndex=0;
		}else{
			document.getElementById("DatePayCardOneDay").disabled=true;
			document.getElementById("DatePayCardOneDay").value="yyyy/mm/dd";			
			document.getElementById("HowManyPayCardSlct").disabled=false;
		}
	}
	
	if(HowPay=="現金"){
		var ElementsCount = document.getElementById(getTodayForTypeDate()).elements.length;
		for( i=0 ; i<ElementsCount ; i++ ) {
			document.getElementById("HowmanyCard").elements[i].checked = false;
		}
		
		document.getElementById("DateFirstPay").value=today;
	}
	document.getElementById("TotalAmount").value=total;
	ck_total_amount();
	/*
	if(inpTotalAmount!==total){
		alert("契約金合計金額が合いません。確認してください。");
	}
	*/
}

function removeComma(number) {
    var removed = number.replace(/,/g, '');
    return parseInt(removed, 10);
}

function addComma(obj) {
	//alert(obj.value);
	var NoComma=removeComma(obj.value)
	//alert(NoComma);	
	if(isNaN(NoComma)){
		obj.value='';
	}else{
		var money=Number(removeComma(obj.value));
	    //alert(removeComma(obj.value));
	    moneyComma=NoComma.toLocaleString();
	    //alert(moneyComma);
	    obj.value=moneyComma;
    }
}

document.getElementById('submit').onclick = function() {
    var radio = document.querySelector('input[type=radio][name=language]:checked');
    radio.checked = false;
}

function total_amount(){
	//alert("Test");
	var KeiyakuNum=document.getElementsByName("KeiyakuNumSlct[]");
	var AmountPerNum=document.getElementsByName("AmountPerNum[]");
	var subTotalAmount=document.getElementsByName("subTotalAmount[]");
	var ContractNaiyo=document.getElementsByName("ContractNaiyo[]");
	var total=0;

	for(i=0;i<5;i++){
		//alert(ContractNaiyo[i].value);	
		if(ContractNaiyo[i].value==""){break;}
		subtotal_cal=Number(removeComma(KeiyakuNum[i].value))*Number(removeComma(AmountPerNum[i].value));
		total=total+subtotal_cal;
		subTotalAmount[i].value=subtotal_cal.toLocaleString();
	}
	document.getElementById("TotalAmount").value=total.toLocaleString();
}

function ck_total_amount(){
	//console.log(ContractNaiyo[1].value);
	/*
	var total=document.getElementById("TotalAmount").value;
	var inpTotalAmount=document.getElementById("inpTotalAmount").value;
	if(inpTotalAmount!==total &&total!=="" ){
		alert("契約金合計金額が合いません。確認してください。");
	}
	*/
}