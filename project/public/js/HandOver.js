let require_group_error_msg="<br>「日報」、「申し送り」のどちらか１つは入力してください。";

window.onload = function(){
  document.getElementById("disp_non_customer").style.display="none";
  show_customers('');
	show_customers_order('');
	 $("#customer_slct_chosen").chosen({
    width: "250px",
    search_contains:true
  });
}

jQuery(document).ready(function($){
	$("#submitForm").validate({
		rules:{
            sentence: {required :true},
            staff_slct: {required: true},
            target_date: {required: true,date: true},
            HandOver_DaylyRepo_rbn: {required: true},
            customer_txt: {required:{
                depends: function (element) {
                        return $('#handover_rbn').is(':checked');
                    }
                }
            }
		},
		messages: {
            sentence: {required: "<br>必須項目です。"},
            customer_txt: {required:"顧客を選択してください。"},
			HandOver_DaylyRepo_rbn:{required: "<br>「日報」、「申し送り」のどちらか選択してください。"},
            staff_slct:{required: "「入力者」を選択してください。"},
            target_date:{required: "必須項目です。",date:"「日付」を入力してください。"}
	  	},
		errorPlacement: function(error, element) {
			if(element.attr("name")=="target_date"){
				error.appendTo($('#target_date_for_error'));
			}else if(element.attr("name")=="staff_slct"){
				error.appendTo($('#staff_slct_for_error'));
			}else if(element.attr("name")=="sentence"){
				error.appendTo($('#sentence_for_error'));
	        }else if(element.attr("name")=="HandOver_DaylyRepo_rbn"){
				error.appendTo($('#HandOver_DaylyRepo_rbn_for_error'));
	        }else{
		        error.insertAfter(element);
	        }
		}
        /*
		invalidHandler: function(event, validator) {
			// エラーがあるフィールドの数
			var errors = validator.numberOfInvalids();
			$('#error_flg_hdn').val(errors);
			if (errors) {
				$('#error_flg_hdn').val('1');
			} else {
				$('#error_flg_hdn').val('0');
			}
		}
        */        
    });
});

