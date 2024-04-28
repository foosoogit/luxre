<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\User;

class Point extends Model
{
    use HasFactory;
    use SoftDeletes;
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

	public function getReferredNameAgeAttribute($value){
		$Referred=User::where('serial_user','=', $this->serial_user)->first();
		$ReferredName=$Referred->name_sei.'&nbsp;'.$Referred->name_maei;
		return $ReferredName;
    }
}
