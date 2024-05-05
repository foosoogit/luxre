<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Point;
use Livewire\WithPagination;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;
if(!isset($_SESSION)){session_start();}

class PointsList extends Component
{
    public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
	public $kensakukey="";
	public $target_page=null;

    public function state_validity(){
        Log::alert("state_validity");
        if(session('state_validity')=="checked"){
            session(['state_validity' => ""]);
        }else{
            session(['state_validity' => "checked"]);
        }
        Log::alert("session=".session('state_validity'));
    }

    public function state_used(){
        if(session('state_used')=="checked"){
            session(['state_used' => ""]);
        }else{
            session(['state_used' => "checked"]);
        }
    }

    public function change_point($point_id){
        Point::where('id','=',$point_id)->update([
            'time_out' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
    }

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
        $points_histories = Point::query();
        Log::alert("state_validity=".session('state_validity'));
        Log::alert("state_used=".session('state_used'));
        if(session('state_validity')=="checked" && empty(session('state_used'))){
            Log::alert("state_validity only");
            $points_histories = $points_histories->where('digestion_flg','=','false');
        }else if(empty(session('registered_flg')) && session('state_used')=="checked"){
            $points_histories = $points_histories->where('digestion_flg','=','true');
        }else{
            session(['state_validity' => "checked"]);
            session(['state_used' => "checked"]);
            $points_histories = Point::query();
        }
        /*
        $pointQuery =$pointQuery->leftJoin('users', 'points.serial_user', '=', 'users.serial_user')
            //->select("points.id AS points_id","date_get","method","point","visit_date","referred_serial","name_sei","name_mei");
            ->select("points.id AS points_id")
            ->select("referred_serial")->select("ReferredName");
        //$pointQuery =$pointQuery->leftJoin('users', 'points.referred_serial', '=', 'users.serial_user');
        */
        $points_histories=$points_histories->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        //$points_histories=Point::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.points-list',compact('points_histories','target_day'));
    }
}
