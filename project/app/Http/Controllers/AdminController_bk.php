<?php

namespace App\Http\Controllers;
//ini_set('error_log', dirname(__FILE__) . '/error.log');
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Teachers;
use App\Models\Schedule;
use App\Models\User;
use App\Models\Keiyaku;
use App\Models\ContractDetail;
use App\Models\VisitHistory;
use App\Models\PaymentHistory;
use App\Models\TreatmentContents;
use App\Models\lesson_schedule;
use App\Models\Good;
use App\Models\Recorder;
use App\Models\SalesRecord;
use App\Models\Configration;
use App\Http\Requests\StorePostRequest;
use Illuminate\Auth\Notifications\VerifyEmail;
//use Illuminate\Http\File;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Config;
use App\Library\OtherFunc;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use App\Mail\KakuninMail;
use App\Mail\KakuninMailUser;
use DateTime;
use DateTimeZone;
use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Pagination\LengthAwarePaginator;
use App\Consts\initConsts;
use App\Models\Campaign;
use App\Models\Referee;
use Illuminate\Support\Facades\Log;
//use App\Models\Staff;

class TeacherController extends Controller
{
	private $formItems = ["default_txt"];
	private $manage_flg="";
	
	public function __construct(){
		$this->middleware('auth:teacher')->except('logout');
	}

