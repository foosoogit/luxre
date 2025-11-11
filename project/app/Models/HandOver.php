<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Staff;
use App\Models\User;
//use Illuminate\Support\Facades\Log;

class HandOver extends Model
{
    use HasFactory;
    use SoftDeletes;
    
    public function getCustomerNameAttribute($value){
		  $CustomerArray=User::where('serial_user','=',$this->target_customaer_serial)->first();
      if(empty($CustomerArray)){
        return "--";
      }else{
		    return $this->target_customaer_serial.' '.$CustomerArray->name_sei.$CustomerArray->name_mei;
      }
	  }

    public function getInputterNameAttribute($value){
		$StaffArray=Staff::where('serial_staff','=',$this->serial_staff)->first();
		return $StaffArray->last_name_kanji.$StaffArray->first_name_kanji;
	}

  public function getTypeFlagJPAttribute($value){
		if($this->type_flag=="DaylyRepo"){
      return "日報";
    }else if($this->type_flag=="HandOver"){
      return "申し送り";
    }else{
      return "";
    }
    //$StaffArray=Staff::where('serial_staff','=',$this->serial_staff)->first();
		//return $StaffArray->last_name_kanji.$StaffArray->first_name_kanji;
	}
}
