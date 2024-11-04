<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\VisitHistory;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use App\Models\Point;

class UserController extends Controller
{
    public function ShowMyPage(){
        $user_inf = Auth::user();
        $point_total=Point::where("serial_user","=", $user_inf->serial_user)->where('digestion_flg','=','false')->sum('point');
        $user_inf = Auth::user();
        $serial_user=$user_inf->serial_user;
		return view('customers.InfCustomer', compact('user_inf','point_total','serial_user'));
	}
}
