<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Staff extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
		'phone',
		'email',
		'last_name_kanji',
		'first_name_kanji',
		'last_name_kana',
		'first_name_kana',
		'serial_staff',
	];
}
