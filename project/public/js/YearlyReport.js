function save_target_contract_money(obj){
	var result = prompt(obj.name+" の目標金額を入力してください。");

	if(result!==null){
		$.ajax({
			url: "/ajax_save_target_contract_money",
			type: 'post',
			dataType: 'text', 
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {'target_day': obj.name,'target_money': result},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
			//alert(data);
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
		//alert(result);
		document.getElementsByName(obj.name).value=result;
		const formatter = new Intl.NumberFormat('ja-JP');
		document.getElementById(obj.name+"-display").innerText = formatter.format(result);
		tasseiritu=parseInt(document.getElementById(obj.name+"-gokei").innerText, 10)/parseInt(result, 10)*100;
		tasseiritu=Math.round(tasseiritu*10)/10;
		document.getElementById(obj.name+"-tassei").innerText = tasseiritu;
	}
}