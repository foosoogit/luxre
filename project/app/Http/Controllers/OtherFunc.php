<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PaymentHistory;
use App\Models\VisitHistory;
use DateTime;
use App\Models\Contract;
use Illuminate\Support\Facades\Log;
use App\Consts\initConsts;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use App\Models\TreatmentContent;
use DateInterval;
use DatePeriod;
use App\Models\Staff;
use Carbon\Carbon;
use Endroid\QrCode\Color\Color;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\ErrorCorrectionLevel;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\Label\Label;
use Endroid\QrCode\Logo\Logo;
use Endroid\QrCode\RoundBlockSizeMode;
use Endroid\QrCode\Writer\PngWriter;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use App\Models\Branch;
use App\Models\CashBook;
if(!isset($_SESSION)){session_start();}

class OtherFunc extends Controller
{
	public static function html_make_select_summary_ajax(){
		/*
		if($_POST["cash_book_type"]=="small"){
			$summary_array=CashBooksSmall::where('branch',session('target_branch_serial'))->select('summary')->distinct()->get();
		}else{
			$summary_array=CashBook::where('branch',session('target_branch_serial'))->select('summary')->distinct()->get();
		}
		*/
		$summary_array=CashBook::where('branch',session('target_branch_serial'))->select('summary')->distinct()->get();
		$htm_summary_slct="";
		$htm_summary_slct='<select name="summary_slct" id="summary_slct" class="form-select" onchange="set_summmary(this);">';
		$sct='';
		$htm_summary_slct.='<option value=0 '.$sct.'>-- 選択してください。 --</option>';
		foreach($summary_array as $value){
			$htm_summary_slct.='<option value="'.$value->summary.'">'.$value->summary.'</option>';
		}
		$htm_summary_slct.='</select>';
		return $htm_summary_slct;
	}
	
	public static function set_target_balance_to_CashBookDb($target_id){
		$balance_tatal=0;
		$Branch_inf_array=Branch::get();
		$fnd_flg=false;
		//Log::alert("target_id=".$target_id);
		$CashBook_inf_array=CashBook::where('branch',session('target_branch_serial'))->orderBy('target_date', 'asc')->orderBy('created_at', 'asc')->get();
		foreach($CashBook_inf_array as $CashBook_inf){
			if($CashBook_inf->id==$target_id or $fnd_flg==true){
				$fnd_flg=true;
				$balance_tatal=$balance_tatal+intval($CashBook_inf->deposit)-intval($CashBook_inf->payment);
				$target_rec = CashBook::find($CashBook_inf->id);
				$target_rec->balance = $balance_tatal;
				$target_rec->save();
			}else if(!$fnd_flg){
				$target_befor_serial=$CashBook_inf->id;
				$balance_tatal=$CashBook_inf->balance;
			}
		}
	} 

	public static function set_balance_to_CashBookDb(){
		//Log::alert("message");
		$balance_tatal=0;
		$Branch_inf_array=Branch::get();
		foreach($Branch_inf_array as $Branch_inf){
			$CashBook_inf_array=CashBook::where('branch',$Branch_inf->serial_branch)->orderBy('target_date', 'asc')->orderBy('created_at', 'asc')->get();
			foreach($CashBook_inf_array as $CashBook_inf){
				$balance_tatal=$balance_tatal+intval($CashBook_inf->deposit)-intval($CashBook_inf->payment);
				$target_rec = CashBook::find($CashBook_inf->id);
				$target_rec->balance = $balance_tatal;
				$target_rec->save();
			}
		}
	} 

	public static function make_select_branch_btn(){
		$branch_inf_array=Branch::all();
		$htm_select_branch_btn='<div class="d-grid gap-2 col-6 mx-auto">';
        $color_array=['primary','info','secondary','warning','light','secondary','dark'];
		$cnum=0;
		foreach($branch_inf_array as $branch_inf){
			$htm_select_branch_btn.='<button class="mt-5 btn btn-'.$color_array[$cnum].'" type="submit" style="font-weight:bold;font-size: 200%;height: 200px;" name="target_branch_serial" value="'.$branch_inf->serial_branch.'" >'.$branch_inf->name_branch.'</button>';
			//Log::alert("cnum=".$color_array[$cnum]);
			$cnum++;
		}
		$htm_select_branch_btn.='</div>';
		return $htm_select_branch_btn;
	}

	public static function make_html_monthly_report_table($targetYear,$targetMonth){
		$sbj_array=array();
		$htm_month_table="";
		$sbj_array=['日','ｸﾚｼﾞｯﾄ・ﾛｰﾝ','PayPay','スマート支払い','現金','合計売上','累計売上','新規<br>来店数','会員<br>来店数','来店<br>合計','累計<br>来店数','契約<br>人数','累計<br>契約数','契約率'];
		$htm_month_table='<table class="table-auto" border-solid>';
		foreach($sbj_array as $value){
			$htm_month_table.='<th class="border px-4 py-2">'.$value.
			'<!--<button type="button" wire:click="sort(\'serial_user-ASC\')"><img src="{{ asset(\'storage/images/sort_A_Z.png\') }}" width="15px" /></button>
			<button type="button" wire:click="sort(\'serial_user-Desc\')"><img src="{{ asset(\'storage/images/sort_Z_A.png\') }}" width="15px" /></button>-->
			</th>';
		}
		$date = $targetYear.'-'.$targetMonth;
		$begin = new DateTime(date('Y-m-d', strtotime('first day of '. $date)));
		$end = new Datetime(date('Y-m-d', strtotime('first day of next month '. $date)));
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval, $end);
		$htm_month_table.='<tbody>';
		$ruikei_visiters_cnt=0;$ruikei_contract_cnt=0;
		$amount_card=0;$total_amount_card=0;
		$amount_paypay=0;$total_amount_paypay=0;
		//$amount_cash_bunkatu=0;$total_mount_cash_bunkatu=0;
		$amount_cash_uriage=0;$total_amount_cash_uriage=0;
		$amount_smart=0;$total_amount_smart=0;
		$total_new_visiters_cnt=0;$total_member_visiters_cnt=0;

