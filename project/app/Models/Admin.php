<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\vendor\Laravel\Sanctum\src\HasApiTokens;

class Admin extends Model
{
    use HasFactory;
    protected $guard = 'admin';
	protected $fillable = [
		'email', 'password',
	];
	protected $hidden = [
		'password', 'remember_token',
	];
	protected $casts = [
		'email_verified_at' => 'datetime',
	];
	public function sendPasswordResetNotification($token){
		$this->notify(new AdminPasswordResetNotification($token));
	}
}
