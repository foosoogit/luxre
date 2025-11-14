/*
window.onload = function(){
  console.log("MedicalRecordsListBtn clicked1");
}
*/
let medical_records_inf;
//let target_URL;
//let url=ajax_get_Medical_records_file_name_by_customers
//let url=ajax_get_Medical_records_file_name_by_customers
function get_medical_records_file_url(contract_serial){
  $.ajax({
        //url: '{{route("ajax_get_Medical_records_file_name")}}',
        url:'ajax_get_Medical_records_file_name',
        type: 'POST', // getかpostを指定(デフォルトは前者)
        dataType: 'text', 
        scriptCharset: 'utf-8',
        frequency: 10,
        cache: false,
        async : false,
        data: {
            'contract_serial': contract_serial
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          //console.log("response="+response);
          medical_records_inf=response;
          //return "url" + response;
          //            callback(response);  // データが取れたらコールバック実行
        }
            
    }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        alert(XMLHttpRequest.status);
        alert(textStatus);
        alert(errorThrown);	
        alert('データ取得に失敗しました。');
    });
}

$(function(){
  $('#MedicalRecordFormModal').on('show.bs.modal', function (event) {
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    let modal_obj = $(this);
    let contract_serial = button.data('contractserial');
    //let flg= button.data('VisitHHistory');
    //if(flg=='VisitHHistory'){
    //  target_URL=
    //}
    //console.log("contract_serial="+contract_serial);
    
    get_medical_records_file_url(contract_serial);
    
    let customerserial=button.data('customerserial');
    modal_obj.find('.modal-body span#serial').text(customerserial);
    let customer_name = button.data('customer_name');
    modal_obj.find('.modal-body span#customer_name').text(customer_name);
    let contract_name = button.data('keiyaku_name');
    modal_obj.find('.modal-body span#contract_name').text(contract_name);
    let medical_records_inf_array=medical_records_inf.split(',');

    for (let i=0;i<medical_records_inf_array.length;i++){
      let target_array=medical_records_inf_array[i].split("|");
      medical_records_file_url=target_array[0];
      medical_records_file_date=target_array[1];
      medical_records_file_date=medical_records_file_date.replace(/"/g, '');
      medical_records_file_date=medical_records_file_date.replace(/]/g, '');
      const new_image = document.createElement("img");
      let new_div = document.createElement("div");
      //new_div.className='overlay-text';
      new_div.innerHTML=medical_records_file_date;
      let url=base_url+medical_records_file_url;
      url=url.replace(/"/g, '');
      url=url.replace("[", '');
      url=url.replace("]", '');
      medical_records_file_date=medical_records_file_date.replace('"','');
      new_image.src = url;
      new_image.width = 300;
      new_image.style.margin = "5px";
      //document.getElementById("medical_records_list_img").appendChild(new_div);
      //document.getElementById("medical_records_list_img").appendChild(new_image);


      //$('#medical_records_list_img').prepend('<figure> <img src="'+url+'" alt="'+medical_records_file_date+'" /><figcaption>'+medical_records_file_date+'</figcaption></figure>');
      $('#medical_records_list_img').append('<figure><a href="'+url+'" target="_blank"><img src="'+url+'" alt="'+medical_records_file_date+'" /></a><figcaption>'+medical_records_file_date+'</figcaption></figure>');
    }
    /*
    console.log("medical_records_file_url_array="+medical_records_file_url_array);
    document.getElementById("medical_records_list_img").innerHTML="";
    medical_records_file_url_array.forEach(function(value){
      const new_image = document.createElement("img");
      value.replace('[', '');
      new_image.src = base_url+value;

      new_image.width = 120;
      new_image.height = 90;
      new_image.style.margin = "5px";
      document.getElementById("medical_records_list_img").appendChild(new_image);
    })
    */
    //modal_obj.find('.modal-body span#medical_records_list_img').text(medical_records_file_url);
    //modal_obj.find('.modal-body span#medical_records_list_img').text(medical_records_file_url);

    
    
/*
    $.ajax({
        //url: '{{route("ajax_get_Medical_records_file_name")}}',
        url:'ajax_get_Medical_records_file_name',
        type: 'POST', // getかpostを指定(デフォルトは前者)
        dataType: 'text', 
        scriptCharset: 'utf-8',
        frequency: 10,
        cache: false,
        async : false,
        data: {
            'contract_serial': contract_serial
        },
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
          console.log("response="+response);
          url=response;
          //return "url" + response;
          //            callback(response);  // データが取れたらコールバック実行
        }
    //}).done(function(response) {
    //   callback(response);
    //}
    
    //}).done(function (data) {
     // console.log("data="+data);
    //  return data;
      //let img_url=data;
      //modal_obj.find('.modal-body span#medical_records_list_img').text(img_url);
    }) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
        alert(XMLHttpRequest.status);
        alert(textStatus);
        alert(errorThrown);	
        alert('データ取得に失敗しました。');
    });


*/
    
    //let medical_records_file_url
    //var result = work_sync('nanika');
    //let url=work_sync(contract_serial);
    //medical_records_file_url=get_medical_records_file_url(contract_serial);
    //console.log("url="+url);
    
    /*
    
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
      */
	});
});
/*
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
*/
