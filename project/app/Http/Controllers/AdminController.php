<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;
use App\Models\Contract;
use App\Models\PaymentHistory;
use App\Models\Staff;
use App\Models\Recorder;
use App\Models\User;
use App\Models\ContractDetail;
use App\Models\VisitHistory;
use App\Models\TreatmentContent;
use App\Models\InOutHistory;
use App\Models\Configration;
use App\Models\CashBook;
use App\Mail\SendMail;
use App\Http\Requests\InpCustomerRequest;
use App\Http\Controllers\OtherFunc;
use App\Consts\initConsts;
//use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Point;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use Endroid\QrCode\Writer\ValidationException;
use App\Models\HandOver;

//use DateTime;
//use App\Consts\get_imagick_info;

use Intervention\Image\Facades\Image;
if(!isset($_SESSION)){session_start();}

class AdminController extends Controller
{
    private $formItems = ["default_txt"];
	private $manage_flg="";
	
	public function __construct(){
		$this->middleware('auth:admin')->except('logout');
	}
	
	public function ajax_get_Medical_records_file_name(Request $request){
		$ContractSerial=$request->contract_serial;
		$serch_file="MedicalRecord/".$ContractSerial."-*.png";
		$result=array();$medical_records_inf_array=array();
		$cnt=0;
		foreach(glob($serch_file) as $file) {
			$file_name= str_replace('K', 'V', $file);
			$visit_serial_array=explode("-", $file_name);
			$visit_serial_array=explode("-", $file);
			$visit_serial=$visit_serial_array[0].'-'.$visit_serial_array[1].'-'.$visit_serial_array[2];
			$visit_serial=str_replace('MedicalRecord/', '', $visit_serial);
			$visit_serial=str_replace('K', 'V', $visit_serial);
			$visit_date=VisitHistory::where('visit_history_serial','=',$visit_serial)->first('date_visit');
			//$res=$file."|".$visit_date->date_visit."|".$visit_date->remarks;
			$res=$file."|".$visit_date->date_visit;
			//Log::alert("res=".$res);
			$result[] = $res;
			/*
			$medical_records_inf_array[$cnt][0]=$file;
			$medical_records_inf_array[$cnt][1]=$visit_date->date_visit;
			$memo="";
			
			if(!empty($visit_date->remarks)){
				$memo=$visit_date->remarks;
			}
			$medical_records_inf_array[$cnt][2]=$visit_date->remarks;
			*/
			//Log::alert("file=".$file);
			//Log::alert("date_visit=".$visit_date->date_visit);
			//Log::alert("remarks=".$memo);
			//Log::info("medical_records_inf_array=".$memo);
			$cnt=$cnt++;
		}
		//Log::info($medical_records_inf_array);
		rsort($result);
		//rsort($medical_records_inf_array);
		//Log::info($medical_records_inf_array);
		if(count($result)>0){
			$target_file=$result[0];
		}else{
			$target_file="";
		}
		//$keiyaku_array=Contract::where('serial_keiyaku','=',$ContractSerial)->first();
		//$keiyaku_name=$keiyaku_array->keiyaku_name;
		echo json_encode($result, JSON_UNESCAPED_UNICODE);
		//echo json_encode($medical_records_inf_array, JSON_UNESCAPED_UNICODE);
	}
	
	public function ajax_get_customer_slct_option_for_HandOver(Request $request){
		if(empty($request->customer_serial)){
			$customer_serial='';
		}else{
			$customer_serial=$request->customer_serial;
		}
		echo OtherFunc::ajax_get_customer_slct_option($customer_serial);
	}

	public function ajax_make_customer_list_for_HandOver(Request $request){
		if(empty($request->customer_serial)){
			$customer_serial='';
		}else{
			$customer_serial=$request->customer_serial;
		}
		echo OtherFunc::make_html_customer_slct($customer_serial);
	}

	public function ajax_upsert_HandOver(Request $request){
		$rec = [
            [
				'id' => $request->id,
				'branch'=>session('target_branch_serial'),
				'target_date' => $request->target_date,
				'serial_staff' => $request->staff_serial,
				'target_customaer_serial' => $request->customer_serial,
				'sentence' => $request->sentence,
				'type_flag'=> $request->type_flag,
				'remarks'=>$request->remarks,
				'inputter'=> Auth::id()
			],
        ];
        HandOver::upsert($rec, ['id']);
	}

