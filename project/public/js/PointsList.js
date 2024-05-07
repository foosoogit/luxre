function clear_serch(){
	document.getElementById('search_key').value='';
	document.getElementById('target_day').value='';
}
function point_digestion(target_id){
    //var points=prompt("ポイント数を入力してください。");
	const el_digestion_btn=document.getElementById('point_digestion_btn_'+target_id);
	const el_point_btn=document.getElementById('change_point_btn_'+target_id);
    if(window.confirm("ポイントを"+el_digestion_btn.value+"します。よろしいですか？")){
        $.ajax({
			url: 'ajax_digestion_point',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'target_id': target_id},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (set_flg) {
			//msg="復元";
			console.log("set_flg="+set_flg)
			if(set_flg=="false"){
				msg="復元しました。";
				vl="消化";
				el_digestion_btn.className = 'btn btn-warning  btn-sm';
				el_point_btn.readOnly = false;
				el_point_btn.className = 'btn btn-info btn-sm';
				
			}else if(set_flg=="true"){
				msg="消化しました。";
				vl="復元";
				el_digestion_btn.className = 'btn btn-outline-warning btn-sm';
				el_point_btn.readOnly = true;
				el_point_btn.className = 'btn btn-light btn-sm';
			}
            el_digestion_btn.value=vl;
			alert(msg);
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
	}
}

function change_point(target_id){
    var points=prompt("ポイント数を入力してください。");
    if(points!==null){
        $.ajax({
			url: 'ajax_change_point',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'target_id': target_id,'points':points},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
            document.getElementById('change_point_btn_'+target_id).value=points;
			alert("修正しました。");
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
	}
}
function SerchRefereeInf(obj){

	if(obj.value.length==6){
		$.ajax({
			url: 'getCustomerInf',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'TargetSerial': obj.value},
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
	}else if(obj.value.length>6){
		alert("登録されていません。");
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
});