		session(['TotalSalesRuikei' =>0]);
		foreach($daterange as $date){
			session(['TotalSales' => 0]);
			list($new_visiters_cnt, $member_visiters_cnt,$all_visiters_cnt) = self::get_raijyosyasu_cnt($date->format("Y-m-d"));
			
			$total_new_visiters_cnt=$total_new_visiters_cnt+$new_visiters_cnt;
			$total_member_visiters_cnt=$total_member_visiters_cnt+$member_visiters_cnt;
			$contract_cnt=self::get_contract_cnt($date->format("Y-m-d"));
			$ruikei_visiters_cnt=$ruikei_visiters_cnt+$all_visiters_cnt;
			$ruikei_contract_cnt=$ruikei_contract_cnt+$contract_cnt;
			$yobi= self::day_of_the_week_dtcls($date->format('w'));
			
			$amount_card=self::get_uriage($date->format("Y-m-d"),'card','');
			$total_amount_card=$total_amount_card+$amount_card;
			
			$amount_paypay=self::get_uriage($date->format("Y-m-d"),'paypay','');
			$total_amount_paypay=$total_amount_paypay+$amount_paypay;
			
			$amount_smart=self::get_uriage($date->format("Y-m-d"),'smart','');
			$total_amount_smart=$total_amount_smart+$amount_smart;
			
			$amount_cash_uriage=self::get_uriage($date->format("Y-m-d"),'cash','');
			$total_amount_cash_uriage=$total_amount_cash_uriage+$amount_cash_uriage;
			
			$colorRed="";
			if($yobi=='日'){
				$colorRed='style="color:red"';
			}else if($yobi=='土'){
				$colorRed='style="color:blue"';
			}
			$keiyakuritu="--";
			if($all_visiters_cnt>0){
				$keiyakuritu=number_format(round($new_visiters_cnt/$all_visiters_cnt*100,1), 1);
			}
			$htm_month_table.='
				<tr>
					<td class="border px-4 py-2" style="text-align: middle;"><button type="submit" name="target_date_from_monthly_rep" value="'.$date->format("Y-m-d").'"><span '.$colorRed.'>'.$date->format("Y-m-d").'('.$yobi.')</span></button>
</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_card).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_paypay).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_smart).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($amount_cash_uriage).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSales')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($new_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($member_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($all_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.$keiyakuritu.'</td>
				</tr>';
		}
		$htm_month_table.='
				<tr>
					<td class="border px-4 py-2" style="text-align: middle;">合計</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_card).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_paypay).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_smart).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_amount_cash_uriage).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format(session('TotalSalesRuikei')).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_new_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($total_member_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_visiters_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_contract_cnt).'</td>
					<td class="border px-4 py-2">&nbsp;</td>
				</tr>';
		$htm_month_table.='</tbody>';
		$htm_month_table.='</tr></thead></table>';
		return $htm_month_table;
	}

	public static function get_uriage($targetDay,$HowToPay,$HowMany){
		if($HowToPay=='cash'){
			$hwtpay='現金';
		}else if($HowToPay=='card'){
			$hwtpay='Credit Card';
		}else if($HowToPay=='smart'){
			$hwtpay='スマート支払い';
		}
		$TargetQuery=PaymentHistory::query();
		$TargetQuery=$TargetQuery->leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
			->where('payment_histories.how_to_pay','=',$HowToPay)
			->where('payment_histories.date_payment','=',$targetDay);
		$TargetQuery=$TargetQuery->selectRaw('SUM(amount_payment) as total');
		$TotalAmount=$TargetQuery->first(['total']);
		$total=$TotalAmount->total+session('TotalSales');
		session(['TotalSales' =>$total]);
		session(['TotalSalesRuikei' =>session('TotalSalesRuikei')+$TotalAmount->total]);
		return $TotalAmount->total;
	}

	public static function send_attendance_card($TargetStaffSerial){
		$staff_inf=Staff::where("serial_staff","=",$TargetStaffSerial)->first();
		if(empty($staff_inf)){
			$target_item_array['msg']='スタッフのご登録が見つかりません。';
			$target_item_array['res']='no serial';
			$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
		}else{
			OtherFunc::make_QRCode($TargetStaffSerial,storage_path('images/'.$TargetStaffSerial.'.png'));
			$target_item_array=array();
			$target_item_array['msg']=$staff_inf->last_name_kanji." ".$staff_inf->first_name_kanji." 様<br>出勤用QRコードをお送りします。<br>Luxer";
			$target_item_array['to_email']=$staff_inf->email;
			$target_item_array['subject']='出退記録用QRコード';
			$target_item_array['from_email']=env('MAIL_FROM_ADDRESS');
			$target_item_array['QR_file_path']=storage_path('images/'.$TargetStaffSerial.'.png');
			Mail::send(new SendMail($target_item_array));
		}
	}

	public function save_payment_history_ajax(Request $request){
		$keiyaku_array=explode("-", session('targetKeiyakuSerial'));
		$seriar_user=str_replace('K_', '', $keiyaku_array[0]);
		$payments = [
			['payment_history_serial' => $request->payment_history_serial,
			'date_payment' => $request->payment_date,
			'amount_payment' => $request->amount,
			'how_to_pay' => $request->method,
			'serial_keiyaku'=>session('targetKeiyakuSerial'),
			'branch'=>session('target_branch_serial'),
			'serial_user'=>$seriar_user]
		];
		$res=PaymentHistory::upsert($payments, ['payment_history_serial']);
		echo $res;
	}

	public static function make_htm_get_payment_method_slct_ajax(Request $request){
		$PaymentMethod=initConsts::PaymentMethod();
		$PaymentMethodArray=explode(",", $PaymentMethod);
		$htm_PaymentMethod_slct="";
		$htm_PaymentMethod_slct='<select name="month_slct" id="method_slct" class="form-select">';
		$sct='';
		if($request->target==''){
			$sct='Selected';
		}
		$htm_PaymentMethod_slct.='<option value=0 '.$sct.'>-- 選択してください。 --</option>';
		foreach($PaymentMethodArray as $value){
			$value_array=explode("_", $value);
			$sct='';
			if(str_contains($value, $request->target) && $request->target!=''){
				$sct='Selected';
			}
			$htm_PaymentMethod_slct.='<option value="'.$value_array[0].'" '.$sct.' >'.$value_array[1].'</option>';
			$sct='';
		}
		$htm_PaymentMethod_slct.='</select>';
		return $htm_PaymentMethod_slct;
	}

	public static function make_html_payment_table($targetContract){
		Contract::where(serial_keiyaku,"=",$targetContract)->get();
	}
	
	public function save_visit_data_ajax(Request $request){
		$keiyaku_array=explode("-", session('targetKeiyakuSerial'));
		$seriar_user=str_replace('K_', '', $keiyaku_array[0]);
		$visits = [
			['visit_history_serial' =>$request->Tvisit_history_serial,
			'date_visit' => $request->Tdate,
			'treatment_dtails' => $request->Ttr_content,
			'serial_keiyaku'=>session('targetKeiyakuSerial'),
			'branch'=>session('target_branch_serial'),
			'serial_user'=>$seriar_user
			]
		];
		$res=VisitHistory::upsert($visits, ['visit_history_serial']);
		echo $res;
	}

	public static function make_htm_get_treatment_slct_ajax(Request $request){
		$TargetTreatmentName=$request->target;
		$htm_TreatmentsName_slct='<select name="tr_content_slct" id="tr_content_slct">';
		$htm_TreatmentsName_slct.=OtherFunc::make_htm_get_treatment_slct($request->target);
		$htm_TreatmentsName_slct.='</select>';
		echo $htm_TreatmentsName_slct;
	}

	public static function make_htm_get_treatment_slct($TargetTreatmentName){
		$kana = array(
			"ア行" => "[ア-オあ-お]",
			"カ行" => "[カ-コガ-ゴか-こが-ご]",
			"サ行" => "[サ-ソザ-ゾさ-そざ-ぞ]",
			"タ行" => "[タ-トダ-ドた-とだ-ど]",
			"ナ行" => "[ナ-ノな-の]",
			"ハ行" => "[ハ-ホバ-ボパ-ポは-ほば-ぼぱ-ぽ]",
			"マ行" => "[マ-モま-も]",
			"ヤ行" => "[ヤ-ヨや-よ]",
			"ラ行" => "[ラ-ロら-ろ]",
			"ワ行" => "[ワ-ンわ-ん]",
			"その他" => ".*"
		);
		$treatmentInfArray=TreatmentContent::orderBy('name_treatment_contents_kana')->get();
		$htm_TreatmentsName_slct='<option value=0>-- 選択してください --</option>';
		$tgtGrp="";
		foreach($treatmentInfArray as $value){
			$sct="";
			$match = false;$flg=false;$cnt=0;$k=0;
			foreach ($kana as $index => $pattern) {
				if (preg_match("/^" . $pattern . "/u", $value->name_treatment_contents_kana)) {
					++$cnt;
					if($tgtGrp<>$index){
						$htm_TreatmentsName_slct.='<optgroup label="'.$index.'">';
						$tgtGrp=$index;
						if($cnt>1){$htm_TreatmentsName_slct.='</optgroup>';}
					};
					if(empty($TargetTreatmentName)){
						$sct='';
					}else{
						if($TargetTreatmentName==$value->name_treatment_contents){
							$sct='Selected';
						}
					}
					$htm_TreatmentsName_slct.='<option value="'.$value->name_treatment_contents.'" '.$sct.'>'.$value->name_treatment_contents.'</option>';
					break;
				}
				++$k;
			}
		}		
		return $htm_TreatmentsName_slct;
	}

	public static function make_QRCode($target_sentence,$save_path){
		$writer = new PngWriter();
		// Create QR code
		$qrCode = new QrCode(
			data: $target_sentence,
			encoding: new Encoding('UTF-8'),
			errorCorrectionLevel: ErrorCorrectionLevel::Low,
			size: 300,
			margin: 10,
			roundBlockSizeMode: RoundBlockSizeMode::Margin,
			foregroundColor: new Color(0, 0, 0),
			backgroundColor: new Color(255, 255, 255)
		);
		// Create generic logo
		$logo = new Logo(
			path: storage_path('images/Luxer_image.png'),
			resizeToWidth: 50,
			punchoutBackground: true
		);
		// Create generic label
		$label = new Label(
			text: $target_sentence,
			textColor: new Color(255, 0, 0)
		);
		$result = $writer->write($qrCode, $logo, $label);
		// Validate the result
		$writer->validateResult($result, $target_sentence);
		//header('Content-Type: '.$result->getMimeType());
		//echo $result->getString();
		// Save it to a file
		
		//$result->saveToFile(storage_path('images/'.$TargetStaffSerial.'.png'));
		$result->saveToFile($save_path);

		// Generate a data URI to include image data inline (i.e. inside an <img> tag)
		//$dataUri = $result->getDataUri();
	}

	public static function get_page_name($target_url){
		//http://127.0.0.1:8000/customers/ContractList/000003?_token=Bq24iKITp8X9Vqd4AngHwghkAPWSI28M90huRSGi&keiyaku_Btn=%E5%B1%A5%E6%AD%B4%E3%83%BB%E6%96%B0%E8%A6%8F&page_num=1  
		$target_url_array_1=explode("?", $target_url);
		$target_url_array_2=explode("/", $target_url_array_1[0]);//http://127.0.0.1:8000/customers/ContractList/000003
		$target_url_array_2_cnt=count($target_url_array_2);
		$target_name=$target_url_array_2[$target_url_array_2_cnt-1];
		if(str_contains($target_url,'customers')){
			$nameNum=array_search('customers', $target_url_array_2);
			$target_name=$target_url_array_2[$nameNum+1];
		}else if(is_numeric($target_name)){
			$target_name=$target_url_array_2[$target_url_array_2_cnt-2];
		}
		return $target_name;
	}

	public static function set_access_history($REFERER){
		//log::alert("REFERER=".$REFERER);
		$prevurl = url()->previous();
		$targetPage=1;
		if(isset($_SESSION['access_history'][0])){
			$access_history_0_name=self::get_page_name($_SESSION['access_history'][0]);
		}else{
			$access_history_0_name="";
		}
		$url_name_from=OtherFunc::get_page_name($REFERER);
		$url_name_now=OtherFunc::get_page_name($_SERVER['REQUEST_URI']);
		if($url_name_now==$url_name_from){
			if(str_contains($_SESSION['access_history'][0],$url_name_now)){
				array_splice($_SESSION['access_history'], 0,1);
			}
		}else{
			$target_referer="";
			if(!str_contains($REFERER,'update')){
				if(empty(session('target_livewire_page'))){
					$target_referer=$_SERVER['HTTP_REFERER'];
				}else{
					$target_referer=session('target_livewire_page');
				}
			}else if(!str_contains($_SERVER['REQUEST_URI'],'update')){
				$target_referer=$_SERVER['REQUEST_URI'];
			}
			/*
			else{
				$target_referer=$_SERVER['HTTP_REFERER'];
			}
			*/
			//$REFERER_name=self::get_page_name($_SERVER['HTTP_REFERER']);
			$REFERER_name=self::get_page_name($target_referer);
			$URI_name=self::get_page_name($_SERVER['REQUEST_URI']);
			if($url_name_now==$access_history_0_name){
				array_splice($_SESSION['access_history'], 0,1);
			}else{
				if($target_referer<>""){
					if(isset($_SESSION['access_history'][0]) && $URI_name<>$REFERER_name && !str_contains($URI_name, "update")){
						array_unshift($_SESSION['access_history'],$REFERER);
					}else if(empty($_SESSION['access_history'])){
						$_SESSION['access_history'][]=$REFERER;
					}
					if(str_contains($_SERVER['REQUEST_URI'], "?")){
						$REQUEST_URI_array=explode("?", $_SERVER['REQUEST_URI']);
						if(str_contains($REQUEST_URI_array[1], "page")){
							$targetPage=intval($REQUEST_URI_array[1]);
						}
					}
				}
			}
		}
		if(isset($_SESSION['access_history'][1]) && $_SESSION['access_history'][0]==$_SESSION['access_history'][1]){
			array_splice($_SESSION['access_history'], 1, 1);
		}
		//Livewireから違う画面にアクセスしたとき
		if(isset($_SESSION['access_history'][1])){
			$url_ck_array0=explode("/",$_SESSION['access_history'][0]);
			$url_ck_array1=explode("/",$_SESSION['access_history'][1]);
			$cnt=0;$flg=true;
			foreach($url_ck_array0 as $key){
				if($key<>$url_ck_array1[$cnt]){
					$flg=false;
					break;
				}
				$cnt++;
			}
			if($flg){
				array_splice($_SESSION['access_history'], 1, 1);
			}
			if(str_contains($_SESSION['access_history'][1], $url_name_from)){
				array_splice($_SESSION['access_history'], 0, 2);
			}
		}
		//$_SESSION[OtherFunc::get_page_name($_SESSION['access_history'][0])]=OtherFunc::get_page_num($_SESSION['access_history'][0]);
	}
	
	public static function getStaffDiffAttribute($time_in,$time_out){
		
		$in=strtotime(date($time_in));
		if(substr($time_in, -2)<>'00'){
			$roundUp = 1;
			$dateRoundUp_in = new Carbon($time_in);
			$dateRoundUp_in = $dateRoundUp_in->addMinutes($roundUp - $dateRoundUp_in->minute % $roundUp)->format('Y-m-d H:i:00');
			$in = strtotime(date($dateRoundUp_in));
		}
        $out=strtotime(date($time_out));
		if(substr($time_out, -2)<>'00'){
			$roundDown = 1;
			$dateRoundDown_out = new Carbon($time_out);
			$dateRoundDown_out = $dateRoundDown_out->subMinutes($dateRoundDown_out->minute % $roundDown)->format('Y-m-d H:i:00');
			$out = strtotime(date($dateRoundDown_out));
		}
        $diff = $out - $in;
		$diff_m = $diff / 60;
        if($diff_m<0){$diff_m=0;}
        return $diff_m;
    }

	public static function make_html_working_list_month_slct(){
		$month_now=date('m');
		$htm_month_slct='<select name="month_slct" id="month_slct" class="form-select">';
		$htm_month_slct.='<option  value="" Selected>--Select--</option>';
		for ($i=1; $i <= 12; $i++) {
			$sct="";
			if($i==$month_now){
				$sct='Selected';
			}
			$htm_month_slct .= '<option value="'.sprintf('%02d', $i).'" '.$sct.'>'.$i.'月</option>';
		}
		$htm_month_slct.='</select>';
		return $htm_month_slct;
	}

	public static function make_html_working_list_year_slct(){
		$htm_year_slct='<select name="year_slct" id="year_slct" class="form-select">';
		$htm_year_slct.='<option  value="" Selected>--Select--</option>';
		$start_year='2024';$year_now=date('Y');
		for($i = $start_year; $i<= $year_now; $i++){
			$sct='';
			if($i==$year_now){
				$sct='Selected';
			}
			$htm_year_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'年</option>';
		}
		$htm_year_slct.='</select>';
		return $htm_year_slct;
	}

	public static function complex($target_string){
		return decrypt($target_string);
	}
	public static function encryption($target_string){
		return encrypt($target_string);
	}

	public static function make_html_reason_coming_cbox($targetSbj,$referee){
		$reason_coming_array=explode(",", initConsts::ReasonsComing());
		$targetSbjArray=explode(",", $targetSbj);
		$htm_reason_coming_cbox='';$sonotaReason="";$reason_id="ri_1";
		foreach($reason_coming_array as $reason){
			$cked="";
			$htm_reason_coming_cbox.='<div class="form-check">';
			if(strstr($targetSbj, $reason)<>false){	$cked='checked';}
			if($reason<>"その他"){
				$htm_reason_coming_cbox.='<input class="form-check-input" type="checkbox" name="reason_coming_cbx[]" id="'.$reason_id.'" value="'.$reason.'" '.$cked.' />';
				$htm_reason_coming_cbox.='<label class="form-check-label" for="'.$reason_id.'">'.$reason.'</label></div>';
			}else{
				$htm_reason_coming_cbox.='<input class="form-check-input" type="checkbox" name="reason_coming_cbx[]" id="reason_coming_cbx_sonota" value="その他" onchange="reason_coming_sonota_manage();"'.$cked.' />';
				$htm_reason_coming_cbox.='<label class="form-check-label" for="reason_coming_cbx_sonota">その他</label>';
				if($cked=='checked'){
					$sonotaArray=array();
					$sonotaArray=explode("(", $targetSbj);
					if(count($sonotaArray)>1){
						$sonotaReason=str_replace(')', '', $sonotaArray[1]);
					}
				}
			}
			$reason_id++;
		}
		
		$htm_reason_coming_cbox.='<input name="reason_coming_txt" id="reason_coming_txt" type="text" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" value="'.$sonotaReason.'" /></div>';
		$htm_reason_coming_cbox.='<div class="row" style="py-3.5"><div class="col-auto">';
		$htm_reason_coming_cbox.='●紹介者(氏名を入力してください。自動でポイントは付きません。)</div><div class="col-auto"><input name="syokaisya_txt" id="syokaisya_txt" type="text" class="bg-white-500 border-solid pxtext-black rounded px-3 py-1" value="'.$referee.'"/></div>';
		return $htm_reason_coming_cbox;
	}

	public static function make_html_yearly_Report_table($targetYear,$startMonth){
		$target_contract_money_array=explode( ',',initConsts::TargetContractMoney());
		$sbj_array=array();
		$sbj_array=['月','契約金額合計(円)','累計契約金額(円)','解約損金合計(円)','累計解約損金(円)','合計(円)','累計合計(円)','目標値/入力・修正(円)','達成率(%)','前年度比(%)','契約金額合計(契約金-損金)(円)','目標値(円)','達成率(%)','契約金額合計(円)','目標値(円)','達成率(%)'];
		$htm_year_table="";
		foreach($sbj_array as $value){
			$htm_year_table.='<th class="border px-4 py-2">'.$value.'</th>';
		}

		$htm_year_table.='<tr>';
		$targetMonth=$startMonth;$ruikei_contract_amount=0;$ruikei_sonkin_amount=0;$ruikei_gokei=0;
		$ruikei_tm=0;$ruikei_contract_amount_last_year=0;$ruikei_tm_last_year=0;$ruikei_tm_last_year=0;$ruikei_gokei_last_year=0;
		$ruikei_contract_amount_last_last_year=0;$ruikei_sonkin_amount_last_last_year=0;$ruikei_contract_amount_last_last_year=0;
		$ruikei_tm_last_last_year=0;
		for($i=0;$i<12;$i++){
			$targetMonth++;
			if($targetMonth==13 and $startMonth<>2){
				$targetMonth=1;
				$targetYear=$targetYear+1;
			}
			$tm="No Data";$tm_last_year="No Data";$tm_last_last_year="No Data";
			foreach($target_contract_money_array as $target_contract_money){
				$target_contract_money_data_array=explode( '-',$target_contract_money);
				$cd=$targetYear."-".sprintf('%02d', $targetMonth);
				$target_last_Year=$targetYear-1;
				$cd_last_year=$target_last_Year."-".sprintf('%02d', $targetMonth);
				$target_last_last_Year=$targetYear-2;
				$tv=$target_contract_money_data_array[0]."-".sprintf('%02d', $target_contract_money_data_array[1]);

				if($cd==$tv){
					$tm=$target_contract_money_data_array[2];
					$flg=true;
				}
				if($cd_last_year==$tv){
					$tm_last_year=$target_contract_money_data_array[2];
					$flg_last_year=true;
				}
				if($target_last_last_Year==$tv){
					$tm_last_last_year=$target_contract_money_data_array[2];
					$flg_last_last_year=true;
				}
			}
			$contract_amount=self::get_keiyaku_monthly_amount($targetYear,$targetMonth);
			$contract_amount_last_year=self::get_keiyaku_monthly_amount($targetYear-1,$targetMonth);
			$contract_amount_last_last_year=self::get_keiyaku_monthly_amount($targetYear-2,$targetMonth);
			$ruikei_contract_amount_last_last_year=$ruikei_contract_amount_last_last_year+$contract_amount_last_last_year;
			$sonkin_amount=self::get_kaiyaku_monthly_sonkin_amount($targetYear,$targetMonth);
			$sonkin_amount_last_year=self::get_kaiyaku_monthly_sonkin_amount($targetYear-1,$targetMonth);
			$sonkin_amount_last_last_year=self::get_kaiyaku_monthly_sonkin_amount($targetYear-2,$targetMonth);

			$ruikei_contract_amount_last_last_year=$ruikei_contract_amount_last_last_year+$contract_amount_last_last_year;
			$ruikei_contract_amount=$ruikei_contract_amount+$contract_amount;
			
			$ruikei_contract_amount_last_year=$ruikei_contract_amount_last_year+$contract_amount_last_year;
			$ruikei_sonkin_amount_last_last_year=$ruikei_sonkin_amount_last_last_year+$sonkin_amount_last_last_year;
			$ruikei_sonkin_amount=$ruikei_sonkin_amount+$sonkin_amount;
			$gokei=$contract_amount-$sonkin_amount;
			$gokei_last_year=$contract_amount_last_year-$sonkin_amount_last_year;
			$gokei_last_last_year=$contract_amount_last_last_year-$sonkin_amount_last_last_year;

			$zennendo_hi="--";
			if($gokei_last_year<>0){
				$zennendo_hi=round($gokei/$gokei_last_year*100,1);
			}
			$ruikei_gokei=$ruikei_gokei+$gokei;
			$ruikei_gokei_last_year=$ruikei_gokei_last_year+$gokei_last_year;
			
			if($tm<>'No Data' and $gokei<>0){
				$tasseiritu=round($gokei/$tm*100,1);
			}else{
				$tasseiritu="--";
			}
			if($tm<>'No Data'){$ruikei_tm=$ruikei_tm+$tm;}
			if($tm_last_year<>'No Data' and $gokei_last_year<>0){
				$tasseiritu_last_year=round($gokei_last_year/$tm_last_year*100,1);
			}else{
				$tasseiritu_last_year="--";
			}
			if($tm_last_year<>'No Data'){$ruikei_tm_last_year=$ruikei_tm_last_year+$tm_last_year;}
						
			if($tm_last_last_year<>'No Data' and $gokei_last_last_year<>0){
				$tasseiritu_last_last_year=round($gokei_last_last_year/$tm_last_last_year*100,1);
			}else{
				$tasseiritu_last_last_year="--";
			}

			if($tm_last_last_year<>'No Data'){$ruikei_tm_last_last_year=$ruikei_tm_last_last_year+$tm_last_last_year;}

			$htm_year_table.='
				<tr>
					<td class="border px-4 py-2">'.$targetMonth.'月</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$contract_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_contract_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$sonkin_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_sonkin_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right;"><div id="'.$targetYear.'-'.sprintf('%02d', $targetMonth).'-gokei">'.$gokei.'</div></td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_gokei).'</td>
					<td class="border px-4 py-2">
						<button class="btn btn-link" name="'.$targetYear.'-'.sprintf('%02d', $targetMonth).'" value="'.$tm.'" onClick="save_target_contract_money(this)"><div id="'.$targetYear.'-'.sprintf('%02d', $targetMonth).'-display" style="text-align: right;">'.number_format((float)$tm).'</div></button>
					</td>
					<td class="border px-4 py-2"><div id="'.$targetYear.'-'.sprintf('%02d', $targetMonth).'-tassei" style="text-align: right;">'.$tasseiritu.'</div></td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$zennendo_hi).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$gokei_last_year).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tm_last_year).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tasseiritu_last_year).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$gokei_last_last_year).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tm_last_last_year).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tasseiritu_last_last_year).'</td>
				</tr>';
		}
		if($ruikei_tm>0){
			$tasseiritu_gokei=round($ruikei_gokei/$ruikei_tm*100,1);
		}else{
			$tasseiritu_gokei="--";
		}
		$zennendo_hi_gokei="--";
		if($gokei_last_year<>0){
			$zennendo_hi_gokei=round($ruikei_gokei/$gokei_last_year*100,1);
		}
		$tasseiritu_gokei_last_year="--";
		if($ruikei_tm_last_year<>0){
			$tasseiritu_gokei_last_year=round($ruikei_contract_amount_last_year/$ruikei_tm_last_year*100,1);
		}
		$gokeiamount_last_last_year=$ruikei_contract_amount_last_last_year-$ruikei_sonkin_amount_last_last_year;
		if($ruikei_tm_last_last_year<>0){
			$tasseiritu_last_last_year=round($ruikei_contract_amount_last_last_year/$ruikei_tm_last_last_year*100,1);
		}else{
			$tasseiritu_last_last_year="--";
		}

		$htm_year_table.='
			<tr>
				<td class="border px-4 py-2">合計</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$contract_amount).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_contract_amount).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$sonkin_amount).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_sonkin_amount).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$gokei).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_gokei).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_tm).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tasseiritu_gokei).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$zennendo_hi_gokei).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_contract_amount_last_year).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_tm_last_year).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tasseiritu_gokei_last_year).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_contract_amount_last_last_year).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$ruikei_tm_last_last_year).'</td>
				<td class="border px-4 py-2" style="text-align: right;">'.number_format((float)$tasseiritu_last_last_year).'</td>
			</tr>';
		return $htm_year_table; 
	}

	public static function get_goback_url($now_pageURL){
		$now_array=explode("?", $now_pageURL);
		$flg=preg_match('[.*'.$now_array[0].'.*]', $_SESSION['access_history'][1]);
		if($flg==true){
			for($i=0;$i<count($_SESSION['access_history']);$i++){
				$flg=preg_match('[.*'.$now_array[0].'.*]', $_SESSION['access_history'][$i]);
				if($i==0||$i==1){
					unset($_SESSION['access_history'][$i]);
				}else if($flg){
					unset($_SESSION['access_history'][$i]);	
				}else{
					break;
				}
			}
		}
		$_SESSION['access_history'] = array_values($_SESSION['access_history']);
		return $_SESSION['access_history'][0];
	}

	public static function get_customer_inf(Request $request){
		$TargetSerial=sprintf('%06d', $request->TargetSerial);
		$UserInf=User::where('serial_user','=',$TargetSerial)->first();
		if(empty($UserInf)){
			$UserInf=array();
			$UserInf=array('count'=>'0');
			$UserInf=json_encode($UserInf);
		}
		return $UserInf;
	}

	public static function serch_http_referer($target_page_array){
		foreach ($_SESSION['access_history'] as $url) {
			foreach($target_page_array as $tgt){
				if(str_contains($url,$tgt)){
					$referer=$url;
					break;
				}
			}
		}
		return $url;
	}

	public static function make_html_birth_month_slct($targetMonth){
		$htm_month_slct='<select name="month" class="form-select">';
		$htm_month_slct.='<option  value="" Selected>--選択してください。--</option>';
		for($i=1;$i<=12;$i++){
			$selected="";
			if($targetMonth==sprintf('%02d', $i)){
				$selected="selected";
			}
			$htm_month_slct.='<option value="'.sprintf('%02d', $i).'" '.$selected.' >'.sprintf('%02d', $i).'</option>';
		}
		$htm_month_slct.='</select>';
		return $htm_month_slct;
	}

	public static function make_html_birth_day_slct($targetDay){
		$htm_day_slct='<select name="day" class="form-select">';
		$htm_day_slct.='<option  value="" Selected>--選択してください。--</option>';
		for($i=1;$i<=31;$i++){
			$selected="";
			if($targetDay==$i){
				$selected="selected";
			}
			$htm_day_slct.='<option value="'.sprintf('%02d', $i).'" '.$selected.' >'.sprintf('%02d', $i).'</option>';
		}
		$htm_day_slct.='</select>';
		return $htm_day_slct;
	}

	public static function make_html_birth_year_slct($targetYear){
		$htm_year_slct='<select name="year" class="form-select">';
		$htm_year_slct.='<option  value="" Selected>--選択してください。--</option>';
		$year_now=date('Y');
		$start_year=$year_now-50;
		for($i = $start_year; $i<= $year_now; $i++){
			$sct='';
			if($i==$targetYear){
				$sct='Selected';
			}
			$htm_year_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'</option>';
		}
		$htm_year_slct.='</select>';
		return $htm_year_slct;
	}

	public static function make_html_staff_inout_slct($targetStaffSerial){
		$htm_staff_slct="";
		$htm_staff_slct='<option value="">すべて</option>';
		$staff_array=Staff::all();
		foreach($staff_array as $staff) {
			$sct='';
			if($staff->serial_staff==$targetStaffSerial){
					$sct='selected';
			}
			$htm_staff_slct.='<option value="'.$staff->serial_staff.'" '.$sct.'>'.$staff->last_name_kanji.' '.$staff->first_name_kanji.'</option>';
		}
		return $htm_staff_slct;
	}

	public static function make_html_staff_slct($targetStaffSerial){
		$htm_staff_slct="";
		$htm_staff_slct='<select name="staff_slct" id="staff_slct" class="form-select form-select-sm">';
		$htm_staff_slct.='<option value="">-- 選択してください --</option>';
		$staff_array=Staff::get();
		foreach($staff_array as $staff) {
			$sct='';
			if($staff->serial_staff==$targetStaffSerial){$sct='Selected="Selected"';}
			$htm_staff_slct.='<option value="'.$staff->serial_staff.'" '.$sct.'>'.$staff->last_name_kanji.' '.$staff->first_name_kanji.'</option>';
		}
		$htm_staff_slct.='</select>';
		return $htm_staff_slct;
	}

	static function get_kaiyaku_monthly_sonkin_amount($targetyear,$targetmonth){
		$target=$targetyear."-".sprintf('%02d', $targetmonth)."%";
		$sonkin=Contract::where('cancel','LIKE',$target)
				->where('how_to_pay','=','現金')
				->selectRaw('SUM(keiyaku_kingaku) as total')
				->first(['total']);
		return $sonkin->total;
	}

	static function get_keiyaku_monthly_amount($targetyear,$targetmonth){
		$target=$targetyear."-".sprintf('%02d', $targetmonth)."%";
		$TotalAmount=Contract::where('keiyaku_bi','LIKE',$target)
				->selectRaw('SUM(keiyaku_kingaku) as total')
				->first(['total']);
		return $TotalAmount->total;
	}

	public static function get_page_num($target_url){
		$pn=1;
		$page_num_key_array=['page=','page_num='];
		foreach($page_num_key_array as $page_num_key){
			$page_num_array=explode($page_num_key,$target_url);
			if(isset($page_num_array[1])){
				$pn=$page_num_array[1];
				break;
			}
		}
		return $pn;
	}

	public static function make_htm_get_default_user(){
		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei','payment_histories.serial_user')->get();
		$targetNameHtm="";$targetNameHtm_array=array();
		foreach($DefaultUsersInf as $value){
			$targetNameHtm_array[]='<button type="submit" name="btn_serial" class="btn btn-outline-danger mx-sm-2" value="'.$value->serial_user.'">'.$value->name_sei.' '.$value->name_mei.'&nbsp;</button>';
		}
		$targetNameHtm=implode( "・", $targetNameHtm_array);
		return $targetNameHtm;
	}

	public static function make_htm_get_not_coming_customer(){
		$today = new DateTime('now');
		$keyakukaisu=Contract::where('cancel','=',null)
			->where('how_to_pay','=','現金')
			->get();
		$targetName=array();$targetNameHtmFront=array();$targetNameHtmBack=array();
		$targetNameHtm="";$targetNameHtm_array=array();
		foreach($keyakukaisu as $value){
			$num_payed=DB::table('payment_histories')->where('serial_keiyaku','=',$value->serial_keiyaku)->count();
			if($num_payed<$value->how_many_pay_genkin){
				$payment_date_latest=DB::table('payment_histories')->where('serial_keiyaku','=',$value->serial_keiyaku)->max('date_payment');
				$payment_date_latest_dt = new DateTime($payment_date_latest);
				$diff = $today->diff($payment_date_latest_dt);
				$interval_day=$diff->format('%a');
				if($interval_day>30){
					$terget_user=DB::table('users')->where('serial_user','=', $value->serial_user)->first();
					$targetNameHtm_array[]='<input type="submit" class="btn btn btn-outline-dark mx-sm-2" formaction="/customers/ShowInpRecordVisitPayment/'.$value->serial_keiyaku.'/'.$value->serial_user.'" name="btn_serial" value="'.$terget_user->name_sei.' '.$terget_user->name_mei.'">';
				}
			}
		}
		$targetNameHtm=implode( "・", $targetNameHtm_array);
		return $targetNameHtm;
	}

	public static function make_html_TreatmentsTimes_slct($targetTimes){
		$htm_TreatmentsTimes_slct='';
		$htm_TreatmentsTimes_slct='<select name="TreatmentsTimes_slct" id="TreatmentsTimes_slct" class="cyclic">';
		$htm_TreatmentsTimes_slct.='<option value=0>-- 選択してください --</option>';

		for($i = 1; $i<= initConsts::MaxTreatmentsTimes(); $i++){
			$sct='';
			if($i==$targetTimes){$sct='Selected';}
			$htm_TreatmentsTimes_slct.='<option value="'.$i.'" '.$sct.'>'.$i.'</option>';
		}
		$htm_TreatmentsTimes_slct.='</select>';
		return $htm_TreatmentsTimes_slct;
	}
	
	public static function get_prefecture_name_by_region($targetRegion){
		$pref_codes = array("1" => "北海道", "2" => "青森県", "3" => "岩手県", "4" => "宮城県", "5" => "秋田県", "6" => "山形県", "7" => "福島県", "8" => "茨城県", "9" => "栃木県", "10" => "群馬県", "11" => "埼玉県", "12" => "千葉県", "13" => "東京都", "14" => "神奈川県", "15" => "新潟県", "16" => "富山県", "17" => "石川県", "18" => "福井県", "19" => "山梨県", "20" => "長野県", "21" => "岐阜県", "22" => "静岡県", "23" => "愛知県", "24" => "三重県", "25" => "滋賀県", "26" => "京都府", "27" => "大阪府", "28" => "兵庫県", "29" => "奈良県", "30" => "和歌山県", "31" => "鳥取県", "32" => "島根県", "33" => "岡山県", "34" => "広島県", "35" => "山口県", "36" => "徳島県", "37" => "香川県", "38" => "愛媛県", "39" => "高知県", "40" => "福岡県", "41" => "佐賀県", "42" => "長崎県", "43" => "熊本県", "44" => "大分県", "45" => "宮崎県", "46" => "鹿児島県", "47" => "沖縄県");
		return $pref_codes[$targetRegion];
	}

	public static function make_html_contract_report_table($targetYear,$targetMonth){
		$sbj_array=array();
		$sbj_array=['日','契約金額合計','累計契約金額','解約損金合計','累計解約損金','合計','累計合計','契約人数','累計契約数','契約率'];
		$htm_month_table='<table class="table-auto" border-solid><thead><tr>';
		foreach($sbj_array as $value){
			$htm_month_table.='<th class="border px-4 py-2">'.$value.
			'<!--<button type="button" wire:click="sort(\'serial_user-ASC\')"><img src="{{ asset(\'storage/images/sort_A_Z.png\') }}" width="15px" /></button>
			<button type="button" wire:click="sort(\'serial_user-Desc\')"><img src="{{ asset(\'storage/images/sort_Z_A.png\') }}" width="15px" /></button>-->
			</th>';
		}
		$date = $targetYear.'-'.$targetMonth;
		$begin = new DateTime(date('Y-m-d', strtotime('first day of '. $date)));
		$end = new Datetime(date('Y-m-d', strtotime('first day of next month '. $date)));
		$interval = new DateInterval('P1D');
		$daterange = new DatePeriod($begin, $interval, $end);
		$htm_month_table.='<tbody>';
		session(['TotalSalesRuikei' =>0]);session(['KeiyakukinRuikei' =>0]);$ruikei_keiyaku_amount=0;$ruikei_contract_cnt=0;$ruikei_sonkin=0;
		foreach($daterange as $date){
			session(['TotalSales' => 0]);
			$contract_cnt=self::get_contract_cnt($date->format("Y-m-d"));
			$contract_amount=self::get_keiyaku_amount($date->format("Y-m-d"));
			$sonkin=self::get_kaiyaku_sonkin_amount($date->format("Y-m-d"));
			$ruikei_sonkin=$ruikei_sonkin+$sonkin;
			$ruikei_keiyaku_amount=$ruikei_keiyaku_amount+$contract_amount;
			$ruikei_contract_cnt=$ruikei_contract_cnt+$contract_cnt;
			$yobi= self::day_of_the_week_dtcls($date->format('w'));
			
			$colorRed="";
			if($yobi=='日'){
				$colorRed='style="color:red"';
			}else if($yobi=='土'){
				$colorRed='style="color:blue"';
			}
			$fontColorRed="";$fontColorRedRuikei="";
			if($sonkin<0){$fontColorRed='color: red;';}
			if($ruikei_sonkin<0){$fontColorRedRuikei='color: red;';}
			$htm_month_table.='
				<tr>
					<td class="border px-4 py-2"><span '.$colorRed.'>'.$date->format("Y-m-d").'('.$yobi.')</span></td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($contract_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right">'.number_format($ruikei_keiyaku_amount).'</td>
					<td class="border px-4 py-2" style="text-align: right;'.$fontColorRed.'">'.number_format($sonkin).'</td>
					<td class="border px-4 py-2" style="text-align: right;'.$fontColorRedRuikei.'">'.number_format($ruikei_sonkin).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($contract_amount+$sonkin).'</td>
					<td class="border px-4 py-2" style="text-align: right;">'.number_format($ruikei_sonkin+$ruikei_keiyaku_amount).'</td>
					<td class="border px-4 py-2">'.$contract_cnt.'</td>
					<td class="border px-4 py-2">'.$ruikei_contract_cnt.'</td>
					<td class="border px-4 py-2">&nbsp;</td>
				</tr>';
		}
		$htm_month_table.='</tbody>';
		$htm_month_table.='</tr></thead></table>';
		return array($htm_month_table, $ruikei_keiyaku_amount ,$ruikei_contract_cnt); 
	}
	
	static function get_kaiyaku_sonkin_amount($targetDay){
		$keiyakuKingaku=DB::table('contracts')
			->where('deleted_at','=',NULL)
			->where('cancel','=',$targetDay)->get();
		$sonkinTotal=0;
		foreach($keiyakuKingaku as $value){
			$paied_kingaku=DB::table('payment_histories')->where('serial_keiyaku','=',$value->serial_keiyaku)
				->selectRaw('SUM(amount_payment) as total')
				->first(['total']);
			$sonkin=$paied_kingaku->total-$value->keiyaku_kingaku;
			$sonkinTotal=$sonkinTotal+$sonkin;
		}
		session(['sonkinTotal' =>$sonkinTotal]);
		session(['sonkinRuikei' =>session('sonkinRuikei')+$sonkinTotal]);
		return $sonkinTotal;
	}
	
	public static function get_keiyaku_amount($targetDay){
		$TargetQuery=DB::table('contracts');
		$TargetQuery=$TargetQuery->where('deleted_at','=',NULL)
			->where('keiyaku_bi','=',$targetDay);
		$TargetQuery=$TargetQuery->selectRaw('SUM(keiyaku_kingaku) as total');
		$TotalAmount=$TargetQuery->first(['total']);
		$total=$TotalAmount->total+session('TotalSales');
		session(['Keiyakukin' =>$total]);
		session(['KeiyakukinRuikei' =>session('KeiyakukinRuikei')+$TotalAmount->total]);
		return $TotalAmount->total;
	}
		
	public static function get_raitenReason($targetYear,$targetMonth){
		$key=$targetYear."-".sprintf('%02d', $targetMonth);
		$reason_coming_array=explode(",", initConsts::ReasonsComing());
		$htm_raitenReason_array=array();
		foreach($reason_coming_array as $value){
			$reason_cnt=0;
			$reason_cnt=DB::table('users')
			->where('deleted_at','=',NULL)
			->where('admission_date','like',$key."%")
			->where('reason_coming','like',"%".$value."%")
			->count();
			$htm_raitenReason_array[]=$value." : ".$reason_cnt;
		}
		$htm_raitenReason=implode("&nbsp;&nbsp;",$htm_raitenReason_array);
		return $htm_raitenReason; 
	}

	public static function get_contract_cnt($targetDay){
		$contract_cnt=DB::table('contracts')
			->where('deleted_at','=',NULL)
			->where('keiyaku_bi','=',$targetDay)
			->count();
		return $contract_cnt; 
	}

	public static function get_raijyosyasu_cnt($targetDay){
		$visiters_inf_array=DB::table('visit_histories')
			->where('deleted_at','=',NULL)
			->where('date_visit','=',$targetDay)
			->get();
		$new_visiters_cnt=0;$all_visiters_cnt=0;$member_visiters_cnt=0;
		foreach($visiters_inf_array as $visiters_inf){
			$get_min_visit=DB::table('visit_histories')
				->where('serial_user','=',$visiters_inf->serial_user)
				->min('date_visit');
			if($get_min_visit==$targetDay){
				$new_visiters_cnt++;
			}else{
				$member_visiters_cnt++;
			}
			$all_visiters_cnt++;
		}
		session(['new_visiters_cnt' =>$new_visiters_cnt]);
		session(['member_visiters_cnt' =>$new_visiters_cnt]);
		session(['all_visiters_cnt' =>$all_visiters_cnt]);
		return array($new_visiters_cnt, $member_visiters_cnt,$all_visiters_cnt); 
	}

	public static function day_of_the_week_dtcls($w){
		$aWeek = array(
			'日',//0
			'月',//1
			'火',//2
			'水',//3
			'木',//4
			'金',//5
			'土'//6
		);
		return $aWeek["$w"];
	}

	public static function make_html_month_slct($targetMonth){
		$htm_month_slct='';
		for($i = 1; $i<= 12; $i++){
			$sct='';
			if($i==$targetMonth){$sct='Selected';}
			$htm_month_slct.='<option value="'.$i.'" '.$sct.'>'.$i.'月</option>';
		}
		return $htm_month_slct;
	}

	public static function make_html_year_slct($targetYear){
		$htm_year_slct='';
		for($i = 2015; $i<= $targetYear; $i++){
			$sct='';
			if($i==$targetYear){$sct='Selected';}
			$htm_year_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'年</option>';
		}
		return $htm_year_slct;
	}

	public static function make_html_customer_list_slct($targetUserSerial){
		$kana = array(
			"ア行" => "[ア-オ]",
			"カ行" => "[カ-コガ-ゴ]",
			"サ行" => "[サ-ソザ-ゾ]",
			"タ行" => "[タ-トダ-ド]",
			"ナ行" => "[ナ-ノ]",
			"ハ行" => "[ハ-ホバ-ボパ-ポ]",
			"マ行" => "[マ-モ]",
			"ヤ行" => "[ヤ-ヨ]",
			"ラ行" => "[ラ-ロ]",
			"ワ行" => "[ワ-ン]",
			"その他" => ".*"
		);
		$html_customer_list_slct=array();
		$customers=DB::table('users')->where('deleted_at','=',NULL)->orderBy('name_sei_kana')->orderBy('name_mei_kana')->get();
		$html_customer_list_slct='<option value=0>-- 選択してください --</option>';
		$tgtGrp="";
		foreach($customers as $value){
			$match = false;$flg=false;$cnt=0;$k=0;
			foreach ($kana as $index => $pattern) {
				if (preg_match("/^" . $pattern . "/u", $value->name_sei_kana)) {
					++$cnt;
					if($tgtGrp<>$index){
						$html_customer_list_slct.='<optgroup label="'.$index.'">';
						$tgtGrp=$index;
						if($cnt>1){$html_customer_list_slct.='</optgroup>';}
					};
					$sct='';
					if($targetUserSerial==$value->serial_user){$sct='Selected';}
					$html_customer_list_slct.='<option value="'.$value->serial_user.'" '.$sct.'>'.$value->name_sei.' '.$value->name_mei.'</option>';
					break;
				}
				++$k;
			}
		}		
		return $html_customer_list_slct;
	}

	public static function make_html_sales_good_slct($targetSerial){
		$htm_goods_slct='<option value=0>-- 選択してください --</option>';
		$cmp="";
		$goods=DB::table('goods')->orderBy('model_number')->get();
		foreach($goods as $good){
			$sct='';
			if($targetSerial==$good->serial_good){$sct='Selected';}
			$htm_goods_slct.='<option  value="'.$good->serial_good.'" '.$sct.'>'.$good->model_number.' '.$good->good_name.'</option>';
		}
		return $htm_goods_slct;
	}

	public static function make_html_how_many_slct($targetNum,$MaxNum,$MinmumNUm){
		$htm_num_slct="";
		for($i=$MinmumNUm;$i<=$MaxNum;$i++){
			$sct='';
			if($targetNum==$i){$sct='selected';}
			$htm_num_slct.='<option  value="'.$i.'" '.$sct.'>'.$i.'</option>';
		}
		return $htm_num_slct;
	}

	public static function make_html_card_company_slct($targetCompany){
		$cmp="";
		$cmps=DB::table('configrations')->select('value1')->where('subject', '=', 'Card Company')->get();
		foreach($cmps as $cmp){
			$cmp= $cmp->value1;
		}
		$companyArray=array();
		$companyArray=explode(",",$cmp);
		$htm_company_slct="";
		foreach ($companyArray as $company){
			$sct='';
			if($company==$targetCompany){$sct='Selected';}
			$htm_company_slct.='<option  value="'.$company.'" '.$sct.'>'.$company.'</option>';
		}
		return $htm_company_slct;
	}

	public static function make_html_keiyaku_num_slct($targetNum){
		$keiyaku_num = DB::table('configrations')->select('value1')->where('subject', '=', 'KeiyakuNumMax')->first();
		$htm_keiyaku_num_slct="";
		for ($num=1;$num<=$keiyaku_num->value1 ;$num++){
			$sct='';
			if($targetNum==$num){$sct='Selected';}
			$htm_keiyaku_num_slct.='<option  value="'.$num.'" '.$sct.'>'.$num.'</option>';
		}
		return $htm_keiyaku_num_slct;
	}

	public static function make_teacher_schedule_for_btnStyle($teacherSerial,$studentSerial){
		$MinimumLessonTimeInterval=initConsts::MinimumLessonTimeInterval();
		$target_tercher_schedules_array=DB::table('Schedules')
			->where('endUNIXTimeStamp','>',time())
			->where('deleted_at','=',null)
			->where(function($query) use($teacherSerial,$studentSerial){
					$query->where('idPerson', $teacherSerial)
					->orwhere('idPerson', '<>', $studentSerial);
			})->orderBy('startUNIXTimeStamp')->get();
		$open_schedule_array = array();
		$cnt=0;
		foreach($target_tercher_schedules_array as $target_tercher_schedules){
			$startUnix = $target_tercher_schedules->startUNIXTimeStamp;
			$endUnix=$target_tercher_schedules->endUNIXTimeStamp;
			$target_event_id=$target_tercher_schedules->event_id;
			$start_time_unix_array=self::make_interval_for_reservation_btn_array($startUnix,$endUnix);
			foreach($start_time_unix_array as $start_time_unix){
				$end_time_unix=$start_time_unix+(initConsts::LessonInterval()*60);
				$open_schedule_array[$cnt]["start"]=date('Y-m-d H:i:s', $start_time_unix);
				$open_schedule_array[$cnt]["startUnix"]=$start_time_unix;
				$open_schedule_array[$cnt]["end"]=date('Y-m-d H:i:s',$end_time_unix);
				$open_schedule_array[$cnt]["endUnix"]=$end_time_unix;
				$open_schedule_array[$cnt]["editable"] = true;
				//$open_schedule_array[$cnt]["editable"] = false;
				$open_schedule_array[$cnt]["color"] = 'green';
				$open_schedule_array[$cnt]["id"] =  $target_tercher_schedules->event_id;
				$open_schedule_array[$cnt]["title"] =$target_tercher_schedules->title;
				$open_schedule_array[$cnt]["eventDurationEditable"] =false; //移動不可
				$cnt++;
			}
		}
		return $open_schedule_array;
	}

	public static function make_interval_for_reservation_btn_array($open_start_time_unuix,$open_end_time_unuix){
		$start_time_unuix_array=array();
		$rest_time_unix=initConsts::RestTime()*60;
		$lesson_interval_unix=initConsts::LessonInterval()*60;
		$lesson_cycle_unix=$rest_time_unix+$lesson_interval_unix;
		for($i = $open_start_time_unuix; $i <= $open_end_time_unuix-$lesson_cycle_unix; $i=$i+$lesson_cycle_unix) {
			$start_time_unuix_array[]=$i;
		}
		return $start_time_unuix_array;
	}

	public static function get_teacher_schedule_for_btnStyle($teacherSerial,$studentSerial){
		$MinimumLessonTimeInterval=initConsts::MinimumLessonTimeInterval();
		$target_tercher_schedules_array=DB::table('Schedules')->
			where('endUNIXTimeStamp','>',time())
			->where('deleted_at','=',null)
			->where(function($query) use($teacherSerial,$studentSerial){
					$query->where('idPerson', $teacherSerial)
					->orwhere('idPerson', '<>', $studentSerial);
			})->orderBy('startUNIXTimeStamp')->get();

		$open_schedule_array = array();
		$cnt=0;
		foreach($target_tercher_schedules_array as $target_tercher_schedules){
			$startUnix = $target_tercher_schedules->startUNIXTimeStamp;
			$endUnix=$target_tercher_schedules->endUNIXTimeStamp;
			$target_event_id=$target_tercher_schedules->event_id;
			$start_time_unix_array=self::make_interval_for_reservation_btn_array($startUnix,$endUnix);
			//予約済みのレッスンを探す			
			foreach($start_time_unix_array as $start_time_unix){
				$end_time_unix=$start_time_unix+(initConsts::LessonInterval()*60);
				$clr='green';
				$tget=DB::table('Schedules')
					->where('deleted_at','=',null)
					->where('idPerson','=',$studentSerial)
					->where('startUNIXTimeStamp','=',$start_time_unix)
					->where('endUNIXTimeStamp','=',$end_time_unix)
					->where('idTeacher','=',$teacherSerial)->first();
				if($tget !== null){
					if($tget->LessonRequestResult=="seiritu"){
						$clr='blue';
					}else if($tget->LessonRequestResult=="ukenai"){
						$clr='gray';
					}
				}
				$open_schedule_array[$cnt]["start"]=date('Y-m-d H:i:s', $start_time_unix);
				$open_schedule_array[$cnt]["startUnix"]=$start_time_unix;
				$open_schedule_array[$cnt]["end"]=date('Y-m-d H:i:s',$end_time_unix);
				$open_schedule_array[$cnt]["endUnix"]=$end_time_unix;
				$open_schedule_array[$cnt]["editable"] = true;
				$open_schedule_array[$cnt]["color"] = $clr;
				$open_schedule_array[$cnt]["id"] =  $target_tercher_schedules->event_id;
				$open_schedule_array[$cnt]["title"] =$target_tercher_schedules->title;
				$open_schedule_array[$cnt]["eventDurationEditable"] =false; //移動不可
				$cnt++;
			}
		}
		return $open_schedule_array;
	}

	public static function get_teacher_schedule_without_reserved($teacherSerial,$studentSerial){
		$MinimumLessonTimeInterval=initConsts::MinimumLessonTimeInterval();
		$target_tercher_schedules_array=DB::table('Schedules')->where('endUNIXTimeStamp','>',time())
			->where(function($query) use($teacherSerial,$studentSerial){
					$query->where('idPerson', $teacherSerial)
					->orwhere('idPerson', '<>', $studentSerial);
			})->orderBy('startUNIXTimeStamp')->get();
		$open_schedule_array = array();
		$cnt=0;
		foreach($target_tercher_schedules_array as $target_tercher_schedules){
			$startOriginal = str_replace(' (日本標準時)', '', $target_tercher_schedules->startOriginal);
			$endOriginal= str_replace(' (日本標準時)', '', $target_tercher_schedules->endOriginal);
			$startUnix = $target_tercher_schedules->startUNIXTimeStamp;
			$endUnix=$target_tercher_schedules->endUNIXTimeStamp;
			if($cnt==0){
				$open_schedule_array[$cnt]["start"]=date('Y-m-d H:i:s',  strtotime($startOriginal));
				$last_end=$endOriginal;
				$open_schedule_array[$cnt]["startUnix"]=$startUnix;
				$last_end_unix=$endUnix;
			}else{	
				if($cnt>0){
					$open_schedule_array[$cnt-1]["end"]=date('Y-m-d H:i:s',  strtotime($startOriginal));
					$open_schedule_array[$cnt-1]["endUnix"]=$startUnix;
				}
				$open_schedule_array[$cnt]["start"]=date('Y-m-d H:i:s',  strtotime($endOriginal));
				$open_schedule_array[$cnt]["startUnix"]=$endUnix;
			}
			$open_schedule_array[$cnt]["editable"] = false;
			$open_schedule_array[$cnt]["color"] = 'green';
			$open_schedule_array[$cnt]["id"] =  $target_tercher_schedules->event_id;
			$cnt++;
		}
		$open_schedule_array[$cnt-1]["end"]=date('Y-m-d H:i:s',  strtotime($last_end));
		$open_schedule_array[$cnt-1]["endUnix"]=$last_end_unix;
		$MinimumLessonTimeInterval=initConsts::MinimumLessonTimeInterval();
		$array_cnt=count($open_schedule_array);
		for($i=0;$array_cnt>$i;$i++){
			$interval=$open_schedule_array[$i]["endUnix"]-$open_schedule_array[$i]["startUnix"];
			$tm=$MinimumLessonTimeInterval*60;
			if($MinimumLessonTimeInterval*60>=$interval){
				unset($open_schedule_array[$i]);
			}
		}
		
		$open_schedule_array = array_values($open_schedule_array);
		session(['ReservationAvailableByTeacher' => $open_schedule_array]);
		
		$target_student_schedules_array=DB::table('Schedules')->where('idTeacher',$teacherSerial)->where('endUNIXTimeStamp','>',time())->where('idPerson','=',$studentSerial)->where('deleted_at','=',null)->orderBy('startUNIXTimeStamp')->get();
		
		$close_schedule_user_array=array();$cnt=0;
		foreach($target_student_schedules_array as $target_student_schedules){
			$startOriginal = str_replace(' (日本標準時)', '', $target_student_schedules->startOriginal);
			$endOriginal= str_replace(' (日本標準時)', '', $target_student_schedules->endOriginal);
			$close_schedule_user_array[$cnt]["startUnix"]=$target_student_schedules->startUNIXTimeStamp;
			$close_schedule_user_array[$cnt]["endUnix"]=$target_student_schedules->endUNIXTimeStamp;
			$close_schedule_user_array[$cnt]["start"]=date('Y-m-d H:i:s',  strtotime($startOriginal));
			$close_schedule_user_array[$cnt]["end"]=date('Y-m-d H:i:s',  strtotime($endOriginal));
			$close_schedule_user_array[$cnt]["editable"] = true;
			$close_schedule_user_array[$cnt]["color"] = 'blue';
			$close_schedule_user_array[$cnt]["id"] =  $target_student_schedules->event_id;
			$reservation_number=$target_student_schedules->reservation_number;
			$close_schedule_user_array[$cnt]["title"] =$target_student_schedules->title.$reservation_number;
			$cnt++;
		}
		session(['close_schedule_user_array' => $close_schedule_user_array]);
		$open_schedule_array_all=array();
		$open_schedule_array_all = array_merge($open_schedule_array,$close_schedule_user_array);		
		return $open_schedule_array_all;
	}

	public static function get_teacher_info_By_eventID($eventID){
		$param = ['eid' => $eventID];
		$teacher_info=DB::select('SELECT * FROM teachers WHERE serial_teacher IN (SELECT idTeacher FROM Schedules WHERE event_id = "'.$eventID.'")');
		foreach ($teacher_info as $teachers_info){
			$teacher=$teachers_info;
		}
		return $teacher;
	}

	public static function get_teacher_info_By_serial($serial_teacher){
		$teacher_info=DB::select('SELECT * FROM teachers WHERE serial_teacher = "'.$serial_teacher.'"');
		$teacher="";
		foreach ($teacher_info as $teachers_info){
			$teacher=$teachers_info;
		}
		return $teacher;
	}

	public static function get_user_id_By_eventID($eventID){
		$idPerson=DB::table('Schedules')->where('event_id',$eventID)->first("idPerson");
		return $idPerson;
	}

	public static function make_html_rdiobtn_course_for_calender_by_teacher_serial($teacher_serial){
		$target_instruments_array = DB::table('teachers')->select('instruments')->where('serial_teacher', $teacher_serial)->first();
		$htms=array();
		foreach ($target_instruments_array as $key => $instruments){
			$instrument_array=explode(",", $instruments);
			foreach($instrument_array as $instrumentSerial){ 
				$InstrumentName=self::getInstrumentNameBySerial($instrumentSerial);
				$htms[]='<label><input name="instruments_rdibtn" type="radio" value="'.$instrumentSerial.'" />'.$InstrumentName.'</label>';
			}
		}
		$htm= implode($htms);
		return $htm;
	}

	public static function make_html_select_instruments_for_teacher(){
		$inf_instruments = DB::table('instruments')->get();
		$htms=array();
		foreach ($inf_instruments as $inf_instrument){
			$teacher_inf=Auth::guard('teacher')->user();
			$ck="";
			if(strpos($teacher_inf['instruments'],$inf_instrument->serial_instrument)!== false){
				$ck='checked="checked"';
			}
			$htms[]='<label><input '.$ck.' name="instruments_ckbx[]" type="checkbox" value="'.$inf_instrument->serial_instrument.'" />'.$inf_instrument->instrument_jp.'</label>';
		}
		$htm= implode($htms);
		return $htm;
	}
	
	public static function get_event(){
		$open_schedules = DB::table('open_of_teachers')->get();
		$data = [];
		$ev=array();$newItem=array();
		foreach ($open_schedules as $open_schedule){ 
			$ev = ['id'=>$open_schedule->serial,'title'=>$open_schedule->serial_teacher,'start'=>$open_schedule->date.'T'.$open_schedule->start_time,'color'=>'lightpink'];
			array_push($data,$ev);
			$newItem["id"] = $open_schedule->serial;
			$newItem["title"] = $open_schedule->serial_teacher;
			$newItem["start"] = $open_schedule->date;
			$newArr[] = $newItem;
		}
		return $newArr;
	}
	
	public static function makeLessonTimeNumber(){
		$target_key = "%LT".date("ymd")."%";
		$resRnum = DB::table('Schedules')->select('reservation_number')->where('reservation_number', 'like', $target_key)->orderByDesc('Schedules.reservation_number', 'DESC')->first();
		if($resRnum==""){
			$resnum="LT".date("ymd")."-0001";
		}else{
			$resnum=$resRnum->reservation_number;
			$resnum++;
		}
		return $resnum;
	}

	public static function makeReservationNumber(){
		$target_key = "%R".date("ymd")."%";
		$resRnum = DB::table('Schedules')->select('reservation_number')->where('reservation_number', 'like', $target_key)->orderByDesc('Schedules.reservation_number', 'DESC')->first();
		if($resRnum==""){
			$resnum="R".date("ymd")."-0001";
		}else{
			$resnum=$resRnum->reservation_number;
			$resnum++;
		}
		return $resnum;
	}
 
	public static function make_html_slct_keiyaku_end_day_slct($targetDay){
		$htm_keiyaku_day_slct="";
		$this_day=date("d");
		for($i=1;$i<=31;$i++){
			$selected="";
			if($this_day==$i-1){
				$selected="selected";
			}
			$htm_keiyaku_day_slct.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_day_slct;
	}

	public static function make_html_slct_keiyaku_end_month_slct($targetMonth){
		$htm_keiyaku_month_slct="";
		$this_month=date("m");
		for($i=1;$i<=12;$i++){
			$selected="";
			if($this_month==$i){
				$selected="selected";
			}
			$htm_keiyaku_month_slct.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_month_slct;
	}

	public static function make_html_slct_keiyaku_end_year_slct($targetYear){
		$htm_keiyaku_year_list="";
		$this_year=date("Y");
		for($i=$this_year;$i<=$this_year+2;$i++){
			$selected="";
			if($this_year==$i+1){
				$selected="selected";
			}
			$htm_keiyaku_year_list.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_year_list;
	}

	public static function make_html_slct_keiyaku_day_slct($targetDay){
		$htm_keiyaku_day_slct="";
		$this_day=date("d");
		for($i=1;$i<=31;$i++){
			$selected="";
			if($this_day==$i){
				$selected="selected";
			}
			$htm_keiyaku_day_slct.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_day_slct;
	}

	public static function make_html_slct_keiyaku_month_slct($targetMonth){
		$htm_keiyaku_month_slct="";
		$this_month=date("m");
		for($i=1;$i<=12;$i++){
			$selected="";
			if($this_month==$i){
				$selected="selected";
			}
			$htm_keiyaku_month_slct.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_month_slct;
	}

	public static function make_html_slct_keiyaku_year_slct($targetYear){
		$htm_keiyaku_year_list="";
		$this_year=date("Y");
		for($i=$this_year-1;$i<=$this_year+1;$i++){
			$selected="";
			if($this_year==$i){
				$selected="selected";
			}
			$htm_keiyaku_year_list.='<option value="'.$i.'" '.$selected.' >'.$i.'</option>';
		}
		return $htm_keiyaku_year_list;
	}

	public static function make_html_slct_birth_year_list($targetYear){
		$htm_birth_year_list="";
		$this_year=date("Y");
		
		for($i=$this_year-65;$i<=$this_year;$i++){
			$selected="";
			$gengou=self::wareki($i);
			if($targetYear=="" and $i==$this_year-30){
				$selected="selected";
			}else if($i==$targetYear){
				$selected="selected";
			}
			
			$htm_birth_year_list.='<option value="'.$i.'" '.$selected.' >'.$i.'('.$gengou.')</option>';
		}
		return $htm_birth_year_list;
	}

	public static function wareki($year) {
		$eras = [
			['year' => 2018, 'name' => '令和'],
			['year' => 1988, 'name' => '平成'],
			['year' => 1925, 'name' => '昭和'],
			['year' => 1911, 'name' => '大正'],
			['year' => 1867, 'name' => '明治']
		];
	
	    foreach($eras as $era) {
	        $base_year = $era['year'];
	        $era_name = $era['name'];
	        if($year > $base_year) {
	            $era_year = $year - $base_year;
	            if($era_year === 1) {
	                return $era_name .'元年';
	            }
	
	            return $era_name . $era_year;
	        }
	    }
	    return null;
	}

	public static function make_html_teacher_list(){
		$inf_teachers = DB::table('teachers')->get();
		$htm_teachers_list="";
		foreach ($inf_teachers as $inf_teacher){ 
			$eye_catch_url=config('const._profile_pic_dir_').$inf_teacher->eye_catch_file_name_up;
			$serial_teacher=$inf_teacher->serial_teacher;
			$htm_teachers_list.='<div class="list"><a href="inf_teacher/'.$serial_teacher.'"><figure><img src="'.$eye_catch_url.'" alt="sample name"></figure><h4>'.$inf_teacher->first_name_eng." ".$inf_teacher->last_name_eng.'</h4><p>'.$inf_teacher->syokai_bun_short.'</p></a></div>';
		}
		return $htm_teachers_list;
	}
	
	public static function getInstrumentNameByUserEventId($UserEventId){
		$targetInstSerial = DB::table('Schedules')->where('event_id',$UserEventId)->first();
		$target = DB::table('instruments')->where('serial_instrument',$targetInstSerial->course)->first();
		return $target->instrument_eng;
	}
	
	public static function getInstrumentNameBySerial($serial){
		$instSerialArray=explode(",", $serial);
		$target = DB::table('instruments')->where('serial_instrument',$instSerialArray[0])->first();
		return $target->instrument_eng;
	}
	
	public static function youbi($num){
		$week = ['日', '月', '火', '水', '木', '金','土'];
		return $week[$num];
	}
}
