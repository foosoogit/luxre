<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VisitHistory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class UserController extends Controller
{
    public function ShowMyPage(){
        /*
		$DefaultUsersInf=PaymentHistory::leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
			->where('payment_histories.how_to_pay','=', 'default')
			->whereIn('users.serial_user', function ($query) {
				$query->select('contracts.serial_user')->from('contracts')->where('contracts.cancel','=', null);
			})
			->distinct()->select('name_sei','name_mei')->get();
		$html_year_slct=OtherFunc::make_html_year_slct(date('Y'));
		$html_month_slct=OtherFunc::make_html_month_slct(date('n'));
		$default_customers=OtherFunc::make_htm_get_default_user();
		$not_coming_customers=OtherFunc::make_htm_get_not_coming_customer();
		$htm_kesanMonth=OtherFunc::make_html_month_slct(InitConsts::KesanMonth());
		//list($targetNameHtmFront, $targetNameHtmBack) =OtherFunc::make_htm_get_not_coming_customer();
		$csrf="csrf";
		session(['GoBackPlace' => '../ShowMenuCustomerManagement']);
        */
        $user_inf = Auth::user();
        $point_total=VisitHistory::where("serial_user","=", $user_inf->serial_user)->sum('point');
        $user_inf = Auth::user();
        $serial_user=$user_inf->serial_user;
		return view('customers.InfCustomer', compact('user_inf','point_total','serial_user'));
	}
}
