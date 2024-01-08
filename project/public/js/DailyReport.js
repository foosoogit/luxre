function delArert(msg){
	msg=msg.replace(/__/g, '\n');
	var res=window.confirm( msg+'\n上記データを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}

function SetSellingPrice(obj){
	//alert("test");
	//alert(obj.value);
	if(!obj.value==0){
		$.ajax({
			url: '/ajax_get_good_inf',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'serial_good': obj.value},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
			var json = JSON.stringify(data);
			var dt = JSON.parse(json);
			//alert(dt["SellingPrice"]);
			document.getElementById("selling_price").value=dt['SellingPrice'];
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
	}
}

function getTargetdata(obj){
	//alert('TEST');
	document.getElementById("getTargetDate_fm").submit();
}
