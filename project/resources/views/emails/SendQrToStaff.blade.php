{!!$target_item_array['msg']!!}
{{-- <img src="data:image/png;base64, {!! base64_encode(QrCode::format('png')->size(200)->generate($target_item_array['qr'])) !!} "> --}}
{{--<img src="data:image/png;base64, {!! base64_encode(QrCode::size(200)->generate('qr')) !!} ">--}}
{{--  
{!! $target_item_array['msg'] !!}
{!! nl2br($target_item_array['msg']) !!}
{!! $target_item_array['protector'] !!} 様

{!! $target_item_array['name_sei']!!} {!! $target_item_array['name_mei'] !!}様が、教進セミナー{!!$target_item_array['type_word']!!}されました。
{!! $target_item_array['type'] !!}時間：{!! $target_item_array['target_time'] !!}
--}}