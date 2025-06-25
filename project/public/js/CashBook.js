function kakunin_msg(){

}

function searchClearManage(){
    document.getElementById('payment_cbox').checked=true;
    document.getElementById('deposit_cbox').checked=true;
    document.getElementById('kensakukey_txt').value='';
    document.getElementById('month').value='';
    document.getElementById('date').value='';
    console.log("searchClearManage");
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
			payment_deposit_rdo:{required: true},
      target_date:{required: true,date: true},
      summary:{required: true},
      amount:{required: true,number: true}
		},
		messages: {
			payment_deposit_rdo:{required: "<br>「入出金」を選択してください。"},
			target_date:{required: "必須項目です。",date:"「日付」を入力してください。"},
      summary:{required: "「摘要」を入力してください。"},
      amount:{required: "金額を入力して下さい。",number:"数値を入力してください。"}
	  },
		errorPlacement: function(error, element) {
			//console.log("element.attr name="+element.attr("name"));
      if (element.is(':radio, :checkbox')) {
				if(element.attr("name")=='payment_deposit_rdo'){
					error.appendTo($('#payment_deposit_rdo_for_error'));
				}
			}else if(element.attr("name")=="target_date"){
				error.appendTo($('#target_date_for_error'));
			}else if(element.attr("name")=="summary"){
				error.appendTo($('#summary_for_error'));
			}else if(element.attr("name")=="amount"){
				error.appendTo($('#amount_for_error'));
			}else{
				error.insertAfter(element);
			}
		}
	});
});

$(function(){
  $('#CreateModal').on('show.bs.modal', function (event) {
	let id,manage_type,summary,target_date,amount,remarks;
    //モーダルを開いたボタンを取得
    let button = $(event.relatedTarget);
    let modal_obj = $(this);
    manage_type = button.data('manage');
    if(manage_type=='modyfy'){
      target_date=button.data('t_date');target_date
      modal_obj.find('.modal-body input#target_date').val(target_date);
      in_out=button.data('in_out');
      summary=button.data('summary');
      modal_obj.find('.modal-body input#summary').val(summary);
      amount=button.data('payment');
      document.getElementById('payment').checked=true;
      if (!amount) {
        amount=button.data('deposit');
        document.getElementById('deposit').checked=true;
      }
      modal_obj.find('.modal-body input#amount').val(amount);
      remarks=button.data('remarks');
      modal_obj.find('.modal-body textarea#remarks').val(remarks);
      id=button.data('id');
      modal_obj.find('.modal-body input#id_txt').val(id);
      document.getElementById('serial_disp_none').style.display='';
      document.getElementById('modal_title').innerHTML='修正';
    }else{
      modal_obj.find('.modal-body input#target_date').val('');
      modal_obj.find('.modal-body input#summary').val('');
      modal_obj.find('.modal-body input#amount').val('');
      modal_obj.find('.modal-body textarea#remarks').val('');
      modal_obj.find('.modal-body span#id').text('');
      document.getElementById('serial_disp_none').style.display='none';
      document.getElementById('payment').checked=false;
      document.getElementById('deposit').checked=false;
      document.getElementById('modal_title').innerHTML='新規';
    }
	});
  
});

$(function(){
   // モーダルの中の「ボタン1」を押した時の処理
    $("#submit_btn").on('click', function() {
      let id_txt=document.getElementById("id_txt").value;
      let target_date=document.getElementById("target_date").value;
      let summary=document.getElementById("summary").value;
      let remarks=document.getElementById("remarks").value;
      let payment_deposit= $('input[name="payment_deposit_rdo"]:checked').val();
      let amount=document.getElementById("amount").value;
      let deposit_amount="";
      let payment_amount="";

      //console.log("target_date="+target_date);
      //console.log("summary="+summary);
      //console.log("payment_deposit="+payment_deposit);
      //console.log("amount="+amount);
      
      if(payment_deposit=="payment"){
            payment_amount=amount;
      }else{
            deposit_amount=amount;
      }
      if(target_date!='' && summary!='' && amount!='' && typeof payment_deposit !== 'undefined'){
        document.getElementById("CreateModal").close;
        $.ajax({
            url: "ajax_upsert_CashBook",
            type: 'post', // getかpostを指定(デフォルトは前者)
            dataType: 'text', 
            scriptCharset: 'utf-8',
            frequency: 10,
            cache: false,
            async : false,
            data: {'id':id_txt,
              'target_date': target_date,
              'in_out' : payment_deposit,
              'summary': summary,
              'payment': payment_amount,
              'deposit': deposit_amount,
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
