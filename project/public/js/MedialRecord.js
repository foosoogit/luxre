//console.log('Media');
//canvasの読み込み設定
let undoImg_array = new Array();
var canvas = document.getElementById("canvas");
let ctx = canvas.getContext("2d");
let image_url=document.getElementById("imge_url").value;
//canvas.crossOrigin = "anonymous"; 
	/*
	// PC対応
	canvas.addEventListener('mousedown', startPoint, false);
	canvas.addEventListener('mousemove', movePoint, false);
	canvas.addEventListener('mouseup', endPoint, false);
	// スマホ対応
	canvas.addEventListener('touchstart', startPoint, false);
	canvas.addEventListener('touchmove', movePoint, false);
	canvas.addEventListener('touchend', endPoint, false);
	*/
canvas.width = canvas.clientWidth;
canvas.height = canvas.clientHeight;
var VisitHistorySerial = document.getElementById("visit_history_serial").value;
var ContractSerial = document.getElementById("contract_serial").value;

const chara = new Image();
let host_url=document.getElementById("HTTP_HOST").value
console.log("host_url="+host_url);
console.log("target_file="+document.getElementById("target_file").value);
let tf='http://'+host_url+'/'+document.getElementById("target_file").value;
console.log("tf="+tf);
if(document.getElementById("target_file").value!=""){
	//chara.src ='https://foosoo.xsrv.jp/images/Image_body_w796_h496.png/'+document.getElementById("target_file").value;
	//chara.src =host_url+'/images/Image_body_w796_h496.png/'+document.getElementById("target_file").value;
	//chara.src ='http://'+host_url+"/MedicalRecord/"+document.getElementById("target_file").value;
	//chara.src ="http://"+$hst+"MedicalRecord/"+document.getElementById("target_file").value;
	//chara.src ='http://'+host_url+"/images/Image_body_w796_h496.png/"+document.getElementById("target_file").value;
	chara.src =tf;
	chara.onload = () => {
		var bairitu=2;
		ctx.drawImage(chara,0,0,canvas.width,canvas.height);
	};
}else{
	//chara.src = 'https://foosoo.xsrv.jp/images/Image_body_w796_h496.png';
	//chara.src = 'file:///H:Keys/BeautySalon/Image_body_w796_h496.png';
	//chara.src ="http://127.0.0.1:8000/images/Image_body_w796_h496.png";
	chara.src ='http://'+host_url+"/images/Image_body_w796_h496.png";
	console.log("src="+chara.src);
	//chara.src ="../storage/images/Image_body_w796_h496.png";
	//chara.src =image_url;
	//console.log("image_url="+image_url);
	chara.onload = () => {
		var bairitu=2;
		ctx.drawImage(chara,-50,0,canvas.width,canvas.height);
	};
}
//chara.crossOrigin="anonymous";
//let undoImg_array = new Array();
var undoImageBui;
var target_bui_array_num=Array();
//マウスを操作する
var mouse = {x:0,y:0,x1:0,y1:0,color:"black"};
var draw = false;
//マウスの座標を取得する
canvas.addEventListener("mousemove",function(e) {
	var rect = e.target.getBoundingClientRect();  
	ctx.lineWidth = document.getElementById("lineWidth").value;
	//ctx.globalAlpha = document.getElementById("alpha").value/100;
	ctx.globalAlpha = 1;
	mouseX = e.clientX - rect.left;
	mouseY = e.clientY - rect.top;
	//クリック状態なら描画をする
	if(draw === true) {
		ctx.beginPath();
		ctx.moveTo(mouseX1,mouseY1);
		ctx.lineTo(mouseX,mouseY);
		ctx.lineCap = "round";
		ctx.stroke();
		mouseX1 = mouseX;
		mouseY1 = mouseY;
	}
});
//クリックしたら描画をOKの状態にする
canvas.addEventListener("mousedown",function(e) {
	//console.log("mousedown");
	draw = true;
    mouseX1 = mouseX;
    mouseY1 = mouseY;
	//console.log("mouseX="+mouseX);
	//console.log(undoImg_array);
	//console.log("ctxDAT="+ctx.getImageData(0, 0,canvas.width,canvas.height));
    undoImg_array.push(ctx.getImageData(0, 0,canvas.width,canvas.height));
});
//クリックを離したら、描画を終了する
canvas.addEventListener("mouseup", function(e){
	draw = false;
	//console.log(undoImg_array);
	//console.log("ctxDAT2="+ctx.getImageData(0, 0,canvas.width,canvas.height));
});
//初期化ボタンを起動する
$('#initialize').click(function(e) {
	if(!confirm('本当に初期化しますか？')) return;
	ctx.clearRect(0, 0, ctx.canvas.clientWidth, ctx.canvas.clientHeight);
	//ctx.clearRect(0, 0, canvas.width, canvas.height);
        /*
        var undo_cnt=undoImg_array.length-1;
        for(let i=undo_cnt;i>-2;i--){
        		ctx.putImageData(undoImg_array[i],0,0);
        		undoImg_array.pop();
        }
	*/
	chara.src = 'https://foosoo.xsrv.jp/images/Image_body_w796_h496.png';
	chara.onload = () => {
		var bairitu=2;
		//ctx.drawImage(chara,100,0,172*bairitu,219*bairitu);
		ctx.drawImage(chara,-50,0,canvas.width,canvas.height);
	}
	
});
//線の太さの値を変える
lineWidth.addEventListener("mousemove",function(){  
	var lineNum = document.getElementById("lineWidth").value;
	document.getElementById("lineNum").innerHTML = lineNum;
});
/*
//透明度の値を変える
alpha.addEventListener("mousemove",function(){  
var alphaNum = document.getElementById("alpha").value;
//document.getElementById("alphaNum").innerHTML = alphaNum;
//document.getElementById("alphaNum").innerHTML = 100;
});
*/
//色を選択
$('li').click(function() {
        ctx.strokeStyle = $(this).css('background-color');
});
//消去ボタンを起動する
$('#clear').click(function(e) {
	if(!confirm('本当に消去しますか？')) return;
        var undo_cnt=undoImg_array.length-1;
        //console.log("undo_cnt="+undo_cnt);
        if(undo_cnt==-1){
	       alert('消去できません。');
        }else{
	        e.preventDefault();
	        ctx.clearRect(0, 0, canvas.width, canvas.height);
	        /*
	        for(let i=undo_cnt;i>-1;i--){
	        		ctx.putImageData(undoImg_array[i],0,0);
	        		undoImg_array.pop();
	        }
	        */
        }
});
   
