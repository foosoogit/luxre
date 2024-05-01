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
        /*
        $pointQuery =$pointQuery->leftJoin('users', 'points.serial_user', '=', 'users.serial_user')
            //->select("points.id AS points_id","date_get","method","point","visit_date","referred_serial","name_sei","name_mei");
            ->select("points.id AS points_id")
            ->select("referred_serial")->select("ReferredName");
        //$pointQuery =$pointQuery->leftJoin('users', 'points.referred_serial', '=', 'users.serial_user');
        */
        //$points_histories=$pointQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        $points_histories=Point::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.points-list',compact('points_histories','target_day'));
    }
}
