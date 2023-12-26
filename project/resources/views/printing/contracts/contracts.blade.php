<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<link media="print" rel="stylesheet" href="print.css">
<head>
<meta content="text/html; charset=utf-8" http-equiv="Content-Type" />
<title>エステティックサービス契約書</title>
<style type="text/css">

@font-face {
            font-family: ipag;
            font-style: normal;
            font-weight: normal;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        @font-face {
            font-family: ipag;
            font-style: bold;
            font-weight: bold;
            src: url('{{ storage_path('fonts/ipag.ttf') }}') format('truetype');
        }
        body {
            font-family: ipag !important;
        }
p {
	word-break: break-all;
}
.yakkan {
	position: relative;
	font-size: 9px;
	margin-bottom: 1.5em
	/*overflow-wrap normal;*/
}


.box {
	position: relative;
	font-size: 12px;
}

.box p {
    position: absolute;
    top: 0;
    left: 0;
}

.image {
  top: 0;
  bottom: 0;
  left: 150;
  right: 0;
  margin: auto;
  position: absolute;
  }

.logo{
	text-align: center
	font-size: 30px
	/*color: #364e96;文字色*/
	/*border: solid 3px #364e96;線色*/
	/*padding: 0.5em;文字周りの余白*/
	/*border-radius: 0.5em;角丸*/

}

.jyo {
   text-align: left;
   vertical-align: top;
}

.jyo_branch {
   text-align: right;
}


.auto-style8 {
   font-size: small;
}
.auto-style10 {
   text-align: center;
   border: 1px solid #FF0000;
   font-size: xx-small;
}

.border_top {
	border-top: 0.5px solid #FF0000;
}

.border_bottom {
	border-bottom: 0.5px solid #FF0000;
}

.border_left {
	border-left: 0.5px solid #FF0000;
}

.border_right {
	border-right: 0.5px solid #FF0000;
}

.auto-style11 {
   text-align: center;
   font-size: x-large;
}

.auto-style13 {
   border-left-style: none;
   border-left-width: medium;
   border-bottom-style: solid;
   border-bottom-width: 1px;
}
.td, .table th {
	border-collapse: collapse; /* 1pxにする */
	/*border: 1px solid #666;*/
}

.auto-style18 {
   border: 1px solid #000000;
}
.auto-style24 {
   border-left: 1px solid #000000;
   border-right: 1px solid #000000;
   border-bottom: 1px solid #000000;
   font-size: small;
   border-top-color: #000000;
   border-top-width: 1px;
}
.auto-style26 {
   font-size: small;
   border-top-style: solid;
   border-top-width: 1px;
}
.auto-style28 {
   border-bottom-style: solid;
   border-bottom-width: 1px;
}
.auto-style29 {
   border: 1px solid #000000;
   font-size: small;
}

.auto-style31 {
   border: 1px solid #000000;
   text-align: center;
   font-size: small;
}

.auto-style32 {
	border: 1px solid #000000;
	text-align: right;
	font-size: small;
}

.auto-style33 {
	border: 1px solid #000000;
	text-align: center;
}
.auto-style34 {
	border: 1px solid #000000;
	text-align: right;
}

.auto-style1 {
	text-align: right;
}

.auto-style35 {
	color: #FF0000;
}

.print_pages{
	/*A4縦*/
	inline-size: 172mm;
	/*height: 251mm;*/
	/*page-break-after: always;*/
	overflow-wrap: break-word;
}


</style>
</head>

<body>
<section class="print_pages">
<table class="td">
	<tr>
		<td colspan="11" rowspan="2" class="auto-style11">エステティックサービス契約書</td>
		<td></td>
		<td colspan="7" class="auto-style10">お客様控え</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="10" class="auto-style8">裏面の約款に基づき以下の通り契約を締結します。</td>
		<td></td>
		<td></td>
		<td colspan="7" class="auto-style10">裏面を必ずお読み下さい</td>
	</tr>
	<tr>
		<td colspan="4" class="auto-style8">契約締結日　　{{Str::substr($keiyaku_inf->keiyaku_bi, 0, 4)}}　年　　 {{Str::substr($keiyaku_inf->keiyaku_bi, 5, 2)}}月　 　{{Str::substr($keiyaku_inf->keiyaku_bi, 8, 2)}} 　日</td>
		<td></td>
		<td colspan="3"></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td   class="auto-style18">会員番号</td>
		<td colspan="3"  class="auto-style18">&nbsp;{{$User_inf->serial_user}}</td>
		<td class="auto-style13"></td>
		<td class="auto-style28" colspan="3"></td>
		<td class="auto-style28" colspan="2"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
		<td class="auto-style28"></td>
	</tr>
	<tr>
		<td rowspan="4" class="auto-style18"><span class="auto-style8">ご契約者</span><br class="auto-style8" />
		<span class="auto-style8">（甲）</span></td>
		<td rowspan="2" class="auto-style29">お名前：{{$User_inf->name_sei}}&nbsp;{{$User_inf->name_mei}}</td>
		<td class="auto-style29" colspan="6">フリガナ：{{$User_inf->name_sei_kana}}&nbsp;{{$User_inf->name_mei_kana}}</td>
		<td rowspan="2" class="auto-style31">生年月日</td>
		<td rowspan="2" class="auto-style29" colspan="10">&nbsp;{{$User_inf->birth_year}}年&nbsp;{{$User_inf->birth_month}}月&nbsp;{{$User_inf->birth_day}}日</td>
	</tr>
	<tr>
		<td colspan="6" class="auto-style1" style="line-height: 30px">印</td>
	</tr>
	<tr>
		<td class="auto-style24">ご住所</td>
		<td class="auto-style29" colspan="17">&nbsp;〒{{$User_inf->postal}}<br />&nbsp;{{$prefecture_name}}&nbsp;{{$User_inf->address_locality}}&nbsp;{{$User_inf->address_banti}}
		</td>
	</tr>
	<tr>
		<td class="auto-style24">連絡先</td>
		<td colspan="17" class="auto-style29">&nbsp;{{$User_inf->phone}}</td>
	</tr>
	<tr>
		<td colspan="2" class="auto-style8">&nbsp;</td>
		<td colspan="17" class="auto-style26">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="2" class="auto-style8">1．役務契約</td>
		<td colspan="17" class="auto-style8">役務契約期間&nbsp;&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_start, 0, 4)}}年&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_start, 5, 2)}}月&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_start, 8, 2)}}日&nbsp;～&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_end, 0, 4)}}年&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_end, 5, 2)}}月&nbsp;{{Str::substr($keiyaku_inf->keiyaku_kikan_end, 8, 2)}}日</td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style31">契約内容明細</td>
		<td class="auto-style31" colspan="3">回数</td>
		<td colspan="3" class="auto-style31">単価</td>
		<td colspan="8" class="auto-style31">料金（税込）</td>
	</tr>
	@foreach($ContractDetail_inf as $value)
		<tr>
		<td colspan="5" class="auto-style18">&nbsp;{{$value->keiyaku_naiyo}}</td>
		<td class="auto-style33" colspan="3">&nbsp;{{$value->keiyaku_num}}</td>
		<td colspan="3" class="auto-style34">{{number_format($value->unit_price)}}&nbsp;</td>
		<td class="auto-style18">&nbsp;{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-8,1)}}</td>
		<td class="auto-style18" style="border-right: 1px dashed">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-7,1)}}</td>

		<td class="auto-style18" style="border-left: 1px dashed">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-6,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-5,1)}}</td>
		<td class="auto-style18" style="border-right: 1px dashed">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-4,1)}}</td>
		<td class="auto-style18" style="border-left: 1px dashed">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-3,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-2,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$value->price,Str::length('         '.$value->price)-1,1)}}</td>
		</tr>
	@endforeach
	{{--
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18">&nbsp;</td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed""></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="5" class="auto-style18">&nbsp;</td>
		<td class="auto-style18" colspan="3"></td>
		<td colspan="3" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	--}}
	<tr>
		<td colspan="11" class="auto-style32">役務契約　合計金額（Ａ）</td>
		<td class="auto-style18">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-8,1)}}</td>
		<td class="auto-style18" style="border-right: 1px dashed">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-7,1)}}</td>
		<td class="auto-style18" style="border-left: 1px dashed">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-6,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-5,1)}}</td>
		<td class="auto-style18" style="border-right: 1px dashed">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-4,1)}}</td>
		<td class="auto-style18" style="border-left: 1px dashed">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-3,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-2,1)}}</td>
		<td class="auto-style18">{{Str::substr('         '.$keiyaku_inf->keiyaku_kingaku,Str::length('         '.$keiyaku_inf->keiyaku_kingaku)-1,1)}}</td>
	</tr>
	<tr>
		<td class="auto-style8">&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="8" class="auto-style8">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td class="auto-style8">2．商品</td>
		<td></td>
		<td colspan="8" class="auto-style8">※当サロンは役務に関連する商品はございません。【役務関連商品：無し】</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style31">商品内容（種類）明細</td>
		<td class="auto-style31" colspan="2">単価</td>
		<td class="auto-style29">数量</td>
		<td colspan="8" class="auto-style31">料金（税込）</td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style18">&nbsp;</td>
		<td colspan="2" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style18">&nbsp;</td>
		<td colspan="2" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style18">&nbsp;</td>
		<td colspan="2" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style18">&nbsp;</td>
		<td colspan="2" class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="11" class="auto-style32">商品　合計金額（Ｂ）</td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="3" class="auto-style8">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="3" class="auto-style8">3．役務契約・商品　合計金額</td>
		<td></td>
		<td></td>
		<td colspan="3"></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td colspan="11" class="auto-style32">支払総合計金額（Ａ）+（Ｂ）</td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18" style="border-right: 1px dashed"></td>
		<td class="auto-style18" style="border-left: 1px dashed"></td>
		<td class="auto-style18"></td>
		<td class="auto-style18"></td>
	</tr>
	<tr>
		<td colspan="3" class="auto-style8">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td colspan="3">&nbsp;</td>
		<td colspan="2">&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td colspan="19" class="auto-style8">4．お支払方法及び期間</td>
	</tr>
	<tr>
		<td colspan="19" class="auto-style8">{!!$SentenceHowToPay!!}</td>
	</tr>
	<tr>
		<td colspan="19" class="auto-style8">&nbsp;</td>
	</tr>
	<tr>
		<td colspan="4" class="auto-style8">5．前受け金の保全措置はございません。</td>
		<td></td>
		<td colspan="3"></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
	</tr>
	<tr>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px" colspan="3"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
		<td style="height: 18px"></td>
	</tr>
	<tr>
		<td colspan="8" class="auto-style8">上記内容にて確かにお受け致しました。</td>
		<td colspan="11" class="auto-style8" rowspan="5" style="border: 1px solid"><div class="logo" style="font-size:25px">美シャイン+MoezBeauty</div></td>
	</tr>
	<tr>
		<td colspan="8">
		<div class="box">
			<img class="image" src="{{ asset('storage/images/stamp.png') }}" alt="美シャイン">
			<p>（乙）群馬県館林市富士原町１０５７ー３７７ウェルネス２０３号<br />
			&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;美シャイン　根岸もえ子</p>
	</div>
	</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="3">&nbsp;</td>
		<td></td>
		<td colspan="2">
		&nbsp;</td>
		<td>
		&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td colspan="2"></td>
		<td></td>
		<td></td>
		<td>
		&nbsp;</td>
		<td colspan="2">
		&nbsp;</td>
	</tr>
	<tr>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td colspan="2">
		&nbsp;</td>
		<td>
		&nbsp;</td>
	</tr>
