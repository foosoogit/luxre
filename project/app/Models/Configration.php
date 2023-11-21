<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Configration extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'subject',
        'value1',
        'value2',
        'setumei',
    ];
}
