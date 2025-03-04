var remove = 0;
function radioDeselection(already, numeric) {
	if(remove == numeric) {
		already.checked = false;
		remove = 0;
	} else {
		remove = numeric;
	}
}

$(function(){
	// モーダルの中の「ボタン1」を押した時の処理
	  $("#btn1").on('click', function() {

		let Tdate=document.getElementById("payment_date").value;
		let Tpayment_history_serial=document.getElementById("payment_history_serial").innerText;
		let Tmethod_slct=document.getElementById("method_slct").value;
		let Tamount=document.getElementById("amount").value;
		if(Tmethod_slct==0){
			alert("施術内容を選択してください。");
			return false;
		}
		$('#ModifyModal').modal('hide');
		$.ajax({
		  url: "save_payment_history_ajax",
		  type: 'post', // getかpostを指定(デフォルトは前者)
		  dataType: 'text', 
		  scriptCharset: 'utf-8',
		  frequency: 10,
		  cache: false,
		  async : false,
		  data: {"payment_date": Tdate,"payment_history_serial": Tpayment_history_serial,"method":Tmethod_slct,"amount":Tamount},
		  headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
		}).done(function (data) {
			location.replace(location.href);
			$msg= "修正しました。";
			console.log("data="+data);
			if(data=="1"){
				$msg= "登録しました。";
			}
		  	alert($msg);
		  //let iframe = document.getElementById('sub_VisitHistory');
		  //iframe.contentWindow.location.reload(true);
		  //window.location.reload(false);
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		  alert(XMLHttpRequest.status);
		  alert(textStatus);
		  alert(errorThrown);	
		  alert('エラー');
		});
	  });
  });

function getPaymentMethodSlct(target){
	$.ajax({
		  //url: '{{route("make_htm_get_treatment_slct_ajax")}}',
		url: 'make_htm_get_payment_method_slct_ajax',
		  type: 'post', // getかpostを指定(デフォルトは前者)
		  dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
		  scriptCharset: 'utf-8',
		  frequency: 10,
		  cache: false,
		  async : false,
		  data: {'target': target},
		  headers: {
			  'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		  }
	  }).done(function (data) {
		document.getElementById("method").innerHTML=data;
	  }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		  alert(XMLHttpRequest.status);
		  alert(textStatus);
		  alert(errorThrown);	
		  alert('エラー');
	  });
}

$(function(){
	$('#ModifyModal').on('show.bs.modal', function (event) {

	  //モーダルを開いたボタンを取得
	  let button = $(event.relatedTarget);
	  //モーダルを取得
	  let modal_payment = $(this);
	  let payment_history_serial,num,payment_date,newSerial,name,payment_method;
	  name = button.data('name');
	  newSerial=button.data('nserial');
	  if(typeof newSerial === 'undefined'){
		num = button.data('num');
		payment_date = button.data('payment_date');
		payment_history_serial = button.data('payment_history_serial');
		payment_method=button.data('method');
		amount=button.data('amount');
		//console.log("payment_method="+payment_method);
		method_html=getPaymentMethodSlct(payment_method);
		modal_payment.find('.modal-body input#payment_date').val(payment_date);
		modal_payment.find('.modal-body input#amount').val(amount);
		modal_payment.find('.modal-body span#num').text(num);
		modal_payment.find('.modal-body span#payment_history_serial').text(payment_history_serial);
	  }else{
		method_html=getPaymentMethodSlct('');
		modal_payment.find('.modal-body span#payment_history_serial').text(newSerial);
		let newSerial_array=newSerial.split('-');
		//console.log('num='+newSerial_array[2]);
		modal_payment.find('.modal-body span#num').text(newSerial_array[2]);
	  }
		//受け取った値をspanタグのとこに表示some
	  modal_payment.find('.modal-body span#name').text(name);
	});
  });

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