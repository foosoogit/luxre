<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\OtherFunc;

class InOutHistory extends Model
{
    use HasFactory;

    public function getWeekAttribute($value){
        $date = date('w', strtotime($this->target_date));
        return OtherFunc::youbi($date);
    }

    public function getStaffDiffAttribute($value){
		$diff_m=OtherFunc::getStaffDiffAttribute($this->time_in,$this->time_out);
        return $diff_m;
    }
    public function getTimeOnlyInAttribute($value){
		$TimeOnlyIn_array=explode(" ", $this->time_in);
        return $TimeOnlyIn_array[1];
    }

    public function getTimeOnlyOutAttribute($value){
		if(!empty($this->time_out)){
           $TimeOnlyOut_array=explode(" ", $this->time_out);
            return $TimeOnlyOut_array[1];
        }
    }
}
