<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contract;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;

class PaymentHistory extends Model
{
    use HasFactory;
    use SoftDeletes;

	public function getMethodSCRAttribute($target){
		$PaymentMethod=initConsts::PaymentMethod();
		$PaymentMethodArray=explode(",", $PaymentMethod);
		foreach($PaymentMethodArray as $value){
			$value_array=array();
			if(str_contains($value, $this->how_to_pay)){
				$value_array=explode("_", $value);
				return $value_array[1];
			}
		}
		return "";
	}

    public function getCardAmountAttribute($value){
		$CardAmount="";
		if($this->how_to_pay=="card" and $this->amount_payment<>""){$CardAmount=$this->amount_payment;}
		return $CardAmount;
	}
	
	public function getPayPayAmountAttribute($value){
		$PayPayAmount="";
		if($this->how_to_pay=="paypay" and $this->amount_payment<>""){$PayPayAmount=$this->amount_payment;}
		return $PayPayAmount;
	}
	
	public function getCashAmountAttribute($value){
		$CashAmount="";
		if($this->how_to_pay=="cash" and $this->amount_payment<>""){$CashAmount=$this->amount_payment;}
		/*
		$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		//print_r($kyakuInf);
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin=='1' ){
				$CashAmount=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card=='1' ){
				$CashAmount=$this->amount_payment;
			}
		}
		*/
		return $CashAmount;
	}
	/*
	public function getCashSplitAttribute($value){
		$CashSplit="";
    		$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>1 ){
				$CashSplit=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>1 ){
				$CashSplit=$this->amount_payment;
			}
		}
		return $CashSplit;
	}
	*/
	/*
	public function getCashTotalAttribute($value){
		$CashSplit="";
    		$kyakuInf=Contract::where('serial_keiyaku','=',$this->serial_keiyaku)->first();
		if($this->how_to_pay=="cash" and  $this->amount_payment<>""){
			if($kyakuInf->how_to_pay=='現金' and $kyakuInf->how_many_pay_genkin>=1 ){
				$CashSplit=$this->amount_payment;
			}else if($kyakuInf->how_to_pay=='Credit Card' and $kyakuInf->how_many_pay_card>=1 ){
				$CashSplit=$this->amount_payment;
			}
		}
		return $CashSplit;
	}
	*/
	public function getPaiedNumAttribute($value){
		$Paied_history_serial_array=explode("-", $this->payment_history_serial);
		$PaiedNum=$Paied_history_serial_array[2];
		return $PaiedNum;
	}
}
