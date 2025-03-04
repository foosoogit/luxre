<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Staff;

class VisitHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
		'serial_keiyaku',
		'serial_user',
		'visit_history_serial',
		'date_visit',
		'point',
		'treatment_dtails',
	];

	public function getVisitNumAttribute($value){
		$visit_history_serial_array=explode("-", $this->visit_history_serial);
		$visitNum=$visit_history_serial_array[2];
		return $visitNum;
	}
	/*
	public function getTantosyaAttribute($value){
		Staff::where('serial_staff',$this->serial_staff)
		$visit_history_serial_array=explode("-", $this->visit_history_serial);
		$visitNum=$visit_history_serial_array[2];
		return $visitNum;
	}
	*/
}
