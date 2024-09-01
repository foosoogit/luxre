/*
$(function() {
	$('[data-toggle="tooltip"]').tooltip()
})
*/

function delArert(msg){
	//return false;
	//console.log("delArert");
	if(ck_pass()){
		var res=window.confirm( "データID: "+msg+'\n上記データを削除します。よろしいですか？');
		if(res){
			//console.log("true");
			return true;
		}else{
			//console.log("false");
			return false;
		}
	}

}

function set_read_only(obj){
	obj.readOnly=true;
}

$('.target_date').keypress(function(e) {
	console.log("keyCodee="+e.keyCode);
	if(e.keyCode === 13) {
		var focused = document.activeElement;
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
	}else if (e.key === "Escape"){
		console.log('Escape');
		focused.readOnly=true;	
	}
	focused.readOnly=true;
});

function DelRec(objid){
	$.ajax({
		url: 'admin/ajax_staff_dell_time_card',
		type: 'post', // getかpostを指定(デフォルトは前者)
		dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
		scriptCharset: 'utf-8',
		frequency: 10,
		cache: false,
		async : false,
		data: {"ObjId":objid},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function (data) {
		alert("削除しました。");
		reload();
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});
}

function ReleaseReadOnly(obj){
	if(obj.type=="text"){
		obj.readOnly=false;
		obj.focus();
	}else{
		if(obj.readOnly==true || obj.type=="button") {
			//if(obj.getElementsByTagName())
			if(ck_pass(obj)){
				obj.readOnly=false;
				obj.focus();	
			}
		}
	}
}

function ck_pass(obj){
	var res = prompt("パスワードを入力してください。");
	if(res!==""){
		var today = new Date();
		dy = ('0' + today.getDate()).slice(-2);
		mt=Number(today.getMonth())+1;
		mt=('0' + mt).slice(-2);
		ps=dy+mt;
		if(ps!==res){
			alert('パスワードが違います。');
			return false;
		}else{
			//obj.focus();
			//obj.readOnly=false;
			return true;
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
	document.getElementById("getTargetDate_fm").submit();
}