	public function ShowSyuseiContract($ContractSerial,$UserSerial){
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		session(['ContractManage' => 'syusei']);
		session(['fromPage' => 'SyuseiContract']);
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$newKeiyakuSerial=$ContractSerial;
		$targetContract=Keiyaku::where('serial_keiyaku','=', $ContractSerial)->first();
		$targetContractdetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		$HowToPay=array();$HowToPay['card']="";$HowToPay['cash']="";
		$CardCompany="";$HowManyPay=array();
	
		$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_genkin,20,1);	
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
		}else{
			$HowToPay['cash']='checked';
			$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct($targetContract->how_many_pay_genkin,20,1);			
		}
		$CardCompanySelect=OtherFunc::make_html_card_company_slct($CardCompany);

		$KeiyakuNaiyouArray=array();$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();$KeiyakuNaiyouSelectArray=array();
		$num=0;
		foreach($targetContractdetails as $targetContractdetail){
			$KeiyakuNaiyouArray[]=$targetContractdetail->keiyaku_naiyo;
			$KeiyakuNaiyouSelectArray[]=OtherFunc::make_htm_get_treatment_slct($targetContractdetail->keiyaku_naiyo);
			$keiyakuCnt=$targetContractdetail->keiyaku_num;
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct($targetContractdetail->keiyaku_num);
			$KeiyakuTankaArray[]=$targetContractdetail->unit_price;
			$KeiyakuPriceArray[]=$targetContractdetail->price;
			$num++;
		}
		for($i=$num;$i<=5;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}
		if(isset($request->syusei_Btn)){
			$GoBackPlace="/customers/ShowCustomersList_livewire";
			if(Auth::user()->serial_teacher=="A_0001"){
				$GoBackPlace="/customers/ShowCustomersList_livewire";
			}else{
				$GoBackPlace="/customers/ShowCustomersList_livewire";
			}
		}else if(isset($request->fromMenu)){
			$GoBackPlace="../ShowMenuCustomerManagement";
		}
		$GoBackPlace="/customers/ShowContractList";
		$TreatmentsTimes_slct=OtherFunc::make_html_TreatmentsTimes_slct($targetContract->treatments_num);
		//$html_staff_slct=OtherFunc::make_html_staff_slct($targetContract->serial_tantosya);
		$stf=DB::table('Staff')->first();
		$html_staff_slct=OtherFunc::make_html_staff_slct($targetContract->serial_tantosya);
		return view('customers.CreateContracts',compact("html_staff_slct","header",'slot','newKeiyakuSerial','targetContract',"targetContractdetails","targetUser","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","HowManyPay","CardCompanySelect","GoBackPlace","TreatmentsTimes_slct","KeiyakuNaiyouSelectArray"));
	}
	
	public function ShowMedicalRecord(Request $request){
		$visit_history_num=$request->count_btn;
		$visit_history_num_int=(int)$visit_history_num;
		$visit_history_serial=str_replace( "K","V" , session('ContractSerial')."-".$visit_history_num);
		$VisitHistoryArray=VisitHistory::where('visit_history_serial','=',$visit_history_serial)->first();
		//Log::alert('VisitDate='.$request->visitDate[1]);
		//"visitDate.0"
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
		}else if($visit_history_num_int==14){
			$request->validate(
				["visitDate.14" => "required" ],
				['visitDate.14.required' => '施術日15回目を先に保存してください。']
			);
		}else if($visit_history_num_int==15){
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
		$target_file='storage/MedicalRecord/'.session('ContractSerial')."-".$request->count_btn."*.png";
		$result=array();
		foreach(glob($target_file) as $file) {
			$result[] = $file;
		}
		if(count($result)>0){
			$target_file=$result[0];
		}else{
			$target_file="";
		}
		$array=explode('-', $request->VisitHistorySerial);
		$UserSerial=str_replace('V_', '', $array[0]);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		
		$keiyaku_array=Keiyaku::where('serial_keiyaku','=',session('ContractSerial'))->first();
		$keiyaku_name=$keiyaku_array->keiyaku_name;
		if(is_null($VisitHistoryArray->serial_staff)){
			$SerialStaff="";
		}else{
			$SerialStaff=$VisitHistoryArray->serial_staff;
		}
		$html_staff_slct=OtherFunc::make_html_staff_slct($VisitHistoryArray->serial_staff);
		//$html_staff_slct=OtherFunc::make_html_staff_slct($SerialStaff);
		$ContractSerial=session('ContractSerial');
		return view('customers.MedicalRecord',compact('html_staff_slct','target_file','ContractSerial','visit_history_num','UserInf','keiyaku_name'));
	}
	/*
	public function ShowMedicalRecord(Request $request){
		$target_file='storage/MedicalRecord/'.session('ContractSerial')."-".$request->count_btn.".png";
		Log::alert('count='.$request->count_btn);
		if (!file_exists($target_file)) {
			$target_file="";
		}
		$array=explode('-', $request->VisitHistorySerial);
		$UserSerial=str_replace('V_', '', $array[0]);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		$visit_history_serial=$request->count_btn;
		$keiyaku_array=Keiyaku::where('serial_keiyaku','=',session('ContractSerial'))->first();
		$keiyaku_name=$keiyaku_array->keiyaku_name;
		$ContractSerial=session('ContractSerial');
		return view('customers.MedicalRecord',compact('target_file','ContractSerial','visit_history_serial','UserInf','keiyaku_name'));
	}
	*/
	
	public function ajax_SaveMedicalRecord(Request $request){
		$target_file_name=session('ContractSerial')."-".$request->VisitHistorySerial;
		$result=array();
		//Log::alert('count='.count($result));
		foreach(glob("storage/MedicalRecord/".$target_file_name."*.png") as $file) {
			$result[] = $file;
		}
		//Log::alert('count='.count($result));
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
		
		//Log::alert('filename_array='.$filename_array[3]);
		
		$fp = fopen('storage/MedicalRecord/'.$new_file_name,'w');
		$upload_data=$_POST['upload_data'];
		fwrite($fp,base64_decode($upload_data));
		fclose($fp);
		
		$ts=str_replace('K', 'V', session('ContractSerial')."-".$request->VisitHistorySerial);
		Log::alert('ts='.$ts);
		Log::alert('StaffSerial='.$request->StaffSerial);
		VisitHistory::where('visit_history_serial', '=', $ts)->update([
			'serial_staff' => $request->StaffSerial
		]);
	}
	/*BK
	public function ajax_SaveMedicalRecord(Request $request){
		$upload_data=$_POST['upload_data'];
		$new_file_name=session('ContractSerial')."-".$request->VisitHistorySerial.".png";
		$fp = fopen('storage/MedicalRecord/'.$new_file_name,'w');
		fwrite($fp,base64_decode($upload_data));
		fclose($fp);

	}
	*/
	
	public function ShowInpRecordVisitPayment($ContractSerial,$UserSerial){
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
		$RecordUrl = route('recordVisitPaymentHistory.post');
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$targetVisitHistoryArray=VisitHistory::where('serial_keiyaku','=', $ContractSerial)->get();
		$targetPaymentHistoryArray=PaymentHistory::where('serial_keiyaku','=', $ContractSerial)->get();

		$targetUser=User::where('serial_user','=', $UserSerial)->first();
		session(['userneme' => $targetUser->name_sei.$targetUser->name_mei]);

		$targetContract=Keiyaku::where('serial_keiyaku','=', $ContractSerial)->first();
		$targetContractDetails=ContractDetail::where('serial_keiyaku','=', $ContractSerial)->get();
		$KeiyakuNaiyouArray=array();$VisitDateArray=array();
		$KeiyakuNumMax = DB::table('configrations')->select('value1')->where('subject', '=', 'KeiyakuNumMax')->first();
		$sejyutukaisu=Keiyaku::where('serial_keiyaku','=',$ContractSerial)->first('treatments_num');
		$ck=Keiyaku::where('serial_keiyaku','=',$ContractSerial);
		$visit_disabeled=array();$set_gray_array=array();$only_treatment_color_array=array();
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
		$i=0;$TreatmentDetailsArray=array();$TreatmentDetailsSelectArray=array();$VisitSerialArray=array();
		foreach($targetVisitHistoryArray as $targetVisitHistory){
			//$VisitSerialArray[]=$targetVisitHistory->visit_history_serial;
			$VisitSerialArray[]=sprintf('%02d', $i+1);
			$_SESSION['VisitSerialSessionArray'][]=$targetVisitHistory->visit_history_serial;
			$VisitDateArray[]=$targetVisitHistory->date_visit;
			$TreatmentDetailsArray[]=$targetVisitHistory->treatment_dtails;
			$TreatmentDetailsSelectArray[]=OtherFunc::make_htm_get_treatment_slct($targetVisitHistory->treatment_dtails);
			$set_gray_array[$i]='style="background-color:#e0ffff"';$only_treatment_color_array[$i]='#e0ffff';
			$i++;
		}

		for($k=$i;$k<24;$k++){
			$TreatmentDetailsSelectArray[$k]=OtherFunc::make_htm_get_treatment_slct('');
			//$VisitSerialArray[$k]="";
			$VisitSerialArray[]=sprintf('%02d', $k+1);
		}

		if($targetContract->how_to_pay=='現金'){
			$paymentCount=$targetContract->how_many_pay_genkin;
		}else{
			$paymentCount=$targetContract->how_many_pay_card;
		}
		for($i=0;$i<initConsts::PaymentNumMax();$i++){
			$payment_disabeled[$i]='disabled'; $set_gray_pay_array[$i]='color:#DDDDDD';$set_background_gray_pay_array[$i]='background-color:#EEEEEE';
			if($i<$paymentCount){
				$payment_disabeled[$i]="";$set_gray_pay_array[$i]="";$set_background_gray_pay_array[$i]='';
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
			}else if($targetPaymentHistory->how_to_pay=="paypay"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="checked";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="";
			}else if($targetPaymentHistory->how_to_pay=="cash"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="checked";
				$HowToPayCheckedDefault="";
			}else if($targetPaymentHistory->how_to_pay=="default"){
				$HowToPayCheckedCard="";
				$HowToPayCheckedPaypay="";
				$HowToPayCheckedCash="";
				$HowToPayCheckedDefault="checked";
			}
			$HowToPayCheckedArray[$i][0]=$HowToPayCheckedCard;
			$HowToPayCheckedArray[$i][1]=$HowToPayCheckedPaypay;
			$HowToPayCheckedArray[$i][2]=$HowToPayCheckedCash;
			$HowToPayCheckedArray[$i][3]=$HowToPayCheckedDefault;

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
		return view('customers.PaymentRegistration',compact("only_treatment_color_array","GoBackToPlace","header","slot",'VisitSerialArray','VisitDateArray','PaymentDateArray','targetUser','targetContract','KeiyakuNaiyou','PaymentAmountArray','HowToPayCheckedArray','visit_disabeled','sejyutukaisu','set_gray_array','payment_disabeled','set_gray_pay_array','set_background_gray_pay_array','paymentCount','TreatmentDetailsArray','TreatmentDetailsSelectArray'));
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
			'memo' => $request->memo,
		];
		Campaign::upsert($targetData,['serial_campaign']);
		session()->flash('success', '登録しました。');
		$this::save_recorder("SavCampaign");
		return redirect('/workers/ShowCampaigns');
	}

	public function ShowInpCampaign($TargetCampaignSerial){
		$header="";$slot="";$checked_completed="";$checked_contract="";$checked_person="";$checked_total="";
		$GoBackPlace="/workers/ShowCampaigns";$saveFlg="";
		//print "TargetCampaignSerial=".$TargetCampaignSerial."<br>";
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

	function insertCustomer(Request $request){
		if(isset($request->serial_user)){
			session(['CustomerManage' => 'syusei']);
			$targetSerial=$request->serial_user;
			$redirectPlace='/customers/ShowCustomersList';
			$btnDisp="　修　正　";
		}else{
			$max = DB::table('users')->max('serial_user');
			$targetSerial=++$max;
			$targetSerial=sprintf('%06d', $targetSerial);
			if($targetSerial==1){$targetSerial="001001";}
			$redirectPlace='/customers/ShowInputCustomer';
			session(['CustomerManage' => 'new']);
			$btnDisp="　登　録　";
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
			//'address_banti' => $request->address_banti_txt,

			'email' => $request->email,
			'phone' => $request->phone,
			'reason_coming'=>$reason_coming,
			
			'referee'=>trim($request->syokaisya_txt)
		];
		User::upsert($targetData,['serial_user']);
		$target_referee_array=array();$target_referee_array1=array();$target_referee_array2=array();$referee_old_array=array();$referee_new_array=array();
		$referee_old_array=explode(",",$referee_old);
		$referee_new_array=explode(",",$request->syokaisya_txt);
		foreach($referee_old_array as $old_serial){
			if(array_search($old_serial, $referee_new_array)==false and !empty($old_serial)){
				$target_referee_array[]=$old_serial;
			}
		}
		
		foreach($referee_new_array as $new_serial){
			if(array_search($new_serial, $referee_old_array)==false and !empty($new_serial)){
				$target_referee_array[]=$new_serial;
			}
		}
		
		foreach($target_referee_array as $target_referee_serial){
			$target_referee=sprintf('%06d', $target_referee_serial);
			$total_cnt=DB::table('users')->where('referee','like','%'.$target_referee_serial.'%')->count();
			DB::table('users')->where('serial_user','=', $target_referee)->update(['referee_num' => $total_cnt]);
		}
		$referee_target_serial_array=array();
		//dd(User::select('referee_target_serial')->where('serial_user','=', sprintf('%06d', trim($request->syokaisya_txt)))->toSql(), User::select('referee_target_serial')->where('serial_user','=', sprintf('%06d', trim($request->syokaisya_txt)))->getBindings());
		//$sql=User::select('referee_target_serial')->where('serial_user','=', sprintf('%06d', trim($request->syokaisya_txt)))->first();
		//$user_inf
		$sql_referee_inf=User::where('serial_user','=', sprintf('%06d', trim($request->syokaisya_txt)))->first();
		
		//$referee_serial=$sql_referee_inf->referee_target_serial;
		
		$referee_target_serial_old="";
		if(isset($sql_referee_inf->referee_target_serial)){
			$referee_target_serial_old=$sql_referee_inf->referee_target_serial;
		}
		
		$referee_target_serial_array[]=$referee_target_serial_old;
		$referee_target_serial_array[]=$targetSerial;
		$referee_target_serial=implode( ',', $referee_target_serial_array);
		$userBuilder=User::where('serial_user','=', sprintf('%06d',trim($request->syokaisya_txt)))->update(['referee_target_serial' => $referee_target_serial]);
		setcookie('TorokuMessageFlg','true',time()+60);
		$header="";$slot="";
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);
		$GoBackPlace=session('GoBackPlace');
		$saveFlg="true,".session('CustomerManage');
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		if(session('fromMenu')=='MenuCustomerManagement'){
			$GoToBackPlace="../ShowMenuCustomerManagement";
		}else if(session('fromMenu')=='CustomersList'){
			$GoToBackPlace="/customers/ShowCustomersList_livewire";
		}
		
		if(session('CustomerManage')=='syusei'){
			return redirect("/customers/ShowCustomersList_livewire");
		}else{
			$userInf=User::where('serial_user','=',$targetSerial)->first();
			$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんのデータを新規登録しました。";
    		return view("layouts.DialogMsg", compact('userInf','msg','targetSerial','header',"slot","GoToBackPlace"));
   		}
	}
	
	function menu_teacher(Request $request) {
		$teacher_inf=Auth::guard('teacher')->user();
		return view('teacher.menu_teacher');
	}
	
	function menuEmployee(Request $request) {
		$teacher_inf=Auth::guard('teacher')->user();
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
	
	public function deleteTreatmentContent($TreatmentContentSerial){
		$deleTreatmentContent=TreatmentContents::where('serial_treatment_contents','=',$TreatmentContentSerial)->delete();
		$this::save_recorder("deleteTreatmentContent");
		return redirect('/workers/ShowTreatmentContents');
	}

	public function SaveTreatmentContent(Request $request){
		$targetData=[
			'created_at' => date('Y-m-d H:i:s'),
			'serial_treatment_contents' => $request->serial_TreatmentContent,
			'name_treatment_contents' => $request->TreatmentContent_name,
			
			'name_treatment_contents_kana' => $request->TreatmentContent_name_kana,
			'treatment_details' => $request->TreatmentContent_details,
			'memo' => $request->memo,
		];
		TreatmentContents::upsert($targetData,['serial_treatment_contents']);
		session()->flash('success', '登録しました。');
		$this::save_recorder("SaveTreatmentContent");
		return redirect('/workers/ShowTreatmentContents');
	}

	public function ShowSyuseiTreatmentContent($TreatmentContentSerial){
		$header="";$slot="";
		$GoBackPlace="/workers/ShowTreatmentContents";$saveFlg="";
		if($TreatmentContentSerial=="new"){
			$maxSerial=DB::table('treatment_contents')->max('serial_treatment_contents');
			if($maxSerial==""){
				$targetTreatmentContentSerial="Tr_000001";
			}else{
				$targetTreatmentContentSerial=++$maxSerial;
			}
			$TreatmentContentInf=array();$btnDisp="新規登録";
			session(['TreatmentContentSerial' => $targetTreatmentContentSerial]);
			return view('teacher.CreateTreatmentContents',compact("header","slot",'targetTreatmentContentSerial','TreatmentContentInf',"GoBackPlace","btnDisp","saveFlg"));
		}else{
			session(['TreatmentContentmanage' => 'new']);
			$TreatmentContentInf=TreatmentContents::where('serial_treatment_contents','=',$TreatmentContentSerial)->first();
			$btnDisp="修正";
			$targetTreatmentContentSerial=$TreatmentContentSerial;
			session(['targetGoodSerial' => $TreatmentContentSerial]);
			return view('teacher.CreateTreatmentContents',compact("header","slot",'targetTreatmentContentSerial','TreatmentContentInf',"GoBackPlace","btnDisp","saveFlg"));
		}
	}
	
	public function ContractCancellation($serial_Contract,$UserSerial,Request $request){
		$kaiyakuFlg=Keiyaku::where('serial_keiyaku','=', $serial_Contract)->first('cancel');
		if($kaiyakuFlg->cancel==null){
			$dt=$request->KaiyakuDate;
		}else{
			$dt=null;
		}
		Keiyaku::where('serial_keiyaku','=', $serial_Contract)->update(['cancel' => $dt]);
		return redirect('/customers/ShowSyuseiContract/'.$serial_Contract.'/'.$UserSerial);
	}
	
	public function MakeContractPDF($serial_Contract){
		$keiyaku_inf=Keiyaku::where('serial_keiyaku','=',$serial_Contract)->first();
		$User_inf=User::where('serial_user','=',$keiyaku_inf->serial_user)->first();
		$prefecture_name=OtherFunc::get_prefecture_name_by_region($User_inf->address_region);
		$ContractDetail_inf=ContractDetail::where('serial_keiyaku','=',$serial_Contract)->get();
		$SentenceHowToPay='';
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
		
		$pdf = \PDF::loadView('printing.contracts.contracts',compact('keiyaku_inf','User_inf','ContractDetail_inf','SentenceHowToPay','prefecture_name'));
		$pdf->setPaper('A4');       
		return $pdf->stream('title.pdf');	
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
				'created_at'=>date("Y-m-d H:i:s")
			];

		DB::table('goods')->upsert($targetData,['serial_good']);
		$this::save_recorder("SaveGood");
		session()->flash('success', '登録しました。');
		return redirect('/workers/ShowGoodsList');
	}

	public function ShowInputSalesGoods($SalesSerial){
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

	public function deleteContract($serial_contract,$serial_user){
		$header="";$slot="";
		$delContract=Keiyaku::where('serial_keiyaku','=',$serial_contract)->delete();
		$delContractDetails=ContractDetail::where('serial_keiyaku','=',$serial_contract)->delete();
		$delPaymentHistory=PaymentHistory::where('serial_keiyaku','=',$serial_contract)->delete();
		$delVisitHistory=VisitHistory::where('serial_keiyaku','=',$serial_contract)->delete();

		//return redirect('/customers/ShowCustomersList');
		return redirect('/customers/ShowContractList/'.$serial_user);
		//return view('customers.InfoCustomer',compact("user","header","slot"));
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
		session(['fromPage' => 'GoodsList']);
		session(['fromMenu' => 'GoodsList']);

		$header="";$slot="";
		$key="";
		$key=$request->kensakuKey;
		$goods=array();$goodArray=array();
		$goods=Good::paginate(initConsts::DdisplayLineNumCustomerList());
		session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		if(Auth::user()->serial_teacher=="A_0001"){
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}else{
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}
		return redirect('/workers/ShowGoodsList');
	}

	public function ShowCustomersList(Request $request){
		session(['fromPage' => 'CustomersList']);
		session(['fromMenu' => 'CustomersList']);
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
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
		if(Auth::user()->serial_teacher=="A_0001"){
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}else{
			session(['GoBackPlace' => '/customers/ShowCustomersList_livewire']);
		}

		if(Auth::user()->serial_teacher=="A_0001"){
			return redirect('/customers/ShowCustomersList_livewire',['page' => $request->get('page')]);
		}else{
			return redirect('/customers/ShowCustomersList_livewire');
		}
	}
	
	public function showDialogMsg(Request $request){
		return view("article.show", ['id'=> $id,'title' => 'タイトル','data'  => 'こんにちは']);
	}
	protected function guard(){
		return Auth::guard('teacher');
	 }
	public function show_dashboard(){
		return view('teacher.dashboard');
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
				//$htp="";
				if(isset($request->HowToPay[$i])){
					$PaymentHowToPayArray[$i]=$request->HowToPay[$i];
				}
				
				$targetlData=[
					'serial_keiyaku'=>session('ContractSerial'),
					'serial_user'=>session('UserSerial'),
					'payment_history_serial'=>$PaymentHistorySerial,
					'serial_Teacher'=>Auth::user()->serial_teacher,
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
					'serial_Teacher'=>Auth::user()->serial_teacher,
					'date_visit'=>$visitDateValue,
					//'treatment_dtails'=>$request->TreatmentDetails[$i]
					'treatment_dtails'=>$request->TreatmentDetailsSelect[$i],
					'deleted_at'=>null
				];
				VisitHistory::where('visit_history_serial','=', $VisitHistorySerial)->restore();
				VisitHistory::upsert($targetlData,['visit_history_serial']);
				$targetDataArray[]=$targetlData;
				$VisitHistorySerial++;
				$i++;
			}
		}
		Keiyaku::where('serial_keiyaku','=',session('ContractSerial'))->update(['date_latest_visit' =>$date_latest_visit]);
		session()->flash('success', '登録しました。');
		session(['InpRecordVisitPaymentFlg' => true]);
		$this::save_recorder("recordVisitPaymentHistory");
		return redirect('/customers/ShowInpRecordVisitPayment/'.session("ContractSerial").'/'.session("UserSerial"));
	}

	public function ShowContractList($UserSerial,Request $request){
		session(['fromPage' => 'ContractList']);
		session(['targetUserSerial' => $UserSerial]);
		if(isset($request->page_num)){
			session(['target_page_for_pager'=>$request->page_num]);
		}
		$header="";$slot="";
		
		$key="";
		$Contracts="";
		if(Auth::user()->serial_teacher=="A_0001"){
			if($UserSerial=="all"){
				$userinf="";
				$Contracts=Keiyaku::leftjoin('users', 'keiyakus.serial_user', '=', 'users.serial_user')->paginate(initConsts::DdisplayLineNumContractList());
				$GoBackPlace="/ShowMenuCustomerManagement/";
				session(['targetUserSerial' => 'all']);
			}else{
				session(['targetUserSerial' => $UserSerial]);
				session(['target_page_for_pager'=>'']);
				$GoBackPlace="/customers/ShowCustomersList_livewire";				
				$userinf=User::where('serial_user','=',$UserSerial)->first();
				$Contracts=Keiyaku::where('keiyakus.serial_user','=',$UserSerial)
					->leftjoin('users', 'keiyakus.serial_user', '=', 'users.serial_user')
					->select('keiyakus.*', 'users.*')
					->paginate(initConsts::DdisplayLineNumContractList());
			}
			return view('customers.ListContract',compact("Contracts","UserSerial","userinf","GoBackPlace","header","slot"));

		}else{
			if($UserSerial=="all"){
				$userinf="";
				$Contracts=Keiyaku::leftjoin('users', 'keiyakus.serial_user', '=', 'users.serial_user')->paginate(initConsts::DdisplayLineNumContractList());
				session(['targetUserSerial' => 'all']);
				$GoBackPlace="/ShowMenuCustomerManagement/";
			}else{
				session(['targetUserSerial' => $UserSerial]);
				session(['target_page_for_pager'=>'']);
				$GoBackPlace="/customers/ShowCustomersList_livewire";				
				$userinf=User::where('serial_user','=',$UserSerial)->first();
				$Contracts=Keiyaku::where('keiyakus.serial_user','=',$UserSerial)
					->leftjoin('users', 'keiyakus.serial_user', '=', 'users.serial_user')
					->select('keiyakus.*', 'users.*')
					->paginate(initConsts::DdisplayLineNumContractList());
			}
			return view('customers.ListContract',compact("Contracts","UserSerial","userinf","GoBackPlace","header","slot"));
		}
	}

	public function ShowContractHistory($serial_user){
		session(['fromPage' => 'ContractHistory']);
		$header="";$slot="";
		return view('customers.ContractHistory');
	}

	function insertContract(Request $request){
		Log::alert('staff_slct='.$request->staff_slct);

		$motourl = $_SERVER['HTTP_REFERER'];
		$kyo=date("Y/m/d H:i:s");
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
		Log::alert('staff_slct='.$request->staff_slct);

		$targetData=[
			'serial_keiyaku' => $request->ContractSerial,
			'serial_user' => $request->serial_user,
			'keiyaku_kikan_start' => $request->ContractsDateStart,

			'keiyaku_kikan_end' => $request->ContractsDateEnd,
			'keiyaku_name' => $request->ContractName,

			'keiyaku_bi' => $request->ContractsDate,
			'keiyaku_kingaku' =>  str_replace(',','',mb_convert_kana($request->inpTotalAmount, "n")),
			'keiyaku_num' => $request->ContractSerial,

			'keiyaku_kingaku_total' => str_replace(',','',$request->TotalAmount),
			'how_to_pay' => $request->HowPayRdio,

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
			'deleted_at'=>null
		];

		if($request->ContractSerial<>""){
			Keiyaku::upsert($targetData,['serial_keiyaku']);
			$targetDataArray=array();
			DB::table('contract_details')->where('serial_keiyaku','=',$request->ContractSerial)->delete();
			for($i=0;$i<=4;$i++){
				if($request->ContractNaiyo[$i]<>""){
					$contract_detail_serial=$request->ContractSerial."-".sprintf('%02d', $i+1);
					$targetDetailData=array();
					$targetDetailData=[
						'contract_detail_serial'=>$contract_detail_serial,
						'serial_keiyaku'=>$request->ContractSerial,
						'serial_user'=>$request->serial_user,
						'keiyaku_naiyo'=>$request->ContractNaiyo[$i],
						'keiyaku_num'=>$request->KeiyakuNumSlct[$i],
						'unit_price'=>str_replace(',','',$request->AmountPerNum[$i]),
						'price'=>$request->subTotalAmount[$i],
					];
					$targetDataArray[]=$targetDetailData;
				}else{
					break;
				}
			}
			ContractDetail::upsert($targetDataArray,['contract_detail_serial']);
			Storage::append('errorCK.txt', $kyo." / ".$motourl." / ok");
			$header="";$slot="";
			$SerialUser=$request->serial_user;$SerialKeiyaku=$request->ContractSerial;
			session(['targetUserSerial' => $SerialUser]);
			if(Auth::user()->serial_teacher=="A_0001"){
				if(session('ContractManage')=='syusei'){
					return redirect("/customers/ShowContractList/".$SerialUser);
				}else{
					$userInf=User::where('serial_user','=',$request->serial_user)->first();
					$keiyakuInf=Keiyaku::where('serial_keiyaku','=',$request->ContractSerial)->first();
					
					$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんの契約を新規登録しました。";
	
					if(session('fromMenu')=='MenuCustomerManagement'){
						$GoBackToPlace="../ShowMenuCustomerManagement";
					}else if(session('fromMenu')=='CustomersList'){
						$GoBackToPlace="/customers/ShowCustomersList_livewire";
					}
			    		return view("layouts.DialogMsgKeiyaku", compact('msg','SerialUser','SerialKeiyaku','GoBackToPlace','header',"slot"));
		    		}
			}else{
				if(session('ContractManage')=='syusei'){
					return redirect("/customers/ShowContractList/".$SerialUser);
				}else{
					$userInf=User::where('serial_user','=',$request->serial_user)->first();
					$keiyakuInf=Keiyaku::where('serial_keiyaku','=',$request->ContractSerial)->first();
					
					$msg="氏名: ".$userInf->name_sei." ".$userInf->name_mei."さんの契約を新規登録しました。";
	
					if(session('fromMenu')=='MenuCustomerManagement'){
						$GoBackToPlace="../ShowMenuCustomerManagement";
					}else if(session('fromMenu')=='CustomersList'){
						$GoBackToPlace="/customers/ShowCustomersList_livewire";
					}
			    		return view("layouts.DialogMsgKeiyaku", compact('msg','SerialUser','SerialKeiyaku','GoBackToPlace','header',"slot"));
		    		}
			}
		}
	}

	public function SerchCustomers(Request $request){
		$header="";$slot="";
		$key=$request->kensakuKey;
		$users=User::where('serial_user','like','%'.$key.'%')
			->where('name_sei','like','%'.$key.'%')
			->orwhere('name_mei','like','%'.$key.'%')
			->orwhere('name_sei_kana','like','%'.$key.'%')
			->orwhere('name_mei_kana','like','%'.$key.'%')
			->orwhere('birth_year','like','%'.$key.'%')
			->orwhere('birth_month','like','%'.$key.'%')
			->orwhere('birth_day','like','%'.$key.'%')
			->orwhere('address_region','like','%'.$key.'%')
			->orwhere('address_locality','like','%'.$key.'%')
			->orwhere('email','like','%'.$key.'%')->get();
		return view('customers.CreateContracts',compact("users","header","slot"));
	}

	public function ShowInpKeiyaku($serial_user){
		session(['fromPage' => 'InpKeiyaku']);
		$header="";$slot="";$HowToPay=array();
		//$KeiyakuNumSlct=OtherFunc::make_html_keiyaku_num_slct("");
		$KeiyakuNumSlctArray=array();$KeiyakuTankaArray=array();$KeiyakuPriceArray=array();
		for($i=0;$i<=4;$i++){
			$KeiyakuNumSlctArray[]=OtherFunc::make_html_keiyaku_num_slct("");
			$KeiyakuTankaArray[]="";
			$KeiyakuPriceArray[]="";
		}

		$targetUser=User::where('serial_user','=',$serial_user)->first();
		$serial_max=Keiyaku::where('serial_user','=',$serial_user)->max('serial_keiyaku');
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
			//$redirectPlace='/customers/ShowCustomersList';
			$redirectPlace='/customers/ShowCustomersList_livewire';
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
		//$targetContract="";
		$targetContract=array();
		$KeiyakuNaiyouArray=array();
		$CardCompanySelect=OtherFunc::make_html_card_company_slct("");
		$HowManyPay['CashSlct']=OtherFunc::make_html_how_many_slct("",20,1);
		$html_staff_slct=OtherFunc::make_html_staff_slct("");
		return view('customers.CreateContracts',compact("html_staff_slct","targetUser","header","slot","tday","endDay","newKeiyakuSerial","targetContract","KeiyakuNaiyouArray","KeiyakuNumSlctArray","KeiyakuTankaArray","KeiyakuPriceArray","HowToPay","CardCompanySelect","HowManyPay",'TreatmentsTimes_slct','KeiyakuNaiyouSelectArray'));
	}
	
	public function deleteCustomer($serial_user){
		$header="";$slot="";
		$deleUser=User::where('serial_user','=',$serial_user)->delete();
		$deleKeiyaku=Keiyaku::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=ContractDetail::where('serial_user','=',$serial_user)->delete();
		$deleContractDetail=PaymentHistory::where('serial_user','=',$serial_user)->delete();
		$deleVisitHistory=VisitHistory::where('serial_user','=',$serial_user)->delete();
		//return redirect('/customers/ShowCustomersList');
		return redirect('/customers/ShowCustomersList_livewire');
		//return view('customers.InfoCustomer',compact("user","header","slot"));
	}

	public function ShowCustomerInfo($serial_user){
		session(['fromPage' => 'CustomerInfo']);
		$header="";$slot="";
		$user=User::where('serial_user','=',$serial_user)->first();
		return view('customers.InfoCustomer',compact("user","header","slot"));
	}

	/*
	public function ShowCustomersList(Request $request){
		$header="";$slot="";
		$key="";
		$key=$request->kensakuKey;
		$users="";
		if($request->kensakuKey<>""){
			$users=User::where('serial_user','like',"%$key%")
				->orwhere('name_sei','like',"%$key%")
				->orwhere('name_mei','like',"%$key%")
				->orwhere('name_sei_kana','like',"%$key%")
				->orwhere('name_mei_kana',"%$key%")
				->orwhere('birth_year','like',"%$key%")
				->orwhere('birth_month','like',"%$key%")
				->orwhere('birth_day','like',"%$key%")
				->orwhere('address_region','like',"%$key%")
				->orwhere('address_locality','like',"%$key%")
				->orwhere('email','like',"%$key%")->paginate(10);
		}else{
			$users=User::paginate(10);
		}
		return view('customers.ListCustomers',compact("users","header","slot"));
	}
	*/
	
	public function ShowInputCustomer(Request $request){
		//print 'fromMenu='.session('fromMenu');
		session(['fromPage' => 'InputCustomer']);
		session(['CustomerManage' => 'new']);
		$header="";$slot="";
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list("");
		$html_birth_year_slct=trim($html_birth_year_slct);
		//CustomerListCreateBtn
		//insertCustomerFromMenu
		$GoBackPlace="../ShowMenuCustomerManagement";
		if(isset($request->CustomerListCreateBtn)){
			//$GoBackPlace="/customers/ShowCustomersList";
			$GoBackPlace="/customers/ShowCustomersList_livewire";
		}
		setcookie('TorokuMessageFlg','false',time()+60);

		$GenderRdo=array();
		$target_user="";$selectedManth=null;$selectedDay=null;$selectedRegion=null;
		$saveFlg="false,".session('CustomerManage');$btnDisp="　登　録　";
		$html_reason_coming="";
		$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
		return view('customers.CreateCustomer',compact('header',"slot",'html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming"));
	}
    
	public function ShowSyuseiCustomer(Request $request){
		session(['fromPage' => 'SyuseiCustomer']);
		//$userInfo=User::where('serial_user','=',$request->input('syusei_Btn'))->first();
		session(['CustomerManage' => 'syusei']);
		$header="";$slot="";$selectedManth=array();$selectedManth=array();
		$target_user=User::where('serial_user','=', $request->input('syusei_Btn'))->first();
		$html_birth_year_slct=OtherFunc::make_html_slct_birth_year_list($target_user->birth_year);
		//$mnt="m".sprintf('%02d', $target_user->birth_month);
		$selectedManth[(int)$target_user->birth_month]="Selected";
		$selectedDay[(int)$target_user->birth_day]="Selected";
		$selectedRegion[$target_user->address_region]="Selected";
		$GenderRdo=array();
		$GenderRdo[$target_user->gender]="checked";
		setcookie('TorokuMessageFlg','false',time()+60);
		$saveFlg="false,".session('CustomerManage');$btnDisp="　修　正　";
		$html_reason_coming="";
		if(isset($request->syusei_Btn)){
			//$GoBackPlace="/customers/ShowCustomersList";
			$GoBackPlace="/customers/ShowCustomersList_livewire";
			$GoBackPlace="/customers/ShowCustomersList_livewire";
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox($target_user->reason_coming,$target_user->referee);

		}else if(isset($request->fromMenu)){
			//$GoBackPlace="/customers/ShowCustomersList_livewire";
			$html_reason_coming=OtherFunc::make_html_reason_coming_cbox("","");
			$GoBackPlace="../ShowMenuCustomerManagement";
		}
		return view('customers.CreateCustomer',compact("header","slot",'html_birth_year_slct',"target_user","selectedManth","selectedDay","selectedRegion","GoBackPlace","saveFlg","btnDisp","GenderRdo","html_reason_coming"));
	}
	
	public function ShowMenuCustomerManagement(){
		session(['fromPage' => 'MenuCustomerManagement']);
		session(['fromMenu' => 'MenuCustomerManagement']);
		$header="";$slot="";
		session(['fromMenu' => 'MenuCustomerManagement']);
		session(['targetYear' => date('Y')]);
		$targetYear=session('targetYear');
		//OtherFunc::set_access_history('');
		if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}

		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('keiyakus.serial_user')->from('keiyakus')->where('keiyakus.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei')->get();
		$html_year_slct=OtherFunc::make_html_year_slct(date('Y'));
		$html_month_slct=OtherFunc::make_html_month_slct(date('n'));
		$default_customers=OtherFunc::make_htm_get_default_user();
		$not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
		$htm_kesanMonth=OtherFunc::make_html_month_slct(initConsts::KesanMonth());
		//list($targetNameHtmFront, $targetNameHtmBack) =OtherFunc::make_htm_get_not_coming_customer();
		$csrf="csrf";
		session(['GoBackPlace' => '../ShowMenuCustomerManagement']);
		return view('teacher.MenuCustomerManagement',compact("header","slot","html_year_slct","html_month_slct","DefaultUsersInf","not_coming_customers","default_customers",'htm_kesanMonth'));
	}
	
	public function ckScheduleDeletePossible(Request $request){
		$target_schedules_event_id=$request->input('eventID');
		$serial_teacher = Auth::user()->serial_teacher;
		$flg=true;
		if(DB::table('Schedules')
			->where('event_id','=',$target_schedules_event_id)
			->where('deleted_at','<>',null)
			->where('idPerson','=',$serial_teacher)->exists())
		{
			$flg=false;	
		}
		echo json_encode($flg);
		//return ;
	}
	
	public function ckDellPossibleTeacher(Request $request){
		$unixStrt=$request->input('utcStartTime');
		$unixEnd=$request->input('utcEndTime');
		$unixToday = time();
		//console.log( session('target_teacher_serial'));
		$flg=true;
		//$target_schedules=DB::table('Schedules')->where('parentEventId','=', $request->input('eventID'))->get();
		$target_schedules=Schedule::where('parentEventId','=', $request->input('eventID'))->get();
		$resArr["count"]=$target_schedules->count();
		if($unixStrt<=$unixToday){
			$flg='old';
		}else if($target_schedules->count()>0){
			$flg='lessonReserved';
		}
		//$resArr["startUNIXTimeStamp"]=$open_schedule->startUNIXTimeStamp ;
		$resArr["utcStrt"]=$unixStrt;
		$resArr["utcEnd"]=$unixEnd;
		$resArr["unixToday"]=$unixToday;
		$resArr["flg"]=$flg;
		echo json_encode($resArr);
		//echo json_encode($request);
	}
	
	public function ckReservPossibleTeacher(Request $request){
		$unixStrt=$request->input('utcStartTime');
		$unixEnd=$request->input('utcEndTime');
		$unixToday = time();
		
		//$target_schedules=DB::table('Schedules')->where('idPerson','=', session('target_teacher_serial'))->where('startUNIXTimeStamp','>=', $unixToday)->get();
		$flg=false;
		$resArr["deadlineReservPossible"]=config('const.deadlineReservPossible');
		//$resArr["deadlineReservPossible"]=60;

		if($unixStrt>=$unixToday){
			$flg=true;
		}
		$resArr["utcStrt"]=$unixStrt;
		$resArr["utcEnd"]=$unixEnd;
		$resArr["flg"]=$flg;
		$resArr["unixToday"]=$unixToday;
		echo json_encode($resArr);
		//echo json_encode($request);
	}

	public function setResourcesTimeLine(Request $request){
		$teacher_inf = Auth::guard('teacher')->user();
		$target = $teacher_inf->serial_teacher;
		$target_schedules=Schedule::where('idPerson', 'like', 'U_%')->where('idTeacher',$target)->where('deleted_at','=',null)->get();
		$data = [];$personID=array();$newArr=array();
		$ev=array();$newItem=array();
		foreach ($target_schedules as $user_inf){ 
			if (!in_array($user_inf->idPerson,$personID)){ 
				$personID[]=$user_inf->idPerson;
				$newItem["id"] =$user_inf->idPerson;
				$target_name=DB::table('users')->where('serial_user',$user_inf->idPerson)->first();
				//$new = htmlspecialchars('<button type="submit" formaction="ShowTimeLine">Time Line</button>', ENT_QUOTES);
				$newItem["title"] =$target_name->name;
				//$newItem["eventTextColor"] ='Red';
				//$newItem["eventBackgroundColor"] ='Red';
				//$newItem["eventColor"]='#6fc2d0';
				//$newItem["eventClassNames"]='eventClassNames';

				$newArr[] = $newItem;
			}
		}
		echo json_encode($newArr);
	}

	public function setScheduleTimeLine(Request $request){
		/*
		{ id: '1', resourceId: 'a', start: '2019-05-14', end: '2019-05-16', title: 'event 1' },
        { id: '2', resourceId: 'b', start: '2019-05-16', end: '2019-05-22', title: 'event 2' },
        { id: '3', resourceId: 'a', start: '2019-05-19', end: '2019-05-21', title: 'event 3' }
        */
		$teacher_inf = Auth::guard('teacher')->user();
		$target = $teacher_inf->serial_teacher;
		//$target_schedules=DB::table('Schedules')->where('idPerson',$target)->orwhere('idTeacher',$target)->where('deleted_at','=',null)->get();
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
				//$newItem["Editable"] = false;
				$newItem["startEditable"] = false;
				$newItem["durationEditable"] = false;
				//$close_schedule_user_array[$cnt]["eventDurationEditable"] = false;
				//$close_schedule_user_array[$cnt]["eventStartEditable"] = false;

				//$newItem["eventDurationEditable"] = false;
			}
			$newArr[] = $newItem;
		}
		echo json_encode($newArr);
	}

	public function setSchedule(Request $request){
		$teacher_inf = Auth::guard('teacher')->user();
		$target = $teacher_inf->serial_teacher;
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
		$teacher_inf = Auth::guard('teacher')->user();
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
		$teacher_inf = Auth::guard('teacher')->user();
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
		$teacher_inf = Auth::guard('teacher')->user();
		$target_teacher_serial=$request->_METHOD;
		$vType="dayGridMonth";
		$targetData="/setSchedule";
		$initFlg='true';
		return view('schedule.calender',compact('teacher_inf','vType','initFlg','targetData'));
	}
	
	function ShowTimeLine(Request $request) {
		$teacher_inf = Auth::guard('teacher')->user();
		$target_teacher_serial=$request->_METHOD;
		$vType="resourceTimelineDay";
		$targetData="/setScheduleTimeLine";
		$targetResources="/setResourcesTimeLine";
		$initFlg='true';
		return view('schedule.calender_timeline',compact('teacher_inf','vType','initFlg','targetData','targetResources'));
	}
	
	function ShowUserPagination(Request $request) {
		$teacher_inf = Auth::guard('teacher')->user();
		$userDB = DB::table('users')->paginate(initConsts::DdisplayLineNumCustomerList());
		return view('layouts.userList',compact('userDB'));
	}

	function inp_teacher_inf(Request $request){
		$manage_flg="show";
		$teacher_inf=Auth::guard('teacher')->user();
		return view("teacher.inp_inf_teacher",compact("manage_flg","teacher_inf"));
	}
	
	public function showChangePasswordForm(Request $request){
		return view('teacher.change-password',compact("request"))->with('user', Auth::guard('teacher')->user());
	}

	public function ChangePassword(Request $request){
		//ValidationはChangePasswordRequestで処理
		//パスワード変更処理
		$teacher_inf = Auth::guard('teacher')->user();
		$teacher_inf->password = Hash::make($request->get('password'));
		$teacher_inf->save();
		// パスワード変更処理後、homeにリダイレクト
		$setumei="パスワードを変更しました。";
		$BackToURL="/menu_teacher";
		return view("teacher.kakunin",compact("setumei","BackToURL"));
	}
      
	function show_teacher_dashboard(Request $request){
		$teacher_inf=Auth::guard('teacher')->user();
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
			$teacher_inf=Auth::guard('teacher')->user();
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
		$teacher_inf=Auth::guard('teacher')->user();
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
		$teacher_inf=Auth::guard('teacher')->user();
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
				Auth::guard('teacher')->user()->{$tgt}= $input['default_txt'];
				$model_teacher::where('id',$teacher_inf['id'])->update([session('target_sbj') => $input['default_txt']]);
			}
		}
		return redirect('inp_teacher_inf');
	}

	function changeEmail(Request $request){
        //ValidationはChangeUsernameRequestで処理
        //メールアドレス変更処理
		$teacher_inf = Auth::guard('teacher')->user();
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
		Auth::guard('teacher')->logout();
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
		DB::table('recorders')->insert([
			'id_recorder' => Auth::user()->serial_teacher,
			'name_recorder' => Auth::user()->last_name_kanji.' '.Auth::user()->first_name_kanji,
			'location_url' => $_SERVER['REQUEST_URI'],
			'location' =>$location,
			'created_at' => date('Y-m-d H:i:s'),
		]);
		return;
	}
}