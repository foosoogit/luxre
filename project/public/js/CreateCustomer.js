﻿window.onload = function(){
	var saveFlg=document.getElementById("TorokuMessageFlg").value;
	reason_coming_sonota_manage();
	if(saveFlgArray[0]=="true"){
		if(saveFlgArray[1]=="new"){
			alert('登録しました。');
		}else{
			alert('修正しました。');
		}
		document.getElementById("TorokuMessageFlg").value="false";
	}
}

function SerchRefereeInf(){
	TargetSerial=document.getElementById("syokaisya_txt").value;;
	//console.log("obj="+obj);
	//console.log("TargetSerial="+TargetSerial);
	$.ajax({
		url: 'getCustomerInf',
		type: 'post', // getかpostを指定(デフォルトは前者)
		dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
		scriptCharset: 'utf-8',
		frequency: 10,
		cache: false,
		async : false,
		data: {'TargetSerial': TargetSerial},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function (data) {
		var json = JSON.stringify(data);
		var dt = JSON.parse(json);
		if(dt['count'] == 0){
			alert("登録されていません。");
		}else{
			alert("紹介者は "+dt["name_sei"]+" "+dt["name_mei"]+"さんです。");
		}
		//document.getElementById("selling_price").value=dt['SellingPrice'];
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});
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
	$("#input_customer_fm").validate({
		rules : {
			AdmissionDate: {
				required: true
			},
			name_sei: {
				required: true
			},
			name_mei: {
				required: true
			},
			name_sei_kana: {
				required: true
			},
			name_mei_kana: {
				required: true
			},
			GenderRdo: {
				required: true
			},
			email: {
				email: true
			},
			phone: {
				required: true,
				phone_vdt: true
			},
			region: {
				required: true
			},
			locality: {
				required: true
			}

		},
		messages: {
			AdmissionDate: {
				required: "「入会日」を入力してください。"
			},
			name_sei:{
				required: "「姓」を入力してください。"
			},
			name_mei:{
				required: "「名」を入力してください。"
			},
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
			},
			region: {
		        required: "&nbsp;「都道府県」を選択してください。"
			},
			locality: {
		        required: "&nbsp;「住所」を入力してください。"
			}
	  	},
		errorPlacement: function(error, element) {
			if (element.is(':radio, :checkbox')) {
				//alert("TEST");
				if(element.attr("name")=='GenderRdo'){
					error.appendTo($('#GenderRdo_for_error'));
					//error.appendTo(element.parent());
				}
			}else if(element.attr("name")=="AdmissionDate"){
				error.appendTo($('#AdmissionDate_for_error'));
			}else if(element.attr("name")=="phone"){
				error.appendTo($('#phone_for_error'));
			}else if(element.attr("name")=="name_sei"){
				error.appendTo($('#name_sei_for_error'));
			}else if(element.attr("name")=="name_mei"){
				error.appendTo($('#name_mei_for_error'));
			}else if(element.attr("name")=="name_sei_kana"){
				error.appendTo($('#name_sei_kana_for_error'));
			}else if(element.attr("name")=="name_mei_kana"){
				error.appendTo($('#name_mei_kana_for_error'));
			}else if(element.attr("name")=="email"){
				error.appendTo($('#email_for_error'));
			}else if(element.attr("name")=="region"){
				error.appendTo($('#region_for_error'));
			}else if(element.attr("name")=="locality"){
				error.appendTo($('#locality_for_error'));
			}else{
				error.insertAfter(element);
			}
		}
	});

	$.validator.addMethod('phone_vdt', function(value, element) {
		return this.optional(element) || /^[0-9\-]+$/.test(value);
 	},  $.validator.format("正しい電話番号を入力してください。<br>"));
	/*	
	$.validator.addMethod('presentation_title_vdt', function(value, element) {
		//alert(value.length);
		var target=$('[name="presentation_rbtn"]:checked').val();
		var flg=true;
		if(target=="Yes"){
			if(value.length>200 || value==""){
				flg=false;
			}
		}
		return flg;
		
 	},  $.validator.format("This field is required. And please enter no more than 200 characters."));
	
	$.validator.addMethod('abstract_tarea_vdt', function(value, element) {
		
		var target=$('[name="presentation_rbtn"]:checked').val();
		
		var flg=true;
		if(target=="Yes"){
			if(value.length>500 || value==""){
				flg=false;
			}
		}
		return flg;
		
 	},  $.validator.format("This field is required. And please enter no more than 500 characters."));
	
	$.validator.addMethod('invitation_letter_vdt', function(value, element) {
		var tgt = document.getElementsByName( "invitation_letter_rbtn" ) ;
		var str="";
		for (let i = 0; i < tgt.length; i++){
			if(tgt[i].checked){ //(color1[i].checked === true)と同じ
				str = tgt[i].value;
				break;
			}
		}
		var target_1=$('[name="pi_ci_rbtn"]:checked').val();
		var target_2=$('[name="invitation_letter_rbtn"]:checked').val();
		var flg=true;
		if(target_1!="Other"){
			if(str==""){
				flg=false;
			}else{
				flg=true;
			}
		}
		return flg;
 	},  $.validator.format("This field is required.<BR>"));
	
	$.validator.addMethod("tel", function(value, element){
		return this.optional(element) || /^[0-9+-]+$/.test(value);
	},"This field is Phone Number.");
  
	$.validator.addMethod("maxwords", function(value, element, params) { 
		var words_array=value.split(/[" ",",","."]/);
		var words_cnt=words_array.length;
		
		return this.optional(element) || params+1>words_cnt; 
	}, $.validator.format("Please enter no more than {0} words."));
	
	
	$.validator.addMethod("one_byte", function(value, element) {
    	return this.optional(element) || /^[0-9A-Za-z@! \s\-\#$\%&\'()\*\+\,\-\.\/\:\;\<\=\>\?\{\}\"]+$/.test(value);
	}, "one-byte character only");
	
	
	$.validator.addMethod("valueNotEquals", function(value, element, arg){
 		 return arg != value;
 	}, "Value must not equal arg.");

	$.validator.addMethod("alphabet", function(value, element) {
		//alert(value);
    	return this.optional(element) || /^[a-zA-Z0-9!#$%&()*+,.:;=?@\[\]^_{}-]+$/.test(value);
	}, "Alphabet only");
	*/
});