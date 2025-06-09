function kakunin_msg(){

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
			console.log("element.attr name="+element.attr("name"));
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
      modal_obj.find('.modal-body span#id').text(id);
    }else{
      modal_obj.find('.modal-body input#target_date').val('');
      modal_obj.find('.modal-body input#summary').val('');
      modal_obj.find('.modal-body input#amount').val('');
      modal_obj.find('.modal-body textarea#remarks').val('');
      modal_obj.find('.modal-body span#id').text('');
      document.getElementById('payment').checked=false;
      document.getElementById('deposit').checked=false;
    }
	});
  
});

$(function(){
   // モーダルの中の「ボタン1」を押した時の処理
    //$("#save_btn").on('click', function() {
    //  console.log("create_btn");
      //let Tdate=document.getElementById("visit_date").value;
      //let Tvisit_history_serial=document.getElementById("visit_history_serial").innerText;
      //let Ttr_content=document.getElementById("tr_content_slct").value;
      //let Tpoint=document.getElementById("point").value;
      //if(Ttr_content==0){
      //  alert("施術内容を選択してください。");
      //  return false;
      //}
      //console.log("Ttr_content="+Ttr_content);

      //$('#CreateModal').modal('hide');
      /*
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
      */
    //});
});
