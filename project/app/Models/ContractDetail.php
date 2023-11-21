<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContractDetail extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $dates = [ 'deleted_at' ];
	protected $fillable = [
		'contract_detail_serial',
		'serial_keiyaku',
		'serial_user',
		'serial_Staff',
		'keiyaku_naiyo',
		'keiyaku_num',
		'unit_price',
		'price',
		'remarks'
	];
}
