<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Point;
use Illuminate\Database\Eloquent\Casts\Attribute;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    //protected $appends = ['TotalPoints'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

     protected $appends = [
        'profile_photo_url','TotalPoints',
    ];

    protected $fillable = [
        'name',
        'email',
        'password',
        'reservation',
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
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array<int, string>
     */

     public function getTotalPointsAttribute() {
        $tpoint=Point::where('serial_user','=',$this->serial_user)->sum('point');
        return $tpoint;
    }

    /*
    protected function TotalPoints(): Attribute
    {
        return new Attribute(
            get: function ($value) {
                $tpoint=Point::where('serial_user','=',$this->serial_user)->sum('point');
                //return ucfirst($value);
                return $tpoint;
            },
            
            //set: function ($value) {
            //    return strtolower($value);
            //},

        );
    }
    */
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
		$PaidAmount=PaymentHistory::leftJoin('contracts', 'payment_histories.serial_keiyaku', '=', 'contracts.serial_keiyaku')
				->where('payment_histories.serial_user','=',$this->serial_user)
				->where('payment_histories.date_payment','<>',"")
				->where('contracts.cancel','=',null)
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