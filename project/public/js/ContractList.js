/*
window.onload = function(){
  console.log("MedicalRecordsListBtn clicked1");
}
*/
let medical_records_inf;
/*
function p_d_manage(){
  if(document.getElementById('payment_cbox').checked==false && document.getElementById('deposit_cbox').checked==false){
    document.getElementById('payment_cbox').checked=true;
    document.getElementById('deposit_cbox').checked=true;
  }
}
*/

function contract_status_manage(){
  /*
  if(document.getElementById('contract_status_under').checked==false && document.getElementById('contract_status_cancellation').checked==false){
    document.getElementById('contract_status_under').checked=true;
    document.getElementById('contract_status_cancellation').checked=true;
  }
    */
}

function contract_type_manage(obj){
  /*
  console.log("name="+obj.name);
  if(document.getElementById('contract_type_subscription').checked==false && document.getElementById('contract_type_cyclic').checked==false){
    document.getElementById('contract_type_subscription').checked=true;
    document.getElementById('contract_type_cyclic').checked=true;
  }
    */
}

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
      medical_records_remarks=target_array[2];
      console.log("medical_records_file_date="+ medical_records_file_date);
      console.log("medical_records_remarks="+medical_records_remarks);
      medical_records_remarks=medical_records_remarks.replace(/"/g, '');
      medical_records_remarks=medical_records_remarks.replace(/]/g, '');
      if(medical_records_remarks!==''){
        medical_records_remarks='<br>'+medical_records_remarks;
      }
      medical_records_file_date=medical_records_file_date.replace(/"/g, '');
      medical_records_file_date=medical_records_file_date.replace(/]/g, '');
      const new_image = document.createElement("img");
      let new_div = document.createElement("div");
      new_div.innerHTML=medical_records_file_date;
      let url=base_url+medical_records_file_url;
      url=url.replace(/"/g, '');
      url=url.replace("[", '');
      url=url.replace("]", '');
      medical_records_file_date=medical_records_file_date.replace('"','');
      new_image.src = url;
      new_image.width = 300;
      new_image.style.margin = "5px";
      $('#medical_records_list_img').prepend('<figure> <img src="'+url+'" alt="'+medical_records_file_date+'" /><figcaption>'+medical_records_file_date+medical_records_remarks+'</figcaption></figure>');
      //$('#medical_records_list_img').prepend('<figure> <img src="'+url+'" alt="'+medical_records_file_date+'" /></figure>');
      //$('#medical_records_list_img').append('<figure><a href="'+url+'" target="_blank"><img src="'+url+'" alt="'+medical_records_file_date+'" /></a><figcaption>'+medical_records_file_date+'</figcaption></figure>');
    }
	});
});
