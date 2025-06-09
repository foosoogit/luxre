window.onload = function() {
	console.log("cookie3="+getCookie("ModalOpenFlg"));
	if(getCookie("ModalOpenFlg")!=="true"){
		const dt=ShowModal();
		const ReservationBirthdayModalBtn= document.getElementById('ReservationBirthdayModalBtn');
		ReservationBirthdayModalBtn.click();
		document.getElementById('Reservation').innerHTML = ModalData_Reservation ;
		document.getElementById('Birthday').innerHTML = ModalData_Birthday ;
	}
 }

function pass_ctrl(){
	let pass = window.prompt('パスワードを入力してください。');
	if(pass=='0927'){
		return true;
	}else{
		return false;
	}
}

 let ModalData_Reservation="";
 let ModalData_Birthday="";

 $(function(){
	$('#ReservationBirthdayModal').on('show.bs.modal', function (event) {
		//モーダルを開いたボタンを取得
		var button = $(event.relatedTarget);
		//モーダルを取得
		const dt=ShowModal();
		document.cookie = 'ModalOpenFlg=true';
		var modal_ReservationBirthday = $(this);
		//受け取った値をspanタグのとこに表示some
		document.getElementById('Reservation').innerHTML = ModalData_Reservation ;
		document.getElementById('Birthday').innerHTML = ModalData_Birthday ;
	});
  });

function ShowModal(){
	$.ajax({
		url: '/ajax_get_coming_soon_user',
		type: 'post', // getかpostを指定(デフォルトは前者)
		dataType: 'json', 
		scriptCharset: 'utf-8',
		frequency: 10,
		cache: false,
		async : false,
		data: {'Test': 'Test'},
		headers: {
			'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}
	}).done(function (data,dataType) {
		let data_stringify = JSON.stringify(data);
		let data_json = JSON.parse(data_stringify);
		ModalData_Reservation=data_json["Reservation"];
		ModalData_Birthday=data_json["Birthday"];
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});
	return;
}

function getCookie(name) {
	let matches = document.cookie.match(new RegExp(
	  "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
	));
	return matches ? decodeURIComponent(matches[1]) : undefined;
  }