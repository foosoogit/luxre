function delArert(targetMsg){
	ary = targetMsg.split(' ');
	msg='下記データを削除します。'+'\n'+ary[0];
	//console.log(msg);
	//alert(msg);
	if(ary[1]!== undefined){
		msg=msg+'\n'+ary[1];
	}
	//console.log(msg);
	//alert(msg);
	if(ary[2]!== undefined){
		msg=msg+'\n'+ary[2];
	}
	//console.log(msg);
	//alert(msg);
	msg=msg+'\nよろしいですか？';
	//console.log(msg);
	//alert(msg);
	var res=window.confirm(msg);
	//var res=window.confirm('下記データを削除します。'+'\n'+ary[0]+'\n'+ ary[1]+'\n'+ary[2]+'\nよろしいですか？');

	if(res){
		return true;
	}else{
		return false;
	}
}