	public function ShowMenuCustomerManagement(Request $request){
		session(['target_branch_serial' => '01']);
		session(['fromPage' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['targetYear' => date('Y')]);
		$targetYear=session('targetYear');
		if(isset($_SERVER['HTTP_REFERER'])){
			$_SESSION['access_history']=array();
		}

		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei')->get();
		$html_year_slct=OtherFunc::make_html_year_slct(date('Y'));
		$html_month_slct=OtherFunc::make_html_month_slct(date('n'));
		$default_customers=OtherFunc::make_htm_get_default_user();
		$not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
		$htm_kesanMonth=OtherFunc::make_html_month_slct(InitConsts::KesanMonth());
		$csrf="csrf";
		session(['GoBackPlace' => '../ShowMenuCustomerManagement']);
		$_SESSION['access_history']=array();
		return view('admin.menu_top',compact("html_year_slct","html_month_slct","DefaultUsersInf","not_coming_customers","default_customers",'htm_kesanMonth'));
	}

	public function ShowSelectBranch(){
		$select_branch_btn=OtherFunc::make_select_branch_btn();
		return view('admin.select_branch',compact("select_branch_btn"));
	}

	public function ajax_upsert_CashBook(Request $request){
        $rec = [
            [
				'id' => $request->id,
				'target_date' => $request->target_date,
				'in_out' => $request->in_out,
				'summary' => $request->summary,
				'payment'=> $request->payment ?? '',
				'deposit'=> $request->deposit ?? '',
				'inputter'=> Auth::id(),
				'branch'=>session('target_branch_serial'),
				'remarks'=>$request->remarks 
			],
        ];
        CashBook::upsert($rec, ['id']);
		if($request->id==""){
			$Tid=CashBook::where('branch', session('target_branch_serial'))->max('id');
		}else{
			$Tid=$request->id;
		}
		OtherFunc::set_target_balance_to_CashBookDb($Tid);
	}

	private function staff_reception_manage($staff_serial){
		$target_item_array['ipadd']=$_SERVER['REMOTE_ADDR'];
		$staff_inf=Staff::where("serial_staff","=",$staff_serial)->first();
		$latest_in_out_history_id=InOutHistory::where("target_serial","=",$staff_serial)
				->orderBy('id','desc')->first('id');
		$target_item_array['user_serial']=$staff_serial;
		if(empty($staff_inf)){
			$target_item_array['msg']='スタッフのご登録が見つかりません。';
			$target_item_array['res']='no serial';
			$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
		}else{
			$target_item_array['res']='true';
			$ck_jyufuku=InOutHistory::where("target_serial","=",$staff_serial)
				->where("target_date","=",date('Y-m-d'))
				->orderBy('id','desc');
			$rec_cnt=$ck_jyufuku->count();
			$target_item_array['name']=$staff_inf->last_name_kanji.' '.$staff_inf->first_name_kanji;
			
			if($rec_cnt==0){
				$target_item_array['res']='in';
				$target_item_array['in_out_type']="出勤";
			}else{
				$target_item_array['res']='out';
				$target_item_array['in_out_type']="退勤";
				$target_item_array['target_id']=$latest_in_out_history_id;
			}
			$target_item_array['msg']=$target_item_array['name'].' さんの'.$target_item_array['in_out_type'].'を受け付けました。';
			$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
		}
		return $json;
	}

	private function staff_receipt_set_manage($item_array){
		$ipadd=$_SERVER['REMOTE_ADDR'];
		if($item_array['in_out_type']=='出勤'){
			InOutHistory::insert([
				'target_serial' => $item_array["user_serial"],
				'target_date' => date('Y-m-d'),
				'time_in' => date('Y-m-d H:i:s'),
				'target_name'=>$item_array["name"],
				'created_at'=> date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s'),
				'branch'=>session('target_branch_serial'),
				'ip_address_in'=> $ipadd,
			]);
		}else if($item_array['in_out_type']=='退勤'){
			InOutHistory::where("target_serial","=",$item_array['staff_serial'])
				->where("target_date","=",date('Y-m-d'))
				->update([
					'time_out' => date('Y-m-d H:i:s'),
					'updated_at'=> date('Y-m-d H:i:s'),
					'ip_address_out'=> $ipadd,
				]);
		}
	}

	public function customer_reception_manage(Request $request)
    {
		$user_serial=$request->target_serial;
		if(substr(strtoupper($user_serial), 0, 2)=="SF"){
			$json=$this::staff_reception_manage(strtoupper($user_serial));
		}else{
			$user_inf=User::where("serial_user","=",$user_serial)->first();
			$latest_contract_serial=Contract::where("serial_user","=",$user_serial)
					->orderBy('serial_keiyaku','desc')->first('serial_keiyaku');
			$latest_point_id=Point::where("serial_user","=",$user_serial)
					->orderBy('id','desc')->first('id');
			$target_item_array['user_serial']=$user_serial;
			if(empty($user_inf)){
				$target_item_array['msg']='お客様のご登録が見つかりません。';
				$target_item_array['res']='no serial';
				$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
				//echo $json;
			}else{
				$ck_jyufuku=Point::where("serial_user","=",$user_serial)
					->where("visit_date","LIKE",date('Y-m-d')."%")
					->where("method","=","来店")->count();
				if($ck_jyufuku>0){
					$target_item_array['msg']=$user_inf->name_sei.' '.$user_inf->name_mei.' 様の本日の受付は済んでいます。';
					$target_item_array['res']='double registration';
				}else{
					$target_item_array['msg']=$user_inf->name_sei.' '.$user_inf->name_mei.' 様のご来店を受け付けました。';
					$target_item_array['res']='true';
				}
				$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
			}
		}
		echo $json;
    }

	public function ShowInpRecordVisitPayment($ContractSerial,$UserSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$fromURLArray=parse_url($_SERVER['HTTP_REFERER']);
		if(!session('InpRecordVisitPaymentFlg')){
			session(['ShowInpRecordVisitPaymentfromPage' => $fromURLArray['path']]);
			session(['InpRecordVisitPaymentFlg' => false]);
		}else{
			session(['InpRecordVisitPaymentFlg' => false]);
		}
		session(['fromPage' => parse_url($_SERVER['HTTP_REFERER'])]);
		session(['UserSerial' => $UserSerial]);
		session(['ContractSerial' => $ContractSerial]);
		$RecordUrl = route('customers.recordVisitPaymentHistory');
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$targetVisitHistoryArray=VisitHistory::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetPaymentHistoryArray=PaymentHistory::where('serial_keiyaku','=', $ContractSerial)->get();

		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		session(['userneme' => $targetUser->name_sei.$targetUser->name_mei]);

		$targetContract=Contract::where('serial_keiyaku','=', $ContractSerial)->first();
		$targetContractDetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$KeiyakuNaiyouArray=array();$VisitDateArray=array();
		$KeiyakuNumMax = DB::table('configrations')->select('value1')->where('subject', '=', 'KeiyakuNumMax')->first();
		$sejyutukaisu=Contract::where('serial_keiyaku','=',$ContractSerial)->first('treatments_num');
		$ck=Contract::where('serial_keiyaku','=',$ContractSerial);
		$visit_disabeled=array();$set_gray_array=array();$only_treatment_color_array=array();
		
		if($targetContract->keiyaku_type=="subscription"){
			for($i=0;$i<=$KeiyakuNumMax->value1;$i++){
				$visit_disabeled[$i]="";
				$set_gray_array[$i]="";
				$only_treatment_color_array[$i]="white";
			}		
		}else{
			if(is_null($sejyutukaisu->treatments_num) ){
				for($i=0;$i<=$KeiyakuNumMax->value1;$i++){
					$visit_disabeled[$i]='disabled'; $set_gray_array[$i]='style="color:#DDDDDD"';$only_treatment_color_array[$i]='#DDDDDD';
				}
			}else{
				for($i=0;$i<=$KeiyakuNumMax->value1;$i++){
					$visit_disabeled[$i]='disabled'; $set_gray_array[$i]='style="color:#DDDDDD"';$only_treatment_color_array[$i]='#DDDDDD';
					if($i<$sejyutukaisu->treatments_num){
						$visit_disabeled[$i]="";
						$set_gray_array[$i]="";
						$only_treatment_color_array[$i]="white";
					}		
				}
			}
		}
		$i=0;$TreatmentDetailsArray=array();$TreatmentDetailsSelectArray=array();$VisitSerialArray=array();$PointArray=array();
		foreach($targetVisitHistoryArray as $targetVisitHistory){
			//$VisitSerialArray[]=$targetVisitHistory->visit_history_serial;
			$VisitSerialArray[]=sprintf('%02d', $i+1);
			$_SESSION['VisitSerialSessionArray'][]=$targetVisitHistory->visit_history_serial;
			$VisitDateArray[]=$targetVisitHistory->date_visit;
			$PointArray[]=$targetVisitHistory->point;
			$TreatmentDetailsArray[]=$targetVisitHistory->treatment_dtails;
			$TreatmentDetailsSelectArray[]=OtherFunc::make_htm_get_treatment_slct($targetVisitHistory->treatment_dtails);
			$set_gray_array[$i]='style="background-color:#e0ffff"';
			if(empty($targetVisitHistory->treatment_dtails)){
				$only_treatment_color_array[$i]='red';
			}else{
				$only_treatment_color_array[$i]='#e0ffff';
			}
			$i++;
		}

		for($k=$i;$k<24;$k++){
			$TreatmentDetailsSelectArray[$k]=OtherFunc::make_htm_get_treatment_slct('');
			$VisitSerialArray[]=sprintf('%02d', $k+1);
		}

		if($targetContract->how_to_pay=='現金'){
			$paymentCount=$targetContract->how_many_pay_genkin;
		}else{
			$paymentCount=$targetContract->how_many_pay_card;
		}
		for($i=0;$i<initConsts::PaymentNumMax();$i++){
			if($targetContract->keiyaku_type=="subscription"){
				$payment_disabeled[$i]="";$set_gray_pay_array[$i]="";$set_background_gray_pay_array[$i]='';
			}else{
				$payment_disabeled[$i]='disabled'; $set_gray_pay_array[$i]='color:#DDDDDD';$set_background_gray_pay_array[$i]='background-color:#EEEEEE';
				if($i<$paymentCount){
					$payment_disabeled[$i]="";$set_gray_pay_array[$i]="";$set_background_gray_pay_array[$i]='';
				}	
			}	
		}
		
		$payCnt=$targetContract->how_many_pay_genkin;
		if($targetContract->how_to_pay=="Credit Card"){
			$payCnt=$targetContract->how_many_pay_card;
		}

		$PaymentDateArray=array();$PaymentAmountArray=array();$HowToPayCheckedArray=array();
		
		for($i=0;$i<12;$i++){
			$HowToPayCheckedArray[$i][0]="";
			$HowToPayCheckedArray[$i][1]="";
		}
		$i=0;
		foreach($targetPaymentHistoryArray as $targetPaymentHistory){
			$HowToPayCheckedCard="";$HowToPayCheckedCash="";$HowToPayCheckedDefault="";
			if($targetPaymentHistory->how_to_pay=="card"){
				$HowToPayCheckedCard="checked";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
				$HowToPayCheckedSmart="";
			}else if($targetPaymentHistory->how_to_pay=="paypay"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="checked";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
				$HowToPayCheckedSmart="";
			}else if($targetPaymentHistory->how_to_pay=="cash"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="checked";
				$HowToPayCheckedDefault="";
				$HowToPayCheckedSmart="";
			}else if($targetPaymentHistory->how_to_pay=="default"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="checked";
				$HowToPayCheckedSmart="";
			}else if($targetPaymentHistory->how_to_pay=="smart"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
				$HowToPayCheckedSmart="checked";
			}
			$HowToPayCheckedArray[$i][0]=$HowToPayCheckedCard;
			$HowToPayCheckedArray[$i][1]=$HowToPayCheckedPaypay;
			$HowToPayCheckedArray[$i][2]=$HowToPayCheckedCash;
			$HowToPayCheckedArray[$i][3]=$HowToPayCheckedDefault;
			$HowToPayCheckedArray[$i][4]=$HowToPayCheckedSmart;

			$PaymentDateArray[]=$targetPaymentHistory->date_payment;
			$PaymentAmountArray[]=$targetPaymentHistory->amount_payment;
			
			$set_background_gray_pay_array[$i]='background-color:#e0ffff';
			$set_gray_pay_array[$i]='background-color:#e0ffff';
			$i++;
		}

		foreach($targetContractDetails as $targetContractDetail){
			$KeiyakuNaiyouArray[]=$targetContractDetail->keiyaku_naiyo;
		}
		$KeiyakuNaiyou=implode("/", $KeiyakuNaiyouArray);
		$HowToPayChecked[0][0]="";$GoBackToPlace='';
		if(session('fromMenu')=='MenuCustomerManagement'){
			$GoBackToPlace="/ShowMenuCustomerManagement";
		}else if(session('fromMenu')=='CustomersList'){
			$GoBackToPlace="/customers/ShowCustomersList_livewire";
		}
		$GoBackToPlace=session('ShowInpRecordVisitPaymentfromPage');
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		array_push($target_historyBack_inf_array,$UserSerial);
		return view('customers.PaymentRegistration',compact("UserSerial","PointArray","target_historyBack_inf_array","only_treatment_color_array","GoBackToPlace","header","slot",'VisitSerialArray','VisitDateArray','PaymentDateArray','targetUser','targetContract','KeiyakuNaiyou','PaymentAmountArray','HowToPayCheckedArray','visit_disabeled','sejyutukaisu','set_gray_array','payment_disabeled','set_gray_pay_array','set_background_gray_pay_array','paymentCount','TreatmentDetailsArray','TreatmentDetailsSelectArray'));
	}

	public function ShowMedicalRecordFromIframe(Request $request){
		$visit_history_serial=$request->count_btn;
		$visit_history_serial_array=explode('-', $visit_history_serial);
		$visit_history_num=$visit_history_serial_array[2];
		$visit_history_num_int=(int)$visit_history_num;
		$tg='"visitDate.'.$visit_history_num_int.'"';
		$serial_keiyaku=str_replace("V","K",$visit_history_serial_array[0]).'-'.$visit_history_serial_array[1];
		session(['ContractSerial' => $serial_keiyaku]);
		$clinical_serial=str_replace( "V","K" , $visit_history_serial);
		$VisitHistoryInfArray=VisitHistory::where('visit_history_serial','=',$visit_history_serial)->first();
		$serch_file="MedicalRecord/".$clinical_serial."*.png";
		$result=array();
		foreach(glob($serch_file) as $file) {
			$result[] = $file;
		}
		if(count($result)>0){
			$target_file=$result[0];
		}else{
			$target_file="";
		}
		$UserSerial=str_replace('V_', '', $visit_history_serial_array[0]);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		$inf_keiyaku_array=Contract::where('serial_keiyaku','=',$serial_keiyaku)->first();
		$keiyaku_name=$inf_keiyaku_array->keiyaku_name;
		$visit_history_remarks=$VisitHistoryInfArray->remarks;
		if(empty($VisitHistoryInfArray->serial_staff)){
			$SerialStaff="";
		}else{
			$SerialStaff=$VisitHistoryInfArray->serial_staff;
		}
		$html_staff_slct=OtherFunc::make_html_staff_slct($SerialStaff);
		$ContractSerial=session('ContractSerial');
		if (empty($_SERVER['HTTPS'])) {
			$ht_type='http://';
		} else {
			$ht_type='https://';			
		}
		$host_url=$_SERVER['HTTP_ORIGIN'];
		return view('customers.MedicalRecord',compact('visit_history_remarks','host_url','html_staff_slct','target_file','ContractSerial','visit_history_num','UserInf','keiyaku_name'));
	}
	
	public function ShowContractList($UserSerial,Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		$key="";
		$Contracts="";
		if($UserSerial=="all"){
			$userinf="";
			$Contracts=Contract::leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')->paginate(initConsts::DdisplayLineNumContractList());
			$GoBackPlace="/top";
			session(['targetUserSerial' => 'all']);
		}else{
			session(['targetUserSerial' => $UserSerial]);
			session(['target_page_for_pager'=>'']);
			$_SESSION['access_history'][0]=$_SESSION['access_history'][0]."/".$UserSerial;
			$GoBackPlace="/customers/CustomersList";				
			$userinf=User::where('serial_user','=',$UserSerial)->first();
			$Contracts=Contract::where('contracts.serial_user','=',$UserSerial)
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->select('contracts.*', 'users.*')
				->paginate(initConsts::DdisplayLineNumContractList());
		}
		return view('customers.ListContract',compact("target_historyBack_inf_array","Contracts","UserSerial","userinf","GoBackPlace"));
	}
	public function ShowMedicalRecord(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$visit_history_num=$request->count_btn;
		$visit_history_num_int=(int)$visit_history_num;
		$visit_history_serial=str_replace( "K","V" , session('ContractSerial')."-".$visit_history_num);
		$VisitHistoryArray=VisitHistory::where('visit_history_serial','=',$visit_history_serial)->first();
		$tg='"visitDate.'.$visit_history_num_int.'"';
		if($visit_history_num_int==1){
			$request->validate(
				["visitDate.0" => "required" ],
				['visitDate.0.required' => '施術日1回目を先に保存してください。']
			);
		}else if($visit_history_num_int==2){
			$request->validate(
				["visitDate.1" => "required" ],
				['visitDate.1.required' => '施術日2回目を先に保存してください。']
			);
		}else if($visit_history_num_int==3){
			$request->validate(
				["visitDate.2" => "required" ],
				['visitDate.2.required' => '施術日3回目を先に保存してください。']
			);
		}else if($visit_history_num_int==4){
			$request->validate(
				["visitDate.3" => "required" ],
				['visitDate.3.required' => '施術日4回目を先に保存してください。']
			);
		}else if($visit_history_num_int==5){
			$request->validate(
				["visitDate.4" => "required" ],
				['visitDate.4.required' => '施術日5回目を先に保存してください。']
			);
		}else if($visit_history_num_int==6){
			$request->validate(
				["visitDate.5" => "required" ],
				['visitDate.5.required' => '施術日6回目を先に保存してください。']
			);
		}else if($visit_history_num_int==7){
			$request->validate(
				["visitDate.6" => "required" ],
				['visitDate.6.required' => '施術日7回目を先に保存してください。']
			);
		}else if($visit_history_num_int==8){
			$request->validate(
				["visitDate.7" => "required" ],
				['visitDate.7.required' => '施術日8回目を先に保存してください。']
			);
		}else if($visit_history_num_int==9){
			$request->validate(
				["visitDate.8" => "required" ],
				['visitDate.8.required' => '施術日9回目を先に保存してください。']
			);
		}else if($visit_history_num_int==10){
			$request->validate(
				["visitDate.9" => "required" ],
				['visitDate.9.required' => '施術日10回目を先に保存してください。']
			);
		}else if($visit_history_num_int==11){
			$request->validate(
				["visitDate.10" => "required" ],
				['visitDate.10.required' => '施術日11回目を先に保存してください。']
			);
		}else if($visit_history_num_int==12){
			$request->validate(
				["visitDate.11" => "required" ],
				['visitDate.11.required' => '施術日12回目を先に保存してください。']
			);
		}else if($visit_history_num_int==13){
			$request->validate(
				["visitDate.12" => "required" ],
				['visitDate.12.required' => '施術日13回目を先に保存してください。']
			);
		}else if($visit_history_num_int==14){
			$request->validate(
				["visitDate.13" => "required" ],
				['visitDate.13.required' => '施術日14回目を先に保存してください。']
			);
		}else if($visit_history_num_int==15){
			$request->validate(
				["visitDate.14" => "required" ],
				['visitDate.14.required' => '施術日15回目を先に保存してください。']
			);
		}else if($visit_history_num_int==16){
			$request->validate(
				["visitDate.15" => "required" ],
				['visitDate.15.required' => '施術日16回目を先に保存してください。']
			);
		}else if($visit_history_num_int==17){
			$request->validate(
				["visitDate.16" => "required" ],
				['visitDate.16.required' => '施術日17回目を先に保存してください。']
			);
		}else if($visit_history_num_int==18){
			$request->validate(
				["visitDate.17" => "required" ],
				['visitDate.17.required' => '施術日18回目を先に保存してください。']
			);
		}else if($visit_history_num_int==19){
			$request->validate(
				["visitDate.18" => "required" ],
				['visitDate.18.required' => '施術日19回目を先に保存してください。']
			);
		}else if($visit_history_num_int==20){
			$request->validate(
				["visitDate.19" => "required" ],
				['visitDate.19.required' => '施術日20回目を先に保存してください。']
			);
		}else if($visit_history_num_int==21){
			$request->validate(
				["visitDate.20" => "required" ],
				['visitDate.20.required' => '施術日21回目を先に保存してください。']
			);
		}else if($visit_history_num_int==22){
			$request->validate(
				["visitDate.21" => "required" ],
				['visitDate.21.required' => '施術日22回目を先に保存してください。']
			);
		}else if($visit_history_num_int==23){
			$request->validate(
				["visitDate.22" => "required" ],
				['visitDate.22.required' => '施術日23回目を先に保存してください。']
			);
		}else if($visit_history_num_int==24){
			$request->validate(
				["visitDate.23" => "required" ],
				['visitDate.23.required' => '施術日24回目を先に保存してください。']
			);
		}
		$serch_file="MedicalRecord/".session('ContractSerial')."-".$request->count_btn."*.png";
		$result=array();
		foreach(glob($serch_file) as $file) {
			$result[] = $file;
		}
		if(count($result)>0){
			$target_file=$result[0];
		}else{
			$target_file="";
		}
		$array=explode('-', $visit_history_serial);
		$UserSerial=str_replace('V_', '', $array[0]);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		
		$keiyaku_array=Contract::where('serial_keiyaku','=',session('ContractSerial'))->first();
		$keiyaku_name=$keiyaku_array->keiyaku_name;
		if(empty($VisitHistoryArray->serial_staff)){
			$SerialStaff="";
		}else{
			$SerialStaff=$VisitHistoryArray->serial_staff;
		}
		$html_staff_slct=OtherFunc::make_html_staff_slct($SerialStaff);
		$ContractSerial=session('ContractSerial');
		if (empty($_SERVER['HTTPS'])) {
			$ht_type='http://';
		} else {
			$ht_type='https://';			
		}
		$visit_history_remarks=$VisitHistoryArray->remarks;
		$host_url=$_SERVER['HTTP_ORIGIN'];
		return view('customers.MedicalRecord',compact('visit_history_remarks','host_url','html_staff_slct','target_file','ContractSerial','visit_history_num','UserInf','keiyaku_name'));
	}

	public function ajax_show_point_list(Request $request){
		$point_array=Point::where("serial_user","=",$request->user_serial)->get();
		$htm='<table class="table">
		<thead>
		  <tr>
			<th scope="col">取得方法</th>
			<th scope="col">取得日</th>
			<th scope="col">取得ポイント</th>
			<th scope="col">ご紹介いただいたお客様</th>
		  </tr>
		</thead>
		<tbody class="table-group-divider">';
		foreach($point_inf as $point_array){
			$refere_array=User::where("serial_user","=",$point_inf->referred_serial)->first();
			if(empty($refere_array)){
				$refere_name="--";
			}else{
				$refere_name=$refere_array->name_sei."&nbsp;".$refere_array->name_mei;
			}
			$htm.='<tr>
			<td>'.$point_inf->method.'</td>
			<td>'.$point_inf->date_get.'</td>
			<td>'.$point_inf->point.'</td>
			<td>'.$refere_name.'</td>
		  </tr>';
		}
		$htm.='</tbody></table>';
		echo $htm;
	}

	public function ShowPaymentRegistrationIflame($SerialKeiyaku,$SerialUser){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		$KeiyakuInf=Contract::where('serial_keiyaku','=',$SerialKeiyaku)->first();
		$UserInf=User::where('serial_user','=',$SerialUser)->first();
		session()->put(['targetUserSerial'=> $SerialUser, 'targetKeiyakuSerial'=>$SerialKeiyaku]);
		return view('customers.PaymentRegistration_ifame',compact('target_historyBack_inf_array','UserInf','KeiyakuInf'));
	}

	public function ShowInpStaff($TargetStaffSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		OtherFunc::make_QRCode($TargetStaffSerial,storage_path('images/'.$TargetStaffSerial.'.png'));
		$GoBackPlace="/ShowStaffList";
		$html_birth_select=array();
		if($TargetStaffSerial=="new"){
			$StaffInf=array();
			//$maxStaffSerial =Staff::max('serial_staff');
			$maxStaffSerial =DB::table('staff')->max('serial_staff');
			$TargetStaffSerial=++$maxStaffSerial;
			$html_year_slct=OtherFunc::make_html_birth_year_slct('');
			$html_day_slct=OtherFunc::make_html_birth_day_slct('');
			$html_Month_slct=OtherFunc::make_html_birth_month_slct('');
			$btnDisp="登録";
		}else{
			$StaffInf=Staff::where('serial_staff','=',$TargetStaffSerial)->first();
			$btnDisp="修正";
			if(empty($StaffInf->birth_date)){
				$html_year_slct=OtherFunc::make_html_birth_year_slct('');
				$html_day_slct=OtherFunc::make_html_birth_day_slct('');
				$html_Month_slct=OtherFunc::make_html_birth_month_slct('');
			}else{
				$html_year_slct=OtherFunc::make_html_birth_year_slct(date('Y', strtotime($StaffInf->birth_date)));
				$html_day_slct=OtherFunc::make_html_birth_day_slct(date('d', strtotime($StaffInf->birth_date)));
				$html_Month_slct=OtherFunc::make_html_birth_month_slct(date('m', strtotime($StaffInf->birth_date)));
			}
			//return view('teacher.inp_Staff',compact("header","slot",'TargetStaffSerial','StaffInf',"GoBackPlace","btnDisp","saveFlg"));
		}
		$html_birth_select['year']=$html_year_slct;
		$html_birth_select['day']=$html_day_slct;
		$html_birth_select['month']=$html_Month_slct;
		session(['targetStaffSerial' => $TargetStaffSerial]);
		return view('admin.inp_Staff',compact('TargetStaffSerial','StaffInf',"GoBackPlace","btnDisp","html_birth_select"));
	}

	public function send_QRcode_to_staff(Request $request){
		$targetData=[
			'serial_staff' => session('targetStaffSerial'),
			'email' => $request->mail,
			'phone' => $request->phone,
			'last_name_kanji' => $request->name_sei,
			'first_name_kanji' => $request->name_mei,
			'last_name_kana' =>$request->name_sei_kana,
			'first_name_kana' =>$request->name_mei_kana,
			'branch'=>session('target_branch_serial'),
			'birth_date'=>$request->year.'-'.$request->month.'-'.$request->day,
		];
		Staff::upsert($targetData,['serial_staff']);
		OtherFunc::send_attendance_card($request->serial_staff);
		return redirect()->route('ShowInpStaff', ['TargetStaffSerial' => $request->serial_staff]);
    }
	public function SaveStaff(Request $request){
		$targetData=[
			'serial_staff' => session('targetStaffSerial'),
			'email' => $request->mail,
			'phone' => $request->phone,
			'last_name_kanji' => $request->name_sei,
			'first_name_kanji' => $request->name_mei,
			'last_name_kana' =>$request->name_sei_kana,
			'first_name_kana' =>$request->name_mei_kana,
			'branch'=>session('target_branch_serial'),
			'birth_date'=>$request->year.'-'.$request->month.'-'.$request->day,
		];
		Staff::upsert($targetData,['serial_staff']);
		$this::save_recorder("SaveStaff");
		return view("admin.ListStaffs");
	}

	public function ajax_get_coming_soon_user(Request $request){
		if(!(isset($_SESSION['PopupComingSoonFlg']) and $_SESSION['PopupComingSoonFlg']==date("Y-m-d"))){
			//予約処理
			$today = date("Y-m-d");$user_inf_array=array();
			$yesterday= date("Y-m-d",strtotime('+1 day', time()));
			$BookingDisplayPeriod=InitConsts::BookingDisplayPeriod();
			$TargetBookingDisplayDate=date('Y-m-d', strtotime('+'.$BookingDisplayPeriod.' day', time()))." 23:59";
			$add_time=' 00:00';
			$user_inf_array=User::where('reservation','<=',$TargetBookingDisplayDate)
				->where('reservation','<>',null)
				->where('reservation','>=',$today.$add_time)
				->orderBy('reservation', 'asc')
				->get();
			$cnt_day=0;
			$period_array=array();
			foreach($user_inf_array as $user){
				$target_day_array=explode(" ",$user->reservation);
				$target_day=$target_day_array[0];
				for($cnt_day=0;$cnt_day<=$BookingDisplayPeriod;$cnt_day++){
					$td= date("Y-m-d",strtotime('+'.$cnt_day.' day', time()));
					$kyo="";
					if($target_day==$td){
						$period_array[$cnt_day][]="&nbsp;".$user->serial_user." : ".$user->name_sei." ".$user->name_mei." ".$user->reservation;
						if($cnt_day==0){
							$kyo="今日 (".date('y年m月d日').")";
						}else if($cnt_day==1){
							$kyo="明日 (".date("y年m月d日",strtotime('+1 day', time())).")";
						}else{
							$kyo=$cnt_day."日後 (".date("y年m月d日",strtotime('+'.$cnt_day.' day', time())).")";
						}
						break;
					}
				}
			}
			
			$Reservation_msg="";$all_user_inf_array=array();
			foreach($period_array as $number =>$day_array){
				$dy="";
				if($number==0){
					$date = date('w');
					$w=OtherFunc::day_of_the_week_dtcls($date);
					$dy="<span class='text-primary'>"."・今日 (".date('y年m月d日')."(".$w."))"."</span>";
				}else if($number==1){
					$d=date('w', strtotime('+1 day', time()));
					$w=OtherFunc::day_of_the_week_dtcls($d);
					$dy="<span class='text-primary'>"."・明日 (".date("y年m月d日",strtotime('+1 day', time()))."(".$w."))"."</span>";
				}else{
					$d=date('w', strtotime('+'.$number.' day', time()));
					$w=OtherFunc::day_of_the_week_dtcls($d);
					$dy="<span class='text-primary'>"."・".$number."日後 (".date("y年m月d日",strtotime('+'.$number.' day', time()))."(".$w."))"."</span>";
				}
				$Reservation_msg=$dy."<br>";
				$user_inf_array=array();
				foreach($day_array as $nm){
					$user_inf_array[]=$nm;
				}
				$all_user_inf_array[]=$Reservation_msg.implode("<br>", $user_inf_array);
			}
			$all_user_inf['Reservation']=implode("<br>", $all_user_inf_array);

			//誕生日処理
			$user_inf_array=array();
			$target_TDY_array=explode("-",$today);
			$BirthdayDisplayPeriod=InitConsts::BirthdayDisplayPeriod();
			$birthuser_array=array();
			$cnt_day=0;
			$period_array=array();
			for($i=0;$i<$BirthdayDisplayPeriod;$i++){
				$TargetBirthdayDisplayDate=date('Y-m-d', strtotime('+'.$i.' day', time()));
				$target_YMD_array=explode("-", $TargetBirthdayDisplayDate);
				$key=$target_YMD_array[1].$target_YMD_array[2];
				$res_serch=User::where(DB::raw('CONCAT(birth_month, birth_day)'), '=', $key)->get();
				foreach($res_serch as $res_user){
					$user_inf_array[]=$res_user;
				}
			}

			$Birthday_msg="";$user_inf_birth_array=array();$mae="";
			foreach($user_inf_array as $user){
				$dy="";
				for($cnt_day=0;$cnt_day<=$BirthdayDisplayPeriod;$cnt_day++){
					$td= date("d",strtotime('+'.$cnt_day.' day', time()));
					$d=date('w', strtotime('+'.$cnt_day.' day', time()));
					$w=OtherFunc::day_of_the_week_dtcls($d);
					$dy="";
					if($user->birth_day==$td){
						if($cnt_day==0){
							$dy="<span class='text-primary'>"."・今日 (".date('m月d日')."(".$w."))"."</span>";
						}else if($cnt_day==1){
							$dy="<span class='text-primary'>"."・明日 (".date("m月d日",strtotime('+1 day', time()))."(".$w."))"."</span>";
						}else{
							$dy="<span class='text-primary'>"."・".$cnt_day."日後 (".date("m月d日",strtotime('+'.$cnt_day.' day', time()))."(".$w."))"."</span>";
						}
						break;
					}
				}
				$Birthday_msg="";
				if($mae<>$dy){
					$mae=$dy;
					$Birthday_msg=$mae."<br>";
				}
				$user_inf_birth_array[]=$Birthday_msg."&nbsp;".$user->serial_user." ".$user->birth_year."-".$user->birth_month."-".$user->birth_day.":".$user->name_sei." ".$user->name_mei;
			}
			$all_user_inf['Birthday']=implode("<br>", $user_inf_birth_array);
		}
		print json_encode($all_user_inf);
	}

	public function ckScheduleDeletePossible(Request $request){
		$target_schedules_event_id=$request->input('eventID');
		$serial_admin = Auth::user()->serial_admin;
		$flg=true;
		if(DB::table('Schedules')
			->where('event_id','=',$target_schedules_event_id)
			->where('deleted_at','<>',null)
			->where('idPerson','=',$serial_admin)->exists())
		{
			$flg=false;	
		}
		echo json_encode($flg);
		//return ;
	}

	public function ajax_save_yoyaku_time(Request $request){
		try {
			User::where('serial_user','=', trim($request->UserSerial))->update(['reservation' => $request->TargetDate]);
			print 'changed';
		} catch (Exception $e) {
            // トランザクションロールバック
            User:rollback();
            throw $e;  // 例外を再スロー
        }
	}

	public function ShowInputNewCustomer(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		session(['fromPage' => 'InputCustomer']);
		session(['CustomerManage' => 'new']);

		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);

		setcookie('TorokuMessageFlg','false',time()+60);
		$GenderRdo=array();
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		$saveFlg="false,".session('CustomerManage');$btnDisp="　登　録　";
		$html_reason_coming="";
		$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
		$target_user=array();
		$maxUserSerial =DB::table('users')->max('serial_user');
		$TargetUserSerial=++$maxUserSerial;
		$target_user['serial_user']=sprintf('%06d', $TargetUserSerial);
		$GoBackPlace=$_SESSION['access_history'][0];
		$total_point="";
		return view('customers.CreateCustomer',compact('target_historyBack_inf_array','total_point','html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming"));
	}

	public function ajax_staff_change_time_card(Request $request){
		$TargetObjArray=explode("_", $request->TargetObj);
		if(count($TargetObjArray)>=3){
			$id=$TargetObjArray[2];
			$subj=$TargetObjArray[0]."_".$TargetObjArray[1];
		}else{
			$id=$TargetObjArray[1];
			$subj=$TargetObjArray[0];
		}
		if($subj=="target_date"){
			$cnt=InOutHistory::where($subj,"=",$request->Value)
							->where("id","=",$id)->count();
			if($cnt>0){
				print "Unchanged";
			}else{
				$target_inf_array=InOutHistory::where('id', $id)->first();
				$time_in_array=explode(" ", $target_inf_array->time_in);
				$time_in_cng=$request->Value." ".$time_in_array[1];
				$time_out_array=explode(" ", $target_inf_array->time_out);
				$time_out_cng=$request->Value." ".$time_out_array[1];
				InOutHistory::where('id', $id)->update([$subj => $request->Value,"time_in"=>$time_in_cng,"time_out"=>$time_out_cng]);
				print "changed";
			}
		}else if($subj=="time_in"){
			$target_inf_array=InOutHistory::where('id', $id)->first();
			$tgt=$target_inf_array->target_date." ".$request->Value;
			$cnt=InOutHistory::where($subj,"=",$tgt)
							->where("id","=",$id)->count();
			if($cnt>0){
				print "Unchanged";
			}else{
				$target_inf_array=InOutHistory::where('id', $id)->first();
				$time_array=explode(" ", $target_inf_array->time_in);
				$time_cng=$time_array[0]." ".$request->Value;
				InOutHistory::where('id', $id)->update([$subj => $time_cng]);
				print "changed";
			}
		}else if($subj=="time_out"){
			$target_inf_array=InOutHistory::where('id', $id)->first();
			$tgt=$target_inf_array->target_date." ".$request->Value;
			$cnt=InOutHistory::where($subj,"=",$tgt)
							->where("id","=",$id)->count();
			if($cnt>0){
				print "Unchanged";
			}else{
				$target_inf_array=InOutHistory::where('id', $id)->first();
				$time_array=explode(" ", $target_inf_array->time_out);
				$time_cng=$time_array[0]." ".$request->Value;
				InOutHistory::where('id', $id)->update([$subj => $time_cng]);
				print "changed";
			}
		}else{
			$cnt=InOutHistory::where('id',"=", $id)->
				where($subj,"=",$request->Value)->count();
			if($cnt>0){
				print "Unchanged";
			}else{
				InOutHistory::where('id', $id)->update([$subj => $request->Value]);
				print "changed";
			}
		}
	}

	public function ContractCancellation($serial_Contract,$UserSerial,Request $request){
		$kaiyakuFlg=Contract::where('serial_keiyaku','=', $serial_Contract)->first('cancel');
		if($kaiyakuFlg->cancel==null){
			$dt=$request->KaiyakuDate;
		}else{
			$dt=null;
		}
		Contract::where('serial_keiyaku','=', $serial_Contract)->update(['cancel' => $dt]);
		return redirect('/customers/ShowSyuseiContract/'.$serial_Contract.'/'.$UserSerial);
	}

	public function deleteTreatmentContent($TreatmentContentSerial){
		$deleTreatmentContent=TreatmentContent::where('serial_treatment_contents','=',$TreatmentContentSerial)->delete();
		$this::save_recorder("deleteTreatmentContent");
		return redirect('/admin/TreatmentList');
	}

	public function ajax_digestion_point(Request $request){
		
		$flg=Point::where('id','=',$request->target_id)->first("digestion_flg");
		if($flg->digestion_flg=="true"){
			$set_flg="false";
		}else if ($flg->digestion_flg=="false"){
			$set_flg="true";
		}
		Point::where('id','=',$request->target_id)->update(["digestion_flg" => $set_flg]);
		print $set_flg;
	}

	public function ajax_change_point(Request $request){
		Point::where('id','=',trim($request->target_id))->update(["point" => $request->points]);
	}

	function recordVisitPaymentHistory(Request $request){
		$PaymentHistorySerial=session('ContractSerial')."-01";
		$PaymentHistorySerial=str_replace('K','P',$PaymentHistorySerial);
		DB::table('payment_histories')->where('serial_keiyaku','=', session('ContractSerial'))->delete();
			for($i=0;$i<=11;$i++){
				if(!isset($request->PaymentDate[$i]) and !isset($request->PaymentAmount[$i]) and !isset($request->HowToPay[$i])){break;}
				$PaymentDateArra[$i]="";
				if(isset($request->PaymentDate[$i])){
					$PaymentDateArra[$i]=$request->PaymentDate[$i];
				}
				$PaymentAmountArra[$i]="";
				if(isset($request->PaymentAmount[$i])){
					$PaymentAmountArra[$i]=$request->PaymentAmount[$i];
				}
				$PaymentHowToPayArray[$i]="";
				if(isset($request->HowToPay[$i])){
					$PaymentHowToPayArray[$i]=$request->HowToPay[$i];
				}
				
				$targetlData=[
					'serial_keiyaku'=>session('ContractSerial'),
					'serial_user'=>session('UserSerial'),
					'payment_history_serial'=>$PaymentHistorySerial,
					'serial_staff'=>Auth::user()->serial_admin,
					'date_payment'=>$PaymentDateArra[$i],
					'amount_payment'=>str_replace(',','',$PaymentAmountArra[$i]),
					'how_to_pay'=>$PaymentHowToPayArray[$i],
					'deleted_at'=>null
				];
				$targetDataArray[]=$targetlData;
				$PaymentHistorySerial++;
				PaymentHistory::upsert($targetDataArray,['payment_history_serial']);
			}
		VisitHistory::where('serial_keiyaku','=', session('ContractSerial'))->delete();
		
		$targetDataArray=array();
		$VisitHistorySerial=session('ContractSerial')."-01";
		$VisitHistorySerial=str_replace('K','V',$VisitHistorySerial);
		$date_latest_visit="";
		if(isset($request->visitDate)){
			$i=0;
			foreach($request->visitDate as $visitDateValue){
				if($visitDateValue<>""){$date_latest_visit=$visitDateValue;}
				if($visitDateValue==""){break;}
				$targetlData=array();
				$targetlData=[
					'serial_keiyaku'=>session('ContractSerial'),
					'serial_user'=>session('UserSerial'),
					'visit_history_serial'=>$VisitHistorySerial,
					'serial_staff'=>Auth::user()->serial_staff,
					'date_visit'=>$visitDateValue,
					'treatment_dtails'=>$request->TreatmentDetailsSelect[$i],
					//'point'=>$request->point[$i],
					'deleted_at'=>null
				];
				VisitHistory::where('visit_history_serial','=', $VisitHistorySerial)->restore();
				VisitHistory::upsert($targetlData,['visit_history_serial']);
				$targetDataArray[]=$targetlData;
				$VisitHistorySerial++;
				$i++;
			}
		}
		Contract::where('serial_keiyaku','=',session('ContractSerial'))->update(['date_latest_visit' =>$date_latest_visit]);
		session()->flash('success', '登録しました。');
		session(['InpRecordVisitPaymentFlg' => true]);
		$this::save_recorder("recordVisitPaymentHistory");
		return redirect('/customers/ShowInpRecordVisitPayment/'.session("ContractSerial").'/'.session("UserSerial"));
	}

	public function  receipt_set_manage(Request $request){
        $item_array=json_decode( $request->item_json , true );
		if(substr($item_array["user_serial"], 0, 2)=="SF"){
			$item_array["staff_serial"]=$item_array["user_serial"];
			$this::staff_receipt_set_manage($item_array);
		}else{
			Point::insert([
				'serial_user' => $item_array["user_serial"],
				'method' => "来店",
				'date_get' => date('Y-m-d'),
				'point' => initConsts::UserPointVisit(),
				'visit_date' => date('Y-m-d H:i:s'),
				'branch'=>session('target_branch_serial'),
				'validity_flg' => "true",
				'digestion_flg' => "false",
				'created_at'=> date('Y-m-d H:i:s'),
				'updated_at'=> date('Y-m-d H:i:s'),
				//'point_expiration_date'=> $tdate->format('Y-m-d'),
			]);
		}
		$res = ['res'    => 'OK'];
		$json = json_encode( $res, JSON_PRETTY_PRINT ) ;
		echo $json;
    }

	public function update_setting(Request $request)
    {
		$configration_all_array=configration::all();
        foreach($configration_all_array as $configration_array){
            if(isset($_POST[$configration_array['subject']])){
                $udsql=configration::where('subject','=',$configration_array['subject'])
                    ->update(['value1' => $_POST[$configration_array['subject']]]);
            }
        }
		return redirect()->route('admin.show_setting')->with('success','登録しました。');
    }

	public function show_setting()
    {
        $configration_all=Configration::all();
		
        foreach($configration_all as $configration){
            $configration_array[$configration['subject']]=$configration['value1'];
        }
        return view('admin.Setting',compact("configration_array"));
    }

	public function ShowStaffStandbyDisplay(){
		if (empty($_SERVER['HTTPS'])) {
			$ht_type='http://';
		} else {
			$ht_type='https://';			
		}
		$host_url=$_SERVER['HTTP_HOST'];
		$PermittedIPAaddresses=InitConsts::PermittedIPAaddresses();
		session(['target_serial' => ""]);
		return view('admin.StaffReceptionStandByDisplayJQ',compact('host_url','PermittedIPAaddresses'));
	}

	public function ShowCustomerStandbyDisplay(){
		if (empty($_SERVER['HTTPS'])) {
			$ht_type='http://';
		} else {
			$ht_type='https://';			
		}
		$host_url=$_SERVER['HTTP_HOST'];
		session(['target_serial' => ""]);
		return view('customers.CustomerReceptionStandByDisplayJQ',compact('host_url'));
	}

	public function GetQrImage($target){
		//$url = 'https://google.com';
		/*
		$qr_image = QrCode::format('png')
			//->merge('/storage/'.$target)
			->merge('/storage/MedicalRecord')
			->style('square')
			->backgroundcolor(255,255,255)
			->size(300)
			->errorcorrection('H')
			->generate('TEST');
			//->generate($target);
		*/
		//$qr_image = Image::make($qr_image);
		//return $qr_image;
		//$src = base64_encode(QrCode::size(100)->generate('https://qiita.com/nobuhiro-kobayashi'));
		//$src = base64_encode(QrCode::size(100)->generate($target));
		$path = public_path(time().'.eps');
		QrCode::format('eps')->size(300)->generate($target, $path);
		//QrCode::email(null, 'This is the subject.', 'This is the message body.');
		//$src = QrCode::size(100)->generate($target);
		//return $src;
		//return response('<img src="data:image/png;base64, ' . $src . '">');
	}

	public function ShowSyuseiCustomer(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['livewire_page_num_for_back' => OtherFunc::get_page_num($_SESSION['access_history'][0])]);
		if(isset($_POST['back_flg'])){
            array_shift($_SESSION['access_history']);
            array_shift($_SESSION['access_history']);
        }
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		session(['fromPage' => 'SyuseiCustomer']);
		session(['CustomerManage' => 'syusei']);
		$selectedManth=array();$selectedManth=array();
		$target_user=User::where('serial_user','=', $request->input('syusei_Btn'))->first();
		$referee=Point::where('referred_serial','=', $request->input('syusei_Btn'))->first();
		$total_point=Point::where('serial_user','=', $request->input('syusei_Btn'))->sum('point');
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list($target_user->birth_year);
		$selectedManth[(int)$target_user->birth_month]="Selected";
		$selectedDay[(int)$target_user->birth_day]="Selected";
		$selectedRegion[$target_user->address_region]="Selected";
		$GenderRdo=array();
		$GenderRdo[$target_user->gender]="checked";
		setcookie('TorokuMessageFlg','false',time()+60);
		$saveFlg="false,".session('CustomerManage');$btnDisp="修　正";
		$html_reason_coming="";
		if(isset($request->syusei_Btn)){
			$GoBackPlace="/customers/CustomersList";
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox($target_user->reason_coming,$target_user->referee_name);
		}else if(isset($request->fromMenu)){
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
			$GoBackPlace="../top";
		}
		return view('customers.CreateCustomer',compact('total_point','target_historyBack_inf_array','html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming"));
	}

	public function ShowInputCustomer(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		if(isset($_POST['back_flg'])){
            
            array_shift($_SESSION['access_history']);
            array_shift($_SESSION['access_history']);
        }
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		/*
		if(isset($request->CreateCustomer)){
			session(['fromPage' => 'InputCustomer']);
			session(['CustomerManage' => 'new']);
		}else{
			session(['fromPage' => 'SyuseiCustomer']);
			session(['CustomerManage' => 'syusei']);
		}
		//public function ShowInputCustomer(InpCustomerRequest $request){
		if(session('CustomerManage')=='new'){
			//session(['fromPage' => 'InputCustomer']);
			//session(['CustomerManage' => 'new']);
			//$header="";$slot="";
			$target_user=array();
			$maxUserSerial =DB::table('users')->max('serial_user');
			//if($maxUserSerial==1){

			$TargetUserSerial=++$maxUserSerial;
			$target_user['serial_user']=sprintf('%06d', $TargetUserSerial);
			$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
			$html_birth_year_slct=trim($html_birth_year_slct);
			$GoBackPlace="../ShowMenuCustomerManagement";
			if(isset($request->CustomerListCreateBtn)){
				$GoBackPlace="/customers/ShowCustomersList_livewire";
			}
			setcookie('TorokuMessageFlg','false',time()+60);
			$GenderRdo=array();
			$selectedManth=null;$selectedDay=null;$selectedRegion=null;
			$saveFlg="false,".session('CustomerManage');$btnDisp="　登　録　";
			$html_reason_coming="";
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
			
		}else{
			*/
			session(['fromPage' => 'SyuseiCustomer']);
			session(['CustomerManage' => 'syusei']);
			$target_user=User::where('serial_user','=', $request->input('syusei_Btn'))->first();
			$btnDisp="　修　正　";
		
			$selectedManth=array();$selectedManth=array();
			$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list($target_user->birth_year);
			$selectedManth[(int)$target_user->birth_month]="Selected";
			$selectedDay[(int)$target_user->birth_day]="Selected";
			$selectedRegion[$target_user->address_region]="Selected";
			$GenderRdo=array();
			$GenderRdo[$target_user->gender]="checked";
			setcookie('TorokuMessageFlg','false',time()+60);
			$saveFlg="false,".session('CustomerManage');
			$html_reason_coming="";
			if(isset($request->syusei_Btn)){
				$GoBackPlace="/customers/ShowCustomersList_livewire";
				$html_reason_coming=OtherFunc::make_html_reason_coming_cbox($target_user->reason_coming,$target_user->referee);
			}else if(isset($request->fromMenu)){
				$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
				$GoBackPlace="../ShowMenuCustomerManagement";
			}
		//}
		return view('customers.CreateCustomer',compact('target_historyBack_inf_array','html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming"));
	}

	public function ShowInOutStandbyDisplay(){
		if (empty($_SERVER['HTTPS'])) {
			$ht_type='http://';
		} else {
			$ht_type='https://';			
		}
		$host_url=$_SERVER['HTTP_HOST'];
		session(['target_serial' => ""]);
		return view('admin.InOutStandbyDisplayJQ',compact('host_url'));
	}
	public function send_mail_in_out(Request $request){
        $item_array=json_decode( $request->item_json , true );
        if($item_array['seated_type']=='in'){
            $msg=InitConsts::MsgIn();
           
            $sbj=InitConsts::sbjIn();
        }else if($item_array['seated_type']=='out'){
            $msg=InitConsts::MsgIn();
            $sbj=InitConsts::sbjIn();
        }

        $msg=str_replace('[name-target]', $item_array['name_sei']." ".$item_array['name_mei'], $msg);
        $msg=str_replace('[time]', $item_array['target_time'], $msg);
        $msg=OtherFunc::ConvertPlaceholder($msg,"body");
        $sbj=str_replace('[name-target]', $item_array['name_sei']." ".$item_array['name_mei'], $sbj);
        $sbj=str_replace('[time]', $item_array['target_time'], $sbj);
        $sbj=OtherFunc::ConvertPlaceholder($sbj,"sbj");

        $target_item_array['subject']=$sbj;
        $to_email_array=explode (",",$item_array['email']);
        $protector_array=explode (",",$item_array['protector']);
        $target_item_array['from_email']=$item_array['from_email'];
        $i=0;
        foreach($to_email_array as $target_email){
            $target_item_array['msg']=str_replace('[name-protector]', $protector_array[$i], $msg);
            $target_item_array['to_email']=$target_email;
            Mail::send(new ContactMail($target_item_array));
            $i++;
        }
        $send_msd="配信しました。";
        $json_dat = json_encode( $send_msd , JSON_PRETTY_PRINT ) ;
        echo $json_dat;
    }

	public function in_out_manage(Request $request)
    {
		$target_serial=$request->target_serial;
        $target_serial_length=strlen($target_serial);
        $TargetInfSql=Staff::where('serial_staff','=',$target_serial);
        if($TargetInfSql->count()>0){
            $TargetInf=$TargetInfSql->first();
            $target_item_array['target_time']=date("Y-m-d H:i:s");
            $target_item_array['target_date']=date("Y-m-d");
            $target_item_array['student_serial']= $student_serial;
            $target_item_array['from_email']=config('app.MAIL_FROM_ADDRESS');
            $target_item_array['name_sei']=$TargetInf->name_sei;
            $target_item_array['name_mei']=$TargetInf->name_mei;
            $target_item_array['protector']=$TargetInf->protector;
            $target_item_array['email']=$TargetInf->email;
            $serch_target_history_sql=InOutHistory::where('student_serial','=',$student_serial)
                        ->where('target_date','=',date("Y-m-d"))
                        ->whereNull('time_out')
                        ->orderBy('id', 'desc');
            if($serch_target_history_sql->count()>0){
                $serch_target_history_array=$serch_target_history_sql->first();
                $time_in= $serch_target_history_array->time_in;
                $interval=self::time_diff($time_in, $target_item_array['target_time']);
                if($interval<300){
                    $target_item_array['seated_type']='false';
                    $json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
                    echo $json;
                }else{
                    $target_item_array['seated_type']='out';
                    $json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
                    echo $json;
                    $inOutHistory = InOutHistory::find($serch_target_history_array->id);
                    $inOutHistory->update([
                        "time_out" => $target_item_array['target_time'],
                    ]);
                }
            }else{
                $target_item_array['seated_type']='in';
                $json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
                echo $json;
                InOutHistory::create([
                    'student_serial'=>$student_serial,
                    'target_date'=>$target_item_array['target_date'],
                    'time_in'=>$target_item_array['target_time'],
                    'student_name'=>$TargetInf->name_sei.' '.$TargetInf->name_mei,
                    'student_name_kana'=>$TargetInf->name_sei_kana.' '.$TargetInf->name_mei_kana,
                    'to_mail_address'=>$TargetInf->email,
                    'from_mail_address'=>$target_item_array['from_email'],
					'branch'=>session('target_branch_serial'),
                ]);
            }
         }else{
            $target_item_array['seated_type']='No Record';
            $json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
            echo $json;
        }
    }

	public function InpTreatment($TreatmentSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        if(isset($_POST['back_flg'])){
            array_shift($_SESSION['access_history']);
            array_shift($_SESSION['access_history']);
        }
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		$GoBackPlace="/workers/ShowTreatmentContents";
		
		if($TreatmentSerial=="new"){
			session(['TreatmentContentmanage' => 'new']);
			$maxSerial=DB::table('treatment_contents')->max('serial_treatment_contents');
			if($maxSerial==""){
				$TreatmentSerial="Tr_000001";
			}else{
				$TreatmentSerial=++$maxSerial;
			}
			$TreatmentContentInf=array();$btnDisp="新規登録";
			session(['TreatmentContentSerial' => $TreatmentSerial]);
			return view('admin.InpTreatment',compact('target_historyBack_inf_array','TreatmentSerial','TreatmentContentInf',"GoBackPlace","btnDisp"));
		}else{
			$TreatmentContentInf=TreatmentContent::where('serial_treatment_contents','=',$TreatmentSerial)->first();
			$btnDisp="修正";
			$targetTreatmentContentSerial=$TreatmentContentSerial;
			session(['targetGoodSerial' => $TreatmentContentSerial]);
			return view('admin.InpTreatment',compact('target_historyBack_inf_array','TreatmentSerial','TreatmentContentInf',"GoBackPlace","btnDisp"));
		}
	}

	public function deleteContract($serial_contract,$serial_user){
		$header="";$slot="";
		$delContract=Contract::where('serial_keiyaku','=',$serial_contract)->delete();
		$delContractDetails=ContractDetail::where('serial_keiyaku','=',$serial_contract)->delete();
		$delPaymentHistory=PaymentHistory::where('serial_keiyaku','=',$serial_contract)->delete();
		$delVisitHistory=VisitHistory::where('serial_keiyaku','=',$serial_contract)->delete();
		return redirect('/customers/ContractList/all');
	}

	public function deleteCustomer($serial_user){
		$deleUser=User::where('serial_user','=',$serial_user)->delete();
		$deleKeiyaku=Contract::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=ContractDetail::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=PaymentHistory::where('serial_user','=',$serial_user)->delete();
		$deleVisitHistory=VisitHistory::where('serial_user','=',$serial_user)->delete();
		return redirect('/customers/CustomersList');
	}

	public function ajax_SaveMedicalRecord(Request $request){
		$target_file_name=session('ContractSerial')."-".$request->VisitHistorySerial;
		$result=array();
		$hst=$_SERVER['HTTP_HOST'];
		foreach(glob("MedicalRecord/".$target_file_name."*.png") as $file) {
			$result[] = $file;
		}
		if(count($result)>0){
			unlink($result[0]);
			$filename_array=explode('-',$result[0]);
			$sv_cnt=$filename_array[3];
			$sv_cnt=str_replace('.png', '', $sv_cnt);
			$sv_cnt++;
			$num=sprintf('%02d', $sv_cnt);
			$new_file_name=session('ContractSerial')."-".$request->VisitHistorySerial."-".$num.".png";
		}else{
			$new_file_name=session('ContractSerial')."-".$request->VisitHistorySerial."-01.png";
		}
		$fp = fopen("MedicalRecord/".$new_file_name,'w');
		$upload_data=$_POST['upload_data'];
		fwrite($fp,base64_decode($upload_data));
		fclose($fp);
		$ts=str_replace('K', 'V', session('ContractSerial')."-".$request->VisitHistorySerial);
		VisitHistory::where('visit_history_serial', '=', $ts)->update([
			'serial_staff' => $request->StaffSerial,
			'remarks'=> $request->remarks
		]);
	}

	public function ShowSyuseiContract($ContractSerial,$UserSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['ContractManage' => 'syusei']);
		session(['fromPage' => 'SyuseiContract']);
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$newKeiyakuSerial=$ContractSerial;
		$targetContract=Contract::where('serial_keiyaku','=', $ContractSerial)->first();
		
		$targetContractdetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		$HowToPay=array();$HowToPay['card']="";$HowToPay['cash']="";
		$CardCompany="";$HowManyPay=array();
	
		$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct("",20,2);
		if($targetContract->how_to_pay=="Credit Card"){
			$HowToPay['card']='checked';
			$CardCompany=$targetContract->card_company;
			$HowManyPay['one']="";$HowManyPay['bunkatu']="";
			if($targetContract->how_many_pay_card==1){
				$HowManyPay['one']="Checked";
			}else{
				$HowManyPay['bunkatu']="Checked";
				$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_card,20,2);		
			}
			$HowToPay['cash']='';
			$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct("",20,1);			
		}else if($targetContract->how_to_pay=="現金"){
			$HowToPay['cash']='checked';
			$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_genkin,20,1);
			$HowManyPay['bunkatu']="";
			$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct("",20,2);
		}else if($targetContract->how_to_pay=="Paypay"){
			$HowToPay['paypay']='checked';
		}
		$CardCompanySelect=OtherFunc::make_html_card_company_slct($CardCompany);

		$KeiyakuNaiyouArray=array();$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();$KeiyakuNaiyouSelectArray=array();
		for($i=0;$i<5;$i++){
			$KeiyakuNaiyouArray[]="";
			$KeiyakuNaiyouSelectArray[]=OtherFunc::make_htm_get_treatment_slct("");
			$keiyakuCnt="";
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
		}
		if(!empty($targetContractdetails)){
			$num=0;
			foreach($targetContractdetails as $targetContractdetail){
				$KeiyakuNaiyouArray[$num]=$targetContractdetail->keiyaku_naiyo;
				$keiyakuCnt=$targetContractdetail->keiyaku_num;
				$KeiyakuNumSlctArray[$num]=OtherFunc::make_html_keiyaku_num_slct($targetContractdetail->keiyaku_num);
				$KeiyakuTankaArray[$num]=$targetContractdetail->unit_price;
				$KeiyakuPriceArray[$num]=$targetContractdetail->price;
				$num++;
			}
		}
		for($i=$num;$i<=5;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}
		if(isset($request->syusei_Btn)){
			$GoBackPlace="/customers/CustomersList";
			if(Auth::user()->serial_admin=="A_0001"){
				$GoBackPlace="/customers/CustomersList";
			}else{
				$GoBackPlace="/customers/CustomersList";
			}
		}else if(isset($request->fromMenu)){
			$GoBackPlace="../top";
		}
		$GoBackPlace="/customers/ContractList";
		$TreatmentsTimes_slct=OtherFunc::make_html_TreatmentsTimes_slct($targetContract->treatments_num);
		$html_staff_slct=OtherFunc::make_html_staff_slct($targetContract->serial_tantosya);
		$contract_type_checked=array();
		if($targetContract->keiyaku_type=='subscription'){
			$contract_type_checked['subsc']='checked';
			$contract_type_checked['cyclic']='';
		}else{
			$contract_type_checked['subsc']='';
			$contract_type_checked['cyclic']='checked';
		}
		$GoBackPlace=$_SESSION['access_history'][0];
		return view('customers.CreateContract',compact("contract_type_checked","html_staff_slct",'newKeiyakuSerial','targetContract',"targetContractdetails","targetUser","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","HowManyPay","CardCompanySelect","GoBackPlace","TreatmentsTimes_slct","KeiyakuNaiyouSelectArray"));
	}

	function insertContract(Request $request){
		$motourl = $_SERVER['HTTP_REFERER'];
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$kyo=date("Y-m-d H:i:s");
		Storage::append('errorCK.txt', $kyo." / ".$motourl);
		$targetData=array();
		$how_many_pay_card=1;$how_many_pay_card="";
		if($request->HowmanyCard=='一括'){
			$how_many_pay_card=1;
		}else{
			$how_many_pay_card=$request->HowManyPayCardSlct;
		}
		$how_many_pay_genkin=$request->HowManyPaySlct;
		if($request->HowPayRdio=='現金'){
			$how_many_pay_card=null;
		}else{
			$how_many_pay_genkin=null;
		}
		$keiyakukinngaku=str_replace(',','',mb_convert_kana($request->inpTotalAmount, "n"));
		if($request->contract_type=='subscription'){
			$keiyakukinngaku=str_replace(',','',mb_convert_kana($request->inpMonthlyAmount, "n"));
		}
		$how_to_pay=$request->HowPayRdio;
		if($request->contract_type=='subscription'){
			$how_to_pay="Credit Card";
		}
		$targetData=[
			'serial_keiyaku' => $request->ContractSerial,
			'serial_user' => $request->serial_user,
			'keiyaku_kikan_start' => $request->ContractsDateStart,

			'keiyaku_kikan_end' => $request->ContractsDateEnd,
			'keiyaku_name' => $request->ContractName,
			'keiyaku_type' => $request->contract_type,

			'keiyaku_bi' => $request->ContractsDate,
			'keiyaku_kingaku' =>  $keiyakukinngaku,
			'keiyaku_num' => $request->ContractSerial,

			'keiyaku_kingaku_total' => str_replace(',','',$request->TotalAmount),
			'how_to_pay' => $how_to_pay,

			'how_many_pay_genkin' => $how_many_pay_genkin,

			'date_first_pay_genkin' => $request->DateFirstPay,
			'date_second_pay_genkin' => $request->DateSecondtPay,

			'amount_first_pay_cash' => str_replace(',','',$request->AmountPaidFirst),
			'amount_second_pay_cash' =>  str_replace(',','',$request->AmountPaidSecond),

			'card_company' => $request->CardCompanyNameSlct,
			'how_many_pay_card' => $how_many_pay_card,
			'date_pay_card' => $request->DatePayCardOneDay,

			'tantosya' => null,
			'serial_tantosya' => $request->staff_slct,

			'remarks' => $request->memo,
			'treatments_num' => $request->TreatmentsTimes_slct,
			'branch'=>session('target_branch_serial'),
			'deleted_at'=>null
		];

		if($request->ContractSerial<>""){
			Contract::upsert($targetData,['serial_keiyaku']);
			$targetDataArray=array();
			DB::table('contract_details')->where('serial_keiyaku','=',$request->ContractSerial)->delete();
			if($request->contract_type=="subscription"){
				$contract_detail_serial=$request->ContractSerial."-0001";
				$targetDetailData=array();
				$targetDetailData=[
					'contract_detail_serial'=>$contract_detail_serial,
					'serial_keiyaku'=>$request->ContractSerial,
					'serial_user'=>$request->serial_user,
					'keiyaku_naiyo'=>'サブスクリプション',
					'branch'=>session('target_branch_serial'),
					'unit_price'=>str_replace(',','',$request->inpMonthlyAmount),
				];
				$targetDataArray[]=$targetDetailData;
			}else{
				for($i=0;$i<=4;$i++){
					if($request->ContractNaiyo[$i]<>""){
						$contract_detail_serial=$request->ContractSerial."-".sprintf('%04d', $i+1);
						$targetDetailData=array();
						$targetDetailData=[
							'contract_detail_serial'=>$contract_detail_serial,
							'serial_keiyaku'=>$request->ContractSerial,
							'serial_user'=>$request->serial_user,
							'keiyaku_naiyo'=>$request->ContractNaiyo[$i],
							'keiyaku_num'=>$request->KeiyakuNumSlct[$i],
							'branch'=>session('target_branch_serial'),
							'unit_price'=>str_replace(',','',$request->AmountPerNum[$i]),
							'price'=>str_replace(',','',$request->subTotalAmount[$i]),
						];
						$targetDataArray[]=$targetDetailData;
					}else{
						break;
					}
				}
			}
			ContractDetail::upsert($targetDataArray,['contract_detail_serial']);
			Storage::append('errorCK.txt', $kyo." / ".$motourl." / ok");
			//$header="";$slot="";
			$SerialUser=$request->serial_user;$SerialKeiyaku=$request->ContractSerial;
			session(['targetUserSerial' => $SerialUser]);
			//if(Auth::user()->serial_admin=="A_0001"){
			if(isset($request->contract_sheet)){
				return redirect('/customers/MakeContractPDF/'.$request->ContractSerial);
			}else{
				if(session('ContractManage')=='syusei'){
					return redirect("/customers/ContractList/".$SerialUser);
				}else{
					$userInf=User::where('serial_user','=',$request->serial_user)->first();
					$keiyakuInf=Contract::where('serial_keiyaku','=',$request->ContractSerial)->first();
					$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんの契約を新規登録しました。";
					$gobackURL=OtherFunc::get_goback_url($_SERVER['REQUEST_URI']);
					
					if(preg_match('[.*Inp*]', $gobackURL)){
						$GoBackToPlace="history.back()";
					}else if(session('fromMenu')=='MenuCustomerManagement'){
						$GoBackToPlace="../top";
					}else if(session('fromMenu')=='CustomersList'){
						$GoBackToPlace="/customers/CustomersList";
					}
					return view("layouts.DialogMsgKeiyaku", compact('msg','SerialUser','SerialKeiyaku','GoBackToPlace'));
				}
			}
		}
	}

	public function ShowInpKeiyaku($serial_user){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'InpKeiyaku']);
		$header="";$slot="";$HowToPay=array();
		$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();
		for($i=0;$i<=4;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}

		$targetUser=User::where('serial_user','=',$serial_user)->first();
		$serial_max=Contract::where('serial_user','=',$serial_user)->max('serial_keiyaku');
		$newKeiyakuSerial=++$serial_max;

		if($newKeiyakuSerial==1){
			$newKeiyakuSerial='K_'.str_replace('U_', '',$serial_user).'-0001';
		};
		$thisYear=date('Y');
		$thisMonth=date('m');
		$thisDay=date('d');
		$tday=date('Y-m-d');
		$endDay=date("Y-m-d",strtotime("-1 day,+1 year"));
		$HowManyPay['CardSlct']=OtherFunc::make_html_how_many_slct("",20,2);
		$HowToPay['cash']="";
		if(isset($request->serial_user)){
			$targetSerial=$request->serial_user;
			$redirectPlace='/customers/ShowCustomersList';
		}else{
			$max = User::max('serial_user');
			$targetSerial=++$max;
			if($targetSerial==1){$targetSerial="001001";}
			$redirectPlace='/customers/ShowInputCustomer';
		}
		$KeiyakuNaiyouSelectArray=array();
		for($i=0;$i<=5;$i++){
			$KeiyakuNaiyouSelectArray[]=OtherFunc::make_htm_get_treatment_slct('');
		}
		$TreatmentsTimes_slct=OtherFunc::make_html_TreatmentsTimes_slct("");
		$targetContract=array();
		$KeiyakuNaiyouArray=array();
		$CardCompanySelect=OtherFunc::make_html_card_company_slct("");
		$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct("",20,1);
		$HowManyPay['PaypaySlct']=OtherFunc::make_html_how_many_slct("",20,1);
		$html_staff_slct=OtherFunc::make_html_staff_slct("");
		$contract_type_checked['subsc']='';
		$contract_type_checked['cyclic']='';
		return view('customers.CreateContract',compact("contract_type_checked","html_staff_slct","targetUser","header","slot","tday","endDay","newKeiyakuSerial","targetContract","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","CardCompanySelect","HowManyPay",'TreatmentsTimes_slct','KeiyakuNaiyouSelectArray'));
	}

