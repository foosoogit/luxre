<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Contract;
use App\Models\PaymentHistory;
use Illuminate\Support\Facades\DB;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;
    use Notifiable;
	use TwoFactorAuthenticatable;
	use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $dates = [ 'deleted_at' ];
    protected $fillable = [
		'admission_date',
		'name_sei',
		'name_mei',
		'name_sei_kana',
		'name_mei_kana',
		'birth_year',
		'birth_month',
		'birth_day',
		'postal',
		'address_region',
		'address_locality',
		'address_banti',
		'email',
		'phone',
		'password',
		'serial_user',
		'zankin',
		'referee',
		'referee_num',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        //'password' => 'hashed',
    ];

    public function getUserAgeAttribute($value){
		$birthday = $this->birth_year.$this->birth_month.$this->birth_day;
		$today = date('Ymd');
		$age=floor(($today - $birthday) / 10000);
		return $age.'才';
    }
    
	public function getUserZankinAttribute($value){
		$TotalAmount=Keiyaku::where('serial_user','=', $this->serial_user)
			->where('cancel','=',null)
			->selectRaw('SUM(keiyaku_kingaku) as total')
			->first(['total']);
		$PaidAmount=PaymentHistory::leftJoin('keiyakus', 'payment_histories.serial_keiyaku', '=', 'keiyakus.serial_keiyaku')
				->where('payment_histories.serial_user','=',$this->serial_user)
				->where('payment_histories.date_payment','<>',"")
				->where('keiyakus.cancel','=',null)
				->selectRaw('SUM(amount_payment) as paid')->first(['paid']);

		$zankin = $TotalAmount->total-$PaidAmount->paid;
		return $zankin;
	}

	public function getDefaultColorAttribute($value){
		$DefaultCount=PaymentHistory::where('serial_user','=', $this->serial_user)->where('how_to_pay','=', 'default')->count();
		$DefaultColorCss="";
		if($DefaultCount>0){
			$DefaultColorCss='style="color: red"';
		}
		return $DefaultColorCss;
	}

	public function getNoHyphenPhoneAttribute($value){
		$NoHyphenPhone=$this->phone;
		return $NoHyphenPhone;
	}
}
