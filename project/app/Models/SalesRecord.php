<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SalesRecord extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
	protected $fillable = [
		'serial_sales',
		'serial_user',
		'serial_good',
		'date_sale',
		'buying_price',
		'selling_price',
		'memo',
	];
    public function getCashAmountAttribute($value){
		$CashAmount="";
		if($this->how_to_pay=="cash"){
			$CashAmount=$this->selling_price;
		}
		return $CashAmount;
    }
    
    public function getCardAmountAttribute($value){
		$CardAmount="";
    	if($this->how_to_pay=="card"){
			$CardAmount=$this->selling_price;
		}
		return $CardAmount;
    }
    
    public function getTotalAmountAttribute($value){
		$TotalAmount="";
    	$TotalAmount=$this->selling_price;
		return $TotalAmount;
    }
}
