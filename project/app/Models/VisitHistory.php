<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class VisitHistory extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
		'serial_keiyaku',
		'serial_user',
		'visit_history_serial',
		'serial_Teacher',
		'date_visit',
	];
}