//戻るボタンを配置
$('#undo').click(function(e) {
	ctx.putImageData(undoImg_array[undoImg_array.length-1],0,0);
	undoImg_array.pop();
	for(var key of Object.keys(target_bui_array_num)){
		if(key == undoImg_array.length+1){
		        tgtobjID=target_bui_array_num[key];
		        //alert(tgtobjID);
		        document.getElementById(tgtobjID).disabled=false;
		        break;
		}
   	}
});

function GetCampasSize(){
	var TargetCanvas = document.getElementById("canvas");
	//console.log("height="+canvas.height);
	//console.log("width="+canvas.width);
}
	
function SaveMedicalRecord(obj){
	var TargetCanvas = document.getElementById("canvas");
	//TargetCanvas.crossOrigin = "anonymous";
	//console.log("TargetCanvasheight="+TargetCanvas.height);
	var img_url = TargetCanvas.toDataURL("image/png").replace(new RegExp("data:image/png;base64,"),"");
	//var img_url = TargetCanvas.toDataURL("image/png");
	//console.log("test");
	$.ajax({
		url: "/ajax_SaveMedicalRecord",
		//data: {"upload_data":img_url,"VisitHistorySerial":document.getElementById('visit_history_serial').value,"ImageDataArray":ImageDataArray},
		data: {"upload_data":img_url,"VisitHistorySerial":document.getElementById('visit_history_serial').value,"StaffSerial":document.getElementById('staff_slct').value},
		//data: JSON.stringify(undoImg_array),
		//data: {"ImgArray_json":ImgArray_json},
		//data: {"ImgArray_json":undoImg},
	        	//dataType: 'json',
	        	type: 'POST',
		//data: fData ,
		//contentType: false,
		//processData: false,
		//scriptCharset: 'utf-8',
		//frequency: 10,
		//cache: false,
		//async : false,
		//data: {"target_data_json": target_data_json},
		//data:fData,
		//contentType: false,
		//processData: false,
	        //dataType: "json",
	        headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')	}
	}).done(function (data) {
		//console.log("ok");
		alert('保存しました。');
	}) .fail(function (XMLHttpRequest, textStatus, errorThrown) {
		alert(XMLHttpRequest.status);
		alert(textStatus);
		alert(errorThrown);	
		alert('エラー');
	});
}

