<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
	{{-- @livewireStyles --}}
	<!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
</head>
<body class="font-sans antialiased h1">
    <div class="py-12">
		<div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <div class="flex items-center gap-4">
                    <button class="btn btn-primary" onclick="location.href='{{route('admin.top')}}'" >メニューに戻る</button>
                </div>
				<div class="col"> 
					<p id="RealtimeClockArea" class="display-3 lead"></p>
				</div>
				<div class="row height:25rem" style="width: 30rem;"><mark class="mark3">スタッフ入退社受付画面</mark></div>
                <div class="row">
					<div class="col">
                        <label>QRコードの読み込み</label>
                        <input type="text" class="mt-1 block w-full" name="target_customer_serial_txt" id="target_customer_serial_txt" autofocus />
					</div>
        		</div>
				<div class="alert alert-primary alert-dismissible fade show" id="name_fadeout_alert" style="display: none">
					<label id="seated_type" class="text-danger fs-4 display-4"></label>
				</div>
    		</div>
		</div>
	</div>
	<input type="hidden" value="{{$host_url}}" name="HTTP_HOST" id="HTTP_HOST"/>
	<input type="hidden" value="{{asset('/storage/sounds/in.mp3')}}" name="sound_in_url" id="sound_in_url"/>
	<input type="hidden" value="{{asset('/storage/sounds/out.mp3')}}" name="sound_out_url" id="sound_out_url"/>
	<input type="hidden" value="{{asset('/storage/sounds/false.mp3')}}" name="sound_false_url" id="sound_false_url"/>
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
	<script type="text/javascript">
		//var audio_out= new Audio("time_out.mp3");
		var audio_in= new Audio("in.mp3");
		var audio_false= new Audio("false.mp3");
		//console.log("sound_in_url="+document.getElementById("sound_in_url").value);
		let host_url=document.getElementById("HTTP_HOST").value;
		//var audio_in= new Audio(host_url+"/storage/sounds/in.mp3");
		//var audio_in= new Audio(document.getElementById("sound_in_url").value);
		
		//var audio_out= new Audio(document.getElementById("sound_out_url").value);
		//var audio_in= new Audio(document.getElementById("sound_in_url").value);
		//var audio_false= new Audio(document.getElementById("sound_false_url").value);
		//var audio;
		$(document).ready( function(){
			document.getElementById('target_customer_serial_txt').focus();
		});
		$('#target_customer_serial_txt').keypress(function(e) {
			//console.log('target_customer_serial_txt='+$('#target_customer_serial_txt').val());
			if(e.which == 13) {
				document.getElementById("target_customer_serial_txt").disabled=true;
				$.ajax({
					//url: 'send_mail',
					url: 'customer_reception_manage',
					type: 'post', // getかpostを指定(デフォルトは前者)
					dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
					scriptCharset: 'utf-8',
					data: {"target_serial":$('#target_customer_serial_txt').val()},
					headers: {
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
					}
				}).done(function (data) {
					const item_json = JSON.parse(data);
					document.getElementById("name_fadeout_alert").style.display="";
					if(item_json.res=="no serial"){
						audio_false.play();
						document.getElementById("seated_type").style.display="";
						document.getElementById("seated_type").innerText = item_json.msg;
					}else if(item_json.res=="no contract"){
						audio_false.play();
						document.getElementById("seated_type").style.display="";
						document.getElementById("seated_type").innerText = item_json.msg;
					}else if(item_json.res=="double registration"){
						audio_false.play();
						document.getElementById("seated_type").style.display="";
						document.getElementById("seated_type").innerText = item_json.msg;
					}else{
						audio_in.play();
						document.getElementById("seated_type").style.display="";
						document.getElementById("seated_type").innerText = item_json.msg;
						receipt_set_manage(data);
					}
					document.getElementById('target_customer_serial_txt').value="";
					document.getElementById('target_customer_serial_txt').focus();
					data=null;
					window.setTimeout(dispNone, 4000);
				}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
					alert(XMLHttpRequest.status);
					alert(textStatus);
					alert(errorThrown);	
					alert('エラー1');
				});
			}else{
				//alert("TEST");
			}
			//document.getElementById("target_serial_txt").disabled=false;
		});

		function dispNone(){
			document.getElementById("name_fadeout_alert").style.display="none";
			document.getElementById("target_customer_serial_txt").disabled=false;
			document.getElementById("target_customer_serial_txt").focus();
		}
		function receipt_set_manage(item_json){
			$.ajax({
				url: 'receipt_set_manage',
				type: 'post', // getかpostを指定(デフォルトは前者)
				dataType: 'json', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
				scriptCharset: 'utf-8',
				data: {"item_json":item_json},
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			}).done(function (data) {
				//console.log(data.res);
				data=null;
			}).fail(function (XMLHttpRequest, textStatus, errorThrown) {
				alert(XMLHttpRequest.status);
				alert(textStatus);
				alert(errorThrown);	
				alert('エラー2');
			});
			//$('#name_fadeout_alert').show();		
		}

		function name_fadeOut(){
			//$('#name_fadeout_alert').fadeOut('100');
			$('#name_fadeout_alert').hide(5000);
			//$('div').fadeOut('fast');
		}

		setInterval('showClock()',1000);
		function set2fig(num) {
			// 桁数が1桁だったら先頭に0を加えて2桁に調整する
			var ret;
			if( num < 10 ) { ret = "0" + num; }
			else { ret = num; }
			return ret;
		}

		function showClock(){
			var today = new Date();
			var dayOfWeek = today.getDay() ;	// 曜日(数値)
			var dayOfWeekStr = [ "日", "月", "火", "水", "木", "金", "土" ][dayOfWeek]
			var nowYear = today.getFullYear();
			var nowMonth = set2fig(today.getMonth()+1);
			var nowDay = set2fig(today.getDate());
			var nowHour = set2fig( today.getHours() );
			var nowMin  = set2fig( today.getMinutes() );
			var nowSec  = set2fig( today.getSeconds() );
			var msg = nowYear+"年"+nowMonth+"月"+nowDay+"日("+dayOfWeekStr+")<br>"+nowHour+":"+nowMin+":"+nowSec;
			//var msg = nowHour + ":" + nowMin + ":" + nowSec;
			document.getElementById("RealtimeClockArea").innerHTML = msg;
			//document.getElementById("RealtimeClockArea").innerHTML = "TEST!";
		}
	</script>
</body>
</html>