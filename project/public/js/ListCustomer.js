function ClearSerch(){
	document.getElementById("kensakukey_txt").value="";
}

function delArert(targetUser){
	ary = targetUser.split(' ');
	var res=window.confirm( '登録番号: ' + ary[0]+'\n'+ ary[1]+' '+ary[2]+'さんのデータを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}

$(function(){
  $('#AllConstractListuModal').on('show.bs.modal', function (event) {
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    let user_serial = button.data('serial');
    let user_name = button.data('name');
    console.log("user_serial="+user_serial);
    console.log("user_name="+user_name);  
    make_html_constracts_list(user_serial);
      //モーダルを取得
    //let modal_Yoyaku = $(this);
      //受け取った値をspanタグのとこに表示some
    var modal_AllConstractList = $(this);
    modal_AllConstractList.find('.modal-body span#serial_modal').text(user_serial);
    modal_AllConstractList.find('.modal-body span#name_modal').text(user_name);
    //modal_Yoyaku.find('.modal-body input#YoyakuDate').val(yoyaku_array[0]);
    //modal_Yoyaku.find('.modal-body input#YoyakuTime').val(yoyaku_array[1]);
  });
});

function make_html_constracts_list(user_serial){
  //console.log('user_serial = '+user_serial);
  $.ajax({
    url: "CustomersList/html_make_constracts_list_ajax",
    type: 'post', // getかpostを指定(デフォルトは前者)
    dataType: 'html', 
    scriptCharset: 'utf-8',
    frequency: 10,
    cache: false,
    async : false,
    data: {
      'target_serial_user': user_serial
    },
    headers: {
      'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
  }).done(function (data) {
    $("#contracts_list").append(data);
  }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
    alert(XMLHttpRequest.status);
    alert(textStatus);
    alert(errorThrown);	
    alert('摘要を取得できませんでした。');
  });
}

$(function(){
  $('#YoyakuModal').on('show.bs.modal', function (event) {
    //モーダルを開いたボタンを取得
    var button = $(event.relatedTarget);
    var watasuVal = button.data('watasu');
    var serial = button.data('serial');
    var name = button.data('name');
    //console.log("serial="+serial);
    yoyaku_array = watasuVal.split(' ');
      //モーダルを取得
    var modal_Yoyaku = $(this);
      //受け取った値をspanタグのとこに表示some
    modal_Yoyaku.find('.modal-body span#serial').text(serial);
    modal_Yoyaku.find('.modal-body span#name').text(name);
    modal_Yoyaku.find('.modal-body input#YoyakuDate').val(yoyaku_array[0]);
    modal_Yoyaku.find('.modal-body input#YoyakuTime').val(yoyaku_array[1]);
  });
});

$(function(){
// モーダルの中の「ボタン1」を押した時の処理
  $("#btn1").on('click', function() {
    $('#YoyakuModal').modal('hide');
    Tdate=document.getElementById("YoyakuDate").value;
    Ttime=document.getElementById("YoyakuTime").value;
    TargetDate=Tdate+" "+Ttime;
    //UserSerial=$('#YoyakuModal').text();
    UserSerial=document.getElementById("serial").textContent;
    //console.log("UserSerial-6="+UserSerial);  
    //console.log("TargetDate="+TargetDate);  
    $.ajax({
			url: "CustomersList/ajax_save_yoyaku_time",
			type: 'post', // getかpostを指定(デフォルトは前者)
			dataType: 'text', 
			scriptCharset: 'utf-8',
			frequency: 10,
			cache: false,
			async : false,
			data: {"TargetDate": TargetDate,"UserSerial": UserSerial},
			headers: {
				'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
			}
		}).done(function (data) {
			if(data=="changed"){
				window.location.reload();
        //document.location.reload();
        alert("修正しました。");
        
        //$('#yoyaku_btn_'+UserSerial).text(TargetDate);
			}
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
   /*
    var foodVal = $('#food').val();
    $('#re').text(foodVal);
*/
  });
});