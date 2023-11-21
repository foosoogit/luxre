<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Good extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
	protected $fillable = [
		'serial_good',
		'model_number',
		'good_name',
		'buying_price',
		'selling_price',
		'serial_Teacher',
		'zaiko',
		'memo',
	];
}