</table>
</section>


</br></br></br></br></br></br></br></br></br></br></br></br></br></br></br></br>


<section class="print_pages yakkan">

<table class="td">
	<tr>
		<td colspan="5" style="font-size:15px; height: 17px;">エステティックサービス契約書約款</td>
		<td colspan="7" class="auto-style10" style="height: 17px">この裏面をよくお読みください</td>

	</tr>
	<tr>
		<td colspan="12"></td>

	</tr>
	<tr>
		<td class="jyo">第1条</td>
		<td colspan="11">お客様（以下「甲」といいます。）は、本契約書記載の内容と別紙の「サービス内容事前確認書（概要書面）」、「施術同意書」「その他同意書」の内容を承諾、同意の上、当サロン（以下「乙」といいます）に対しエステティックサービスを申込まれました。乙は甲の申し込みを承諾しました。</td>

	</tr>
	<tr>
		<td class="jyo_branch">2・</td>
		<td colspan="11">甲が未成年者の場合は、親権者の同意を必要としますので、親権者の同意を確認したうえで本契約の成立とします。</td>

	</tr>
	<tr>
		<td class="jyo_branch">3・</td>
		<td colspan="11">甲がクレジットを利用する場合に、甲とクレジット会社間の立替払い契約が成立しないときは、本契約も成立しなかったものとみなします。</td>

	</tr>
	<tr>
		<td class="jyo">第2条</td>
		<td colspan="11">乙は、甲に対し、乙の定めるエステティックサービスの中から甲が選択するサービスを、契約書記載の契約期間・回数・単価により行うものとします。</td>

	</tr>
	<tr>
		<td class="jyo_branch">2・</td>
		<td colspan="11">サービスに付随して必要となる役務関連商品はございませんが、商品を販売する場合はその商品・価格・数量を明らかにするものとします。</td>

	</tr>
	<tr>
		<td class="jyo_branch">3・</td>
		<td colspan="11">乙は、甲に対するエステティックサービスの提供記録を作成し、その記録を一定期間常備するものとします。</td>

	</tr>
	<tr>
		<td class="jyo">第3条</td>
		<td colspan="11">甲は、乙からエステティックサービスを受けるに当たって、支払いの方法として、前払い金の現金一括払い又は乙と提携するクレジット会社の立替払いによる支払いの中から希望する方法を選択できるものとします。</td>

	</tr>
	<tr>
		<td class="jyo">第4条</td>
		<td colspan="11">この契約の有効期限は契約書に記載されている「契約期間」となります。「契約期間」が過ぎた場合、本契約に定める甲の権利は消滅するものとします。</td>

	</tr>
	<tr>
		<td class="jyo">第5条</td>
		<td colspan="11">乙は、エステティックサービスを行うに際し、甲に対し、同人が皮膚疾患等により治療中であること、アレルギー体質であること、薬を服用していること、敏感肌であること、その他エステティックサービスを受ける障害となる事由があるか否かを聴取し、甲は虚偽なく報告するものとします。また、甲はエステティックサービス期間中、体調の変化、新たに薬を服用する必要が生じた場合や、疾病等が判明した場合にも同様に乙に報告するものとします。</td>

	</tr>
	<tr>
		<td class="jyo_branch">2・</td>
		<td colspan="11">甲がエステティックサービス期間中に、サービス部位に異常を感じた場合には、甲は乙に対し、直ちにその旨を伝えるものとします。この場合乙は直ちにエステティックサービスを中止し、その原因が乙に起因する疑いがある場合には、乙の指定する提携医療機関にて診療を受けていただくなど、適切な処置を図るものとします。但し、以下の場合は甲の負担にて治療をしていただきます。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">ⅰ　施術前後の注意事項や同意事項をお守りいただけなかった場合。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">ⅱ　脱毛の主なリスクである毛膿炎、赤み、かゆみに係る治療の場合。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">ⅲ　第5条第1項にある報告に虚偽があった場合や、報告がなされなかった場合。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">ⅳ　サービス部位に異常を感じたとき、その旨を乙に対し報告を怠った場合や施術14日以上経過し、診療を受けた場合。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">ⅴ　乙の指定する提携医療機関にて診療を受けなかった場合。</td>

	</tr>
	<tr>
		<td class="jyo_branch">3・</td>
		<td colspan="11">乙のトリートメントに起因する肌トラブル等により第5条第2項のⅰ～ⅴに該当しない治療費については医師による完治との判断までは乙の負担にて治療をさせていただきますが、治療費以外の損害賠償、慰謝料、係る交通費等はお支払いしかねますのでご了承ください。</td>

	</tr>
	<tr>
		<td class="jyo_branch">4・</td>
		<td colspan="11">乙は役務提供を続けることにより、甲に肌トラブル等のリスクが生じると判断した場合、直ちにエステティックサービスを中止することができます。また、役務契約継続が困難と乙が判断した場合、第11条第2項に従い中途解約をさせていただきます。</td>

	</tr>
	<tr>
		<td class="jyo">第6条</td>
		<td colspan="11">甲は乙の提供するサービスの効果については個人差があり、効果についての保証は一切できないことを予めご了承ください。</td>

	</tr>
	<tr>
		<td class="jyo auto-style35 border_top border_left">第7条</td>
		<td colspan="11" class="auto-style35 border_top border_right">甲は本契約を定める事項を記載した契約書面を受領した日から起算して8日以内であれば、書面により、契約を解除することができます。</td>
	</tr>
	<tr>
		<td class="jyo_branch auto-style35 border_left">2・</td>
		<td colspan="11" class="auto-style35 border_right">前項の契約の解除において、乙がクーリングオフについて不実の告知をすることにより甲を誤認させ、又は乙が甲を威迫するなどの責により妨害された結果行われなかった場合は、経済産業省令で定められた契約の解除ができる旨を記載した書面の交付・説明を受けた日から8日間を経過するまでは、前項の契約の解除ができます。</td>

	</tr>
	<tr>
		<td  class="jyo_branch auto-style35  border_left">3・</td>
		<td colspan="11" class="auto-style35  border_right">商品（第2条第2項）についても契約の解除ができます。商品引き渡しがすでにされているときは、その引き取りに要する費用は乙の負担とします。但し、第2条2項に定める商品については、使用し又はその全部もしくは一部を消費したとき（乙が甲に当該商品を使用させ、又はその全部をもしくは一部を消費させた場合を除く）は、その限りではないこととします。ただし、商品の状態により商品価値が残存していないと評価されることがあります。</td>

	</tr>
	<tr>
		<td class="jyo auto-style35  border_left">第8条</td>
		<td colspan="2" class="auto-style35">前項による契約の解除は、甲が契約を解除する旨を記載した書面を、乙宛に発信したときに、その効力が発生するものとします。</td>
		<td></td>
		<td colspan="7" class="auto-style35 border_top border_left border_right">　・クーリングオフ（契約の解除）の文例</td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td class="jyo auto-style35 border_left">第9条</td>
		<td colspan="2" class="auto-style35">第7条による契約解除については、違約金（解約手数料）及び利用したサービスの対価は不要とし、乙は、甲から受領した前払金を返還する際の費用は乙の負担とします。</td>
		<td></td>
		<td colspan="7" class="auto-style35 border_left border_right">　年 　月　 日、貴社との間で締結した　　　　　　の役務契約について、約款第7条第8条の規定に基づき解除します。</td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td colspan="3" rowspan="10" class="border_left"></td>
				<td></td>
		<td colspan="7" class="auto-style35 border_left border_right">なお、私が貴社に支払った代金の　　　　円を、下記の銀行口座に振り込んでください。</td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td ></td>
		<td colspan="7" class="auto-style35 border_left border_right">また、私が保管している商品を引き取ってください。（商品返品有の場合）</td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td></td>
		<td class="border_left"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td style="height: 11px"></td>
		<td colspan="7" class="auto-style35 border_left border_right">　 　銀行　 　支店、普通預金口座　　　　　　号、口座名義人　　　　</td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td></td>
		<td class="border_left"></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>

	</tr>
	<tr>
		<td></td>
		<td colspan="2" class="auto-style35 border_left">　　　 　年 　月 　日</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td></td>
		<td class="auto-style35 border_left">契約者　　住所</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td></td>
		<td class="auto-style35 border_left">　　　　　　　氏名</td>
		<td></td>
		<td class="auto-style35">印</td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>
		
	</tr>
	<tr>
		<td></td>
		<td colspan="2" class="auto-style35 border_left">事業者　　東京都港</td>
		<td></td>
		<td></td>
		<td></td>
		<td></td>
		<td class="border_right"></td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_top"></td>
		<td class="border_right"></td>
	</tr>
	<tr>
		<td colspan="12" class="border_bottom;"></td>
	</tr>
	<tr>
		<td class="jyo  border_top">第10条</td>
		<td colspan="11" class="border_top">第7条に定める期間を経過した場合にも、甲は乙に申し出ることにより契約を解除することができます。この場合、甲は乙に対し、契約残額の</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">10％の解約手数料を支払うものとします。ただし、解約手数料は、2万円を超えることができないものとします。</td>

	</tr>
	<tr>
		<td class="jyo">第11条</td>
		<td colspan="11">甲が前項により解約を解除した場合、乙は、すでに受領している前払い金のうち、下記計算式によって計算された精算金を、契約解除の日</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">から1ヶ月以内に甲に返還するものとします。ただし、精算金がマイナスの場合、甲は乙に対しその不足分を支払うこととします。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">なお、振込手数料は甲の負担となります。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">〈算式〉精算金＝支払総額-（1回あたりの料金×利用回数）-解約手数料-振込手数料</td>


	</tr>
	<tr>
		<td style="height: 12px">2・</td>
		<td colspan="11" style="height: 12px">前項において乙の都合によって甲がサービスを受けることが著しく困難になったことにより、甲が契約解除をした場合には、乙は、甲に対し</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">前項の精算金の計算に当たり、違約金と振込手数料を控除しないものとします。</td>

	</tr>
	<tr>
		<td>3・</td>
		<td colspan="11">甲は、乙がクレジット会社の請求により清算上必要な範囲において甲の利用回数をクレジット会社に通知することを承諾するものとします。</td>

	</tr>
	<tr>
		<td class="jyo" style="height: 20px">第12条</td>
		<td colspan="11" style="height: 20px">乙は、甲に対し、必要と認めるときにはいつでも身分証明書の提示を求めることができ、その場合、甲はこれに応じなければならないものと</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">します。甲が応じなかった場合、乙は甲の施設利用の停止その他必要な措置を講じることができることとします。</td>

	</tr>
	<tr>
		<td class="jyo" style="height: 20px">第13条</td>
		<td colspan="11" style="height: 20px">キャンセル連絡はご予約前日までとさせていただきます。当日のキャンセルもしくは、ご連絡無しにご予約のお時間にお越しいただけなかっ</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">た場合は、一律1000円のキャンセル料を、弊社指定口座へお振込みまたは、次回の来店時にお支払いただきますのでご了承ください。</td>

	</tr>
	<tr>
		<td></td>
		<td colspan="11">また、予約時間に遅れた場合、施術時間の短縮や施術が出来ないことがあることを予めご了承ください。</td>

	</tr>
	<tr>
		<td class="jyo">第14条</td>
		<td colspan="11">本契約に関し訴訟の必要性を生じた場合は、前橋地方裁判所を以て専属的合意管轄裁判所とします。</td>

	</tr>
	<tr>
		<td class="jyo">第15条</td>
		<td colspan="11">本契約を定める事項について疑義が生じた場合、その他に関して紛争が生じた場合には、甲乙協議の上、解決するものとします。</td>

	</tr>
</table>

</section>
</body>

</html>