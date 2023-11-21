<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use App\Models\Staff;

class Contract extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
		'name',
		'email',
		'number_keiyaku',
		'serial_keiyaku',
		'serial_user',
		'serial_Teacher',
		'course',
		'keiyaku_name',
		'keiyaku_kikan',
		'keiyaku_naiyo',
		'keiyaku_bi',
		'keiyaku_kingaku',
		'keiyaku_num',
		'keiyaku_kingaku_total',
		'date_latest_visit',
		'remarks',
		'tantosya',
		'serial_tantosya',
	];

    public function getTantosyaNameAttribute($value){
		$StaffArray=Staff::where('serial_tantosya','=',$value)->first();
		return $StaffArray->last_name_kanji.$StaffArray->first_name_kanji;
	}

	public function getKeiyakuZankinAttribute($value){
		$PaidAmount=PaymentHistory::where('serial_keiyaku','=',$this->serial_keiyaku)
						->where('date_payment','<>',"")
						->selectRaw('SUM(amount_payment) as paid')->first();
				
		$keiyaku_kingaku=0;
		if(isset($this->keiyaku_kingaku)){
			$keiyaku_kingaku=$this->keiyaku_kingaku;
		}
		$keiyaku_zankin = (int)$keiyaku_kingaku-(int)$PaidAmount['paid'];
		return $keiyaku_zankin;
	}
	
	public function getClosedColorAttribute(){
		$closed_color="black";
		$today=date("Y-m-d H:i:s");
		if(!empty($this->keiyaku_kikan_end)){
			if($today>$this->keiyaku_kikan_end){
				$closed_color='style="color: Darkorange;font-weight: bold;"';
			}
		}else if(!empty($this->keiyaku_kikan_start)){
			if($today>$this->keiyaku_kikan_start){
				$closed_color='style="color: Darkorange;font-weight: bold;"';
			}
		}
		return $closed_color;
	}
}
