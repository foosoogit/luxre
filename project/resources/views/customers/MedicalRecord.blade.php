<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
	<meta name="csrf-token" content="{{ csrf_token() }}"/>
	<meta http-equiv="Cache-Control" content="no-cache"/>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous"/>
	<link rel="stylesheet" href="{{asset('/css/MedicalRecord.css')}}"/>
	<title>{{$UserInf->name_sei}} {{$UserInf->name_mei}}</title>
	<link rel="icon" type="image/png" href="{{asset('/images/Luxer_image.png')}}">
</head>
<body>
	{{--<img src="{{asset('/css/Image_body_w796_h496.png')}}">
	<img src="{{asset('/images/Image_body_w796_h496.png')}}">--}}
	<div id="aaa">
		<div class="container text-center w-75 ml-2">
			<div class="row text-center">
				<div class="col"> 
					{{--氏名：<span class="text-primary font-weight-bold h4">{{session('userneme')}}</span> --}}
					氏名：<span class="text-primary font-weight-bold h4">{{$UserInf->name_sei}} {{$UserInf->name_mei}}</span>
				</div>
				<div class="col">
					契約内容：<span class="text-primary font-weight-bold h4">{{$keiyaku_name}}</span>
				</div>
				<div class="col">
					<span class="text-primary font-weight-bold h4">{{$visit_history_num}}回目</span>
				</div>
				<div class="col-3">
					施術者：{!!$html_staff_slct!!}
				</div>
			</div>
			<div class="row">
				<div id="bbb">
					<canvas id="canvas" style="width:800px;height:500px;margin: 1em 1em 1em 5em;">残念ながらHTML5に対応していません</canvas>
				</div>
			</div>
			<div class="row text-left">
				<!--<div id="ccc">-->
				<div class="col-2">
					線の太さ<input type="range" min="1" max="5" value="1" id="lineWidth" list="markers" style="width:100px;"/><span id="lineNum">1</span>
					<datalist id="markers">
						<option value="0"></option><option value="20"></option><option value="40"></option><option value="60"></option><option value="80"></option><option value="100"></option>
					</datalist>
				</div>
				<!--</div>-->
				<div class="col-4">
					<ul>
						<li style="background-color:#000000"></li>
						<li style="background-color:#ff0000"></li>
						<li style="background-color:#0000ff"></li>
						<li style="background-color:#FFFFFF" class="border border-dark border-3"></li>
					</ul>
				</div>
				<div class="col-5">
					<input name="mae_face_btn" id="mae_face_btn" type="button" value="前顔" onclick="mark_bui(this)"/>
					<input name="mae_foot_right_btn" id="mae_foot_right_btn" type="button" value="前右足" value="前右足" onclick="mark_bui(this)"/>
					<input name="mae_foot_left_btn" id="mae_foot_left_btn" type="button" value="前左足" value="前左足" onclick="mark_bui(this)"/>
				</div>
			</div>
			<div class="row text-center">
				<div class="col"><button id="undo">１つ前の状態に戻す</button></div>
				<div class="col"><button id="clear">すべて消去</button></div>
				<div class="col"><button style="width:100px;" id="initialize">初期化</button></div>
				<div class="col">
					<button class="btn btn-primary btn-sm" onclick="SaveMedicalRecord(this)" id="btn-send">保存</button>
				</div>
			</div><!--container-->
			<button class="btn btn-primary btn-sm" onclick="GetCampasSize()" id="btn-send" style="display:none">サイズ取得</button>
			<input name="visit_history_serial" id="visit_history_serial" type="hidden" value="{{$visit_history_num}}"/>
			<input name="contract_serial" id="contract_serial" type="hidden" value="{{$ContractSerial}}"/>
			<input name="target_file" id="target_file" type="hidden" value="{{$target_file}}"/>
			<a id="download_link" alt="ダウンロード用保存図リンク"></a>
		</div>
	</div>
	<input type="hidden" value="{{asset('/storage/images/Image_body_w796_h496.png')}}" name="imge_url" id="imge_url"/>
	<input type="hidden" value="{{$host_url}}" name="HTTP_HOST" id="HTTP_HOST"/>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script src="{{asset('/js/MedialRecord.js')}}?{{now()}}"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script>
</body>
</html>