//部位選択
function mark_bui(obj){
	undoImg_array.push(ctx.getImageData(0, 0,canvas.width,canvas.height));
	target_bui_array_num[undoImg_array.length] = obj.id;
	//alert({{session('userneme')}});
	//console.log( target_bui_array_num);
	ctx.lineWidth = 3;
	ctx.beginPath();
	ctx.strokeStyle = "blue";
	var tyosei_x=0,tyosei_y=0;
	if(obj.id=="mae_face_btn"){
		targetX=255+tyosei_x;targetY=68+tyosei_y;
	}else if(obj.id=="mae_foot_right_btn"){
		targetX=237+tyosei_x;targetY=300+tyosei_y;
	}else if(obj.id=="mae_foot_left_btn"){
		targetX=274+tyosei_x;targetY=300+tyosei_y;
	}
	ctx.arc(targetX , targetY , 10 , 0 , 360);
	ctx.stroke();
	obj.disabled=true;
	ctx.strokeStyle = "black";
}
//スマホ用
var finger=new Array;
for(var i=0;i<10;i++){
	finger[i]={
		x:0,y:0,x1:0,y1:0,
		color:"rgb("
		+Math.floor(Math.random()*16)*15+","
		+Math.floor(Math.random()*16)*15+","
		+Math.floor(Math.random()*16)*15
		+")"
	};
}
	
//タッチした瞬間座標を取得
canvas.addEventListener("touchstart",function(e){
	e.preventDefault();
	var rect = e.target.getBoundingClientRect();
	ctx.lineWidth = document.getElementById("lineWidth").value;
	//ctx.globalAlpha = document.getElementById("alpha").value/100;
	ctx.globalAlpha = 1;
	undoImage = ctx.getImageData(0, 0,canvas.width,canvas.height);
	undoImg_array.push(ctx.getImageData(0, 0,canvas.width,canvas.height));

	for(var i=0;i<finger.length;i++){
		finger[i].x1 = e.touches[i].clientX-rect.left;
		finger[i].y1 = e.touches[i].clientY-rect.top;
	}
});
//タッチして動き出したら描画
canvas.addEventListener("touchmove",function(e){
	e.preventDefault();
	var rect = e.target.getBoundingClientRect();
	for(var i=0;i<finger.length;i++){
		finger[i].x = e.touches[i].clientX-rect.left;
		finger[i].y = e.touches[i].clientY-rect.top;
		ctx.beginPath();
		ctx.moveTo(finger[i].x1,finger[i].y1);
		ctx.lineTo(finger[i].x,finger[i].y);
		ctx.lineCap="round";
		ctx.stroke();
		finger[i].x1=finger[i].x;
		finger[i].y1=finger[i].y;
	}
});
//線の太さの値を変える
lineWidth.addEventListener("touchmove",function(){  
	var lineNum = document.getElementById("lineWidth").value;
	document.getElementById("lineNum").innerHTML = lineNum;
});
//透明度の値を変える
/*
alpha.addEventListener("touchmove",function(){  
var alphaNum = document.getElementById("alpha").value;
	//document.getElementById("alphaNum").innerHTML = alphaNum;
	//document.getElementById("alphaNum").innerHTML = 100;
});
*/