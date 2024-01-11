var remove = 0;
function radioDeselection(already, numeric) {
	if(remove == numeric) {
		already.checked = false;
		remove = 0;
	} else {
		remove = numeric;
	}
}

function canceled_message(){
	alert("契約が解約されてます。保存できません。");
	return false;
}

function payment_manage() {
	var objs_PaymentAmount = document.getElementsByName('PaymentAmount[]');
	var objs_PaymentDate = document.getElementsByName('PaymentDate[]');
	var objs_VisitDate = document.getElementsByName('visitDate[]');
	
	const ary = [];
	for(let num = 0; num < objs_PaymentAmount.length; num++){
		var how_to_pay_flg=false;
		ary[num]=document.getElementsByName('HowToPay['+num+']');
		for(var i=0;i<ary[0].length;i++){
			if(ary[num][i].checked){
				how_to_pay_flg=true;
				break;
			}
		}

		if(objs_PaymentAmount[num].value!=="" && objs_PaymentDate[num].value!=="" && how_to_pay_flg==true){
			return_flg=true;
		}else if(objs_PaymentAmount[num].value=="" && objs_PaymentDate[num].value=="" && how_to_pay_flg==false){
			return_flg=true;
		}else{
			taget_num=num+1;
			if(objs_PaymentAmount[num].value==""){
				alert(taget_num+"ヶ月目の金額を入力してください。");
				return false;
			}else if(objs_PaymentDate[num].value==""){
				alert(taget_num+"ヶ月目の日付を入力してください。");
				return false;
			}else if(how_to_pay_flg===false){
				alert(taget_num+"ヶ月目の支払い方法を入力してください。");
				return false;
			}
		}
	}
	for(let num = 0; num < objs_VisitDate.length; num++){
		if(typeof objs_VisitDate[num+1] !== 'undefined'){
			var res_1=objs_VisitDate[num].value;
			var res_2=objs_VisitDate[num+1].value;
			if(res_1==="" && res_2!==""){
				return_flg=false;
				alert(String(num+1)+"回目の来店記録に誤りがあります。確認してください。");
				break;
			}
		}
	}
	return return_flg;
}