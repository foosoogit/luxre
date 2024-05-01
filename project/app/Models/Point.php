<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Point extends Model
{
	use HasFactory;
    use SoftDeletes;
	//protected $append = ['ReferredName'];

	protected $fillable = [
		'serial_user',
		'method',
		'date_get',
		'point',
		'visit_date',
		'referred_serial',
		'note',
        'validity_flg',
        'digestion_flg',
	];

	public function getUserNameAttribute(){
		$user_inf=User::where('serial_user','=', $this->serial_user)->first();
		$UserName="エラー";
		if(!empty($user_inf->deleted_at)){
			$UserName='退会';
		}else if(!empty($user_inf)){
			$UserName=$user_inf->name_sei.' '.$user_inf->name_mei;
		}
		return $UserName;
    }

	public function getReferredNameAttribute(){
		$Referred=User::where('serial_user','=', $this->referred_serial)->first();
		$ReferredName="";
		if(!empty($Referred)){
			$ReferredName=$Referred->name_sei.' '.$Referred->name_mei;
		}
		return $ReferredName;
    }
}