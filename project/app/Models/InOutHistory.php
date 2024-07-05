<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Support\Facades\Log;

class InOutHistory extends Model
{
    use HasFactory;
    public function getStaffDiffAttribute($value){
		$in = strtotime(date($this->time_in));
        //log::alert("in=".$in);
        $out = strtotime(date($this->time_out));
        //log::alert("out=".$out);
        $diff = $out - $in;
        //log::alert("diff=".$diff);
		$diff_m = $diff / 60;
        return floor($diff_m);
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
