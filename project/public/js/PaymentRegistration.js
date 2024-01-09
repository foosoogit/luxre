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
	//console.log("TEST0");
	//console.log(objs_PaymentAmount.length);
	for(let num = 0; num < objs_PaymentAmount.length; num++){
		//console.log(num);
		var how_to_pay_flg=false;
		ary[num]=document.getElementsByName('HowToPay['+num+']');
		for(var i=0;i<ary[0].length;i++){
			//console.log(ary[num][i].value);
			//console.log(ary[num][i].checked);
			if(ary[num][i].checked){
				how_to_pay_flg=true;
				break;
			}
		}
		//console.log(objs_PaymentAmount[num].value);
		//console.log(objs_PaymentDate[num].value);
		//console.log(how_to_pay_flg);

		if(objs_PaymentAmount[num].value!=="" && objs_PaymentDate[num].value!=="" && how_to_pay_flg==true){
			return_flg=true;
		}else if(objs_PaymentAmount[num].value=="" && objs_PaymentDate[num].value=="" && how_to_pay_flg==false){
			return_flg=true;
		}else{
			taget_num=num+1;
			//console.log("num="+num);
			if(objs_PaymentAmount[num].value==""){
				//console.log(taget_num+"ヶ月目の金額を入力してください。");
				alert(taget_num+"ヶ月目の金額を入力してください。");
				return false;
			}else if(objs_PaymentDate[num].value==""){
				//console.log(taget_num+"ヶ月目の日付を入力してください。");
				alert(taget_num+"ヶ月目の日付を入力してください。");
				return false;
			}else if(how_to_pay_flg===false){
				//console.log(taget_num+"ヶ月目の支払い方法を入力してください。");
				alert(taget_num+"ヶ月目の支払い方法を入力してください。");
				return false;
			}
		}
	}
	//VisitDate_flg=true;
	for(let num = 0; num < objs_VisitDate.length; num++){
		//console.log(num);
		//alert(String(i)+"回目の来店記録に誤りがあります。確認してください。");
		//if(res===""){alert('null');}

		//alert(document.getElementById('visitDateId[0]').value);
		//console.log(res);
		//console.log(typeof objs_VisitDate[num+1]);
		if(typeof objs_VisitDate[num+1] !== 'undefined'){
			var res_1=objs_VisitDate[num].value;
			var res_2=objs_VisitDate[num+1].value;

			//console.log(res_1);
			//console.log(res_2);
			if(res_1==="" && res_2!==""){
				return_flg=false;
				alert(String(num+1)+"回目の来店記録に誤りがあります。確認してください。");
				break;
			}
		}
		//var how_to_pay_flg=false;
		//ary[num]=document.getElementsByName('HowToPay['+num+']');
		//alert("回目の来店記録に誤りがあります。確認してください。");

		/*
		for(var i=0;i<ary[0].length;i++){
			//console.log(ary[num][i].value);
			//console.log(ary[num][i].checked);
			
		}
		*/
		//console.log(objs_PaymentAmount[num].value);
		//console.log(objs_PaymentDate[num].value);
		//console.log(how_to_pay_flg);
	}
	//console.log("TEST1");
	return return_flg;
}