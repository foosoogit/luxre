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
    public function getStaffDiffAttribute($value){
		$diff_m=OtherFunc::getStaffDiffAttribute($this->time_in,$this->time_out);
        /*
        $roundUp = 1;
        $dateRoundUp_in = new Carbon($this->time_in);
        $dateRoundUp_in = $dateRoundUp_in->addMinutes($roundUp - $dateRoundUp_in->minute % $roundUp)->format('Y-m-d H:i:00');
        $in = strtotime(date($dateRoundUp_in));
        $roundDown = 1;
        $dateRoundDown_out = new Carbon($this->time_out);
        $dateRoundDown_out = $dateRoundDown_out->subMinutes($dateRoundDown_out->minute % $roundDown)->format('Y-m-d H:i:00');
        $out = strtotime(date($dateRoundDown_out));
        $diff = $out - $in;
		$diff_m = $diff / 60;
        if($diff_m<0){$diff_m=0;}
        */
        return $diff_m;
    }

    /*
    protected function StaffDif(): Attribute{
        $in = strtotime(date($this->time_in));
        log::alert("in=".$in);
        $out = strtotime(date($this->time_out));
        log::alert("out=".$out);
        $diff = $out - $in;
        log::alert("diff=".$diff);
		$diff_m = $diff / 60;
        return Attribute::make(
            get: fn ($diff_m) => $diff_m;
        );
    }
    */
}
