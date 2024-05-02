<?php

namespace App\Consts;

use Illuminate\Support\Facades\DB;
use App\Models\Configration;

// usersで使う定数
class initConsts{
	public static function PointValidityTerm(){
		$inits_array=Configration::where('subject','=','PointValidityTerm')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','UserPointReferral')->first();
		return $inits_array->value1;
	}
	public static function UserPointReferral(){
		$inits_array=Configration::where('subject','=','UserPointReferral')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','UserPointReferral')->first();
		return $inits_array->value1;
	}
	public static function UserPointVisit(){
		$inits_array=Configration::where('subject','=','UserPointVisit')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','UserPointVisit')->first();
		return $inits_array->value1;
	}
	public static function MinimumLessonTimeInterval(){
		$inits_array=Configration::where('subject','=','MinimumLessonTimeInterval')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','MinimumLessonTimeInterval')->first();
		return $inits_array->value1;
	}
	public static function LessonInterval(){
		$inits_array=Configration::where('subject','=','LessonInterval')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','LessonInterval')->first();
		return $inits_array->value1;
	}
	public static function RestTime(){
		$inits_array=Configration::where('subject','=','RestTime')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','RestTime')->first();
		return $inits_array->value1;
	}
	
	public static function VerifycodeTimeLimitTeacher(){
		$inits_array=Configration::where('subject','=','VerifycodeTimeLimitTeacher')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','VerifycodeTimeLimitTeacher')->first();
		return $inits_array->value1;
	}
	
	public static function DdisplayLineNumCustomerList(){
		$inits_array=Configration::where('subject','=','DdisplayLineNumCustomerList')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','DdisplayLineNumCustomerList')->first();
		return $inits_array->value1;
	}
	
	public static function DdisplayLineNumContractList(){
		$inits_array=Configration::where('subject','=','DdisplayLineNumContractList')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','DdisplayLineNumContractList')->first();
		return $inits_array->value1;
	}
	
	public static function ReasonsComing(){
		$inits_array=Configration::where('subject','=','ReasonComing')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','ReasonComing')->first();
		return $inits_array->value1;
	}
	
	public static function MaxTreatmentsTimes(){
		$inits_array=Configration::where('subject','=','MaxTreatmentsTimes')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','MaxTreatmentsTimes')->first();
		return $inits_array->value1;
	}
	
	public static function PaymentNumMax(){
		$inits_array=Configration::where('subject','=','PaymentNumMax')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','PaymentNumMax')->first();
		return $inits_array->value1;
	}

	public static function KesanMonth(){
		$inits_array=Configration::where('subject','=','KesanMonth')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','KesanMonth')->first();
		return $inits_array->value1;
	}

	public static function TargetContractMoney(){
		$inits_array=Configration::where('subject','=','TargetContractMoney')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','TargetContractMoney')->first();
		return $inits_array->value1;
	}

	public static function TargetPageInf($target){
		$inits_array=Configration::where('subject','=','PageInf')->first();
		//$inits_array=DB::table('configrations')->where('subject','=','PageInf')->first();
		$page_inf_array=explode(";",$inits_array->value1);
		foreach($page_inf_array as $page_inf){
			$tgt_page_inf_array=explode(",",$page_inf);
			if(str_contains($target, $tgt_page_inf_array[0])){
				return array($tgt_page_inf_array[1], $tgt_page_inf_array[2]);
			}
		}
		return array('メニュー','admin.top');
	}
}