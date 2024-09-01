<?php

namespace App\Consts;

use Illuminate\Support\Facades\DB;
use App\Models\Configration;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\OtherFunc;

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
		$page_inf_array=array();
		$page_inf_array=explode(";",$inits_array->value1);
		$tname=OtherFunc::get_page_name($target);
		$pn=1;
		$tgt_page_inf_array=array();
		foreach($page_inf_array as $page_inf){
			if(str_contains($page_inf,$tname)){
				$tgt_page_inf_array=explode(",",$page_inf);
				$page_num_key_array=['page=','page_num='];
				foreach($page_num_key_array as $page_num_key){
					$page_num_array=explode($page_num_key,($target));
					if(isset($page_num_array[1])){
						$pn=$page_num_array[1];
					}
				}
				break;
			}
		}
		array_push($tgt_page_inf_array,$pn);
		return $tgt_page_inf_array;
	}
}