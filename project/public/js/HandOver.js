let require_group_error_msg="<br>「日報」、「申し送り」のどちらか１つは入力してください。";

$(function(){
  $("#del_btn").on('click', function() {
    $('#delConfirmModal').modal('hide');
  })
});

$(function(){
  $('#DispHandoverModal').on('show.bs.modal', function (event) {
    //削除確認モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    //モーダルを取得
    let modal_delConfirm = $(this);
    let serial,t_date,inputter,sentence,sbj;
    serial = button.data('serial');
    t_date = button.data('t_date');
    sentence = button.data('sentence');
    sentence = sentence.replace(/\n/, '<br>');
    inputter= button.data('inputter_name');
    sbj = button.data('sbj');
    modal_delConfirm.find('.modal-body span#serial').text(serial);
    modal_delConfirm.find('.modal-body span#t_date').text(t_date);
    modal_delConfirm.find('.modal-body span#InputterName').text(inputter);
    modal_delConfirm.find('.modal-body span#sbj').text(sbj);
    modal_delConfirm.find('.modal-body span#sentence').text(sentence);
    modal_delConfirm.find('.modal-header span#title').text(sbj);
  });
});

$(function(){
  $('#delConfirmModal').on('show.bs.modal', function (event) {
    //削除確認モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    //モーダルを取得
    let modal_delConfirm = $(this);
    let serial,t_date,type,remarks;
    serial = button.data('num');
    t_date = button.data('t_date');
    handover = button.data('handover_del');
    daily_report = button.data('daily_report_del');
    remarks = button.data('remarks_del');
    InputterName= button.data('inputter_name');
    document.getElementById("delTargetHandoverSerial_hdn").value=serial;
    modal_delConfirm.find('.modal-body span#serial').text(serial);
    modal_delConfirm.find('.modal-body span#t_date').text(t_date);
    modal_delConfirm.find('.modal-body span#InputterName').text(InputterName);
    modal_delConfirm.find('.modal-body span#handover_del').text(handover);
    modal_delConfirm.find('.modal-body span#daily_report_del').text(daily_report);
    modal_delConfirm.find('.modal-body span#remarks_del').text(remarks);
  });
});

function searchClearManage(){
    document.getElementById('payment_cbox').checked=true;
    document.getElementById('deposit_cbox').checked=true;
    document.getElementById('kensakukey_txt').value='';
    document.getElementById('month').value='';
    document.getElementById('date').value='';
}

function p_d_manage(){
  if(document.getElementById('payment_cbox').checked==false && document.getElementById('deposit_cbox').checked==false){
    document.getElementById('payment_cbox').checked=true;
    document.getElementById('deposit_cbox').checked=true;
  }
}

jQuery(document).ready(function($){
	$("#submitForm").validate({
		rules:{
      handover :  {require_group :true},
      daily_report :  { require_group :true},
      staff_slct:{required: true},
      target_date:{required: true,date: true}
		},
		messages: {
      handover: {required:require_group_error_msg},
      daily_report: {required:require_group_error_msg},
      staff_slct:{required: "<br>「入力者」を選択してください。"},
			target_date:{required: "<br>必須項目です。",date:"「日付」を入力してください。"}
	  },
	errorPlacement: function(error, element) {
			if(element.attr("name")=="target_date"){
				error.appendTo($('#target_date_for_error'));
			}else if(element.attr("name")=="staff_slct"){
				error.appendTo($('#staff_slct_for_error'));
			}else if(element.attr("name")=="handover"){
				error.appendTo($('#RequiredContent_for_error'));
			}else if(element.attr("name")=="daily_report"){
        if(document.getElementById('RequiredContent_for_error').textContent==""){
				  error.appendTo($('#RequiredContent_for_error'));
        }
			}else{
				error.insertAfter(element);
			}
		}
	});
});

$.validator.addMethod('require_group', function(value, element) {
  let handover=document.getElementById('handover').value;
  let daily_report=document.getElementById('daily_report').value;
	require_group_flg=true;
  /*
  if(!require_group_flg){
    return true;
  }else	
  */
  if((handover=="" || handover===undefined) && ( daily_report=="" || daily_report===undefined) ){
		require_group_flg=false;
	}
	return require_group_flg;
},  $.validator.format(require_group_error_msg));

$(function(){
  $('#CreateModal').on('show.bs.modal', function (event) {
	let id,manage_type,target_date,remarks;
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    let modal_obj = $(this);
    manage_type = button.data('manage');
    console.log("manage_type:"+manage_type);
    if(manage_type=='modyfy'){
      target_date=button.data('t_date');
      handover=button.data('handover');
      daily_report=button.data('daily_report');
      serial_staff=button.data('serial_staff');
      
      console.log("serial_staff="+serial_staff);
      modal_obj.find('.modal-body input#target_date').val(target_date);
      modal_obj.find('.modal-body textarea#handover').val(handover);
      modal_obj.find('.modal-body textarea#daily_report').val(daily_report);
      modal_obj.find('.modal-body select#staff_slct').val(serial_staff);
      remarks=button.data('remarks');
      modal_obj.find('.modal-body textarea#remarks').val(remarks);
      id=button.data('id');
      modal_obj.find('.modal-body input#id_txt').val(id);
      document.getElementById('serial_disp_none').style.display='';
      document.getElementById('modal_title').innerHTML='修正';
    }else{
      modal_obj.find('.modal-body input#target_date').val('');
      modal_obj.find('.modal-body select#staff_slct').val('');
      modal_obj.find('.modal-body textarea#handover').val('');
      modal_obj.find('.modal-body textarea#daily_report').val('');
      modal_obj.find('.modal-body textarea#remarks').val('');
      modal_obj.find('.modal-body span#id').text('');
      document.getElementById('serial_disp_none').style.display='none';
      document.getElementById('modal_title').innerHTML='新規';
    }
	});
});

$(function(){
   // モーダルの中の「ボタン1」を押した時の処理
    $("#submit_btn").on('click', function() {
      let id_txt=document.getElementById("id_txt").value;
      let staff_serial=document.getElementById("staff_slct").value;
      let target_date=document.getElementById("target_date").value;
      let handover=document.getElementById("handover").value;
      let remarks=document.getElementById("remarks").value;
      let daily_report=document.getElementById("daily_report").value;
      //console.log("handover 2="+handover);
      //console.log("daily_report 2="+daily_report);  
      if(target_date!='' && staff_serial!='' && (handover!='' || daily_report!='')){
        document.getElementById("CreateModal").close;
        $.ajax({
            url: "ajax_upsert_HandOver",
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'text', 
            scriptCharset: 'utf-8',
            frequency: 10,
            cache: false,
            async : false,
            data: {'id':id_txt,
              'target_date': target_date,
              'staff_serial': staff_serial,
              'handover': handover,
              'daily_report': daily_report,
              'remarks': remarks
            },
            headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
          }).done(function (data) {
            document.getElementById("CreateModal").close;
            alert('保存しました。');
          }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
            alert(XMLHttpRequest.status);
            alert(textStatus);
            alert(errorThrown);	
            alert('保存に失敗しました。');
          });
        }
    });
});
