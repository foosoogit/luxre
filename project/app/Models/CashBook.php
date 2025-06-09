<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CashBook extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function getPaymentAddYenAttribute(){
	    $payment="";
		if($this->payment!=""){
            $payment=number_format($this->payment).'円';
        }
		return $payment;
	}

    public function getDepositAddYenAttribute(){
	    $deposit="";
		if($this->deposit!=""){
            $deposit=number_format($this->deposit).'円';
        }
		return $deposit;
	}
}
