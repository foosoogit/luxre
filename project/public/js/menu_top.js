window.onload = function() {
    // 実行したい処理
	//console.log("onload");
	//ShowPopup();
	//console.log("cookie1="+document.cookie); 
	console.log("cookie3="+getCookie("ModalOpenFlg"));
	
	/*
	let r = document.cookie.split(';');

	r.forEach(function(value) {
	var content = value.split('=');
		console.log( content[1] );
	})
	*/
	if(getCookie("ModalOpenFlg")!=="true"){
		const dt=ShowModal();
		const ReservationBirthdayModalBtn= document.getElementById('ReservationBirthdayModalBtn');
		ReservationBirthdayModalBtn.click();
		document.getElementById('Reservation').innerHTML = ModalData_Reservation ;
		document.getElementById('Birthday').innerHTML = ModalData_Birthday ;
		//const ReservationBirthdayModalBtn= document.getElementById('ReservationBirthdayModalBtn');
        //ReservationBirthdayModalBtn.click();
		/*
		const dt=ShowModal();
		document.cookie = 'ModalOpenFlg=true';
		var modal_ReservationBirthday = $(this);
		//受け取った値をspanタグのとこに表示some
		document.getElementById('Reservation').innerHTML = ModalData_Reservation ;
		document.getElementById('Birthday').innerHTML = ModalData_Birthday ;
		*/
		//alert('ページの読み込みが完了したよ！');
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
		//dataType: 'text', 
		//dataType: 'html', 
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
		//let data_id = data_json[0]["id"]; 
		//console.log("data_json="+data_json["Reservation"])
		ModalData_Reservation=data_json["Reservation"];
		ModalData_Birthday=data_json["Birthday"];
		//ModalData = JSON.parse(data);
		//console.log(ModalData);
		//ModalData=data;
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