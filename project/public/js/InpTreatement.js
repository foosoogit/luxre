window.onload = function(){
	var saveFlg=document.getElementById("TorokuMessageFlg").value;
	reason_coming_sonota_manage();
	if(saveFlgArray[0]=="true"){
		if(saveFlgArray[1]=="new"){
			alert('登録しました。');
		}else{
			alert('修正しました。');
		}
		document.getElementById("TorokuMessageFlg").value="false";
	}
}

jQuery(document).ready(function($){
    //console.log('validate5');
	$("#inp_Treatment_fm").validate({
        //console.log('validate3');
		rules:{
			TreatmentContent_name:{
				required: true
			},
			TreatmentContent_name_kana:{
				required: true,
                hiragana: true
			}
		},
		messages: {
			TreatmentContent_name:{
				required: "「施術名」を入力してください。"
			},
			TreatmentContent_name_kana:{
				required: "「施術名(かな)」を入力してください。"
			}
	  	},
		errorPlacement: function(error, element) {
			if (element.is(':radio, :checkbox')) {
				if(element.attr("name")=='GenderRdo'){
					error.appendTo($('#GenderRdo_for_error'));
				}
			}else if(element.attr("name")=="TreatmentContent_name"){
				error.appendTo($('#TreatmentContent_name_for_error'));
			}else if(element.attr("name")=="TreatmentContent_name_kana"){
				error.appendTo($('#TreatmentContent_name_kana_for_error'));
			}else{
				error.insertAfter(element);
			}
		}
	});

    jQuery.validator.addMethod("hiragana", function(value, element) {
        return this.optional(element) || /^([ぁ-ん]+)$/.test(value);
        }, "<br/>全角ひらがなを入力してください"
       );

});