	function insertCustomer(Request $request){
		$targetSerial=$request->serial_user;
		if(session('CustomerManage')=="new"){
			$redirectPlace='/customers/ShowInputCustomer';
			session(['CustomerManage' => 'new']);
			$btnDisp="　登　録　";
		}else{
			$targetSerial=$request->serial_user;
			$redirectPlace='/customers/ShowCustomersList';
			$btnDisp="　修　正　";
		}

		$reason_coming="";
		$user_inf=User::where('serial_user','=',$targetSerial)->first();
		$referee_old="";
		if(isset($user_inf->referee)){
			$referee_old=trim($user_inf->referee);
		}
		
		if($request->reason_coming_cbx<>""){
			$reason_coming=implode(",",$request->reason_coming_cbx);
			if($request->reason_coming_txt<>""){
				$reason_coming.="(".$request->reason_coming_txt.")";
			}
		}
 		$targetData=[
			'serial_user' => $targetSerial,
			'admission_date' => $request->AdmissionDate,
			'name_sei' => $request->name_sei,

			'name_mei' => $request->name_mei,
			'name_sei_kana' => $request->name_sei_kana,
			'name_mei_kana' => $request->name_mei_kana,

			'gender'=> $request->GenderRdo,
			'birth_year' => $request->birt_year_slct,
			'birth_month' => $request->birth_month_slct,

			'birth_day' => $request->birth_day_slct,
			'postal' => $request->postal,
			'address_region' => $request->region,

			'address_locality' => $request->locality,
			'address_banti' => $request->address_banti_txt,
			'email' => $request->email,

			'phone' => $request->phone,
			'reason_coming'=>$reason_coming,
			'branch'=>session('target_branch_serial'),
			'referee_name'=>trim($request->syokaisya_txt)
		];
		User::upsert($targetData,['serial_user']);
		setcookie('TorokuMessageFlg','true',time()+60);
		$header="";$slot="";
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);
		$GoBackPlace=session('GoBackPlace');
		$saveFlg="true,".session('CustomerManage');
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		$target_page_array=array("top","Customer");
		$GoToBackPlace=OtherFunc::serch_http_referer($target_page_array);
		if(session('CustomerManage')=='syusei'){
			return redirect("/customers/CustomersList");
		}else{
			$userInf=User::where('serial_user','=',$targetSerial)->first();
			$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんのデータを新規登録しました。";
    		return view("layouts.DialogMsg", compact('userInf','msg','targetSerial','header',"slot","GoToBackPlace"));
   		}
	}

	public function deleteStaff($serial_staff){
		$deleStaff=Staff::where('serial_staff','=',$serial_staff)->delete();
		return view("admin.ListStaffs");
	}
	
	public function SaveCampaign(Request $request){
		$targetData=[
			'serial_campaign' => $request->serial_Campaign,
			'name_campaign' => $request->Campaign_name,
			'duration_start' => $request->duration_start,
			'duration_end' => $request->duration_end,
			'referrals_num' => $request->referrals_num_slct,
			'contract_amount_unit' =>$request->contract_amount_unit,
			'contract_amount_total' =>$request->contract_amount_total,
			'payment_terms' => $request->jyoken_rdo,
			'details_campaign' => $request->Campaign_details,
			'branch'=>session('target_branch_serial'),
			'memo' => $request->memo,
		];
		Campaign::upsert($targetData,['serial_campaign']);
		session()->flash('success', '登録しました。');
		$this::save_recorder("SavCampaign");
		return redirect('/workers/ShowCampaigns');
	}

	public function ShowInpCampaign($TargetCampaignSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$header="";$slot="";$checked_completed="";$checked_contract="";$checked_person="";$checked_total="";
		$GoBackPlace="/workers/ShowCampaigns";$saveFlg="";
		$referrals_num_slct_array=array();
		if($TargetCampaignSerial=="new"){
			for($i=1;$i<=10;$i++){$referrals_num_slct_array[$i]="";}
			$CampaignInf="";$checked_person="";$checked_total="";
			$maxSerial=Campaign::max('serial_campaign');
			if($maxSerial==""){
				$TargetCampaignSerial="C_0001";
			}else{
				$TargetCampaignSerial=++$maxSerial;
			}
			$CampaignInf=array();$btnDisp="新規登録";
			session(['CampaignSerial' => $TargetCampaignSerial]);
			return view('customers.CreateCampaign',compact("header","slot",'TargetCampaignSerial','CampaignInf',"GoBackPlace","btnDisp","saveFlg","checked_completed","checked_contract","referrals_num_slct_array","checked_person","checked_total"));
		}else{
			$CampaignInf=Campaign::where('serial_campaign','=',$TargetCampaignSerial)->first();
			$btnDisp="修正";
			if($CampaignInf->payment_terms=="completed"){
				$checked_completed="checked";
			}else{
				$checked_contract="checked";
			}
			if($CampaignInf->method=="person"){
				$checked_person="checked";
			}else{
				$checked_total="checked";
			}
			for($i=1;$i<=10;$i++){
				$referrals_num_slct_array[$i]="";
				if($CampaignInf->referrals_num==$i){
					$referrals_num_slct_array[$i]="selected";
				}
			}
			session(['targetCampaignSerial' => $TargetCampaignSerial]);
			return view('customers.CreateCampaign',compact("header","slot",'TargetCampaignSerial','CampaignInf',"GoBackPlace","btnDisp","saveFlg","checked_completed","checked_contract","checked_person","checked_total","referrals_num_slct_array"));
		}
	}
	
	function menu_teacher(Request $request) {
		$teacher_inf=Auth::guard('admin')->user();
		return view('teacher.menu_teacher');
	}
	
	function menuEmployee(Request $request) {
		$teacher_inf=Auth::guard('admin')->user();
		return view('teacher.MenuCustomerManagement');
	}
	
	public function ajax_save_kessan_month(Request $request){
		Configration::where('subject','=', 'KesanMonth')->update(['value1' => $_POST['kesan_month']]);
		echo 'success';
	}

	public function ajax_save_target_contract_money(Request $request){
		$flg=false;
		if(initConsts::TargetContractMoney()!=null){
			$target_contract_money_array=explode( ',',initConsts::TargetContractMoney());
			$i=0;
			foreach($target_contract_money_array as $target_contract_money){
				$target_contract_money_data_array=explode( '-',$target_contract_money);
				if($_POST['target_day']==$target_contract_money_data_array[0]."-".$target_contract_money_data_array[1]){
					$target_contract_money_array[$i]=$_POST['target_day']."-".$_POST['target_money'];
					$flg=true;
					break;
				}
				$i++;
			}
		}
		if(!$flg){
			$target_contract_money_array[]=$_POST['target_day']."-".$_POST['target_money'];
		}
		
		$target_contract_money=implode(",", $target_contract_money_array);
		
		Configration::where('subject','=', 'TargetContractMoney')->update(['value2' => $target_contract_money]);
		echo 'success';
	}
	
	public function SaveTreatment(Request $request){
		$targetData=[
			'created_at' => date('Y-m-d H:i:s'),
			'serial_treatment_contents' => $request->serial_TreatmentContent,
			'name_treatment_contents' => $request->TreatmentContent_name,
			'branch'=>session('target_branch_serial'),
			'name_treatment_contents_kana' => $request->TreatmentContent_name_kana,
			'treatment_details' => $request->TreatmentContent_details,
			'memo' => $request->memo,
		];
		TreatmentContent::upsert($targetData,['serial_treatment_contents']);
		session()->flash('success', '登録しました。');
		$this::save_recorder("SaveTreatmentContent");
		return redirect('/admin/TreatmentList');
	}

	public function MakeContractPDF($serial_Contract){
		$keiyaku_inf=Contract::where('serial_keiyaku','=',$serial_Contract)->first();
		$User_inf=User::where('serial_user','=',$keiyaku_inf->serial_user)->first();
		$prefecture_name=OtherFunc::get_prefecture_name_by_region($User_inf->address_region);
		$ContractDetail_inf=ContractDetail::where('serial_keiyaku','=',$serial_Contract)->get();
		$SentenceHowToPay='';
		if($keiyaku_inf->keiyaku_type=="subscription"){
			$SentenceHowToPay='クレジットカード支払'.'カード会社：'.$keiyaku_inf->card_company.' ('.number_format($keiyaku_inf->keiyaku_kingaku).'円/月)';
		}else{
			if($keiyaku_inf->how_to_pay=='現金'){
				$SentenceHowToPay='現金支払'.'  '.$keiyaku_inf->how_many_pay_genkin.' 回';
				$amount_first_pay_cash="";
				if($keiyaku_inf->amount_first_pay_cash<>""){
					$amount_first_pay_cash=number_format($keiyaku_inf->amount_first_pay_cash);
				}
				$SentenceHowToPay.='<br>1回目　'.substr($keiyaku_inf->date_first_pay_genkin, 0, 4).'年 '.substr($keiyaku_inf->date_first_pay_genkin, 5, 2).'月 ' .substr($keiyaku_inf->date_first_pay_genkin, 8, 2).'日 ('.$amount_first_pay_cash.'円)';
				if($keiyaku_inf->how_many_pay_genkin>1){
					$SentenceHowToPay.='<br>2回目　'.substr($keiyaku_inf->date_second_pay_genkin, 0, 4).'年 '.substr($keiyaku_inf->date_second_pay_genkin, 5, 2).'月 ' .substr($keiyaku_inf->date_second_pay_genkin, 8, 2).'日 ('.$keiyaku_inf->amount_second_pay_cash.'円)';
				}
			}else{
				if($keiyaku_inf->how_many_pay_card>=2){
					$SentenceHowToPay='クレジットカード分割支払  カード会社：'.$keiyaku_inf->card_company.'         '.$keiyaku_inf->how_many_pay_card.'回払い';
				}else{
					$SentenceHowToPay='クレジットカード支払'.'カード会社：'.$keiyaku_inf->card_company.substr($keiyaku_inf->date_first_pay_genkin, 0, 4).'年 '.substr($keiyaku_inf->date_first_pay_genkin, 5, 2).'月 ' .substr($keiyaku_inf->date_first_pay_genkin, 8, 2).'日 ('.number_format($keiyaku_inf->keiyaku_kingaku_total).'円)';
				}
			}
		}
		$pdf = \PDF::loadView('printing.contracts.contracts',compact('keiyaku_inf','User_inf','ContractDetail_inf','SentenceHowToPay','prefecture_name'));
		//$pdf->setPaper('A4');
		return $pdf->download('test.pdf');    
		//return $pdf->stream('title.pdf');	
	}

	public function DeleteSalseGood($serial_sales){
		$header="";$slot="";
		//Good::where('serial_good','=',$serial_good)->delete();
		//$delSales=DB::table('goods')->where('serial_good','=',$serial_good)->delete();
		$delSales=SalesRecord::where('serial_sales','=',$serial_sales)->delete();
		$this::save_recorder("DeleteSalseGood");
		return redirect('/customers/ShowDailyReport');
		//return view('customers.InfoCustomer',compact("user","header","slot"));
	}

	public function SaveSalseGood(Request $request){
		$buying_price_ary=DB::table('goods')->where('serial_good','=',$request->serial_good_slct)->first('buying_price');
		$buying_price=$buying_price_ary->buying_price;
		$targetSalesSerial=session('targetSalesSerial');
		if($targetSalesSerial=="new"){
			$maxSerial=DB::table('sales_records')->max('serial_sales');
			if($maxSerial==""){
				$targetSalesSerial='S_00000001';
			}else{
				$targetSalesSerial=++$maxSerial;
			}
		}

		$targetData=[
			'created_at' => date('Y-m-d'),
			'serial_sales' => $targetSalesSerial,
			'serial_user' => $request->serial_buyer_sct,

			'serial_good' => $request->serial_good_slct,
			'date_sale' => $request->sold_date,
			'buying_price' => $buying_price,

			'selling_price' => $request->selling_price,
			'memo' =>  $request->memo,
			'how_to_pay'=>$request->how_to_pay_rdo,

			'branch'=>session('target_branch_serial'),
		];
		DB::table('sales_records')->upsert($targetData,['serial_sales']);
		$this::save_recorder("SaveGood");
		session()->flash('success', '登録しました。');
		return redirect('/customers/ShowDailyReport');
	}

	public function ajax_get_good_inf(Request $request){
		$GoodInf=DB::table('goods')->where('serial_good','=',$request->serial_good)->first();
		$gf['BuyingPrice']="";$gf['SellingPrice']="";
		if(isset($GoodInf->buying_price)){
			$gf['BuyingPrice']=$GoodInf->buying_price;
			$gf['SellingPrice']=$GoodInf->selling_price;
		}
		echo json_encode($gf);
	}
	
	public function get_inf_good(Request $request){
		$cntPhone=User::where('phone','=',$request->phone)->count();
		$cntName=User::where('name_sei','=',$request->name_sei)
			->where('name_mei','=',$request->name_mei)
			->count();
		$cnt['Phone']=$cntPhone;
		$cnt['Name']=$cntName;
		echo json_encode($cnt);
	}

	public function deleteGood($serial_good){
		$header="";$slot="";
		$deleGood=DB::table('goods')->where('serial_good','=',$serial_good)->delete();
		$this::save_recorder("deleteGood");
		return redirect('/workers/ShowGoodsList');
	}

	public function SaveGood(Request $request){
			$targetData=[
				'serial_good' => session('targetGoodSerial'),
				'model_number' => $request->model_number,
				'good_name' => $request->good_name,
				'buying_price' => $request->buying_price,
	
				'selling_price' => $request->selling_price,
				'zaiko' => $request->zaiko,
				'memo' =>  $request->memo,
				'branch'=>  session('target_branch_serial'),
				'created_at'=>date("Y-m-d H:i:s")
			];

		DB::table('goods')->upsert($targetData,['serial_good']);
		$this::save_recorder("SaveGood");
		session()->flash('success', '登録しました。');
		return redirect('/workers/ShowGoodsList');
	}

	public function ShowInputSalesGoods($SalesSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'SalesGoods']);
		session(['targetSalesSerial' => $SalesSerial]);
		$header="";$slot="";
		
		$GoBackPlace="/workers/ShowDailyReport";$saveFlg="";
		
		$targetUserSerial="";
		$customer_list_slct=OtherFunc::make_html_customer_list_slct($targetUserSerial);
		if($SalesSerial=="new"){
			$maxSerial=DB::table('sales_records')->max('serial_sales');
			if($maxSerial==""){
				$targetsalesSerial="S_000001";
			}else{
				$targetsalesSerial=++$maxSerial;
			}
			$SalesInf=array();$btnDisp="新規登録";
			$good_slct=OtherFunc::make_html_sales_good_slct("");
			$customer_list_slct=OtherFunc::make_html_customer_list_slct("");
			session(['targetsalesSerial' => $targetsalesSerial]);
			return view('teacher.CreateSalseGood',compact("header","slot",'targetsalesSerial','SalesInf',"GoBackPlace","btnDisp","saveFlg","good_slct","customer_list_slct"));
		}else{
			$SalesInf=DB::table('sales_records')->where('serial_sales','=',$SalesSerial)->first();
			$btnDisp="修正";
			$targetSalesSerial=$SalesSerial;
			$customer_list_slct=OtherFunc::make_html_customer_list_slct($SalesInf->serial_user);
			$good_slct=OtherFunc::make_html_sales_good_slct($SalesInf->serial_good);
			session(['targetGoodSerial' => $SalesInf->serial_good]);
			return view('teacher.CreateSalseGood',compact("header","slot",'targetSalesSerial','SalesInf',"GoBackPlace","btnDisp","saveFlg","good_slct","customer_list_slct"));
		}
	}

	public function ShowSyuseiGood($GoodSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'SyuseiGood']);
		session(['goodmanage' => $GoodSerial]);

		$header="";$slot="";
		$GoBackPlace="/workers/ShowGoodsList";$saveFlg="";
		if($GoodSerial=="new"){
			$maxSerial=DB::table('goods')->max('serial_good');
			if($maxSerial==""){
				$targetGoodSerial="G_000001";
			}else{
				$targetGoodSerial=++$maxSerial;
			}
			$GoodInf=array();$btnDisp="新規登録";
			session(['targetGoodSerial' => $targetGoodSerial]);
			return view('teacher.CreateGood',compact("header","slot",'targetGoodSerial','GoodInf',"GoBackPlace","btnDisp","saveFlg"));
		}else{
			session(['goodmanage' => 'new']);
			$GoodInf=DB::table('goods')->where('serial_good','=',$GoodSerial)->first();
			$btnDisp="修正";
			$targetGoodSerial=$GoodSerial;
			session(['targetGoodSerial' => $GoodSerial]);
			return view('teacher.CreateGood',compact("header","slot",'targetGoodSerial','GoodInf',"GoBackPlace","btnDisp","saveFlg"));
		}
	}

	public function check_name_duplication(Request $request){
		$cnt=User::where('phone','=',$request->phone)->count();
		echo $cnt;
	}

	public function check_phone_duplication(Request $request){
		$cntPhone=User::where('phone','=',$request->phone)->count();
		$cntName=User::where('name_sei','=',$request->name_sei)
			->where('name_mei','=',$request->name_mei)
			->count();
		$cnt['Phone']=$cntPhone;
		$cnt['Name']=$cntName;
		echo json_encode($cnt);
	}

	public function ShowGoodsList(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'GoodsList']);
		session(['fromMenu' => 'GoodsList']);

		$header="";$slot="";
		$key="";
		$key=$request->kensakuKey;
		$goods=array();$goodArray=array();
		$goods=Good::paginate(initConsts::DdisplayLineNumCustomerList());
		session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		if(Auth::user()->serial_admin=="A_0001"){
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}else{
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}
		return redirect('/workers/ShowGoodsList');
	}

	public function ShowCustomersList(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'CustomersList']);
		session(['fromMenu' => 'CustomersList']);
		//OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$header="";$slot="";
		$key="";
		$key=$request->kensakuKey;
		$users=array();$userArray=array();
		if($request->kensakuKey<>""){
			$userArray=User::where('serial_user','like',"%$key%")
				->orwhere('name_sei','like',"%$key%")
				->orwhere('name_mei','like',"%$key%")
				->orwhere('name_sei_kana','like',"%$key%")
				->orwhere('name_mei_kana',"%$key%")
				->orwhere('birth_year','like',"%$key%")
				->orwhere('birth_month','like',"%$key%")
				->orwhere('birth_day','like',"%$key%")
				->orwhere('address_region','like',"%$key%")
				->orwhere('address_locality','like',"%$key%")
				->orwhere('email','like',"%$key%")->paginate(initConsts::DdisplayLineNumCustomerList())
				->through(function($user) {
					$birthday = $user->birth_year.$user->birth_month.$user->birth_day;
					$today = date('Ymd');
					$user->age=floor(($today - $birthday) / 10000);
					return $user;
				});
		}else{

			$users=User::paginate(initConsts::DdisplayLineNumCustomerList());
		}
		session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		if(Auth::user()->serial_admin=="A_0001"){
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}else{
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}

		if(Auth::user()->serial_admin=="A_0001"){
			return redirect('/customers/ShowCustomersList_livewire',['page' => $request->get('page')]);
		}else{
			return redirect('/customers/ShowCustomersList_livewire');
		}
	}
	
	public function showDialogMsg(Request $request){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		return view("article.show", ['id'=> $id,'title' => 'タイトル','data'  => 'こんにちは']);
	}
	protected function guard(){
		return Auth::guard('admin');
	 }
	public function show_dashboard(){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		return view('teacher.dashboard');
	}

	public function ShowContractHistory($serial_user){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'ContractHistory']);
		$header="";$slot="";
		return view('customers.ContractHistory');
	}

	public function ShowCustomerInfo($serial_user){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['fromPage' => 'CustomerInfo']);
		$header="";$slot="";
		$user=User::where('serial_user','=',$serial_user)->first();
		return view('customers.InfoCustomer',compact("user","header","slot"));
	}

	public function ckDellPossibleTeacher(Request $request){
		$unixStrt=$request->input('utcStartTime');
		$unixEnd=$request->input('utcEndTime');
		$unixToday = time();
		$flg=true;
		$target_schedules=Schedule::where('parentEventId','=', $request->input('eventID'))->get();
		$resArr["count"]=$target_schedules->count();
		if($unixStrt<=$unixToday){
			$flg='old';
		}else if($target_schedules->count()>0){
			$flg='lessonReserved';
		}
		$resArr["utcStrt"]=$unixStrt;
		$resArr["utcEnd"]=$unixEnd;
		$resArr["unixToday"]=$unixToday;
		$resArr["flg"]=$flg;
		echo json_encode($resArr);
	}
	
	public function ckReservPossibleTeacher(Request $request){
		$unixStrt=$request->input('utcStartTime');
		$unixEnd=$request->input('utcEndTime');
		$unixToday = time();
		$flg=false;
		$resArr["deadlineReservPossible"]=config('const.deadlineReservPossible');
		if($unixStrt>=$unixToday){
			$flg=true;
		}
		$resArr["utcStrt"]=$unixStrt;
		$resArr["utcEnd"]=$unixEnd;
		$resArr["flg"]=$flg;
		$resArr["unixToday"]=$unixToday;
		echo json_encode($resArr);
	}

	public function setResourcesTimeLine(Request $request){
		$teacher_inf = Auth::guard('admin')->user();
		$target = $teacher_inf->serial_admin;
		$target_schedules=Schedule::where('idPerson', 'like', 'U_%')->where('idTeacher',$target)->where('deleted_at','=',null)->get();
		$data = [];$personID=array();$newArr=array();
		$ev=array();$newItem=array();
		foreach ($target_schedules as $user_inf){ 
			if (!in_array($user_inf->idPerson,$personID)){ 
				$personID[]=$user_inf->idPerson;
				$newItem["id"] =$user_inf->idPerson;
				$target_name=DB::table('users')->where('serial_user',$user_inf->idPerson)->first();
				$newItem["title"] =$target_name->name;
				$newArr[] = $newItem;
			}
		}
		echo json_encode($newArr);
	}

	public function setScheduleTimeLine(Request $request){
		$teacher_inf = Auth::guard('admin')->user();
		$target = $teacher_inf->serial_teacher;
		$target_schedules=Schedule::where('idTeacher',$target)->where('deleted_at','=',null)->get();
		$data = [];
		$ev=array();$newItem=array();
		foreach ($target_schedules as $open_schedule){ 
			$startOriginal = str_replace(' (日本標準時)', '', $open_schedule->startOriginal);
			$endOriginal= str_replace(' (日本標準時)', '', $open_schedule->endOriginal);
			$newItem["start"]=date('Y-m-d H:i:s',  strtotime($startOriginal));
			$newItem["end"]=date('Y-m-d H:i:s',  strtotime($endOriginal));
			$st = new DateTime($open_schedule->startUTC);
			$st->setTimeZone(new DateTimeZone('Asia/Tokyo'));
			$st->format('Y-m-d H:i:s');
			
			$et = new DateTime($open_schedule->endUTC);
			$et->setTimeZone(new DateTimeZone('Asia/Tokyo'));
			$et->format('Y-m-d H:i:s');
			
			$newItem["title"] =  $st->format('H:i')." ～ ".$et->format('H:i');
			$newItem["id"] = $open_schedule->event_id;
			$newItem["resourceId"] = $open_schedule->idPerson;

			if(substr($open_schedule->idPerson, 0, 1)=="T"){
				$newItem["color"] = 'green';
				$newItem["Editable"] = true;
				$newItem["startEditable"] = true;
				$newItem["durationEditable"] = true;
			}else{
				$newItem["color"] = 'blue';
				$newItem["Editable"] = true;
				$newItem["startEditable"] = false;
				$newItem["durationEditable"] = false;
			}
			$newArr[] = $newItem;
		}
		echo json_encode($newArr);
	}

	public function setSchedule(Request $request){
		$teacher_inf = Auth::guard('admin')->user();
		$target = $teacher_inf->serial_admin;
		$target_schedules=Schedule::where('idPerson',$target)->orwhere('idTeacher',$target)->where('deleted_at','=',null)->get();
		$data = [];
		$ev=array();$newItem=array();
		foreach ($target_schedules as $open_schedule){ 
			$startOriginal = str_replace(' (日本標準時)', '', $open_schedule->startOriginal);
			$endOriginal= str_replace(' (日本標準時)', '', $open_schedule->endOriginal);
			$newItem["start"]=date('Y-m-d H:i:s',  strtotime($startOriginal));
			$newItem["end"]=date('Y-m-d H:i:s',  strtotime($endOriginal));
			$newItem["title"] = $open_schedule->title;
			$newItem["id"] = $open_schedule->event_id;
			if(substr($open_schedule->idPerson, 0, 1)=="T"){
				$newItem["color"] = 'green';
				$newItem["Editable"] = true;
				$newItem["startEditable"] = true;
				$newItem["durationEditable"] = true;
			}else{
				$newItem["color"] = 'blue';
				$newItem["Editable"] = true;
				$newItem["startEditable"] = false;
				$newItem["durationEditable"] = false;
			}
			$newArr[] = $newItem;
		}
		echo json_encode($newArr);
	}
	
	function lesson_decision_manage(Request $request){
		$target_user_inf = DB::table('users')->where('serial_user',session()->get('targetStudentId'))->first();
		$kakunin="";
		if(isset($request->ukeru)){
			$requestRes='seiritu';
			$subject="レッスンが成立しました。";
			$setumei="レッスンが確定しました。".$target_user_inf->name."さんに確定のメールを送信しました。"."<br>".$kakunin;
		}else if(isset($request->ukenai)){
			$requestRes='ukenai';
			$subject="レッスンリクエストはキャンセルされました。";
			$setumei="レッスンを受けませんでした。".$target_user_inf->name."さんに結果のメールを送信しました。".$kakunin;
		}

		DB::table('Schedules')->where('event_id',session()->get('UserEventId'))->update([
			'LessonRequestResult'=>$requestRes,
			'dateLessonReceive' =>time(),
			'updated_at'=>now()
		]);
		$target_Lesson = DB::table('Schedules')->where('event_id',session()->get('UserEventId'))->first();
		$to_array = [
			[
				'email' =>$target_user_inf->email, 
				'name' => 'Network Musicac Academy',
			]
		];
		$UserEventId=session()->get('UserEventId');
		$ky=$UserEventId;
		$targetURL=(empty($_SERVER['HTTPS']) ? 'http://' : 'https://').$_SERVER['SERVER_NAME']."/LessonResCheck/".$ky;
		$detail_array['idPerson']=$target_Lesson->idPerson;
		$teacherInf=OtherFunc::get_teacher_info_By_eventID(session()->get('UserEventId'));
		$detail_array['TeacherName']=$teacherInf->last_name_kanji." ".$teacherInf->first_name_jp_kana;
		$detail_array['startUtc']=$target_Lesson->startUNIXTimeStamp;
		$detail_array['endUtc']=$target_Lesson->endUNIXTimeStamp;
		$detail_array['title']=$target_Lesson->title;
		$detail_array['targetURL']=$targetURL;
		$detail_array['UserEventId']=session()->get('UserEventId');
		Mail::to($to_array)->send(new KakuninMailUser($target_user_inf,$subject,$detail_array,$requestRes));
		$BackToURL="/menu_teacher";
		return view("teacher.kakunin",compact("setumei","BackToURL","target_user_inf"));
	}

	function request_answer($TeacherId,$UserId,$TeacherEventId,$UserEventId){
		session(['targetStudentId' => $UserId,'UserEventId' => $UserEventId]);
		$target_user_inf = DB::table('users')->where('serial_user',$UserId)->first();
		$teacher_inf = Auth::guard('admin')->user();
		$target_Instrument=OtherFunc::getInstrumentNameByUserEventId($UserEventId);
		$sch=DB::table('Schedules')->where('event_id', $UserEventId)->first();
		if($sch->dateLessonReceive<>""){
			if($sch->LessonRequestResult=="seiritu"){
				$setumei="すでにレッスンの予約を受け付けています。この画面では変更できません。";
			}else{
				$setumei="すでにレッスンの予約を断っています。この画面では変更できません。";
			}
			$BackToURL="/menu_teacher";
			return view("teacher.kakunin_default_teacher",compact("setumei","BackToURL"));
		}else if($sch->deleted_at<>""){
			$setumei="受講者が、レッスン決定前にキャンセルしました。";
			$BackToURL="/menu_teacher";
			return view("teacher.kakunin_default_teacher",compact("setumei","BackToURL"));
		}else{
			return view("layouts.LessonDecision",compact('target_user_inf','teacher_inf','target_Instrument','sch'));
		}
	}

	function saveSchedule(Request $request) {
		$teacher_inf = Auth::guard('admin')->user();
		$LessonTimeNum=OtherFunc::makeLessonTimeNumber();
		$flg=$_POST['manageFlg'];
		$stsUTC=$request->input('utcStartTime');
		$endUTC=$request->input('utcEndTime');
		$startUNIX=strtotime($stsUTC);
		$endUNIX=strtotime($endUTC);
		$detail_array=array();
		$tst="";
		$send_mail_flg=true;
		if($flg=="new"){
			DB::table('Schedules')->insert([
				'event_id' =>$request->input('EventId'),
				'reservation_number' =>$LessonTimeNum,

				'idPerson' =>$teacher_inf->serial_teacher,
				'startOriginal' =>$request->input('originalStartTime'),
					
				'endOriginal' =>$request->input('originalEndTime'),
				'startUTC' =>$request->input('utcStartTime'),
				'endUTC' =>$request->input('utcEndTime'),
					
				'textYear' =>$request->input('year_Slct'),
				'textMonth' =>$request->input('month_Slct'),
				'textDay' =>$request->input('day_Slct'),
					
				'textStartHour' =>$request->input('start_hour_Slct'),
				'textStartMinutes' =>$request->input('start_minute_Slct'),
				'textEndHour' =>$request->input('end_hour_Slct'),
		
				'textEndMinutes' =>$request->input('end_minute_Slct'),
				'title' =>$request->input('titleSchedule'),
				
				'startUNIXTimeStamp'=>$startUNIX,
				'endUNIXTimeStamp'=>$endUNIX,
				'created_at'=>now()
			]);
			$tst="保存しました。";
			$detail_array['startUtc']=$request->input('utcStartTime');
			$detail_array['endUtc']=$request->input('utcEndTime');
			$detail_array['title']=$request->input('titleSchedule');
			$subject="レッスン可能スケジュールを保存しました。";
		}else if($flg=="resize" || $flg=="move"){
			$target=DB::table('Schedules')->where('event_id', $request->input('EventId'))->first();
			if(!is_null($target)){
				$created_at=$target->created_at;
				$detail_array['syuseimae_startUtc']=$target->startUTC;
				$detail_array['syuseimae_endUtc']=$target->endUTC;
				$detail_array['syuseimae_title']=$target->title;
			}else{
				$flg="new";
				$created_at=now();
			}
			DB::table('Schedules')->updateOrInsert(
				['event_id' => $request->input('EventId'),'idPerson'=>$teacher_inf->serial_teacher],
				[
					'startOriginal'=>$request->input('originalStartTime'),
					'endOriginal' => $request->input('originalEndTime'),
					'startUTC' => $request->input('utcStartTime'),
					'endUTC' => $request->input('utcEndTime'),
						
					'textYear' => $request->input('year_Slct'),
					'textMonth' => $request->input('month_Slct'),
					'textDay' => $request->input('day_Slct'),
						
					'textStartHour' => $request->input('start_hour_Slct'),
					'textStartMinutes' => $request->input('start_minute_Slct'),
					'textEndHour' => $request->input('end_hour_Slct'),
			
					'textEndMinutes' => $request->input('end_minute_Slct'),
					'title' =>$request->input('titleSchedule'),
					'startUNIXTimeStamp'=>$startUNIX,
					
					'endUNIXTimeStamp'=>$endUNIX,
					'created_at'=>$created_at,
					'updated_at'=>now()				]
			);
			if($flg=="new"){				$tst="保存しました。";
				$subject="スケジュールを保存しました。";
			}else{
				$tst="変更しました。";
				$subject="スケジュールを変更しました。";
			}
			$detail_array['startUtc']=$request->input('utcStartTime');
			$detail_array['endUtc']=$request->input('utcEndTime');
			$detail_array['title']=$request->input('titleSchedule');
		}else if($flg=="del"){
			$target=DB::table('Schedules')->where('event_id', $request->input('EventId'))->first();
			if(!is_null($target)){
				$detail_array['startUtc']=$target->startUTC;
				$detail_array['endUtc']=$target->endUTC;
				$detail_array['title']=$target->title;
				$asl=Teachers::all();
				$del_target=Schedule::where('event_id', $request->input('EventId'))->delete();
				$subject="スケジュールを削除しました。1";
			}else{
				$detail_array['startUtc']=$request->input('utcStartTime');
				$detail_array['endUtc']=$request->input('utcEndTime');
				$detail_array['title']=$request->input('titleSchedule');
				$send_mail_flg=false;
			}
			$tst="削除しました。";
		}
		echo json_encode($tst);
		if($send_mail_flg){
			$to_array = [[
				'email' =>$teacher_inf->email, 
				'name' => 'Network Musicac Academy',
			]];
			Mail::to($to_array)->send(new KakuninMail($teacher_inf,$subject,$detail_array,$flg));
		}
	}

	function ShowTeacherCalender(Request $request) {
		$teacher_inf = Auth::guard('admin')->user();
		$target_teacher_serial=$request->_METHOD;
		$vType="dayGridMonth";
		$targetData="/setSchedule";
		$initFlg='true';
		return view('schedule.calender',compact('teacher_inf','vType','initFlg','targetData'));
	}
	
	function ShowTimeLine(Request $request) {
		$teacher_inf = Auth::guard('admin')->user();
		$target_teacher_serial=$request->_METHOD;
		$vType="resourceTimelineDay";
		$targetData="/setScheduleTimeLine";
		$targetResources="/setResourcesTimeLine";
		$initFlg='true';
		return view('schedule.calender_timeline',compact('teacher_inf','vType','initFlg','targetData','targetResources'));
	}
	
	function ShowUserPagination(Request $request) {
		$teacher_inf = Auth::guard('admin')->user();
		$userDB = DB::table('users')->paginate(initConsts::DdisplayLineNumCustomerList());
		return view('layouts.userList',compact('userDB'));
	}

	function inp_teacher_inf(Request $request){
		$manage_flg="show";
		$teacher_inf=Auth::guard('admin')->user();
		return view("teacher.inp_inf_teacher",compact("manage_flg","teacher_inf"));
	}
	
	public function showChangePasswordForm(Request $request){
		return view('teacher.change-password',compact("request"))->with('user', Auth::guard('admin')->user());
	}

	public function ChangePassword(Request $request){
		//ValidationはChangePasswordRequestで処理
		//パスワード変更処理
		$teacher_inf = Auth::guard('admin')->user();
		$teacher_inf->password = Hash::make($request->get('password'));
		$teacher_inf->save();
		// パスワード変更処理後、homeにリダイレクト
		$setumei="パスワードを変更しました。";
		$BackToURL="/menu_teacher";
		return view("teacher.kakunin",compact("setumei","BackToURL"));
	}
      
	function show_teacher_dashboard(Request $request){
		$teacher_inf=Auth::guard('admin')->user();
		return view("teacher.dashboard")->within(compact('teacher_inf'));
	}
	
	function show_teacher_inf(Request $request){
		if(isset($request->changepass)){
			//print "changepass=".$request->changepass."<br>";
		}else{
			session_cache_limiter('none');
			header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
			header("Pragma: no-cache");
			$manage_flg="show";$instruments_jp=array();$instruments="";
			$teacher_inf=Auth::guard('admin')->user();
			$inf_instruments = DB::table('instruments')->get();
			foreach ($inf_instruments as $inf_instrument){
				if(strpos($teacher_inf['instruments'],$inf_instrument->serial_instrument)!== false){
					$instruments_jp[] =$inf_instrument->instrument_jp;
				}
			}
			$instruments= implode(' / ',$instruments_jp);
			$msg_sinseityu="";
			if(is_null($teacher_inf->email_verified_at)){
				$msg_sinseityu="<br>(仮メールアドレス。現在認証待ち)";
			}
			return view("teacher.inp_inf_teacher",compact("manage_flg","teacher_inf",'instruments','msg_sinseityu'));
		}
	}
	function show_inp_form(Request $request){
		$manage_flg="show";
		if(isset($_POST['target_hdn'])){
			session(['target_sbj' => $_POST['target_hdn']]);
		}
		$teacher_inf=Auth::guard('admin')->user();
		$tgt=session('target_sbj');$htm="";
		if($tgt=="last_name_eng"){
			$tgt_hyouji="姓(英字)";
			$tgt_view="inp_name_teacher";
			$haba_txt="64";
			$mojisu=30;
		}else if($tgt=="first_name_eng"){
			$tgt_hyouji="名(英字)";
			$tgt_view="inp_name_teacher";
			$haba_txt="64";
			$mojisu=30;
		}else if($tgt=="last_name_kanji"){
			$tgt_hyouji="姓(漢字)";
			$tgt_view="inp_name_teacher";
			$haba_txt="64";
			$mojisu=30;
		}else if($tgt=="first_name_kanji"){
			$tgt_hyouji="名(漢字)";
			$tgt_view="inp_name_teacher";
			$haba_txt="64";
			$mojisu=30;
		}else if($tgt=="phone"){
			$tgt_hyouji="電話番号";
			$tgt_view="inp_name_teacher";
			$haba_txt="64";
			$mojisu=20;
		}else if($tgt=="address"){
			$tgt_hyouji="住所";
			$tgt_view="inp_name_teacher";
			$haba_txt="3/4";
			$mojisu=200;
		}else if($tgt=="email"){
			$tgt_hyouji="e-mail";
			$tgt_view="inp_mail_teacher";
			$haba_txt="3/4";
			$mojisu=200;
		}else if($tgt=="syokai_bun_short"){
			$tgt_hyouji="プロフィール(トップページ)";
			$tgt_view="inp_name_teacher";
			$haba_txt="3/4";
			$mojisu=1000;
		}else if($tgt=="syokai_bun_long"){
			$tgt_hyouji="プロフィール(講師紹介ページ)";
			$tgt_view="inp_syokai_bun_long_teacher";
			$haba_txt="3/4";
			$mojisu=1000;
		}else if($tgt=="eye_catch_file_name_original"){
			$tgt_hyouji="アイキャッチ";
			$tgt_view="inp_eye_catch_teacher";
		}else if($tgt=="url_youtube"){
			$tgt_hyouji="YouTube URL(URLのみ)";
			$tgt_view="inp_name_teacher";
			$haba_txt="3/4";
			$mojisu=2000;
		}else if($tgt=="instruments"){
			$tgt_hyouji="講義可能楽器";
			$tgt_view="inp_instruments_teacher";
			$haba_txt="3/4";
			$mojisu=2000;
			$htm=OtherFunc::make_html_select_instruments_for_teacher();
		}else if($tgt=="password"){
			$tgt_hyouji="パスワード";
			$tgt_view="inp_password_teacher";
			$haba_txt="3/4";
			$mojisu=200;
		}

		$css_validat="";
		if($tgt!="eye_catch_file_name_original"){
			$css_validat="border rounded mb-3 px-2 py-1 w-".$haba_txt." ,validate[required,funcCall[size[".$mojisu."]]";
		}
		$tgt_data=$teacher_inf[$tgt];
		if($tgt<>"password"){
			return view("teacher.{$tgt_view}",compact("teacher_inf","tgt_hyouji","tgt_data","tgt","css_validat","htm"));
		}else{
			return view("teacher.{$tgt_view}",compact("teacher_inf","tgt_hyouji","tgt_data","tgt","css_validat","htm"))->with($validated);
		}
	}

	function save_target(Request $request){
		$teacher_inf=Auth::guard('admin')->user();
		if(!isset($_POST['modoru_btn'])){
			$model_teacher = new Teachers();
			if(session('target_sbj')=="eye_catch_file_name_original"){
				$path='/storage/profile_images';
				$upload_image = $request->file('up');
				$original_file_name=$upload_image->getClientOriginalName();
				$filepath = pathinfo($original_file_name);
				$extension=$filepath['extension'];
				$up_file_name=$teacher_inf['serial_teacher'].".".$extension;
				$teacher_inf->eye_catch_file_name_original=$original_file_name;
				$teacher_inf->eye_catch_file_name_up=$up_file_name;
				$teacher_inf->save();
				$request->file('up')->move(public_path().$path, $up_file_name);
			}else if(session('target_sbj')=='instruments'){
				if (isset($request->instruments_ckbx)) {
					$checkbox = implode("/",$request->instruments_ckbx);
				}
				$teacher_inf->instruments=$checkbox;
				$teacher_inf->save();
			}else{
				$input = $request->only($this->formItems);
				$tgt=session('target_sbj');
				Auth::guard('admin')->user()->{$tgt}= $input['default_txt'];
				$model_teacher::where('id',$teacher_inf['id'])->update([session('target_sbj') => $input['default_txt']]);
			}
		}
		return redirect('inp_teacher_inf');
	}

	function changeEmail(Request $request){
        //ValidationはChangeUsernameRequestで処理
        //メールアドレス変更処理
		$teacher_inf = Auth::guard('admin')->user();
		$teacher_inf->email_tmp = $teacher_inf->email;
		$teacher_inf->email = $request->get('default_txt');
		$teacher_inf->email_verified_at = null;
		$teacher_inf->save();
        //メール送信
		$teacher_inf->sendEmailVerificationNotification();
        //説明メッセージの表示
		$setumei="確認メールをお送りしました。必ずログイン状態のブラウザでメール本文のリンク先にアクセスしてください。確認が取れない場合は、メールアドレスは変更されません。";
		$BackToURL="{{ route('menu_teacher.get') }}";
		return view("teacher.kakunin",compact("setumei","BackToURL"));
  }
	public function logout(Request $request){
		Auth::guard('admin')->logout();
		$request->session()->invalidate();
		$request->session()->regenerateToken();
		return redirect('login_teacher');
	}
	
	private function paginate($items, $perPage = 15, $page = null, $options = []){
        $page = $page ?: (Paginator::resolveCurrentPage() ?: 1);
        $items = $items instanceof Collection ? $items : Collection::make($items);
        return new LengthAwarePaginator($items->forPage($page, $perPage), $items->count(), $perPage, $page, $options);
    }
    
	private function save_recorder($location){
		Recorder::insert([
			'id_recorder' => Auth::id(),
			'name_recorder' => Auth::user()->last_name_kanji.' '.Auth::user()->first_name_kanji,
			'location_url' => $_SERVER['REQUEST_URI'],
			'location' =>$location,
			//'created_at' => date('Y-m-d H:i:s'),
		]);
		return;
	}
}