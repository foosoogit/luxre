function ClearSerch(){
	document.getElementById("kensakukey_txt").value="";
}

function delArert(targetUser){
	//alert('test');
	ary = targetUser.split(' ');
	var res=window.confirm( '登録番号: ' + ary[0]+'\n'+ ary[1]+' '+ary[2]+'さんのデータを削除します。よろしいですか？');
	if(res){
		return true;
	}else{
		return false;
	}
}

/*
function setMsgFlg(){
	document.getElementById("TorokuMessageFlg").value="true";
}
*/

$('#sampleModal').on('show.bs.modal', function (event) {
    //モーダルを開いたボタンを取得
    var button = $(event.relatedTarget);
    //data-watasuの値取得
    var watasuVal = button.data('watasu');
    //モーダルを取得
    var modal = $(this);
    //受け取った値をspanタグのとこに表示
    modal.find('.modal-body span#morau').text(watasuVal+'の');
});

// モーダルの中の「ボタン1」を押した時の処理
$("#btn1").on('click', function() {
  $('#sampleModal').modal('hide');
  var foodVal = $('#food').val();
  $('#re').text(foodVal);
});