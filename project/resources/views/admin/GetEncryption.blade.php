@extends('layouts.appCustomer')
    @section('content')
    <script  type="text/javascript" src="{{ asset('/js/jquery-3.6.0.min.js') }}"></script>
    <style type="text/css">
    input,textarea{
        border: 1px solid #aaa;
    }
    .auto-style1 {
        color: #FF0000;
    }
    </style>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="row">
                    @include('layouts.header')
                </div>
                <div class="mb-2 bg-success text-white">暗号化</div>
                <form action="{{ route('admin.setting.update') }}" method="POST" class="h-adr" id="save_setting" name="save_setting">@csrf
                    <div class="row"> 
                        <div class="col-4">
                            <label for="TargetString" class="form-label">対象文字列</label>
                            <input id="TargetString" name="TargetString" type="text" class="form-control" required autofocus />
                        </div>
                    </div>
                    <div class="row"> 
                        <div class="col-4">
                            <label for="EncryptedString" class="form-label">暗号化済み文字列</label>
                            <input id="EncryptedString" name="EncryptedString" type="text" class="form-control"/>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script type="text/javascript">
        $('#student_serial_txt').keypress(function(e) {
            if(e.which == 13) {
                document.getElementById("student_serial_txt").disabled=true;
                $.ajax({
                    //url: 'send_mail',
                    url: 'in_out_manage',
                    type: 'post', // getかpostを指定(デフォルトは前者)
                    dataType: 'text', // 「json」を指定するとresponseがJSONとしてパースされたオブジェクトになる
                    scriptCharset: 'utf-8',
                    data: {"target_serial":$('#target_serial_txt').val()},
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                }).done(function (data) {
                    const item_json = JSON.parse(data);
                    if(item_json.seated_type=="false"){
                    //if(data=="false"){
                        audio_false.play();
                        //console.log(data);
                        document.getElementById("seated_type").style.display="";
                        document.getElementById("seated_type").innerText = item_json.name_sei + ' '+item_json.name_mei+'さんの退出時間が短すぎます。';
                        dispNone();
                    }else if(item_json.seated_type=="in"){
                    //}else if(data=="in"){
                        audio_in.play();
                        document.getElementById("seated_type").innerText =  item_json.name_sei + ' '+item_json.name_mei+'さんが入室しました。';
                        send_mail(data);
                        //console.log(data);
                    }else if(item_json.seated_type=="out"){
                    //}else if(data=="out"){
                        audio_out.play();
                        document.getElementById("seated_type").innerText =  item_json.name_sei + ' '+item_json.name_mei+'さんが退室しました。';
                        send_mail(data);
                        //console.log(data);
                    }else{
                        audio_false.play();
                        document.getElementById("seated_type").innerText = '登録データが見つかりません。';
                        dispNone();
                    }
                    document.getElementById('student_serial_txt').value="";
                    document.getElementById('student_serial_txt').focus();
                    data=null;
                    window.setTimeout(dispNone, 5000);
                    //name_fadeOut();
                }).fail(function (XMLHttpRequest, textStatus, errorThrown) {
                    alert(XMLHttpRequest.status);
                    alert(textStatus);
                    alert(errorThrown);	
                    alert('エラー');
                });
            }else{
                //alert("TEST");
            }
            document.getElementById("target_serial_txt").disabled=false;
        });
    </script>
@endsection