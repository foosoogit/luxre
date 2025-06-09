function ClearSerch(){
	document.getElementById("kensakukey_txt").value="";
}

function location_href(){
  //location.replace(location.href);
  window.location.reload(false);
  alert("更新しました。");
}

function delArert(targetUser){
	ary = targetUser.split(' ');
	let res=window.confirm( '登録番号: ' + ary[0]+'\n'+ ary[1]+' '+ary[2]+'さんのデータを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}

$(function(){
  $("#del_btn").on('click', function() {
    //console.log("delConfirmModal-2");
    $('#delConfirmModal').modal('hide');
  })
});

$(function(){
  $('#delConfirmModal').on('show.bs.modal', function (event) {
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    //モーダルを取得
    let modal_delConfirm = $(this);
    let visit_history_serial,num,sejyutu_naiyou,visit_date,name;
    name = button.data('name');
    
    num = button.data('num');
    //console.log("num="+num);
    sejyutu_naiyou = button.data('sejyutu_naiyou');
    sejyutusya= button.data('sejyutusya');
    //console.log("sejyutusya="+sejyutusya);
    visit_date = button.data('visit_date');
    visit_history_serial = button.data('visit_history_serial');
    //console.log("visit_history_serial="+visit_history_serial);
    document.getElementById("delTargetVisitHistorySerial_hdn").value=visit_history_serial;
    modal_delConfirm.find('.modal-body span#visit_date_d').text(visit_date);
    modal_delConfirm.find('.modal-body span#tr_d').text(sejyutu_naiyou);
    modal_delConfirm.find('.modal-body span#num_d').text(num);
    modal_delConfirm.find('.modal-body span#visit_date_d').text(visit_date);
    modal_delConfirm.find('.modal-body span#visit_history_serial_d').text(visit_history_serial);
    modal_delConfirm.find('.modal-body span#sejyutusya_d').text(sejyutusya);
    modal_delConfirm.find('.modal-body span#name_d').text(name);
    //console.log("name-2="+name);
  });
});

$(function(){
  //console.log("visit_date1="+document.getElementById("visit_date").value)
  // モーダルの中の「ボタン1」を押した時の処理
    $("#btn1").on('click', function() {
      //console.log("visit_date2="+document.getElementById("visit_date").value)
      let Tdate=document.getElementById("visit_date").value;
      let Tvisit_history_serial=document.getElementById("visit_history_serial").innerText;
      let Ttr_content=document.getElementById("tr_content_slct").value;
      //let Tpoint=document.getElementById("point").value;
      if(Ttr_content==0){
        alert("施術内容を選択してください。");
        return false;
      }
      //console.log("Ttr_content="+Ttr_content);
      $('#ModifyModal').modal('hide');
      $.ajax({
        url: "save_visit_data_ajax",
        type: 'post', // getかpostを指定(デフォルトは前者)
        dataType: 'text', 
        scriptCharset: 'utf-8',
        frequency: 10,
        cache: false,
        async : false,
        //data: {"Tdate": Tdate,"Tvisit_history_serial": Tvisit_history_serial,"Ttr_content":Ttr_content,"Tpoint":Tpoint},
        data: {"Tdate": Tdate,"Tvisit_history_serial": Tvisit_history_serial,"Ttr_content":Ttr_content},
        headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
      }).done(function (data) {
        location.replace(location.href);
        $msg= "修正しました。";
        //console.log("data 2 ="+data);
        if(data=="1"){
          $msg= "登録しました。";
        }
		  	alert($msg);
      }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        alert(XMLHttpRequest.status);
        alert(textStatus);
        alert(errorThrown);	
        alert('エラー');
      });
    });
});

function gettreatmentslct(target){
	  $.ajax({
			//url: '{{route("make_htm_get_treatment_slct_ajax")}}',
      url: 'make_htm_get_treatment_slct_ajax',
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
      document.getElementById("tr").innerHTML=data;
		}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
			alert(XMLHttpRequest.status);
			alert(textStatus);
			alert(errorThrown);	
			alert('エラー');
		});
}

$(function(){
  $('#ModifyModal').on('show.bs.modal', function (event) {
    let visit_history_serial,num,sejyutu_naiyou,visit_date,newSerial,name;
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    //モーダルを取得
    let modal_Yoyaku = $(this);
    name = button.data('name');
    newSerial=button.data('nserial');
    
    if(typeof newSerial === 'undefined'){
      num = button.data('num');
      //console.log('num-2='+num);
      sejyutu_naiyou = button.data('sejyutu_naiyou');
      sejyutusya= button.data('sejyutusya');
      //point = button.data('point');
      visit_date = button.data('visit_date');
      //console.log('visit_date-3='+visit_date);
      visit_history_serial = button.data('visit_history_serial');
      tr_html=gettreatmentslct(sejyutu_naiyou);
      
      modal_Yoyaku.find('.modal-body span#num').text(num);
      //modal_Yoyaku.find('.modal-body input#visit_date').val(visit_date);
      modal_Yoyaku.find('.modal-body span#visit_history_serial').text(visit_history_serial);
      modal_Yoyaku.find('.modal-body span#sejyutusya').text(sejyutusya);
      modal_Yoyaku.find('.modal-body input#visit_date').val(visit_date);
    }else{
      tr_html=gettreatmentslct('');
      let newSerial_array=newSerial.split('-');
      modal_Yoyaku.find('.modal-body span#num').text(newSerial_array[2]);
      modal_Yoyaku.find('.modal-body span#visit_history_serial').text(newSerial);
      modal_Yoyaku.find('.modal-body input#visit_date').val("");
    }
      //受け取った値をspanタグのとこに表示some
    modal_Yoyaku.find('.modal-body span#name').text(name);
  });
});