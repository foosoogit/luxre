<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Staff;
//use Illuminate\Support\Facades\Log;

class HandOver extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function getInputterNameAttribute($value){
		$StaffArray=Staff::where('serial_staff','=',$this->serial_staff)->first();
		return $StaffArray->last_name_kanji.$StaffArray->first_name_kanji;
	}
}
