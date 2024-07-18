function delArert(msg){
	msg=msg.replace(/__/g, '\n');
	var res=window.confirm( msg+'\n上記データを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}
/*
time_in.addEventListener('keydown', (e) => {
	if(e.keyCode === 13) {
	  //message.innerText = '確定'
	  console.log('確定');
	}
})
*/
$('.target_date').keypress(function(e) {
	//console.log("keyCode="+e.keyCode);
	if(e.keyCode === 13) {
		//alert("key=Enter");
		var focused = document.activeElement;
		//console.log("Id="+focused.id);
		$.ajax({
			url: 'admin/ajax_staff_change_time_card',
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {"TargetObj": focused.id,"Value":focused.value},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
			if(data=="changed"){
				alert("修正しました。");	
			}
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
	}
	focused.readOnly=true;
});

/*
function ChangeDat(obj){
	//alert("Change");
	console.log('ObjId4='+obj.id)
	$.ajax({
		url: 'admin/ajax_staff_change_time_card',
		type: 'post', // getかpostを指定(デフォルトは前者)
		dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
		scriptCharset: 'utf-8',
		frequency: 10,
		cache: false,
		async : false,
		data: {"SerialInOut": obj.value,"ObjId":obj.id},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function (data) {
		//var json = JSON.stringify(data);
		//var dt = JSON.parse(json);
		//alert(dt["SellingPrice"]);
		document.getElementById("selling_price").value=dt['SellingPrice'];
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});
	obj.readOnly=true;
}
*/
function ReleaseReadOnly(obj){
	//var targetid = document.getElementById(obj.Id);
	//console.log("Name="+obj.name);
	//var typ = obj.type;
	console.log("type="+obj.type);
	if(obj.type=="text"){
		obj.readOnly=false;
		obj.focus();
	}else{
		if(obj.readOnly==true){
			if(obj.getElementsByTagName())
			var res = prompt("パスワードを入力してください。");
			if(res!==""){
				var today = new Date();
				dy = ('0' + today.getDate()).slice(-2);
				mt=Number(today.getMonth())+1;
				mt=('0' + mt).slice(-2);
				//alert(dy+mt);
				ps=dy+mt;
				if(ps!==res){
					alert('パスワードが違います。');
				}else{
					obj.readOnly=false;
					obj.focus();
				}
			}
		}
	}
}

function SetReadOnly(obj){
	obj.readOnly=true;
}

//function open_SetSellingPrice(obj)
$(function() {
	$('#time_in').datetimepicker({
    	language: 'pt-BR'
    });
});

$(function() {
	// 入力ダイアログを表示
	$(".modification").click(function() {
	  //console.log('test');
		$("#input").dialog("open");
	  return false;
	});
	$("#input").dialog({
		autoOpen: false,
		modal: true,
		buttons: {
		  "ＯＫ": function() {
			displayMessage("保存しました。（ ID："
			  + $("#inputId").val()
			  + "、名前："
			  + $("#inputName").val()
			  + " ）");
			$(this).dialog("close");},
		  "キャンセル": function() {
			displayMessage("キャンセルしました。");
			$(this).dialog("close");}
		}
	  });
	});

	function displayMessage(str) {
		$("#info").html(str);
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