$(function(){
   // モーダルの中の「ボタン1」を押した時の処理
    $("#submit_btn").on('click', function() {
      let id_txt=document.getElementById("id_txt").value;
      let staff_serial=document.getElementById("staff_slct").value;
      let target_date=document.getElementById("target_date").value;
      let customer_serial='';
      //console.log("customer_serial_hdn="+$('#customer_serial_hdn').val());
      if($('#customer_serial_hdn').val()!==null){
        customer_serial=$('#customer_serial_hdn').val();
        }
        //console.log("customer_serial="+customer_serial);
      //let customer_serial=document.getElementById("customer_slct_chosen").value;
        let sentence=$('#sentence_txtarea').val();
        
      let remarks=document.getElementById("remarks").value;
	  let HandOver_DaylyRepo=$('input[name="HandOver_DaylyRepo_rbn"]:checked').val();
        //console.log("sentence="+sentence);
      /*
      console.log("HandOver_DaylyRepo="+HandOver_DaylyRepo);
	  
	  console.log("HandOver_DaylyRepo="+HandOver_DaylyRepo);
      if ($("#submitForm").valid()) {
            console.log("valid="+$("#submitForm").valid());
            alert("バリデーション成功！");
        } else {
            alert("バリデーション失敗！");
            console.log("valid="+$("#submitForm").valid());
        }
        */
    //if(target_date!='' && staff_serial!='' && sentence!==null && sentence!=='' && sentence!==undefined){
    if($("#submitForm").valid()){
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
              'customer_serial': customer_serial,
              'sentence': sentence,
              'type_flag': HandOver_DaylyRepo,
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

$(function(){
  $('#CreateModal').on('show.bs.modal', function (event) {
	let id,manage_type,target_date,remarks;
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    let modal_obj = $(this);
    manage_type = button.data('manage');
    //console.log("manage_type:"+manage_type);
    if(manage_type=='modyfy'){
      target_date=button.data('t_date');
      sentence=button.data('sentence');
      serial_staff=button.data('serial_staff');
	  type_flag=button.data('type_flag');
      
      console.log("type_flag="+type_flag);
      modal_obj.find('.modal-body input#target_date').val(target_date);
      modal_obj.find('.modal-body textarea#sentence_txtarea').val(sentence);
      modal_obj.find('.modal-body select#staff_slct').val(serial_staff);
	  $('input[name=HandOver_DaylyRepo_rbn]').val([type_flag]);
	  //modal_obj.find('.modal-body select#staff_slct').val(serial_staff);
      remarks=button.data('remarks');
      modal_obj.find('.modal-body textarea#remarks').val(remarks);
      id=button.data('id');
      modal_obj.find('.modal-body input#id_txt').val(id);
      document.getElementById('serial_disp_none').style.display='';
      document.getElementById('modal_title').innerHTML='修正';

    }else{
      modal_obj.find('.modal-body input#target_date').val('');
      modal_obj.find('.modal-body select#staff_slct').val('');
      modal_obj.find('.modal-body textarea#sentence_txtarea').val('');
      modal_obj.find('.modal-body textarea#HandOver_DaylyRepo_rbn').val('');
      modal_obj.find('.modal-body textarea#remarks').val('');
      modal_obj.find('.modal-body span#id').text('');
      document.getElementById('serial_disp_none').style.display='none';
      document.getElementById('modal_title').innerHTML='新規';
    }
	});
});

function set_customer_serial(obj){
    let customer_inf;
    document.getElementById("customer_serial_hdn").value=obj.value;
    if(obj.name=="customer_slct"){
        customer_inf = $('[name=customer_slct] option:selected').text();
        $('#customer_slct_chosen').val("").trigger('chosen:updated');
    }else{
      customer_inf = $('[name=customer_slct_chosen] option:selected').text();
        $('#customer_slct').val("");
    }
    let customer_inf_array = customer_inf.split(' ');
    let customer_name=customer_inf_array[0]+" "+customer_inf_array[1]+" "+customer_inf_array[2];
    document.getElementById("customer_txt").value=customer_name;
}

function type_manage(obj){
  if(document.getElementById("handover_rbn").checked){
    document.getElementById("disp_non_customer").style.display="";
  }else{
    $('#customer_slct_chosen').val("").trigger('chosen:updated');
    $('#customer_slct').val("");
    $('#customer_txt').val("");
    document.getElementById("disp_non_customer").style.display="none";
  }
}

$(function() {
 $("#chosen").chosen({
    width: "150px",
    search_contains:true
  });
});

$(function() {
 $(".chosen").chosen({
    width: "150px",
    search_contains:true
  });
});

function show_customers_order(customer_serial){
	$.ajax({
        url: "ajax_get_customer_slct_option_for_HandOver",
        type: 'post', // getかpostを指定(デフォルトは前者)
        dataType: 'json', 
        scriptCharset: 'utf-8',
        frequency: 10,
        cache: false,
        async : false,
        data: {
            'customer_serial': customer_serial
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (data) {
        let data_stringify = JSON.stringify(data);
        let data_json = JSON.parse(data_stringify);
        let customer_name
        $.each(data_json,
        	function(index, val) {
        		customer_name=val.serial+" "+val.name_sei+" "+val.name_mei+" "+val.name_sei_kana+" "+val.name_mei_kana
				$('#customer_slct_chosen_id').append($('<option>').val(val.serial).text(customer_name));
        	}
    	);
            
    }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        alert(XMLHttpRequest.status);
        alert(textStatus);
        alert(errorThrown);	
        alert('データ取得に失敗しました。');
    });
}

function show_customers(customer_serial){
  	$.ajax({
    	url: "ajax_make_customer_list_for_HandOver",
        type: 'post', // getかpostを指定(デフォルトは前者)
        dataType: 'text', 
        scriptCharset: 'utf-8',
        frequency: 10,
        cache: false,
        async : false,
        data: {
            'customer_serial': customer_serial
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    }).done(function (data) {
        $('#show_customers_list').append(data);
    }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        alert(XMLHttpRequest.status);
        alert(textStatus);
        alert(errorThrown);	
        alert('データ取得に失敗しました。');
    });
}

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
    type_flag = button.data('type_flag');
	type_customer_name = button.data('customer_name');
    modal_delConfirm.find('.modal-body span#serial').text(serial);
    modal_delConfirm.find('.modal-body span#t_date').text(t_date);
    modal_delConfirm.find('.modal-body span#InputterName').text(inputter);
    modal_delConfirm.find('.modal-body span#type_flag').text(type_flag);
    modal_delConfirm.find('.modal-body span#sentence').text(sentence);
    modal_delConfirm.find('.modal-header span#title').text(type_flag);
	modal_delConfirm.find('.modal-header span#target_customer_name').text(target_customer_name);
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

$.validator.addMethod('require_group', function(value, element) {
  let sentence=document.getElementById('sentence').value;
	require_group_flg=true;
    if((handover=="" || handover===undefined) && ( daily_report=="" || daily_report===undefined) ){
		require_group_flg=false;
	}
	return require_group_flg;
},  $.validator.format(require_group_error_msg));