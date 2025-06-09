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

	public function getContractTypeAttribute($value){
		$ContractArray=Contract::where("serial_keiyaku",$this->serial_keiyaku)->first();
		return $ContractArray->keiyaku_type;
	}

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

	public function getSmartAmountAttribute($value){
		$SmartAmount="";
		if($this->how_to_pay=="smart" and $this->amount_payment<>""){$SmartAmount=$this->amount_payment;}
		return $SmartAmount;
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
		return $CashAmount;
	}

	public function getPaiedNumAttribute($value){
		$Paied_history_serial_array=explode("-", $this->payment_history_serial);
		$PaiedNum=$Paied_history_serial_array[2];
		return $PaiedNum;
	}
}
