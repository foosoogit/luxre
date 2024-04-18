<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

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
}
