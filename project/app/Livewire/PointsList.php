<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Point;
use Livewire\WithPagination;
use App\Consts\initConsts;
if(!isset($_SESSION)){session_start();}

class PointsList extends Component
{
    public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
	public $kensakukey="";
	public $target_page=null;
    public function render()
    {
        /*
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		if(!isset($sort_key_p) and session('sort_key')==null){
			session(['sort_key' =>'']);
		}
        */
        $target_day="";
        $pointQuery = Point::query();
        $pointQuery =$pointQuery->leftJoin('users', 'points.serial_user', '=', 'users.serial_user');
        //$pointQuery =$pointQuery->leftJoin('users', 'points.referred_serial', '=', 'users.serial_user');
        $points_histories=$pointQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.points-list',compact('points_histories','target_day'));
    }
}
