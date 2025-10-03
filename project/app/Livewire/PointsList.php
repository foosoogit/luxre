<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Point;
use Livewire\WithPagination;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;
use App\Models\User;
use Illuminate\Support\Facades\DB;
if(!isset($_SESSION)){session_start();}

class PointsList extends Component
{
    public $sort_key = '',$asc_desc="",$serch_key_point="",$serch_date_key_point="";
	public $target_page=null;
    public $state_validity_checked="true";
    public $state_used_checked="false";

    public function searchClear(){
		$this->serch_key_point="";
        $this->sort_key="";
        $this->serch_date_key="";
        $this->asc_desc="";
		session(['serch_key_point' => null]);
        session(['serch_date_key_point' =>null]);
	}
    public function search_date($key){
		$this->serch_date_key=$key;
		session(['serch_date_key_poin' => $key]);
	}
    public function search($key){
        $this->serch_key_point=$key;
		session(['serch_key_point' => $key]);
	}

    public function sort($sort_key){
        $sort_key_array=array();
        $sort_key_array=explode("-", $sort_key);
        $this->sort_key=$sort_key_array[0];
        $this->asc_desc=$sort_key_array[1];
        session(['sort_key_point' =>$sort_key_array[0]]);
        session(['asc_desc_point' =>$sort_key_array[1]]);
    }

    public function state_validity($value){
        if(empty($value)){
            session(['state_validity_checked' => null]);
        }else{
            session(['state_validity_checked' => "checked"]);
        }
    }

    public function state_used($value){
        if(empty($value)){
            session(['state_used_checked' => null]);
        }else{
            session(['state_used_checked' => "checked"]);
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
        //Log::alert("serch_key=".$this->serch_key);
        //Log::alert("serch_key_point=".session('serch_key_point'));
        /*
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		if(!isset($sort_key_p) and session('sort_key_point')==null){
			session(['sort_key_point' =>'']);
		}
        */
        //$target_day = date("Y-m-d");

        $target_day = null;
        if(session('serch_key_point')<>""){
			$this->serch_key_point=session('serch_key_point');
		}
        $points_histories = Point::query();
       // $points_histories = $points_histories->select("points.id AS points_id")->select("*")->join('users', 'points.serial_user', '=', 'users.serial_user');
        $points_histories = $points_histories->select('*', 'points.id as points_id')->join('users', 'points.serial_user', '=', 'users.serial_user');
        
        
        if(session('state_validity_checked')!==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','false');
        }else if(session('state_validity_checked')==null && session('state_used_checked')!==null){
            $points_histories = $points_histories->where('digestion_flg','=','true');
        }else if(session('state_validity_checked')==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','none');
        }
        /*
        if(session('state_validity_checked')!==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','false');
        }else if(session('state_validity_checked')==null && session('state_used_checked')!==null){
            $points_histories = $points_histories->where('digestion_flg','=','true');
        }else if(session('state_validity_checked')==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','none');
        }
        */
        /*
        if(empty(session('serch_key_point'))){
			session(['serch_key_point' => $this->serch_key_point]);
		}
        */
        if($this->serch_key_point<>"" && $this->serch_date_key_point==""){
			$key="%".$this->serch_key_point."%";
			$points_histories =$points_histories->where('points.serial_user','like',$key)
				->orwhere('users.name_sei','like',$key)
				->orwhere('users.name_mei','like',$key)
				->orwhere('users.name_sei_kana','like',$key)
				->orwhere('users.name_mei_kana','like',$key)
                ->orwhere('points.date_get','like',$key)
                ->orwhere('points.visit_date','like',$key);
		}else if($this->serch_date_key_point<>"" && $this->serch_key_point==""){
                $key_d="%".$this->serch_date_key_point."%";
                $points_histories =$points_histories->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
        }else if($this->serch_date_key_point<>"" && $this->serch_key_point<>""){
            $key_d="%".$this->serch_date_key_point."%";
            $key="%".$this->serch_key_point."%";
            /*
            $points_histories =$points_histories->where('points.serial_user','like',$key)
            ->orwhere('users.name_sei','like',$key)
            ->orwhere('users.name_mei','like',$key)
            ->orwhere('users.name_sei_kana','like',$key)
            ->orwhere('users.name_mei_kana','like',$key)
            ->orwhere('points.date_get','like',$key)
            ->orwhere('points.visit_date','like',$key)
            ->where('points.date_get','like',$key_d)
            ->orwhere('points.visit_date','like',$key_d);
            */ 
            
            /*$points_histories =$points_histories
            ->Where(function (Builder $query1) {
                $query1->where('points.serial_user','like',$key)
                    ->orwhere('users.name_sei','like',$key)
                    ->orwhere('users.name_mei','like',$key)
                    ->orwhere('users.name_sei_kana','like',$key)
                    ->orwhere('users.name_mei_kana','like',$key)
                    ->orwhere('points.date_get','like',$key)
                    ->orwhere('points.visit_date','like',$key);
            })->Where(function (Builder $query2) {
                $query2->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
            });
            */
            //Log::alert("message");
            $points_histories =$points_histories
            /*    
            ->where('points.serial_user','like',$key)
                
                ->orwhere('users.name_sei','like',$key)
                ->orwhere('users.name_mei','like',$key)
                ->orwhere('users.name_sei_kana','like',$key)
                ->orwhere('users.name_mei_kana','like',$key)
                ->orwhere('points.date_get','like',$key)
                ->orwhere('points.visit_date','like',$key)
                */

                ->where(function ($query) use ($key) {
                    $query
                    ->where('points.serial_user','like',$key)
                ->orwhere('users.name_sei','like',$key)
                ->orwhere('users.name_mei','like',$key)
                ->orwhere('users.name_sei_kana','like',$key)
                ->orwhere('users.name_mei_kana','like',$key)
                ->orwhere('points.date_get','like',$key)
                ->orwhere('points.visit_date','like',$key);
                })

                /*
                ->Where(function (Builder $query) {
                    $query->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
                });
                */
                ->where(function ($query) use ($key_d) {
                    $query
                    ->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
                });

                /*
                ->Where(function (Builder $query) {
                    $query->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
                });
                */
            /*
            ->Where(function (Builder $query1) {
                    $query1->where('points.serial_user','like',$key)
                        ->orwhere('users.name_sei','like',$key)
                        ->orwhere('users.name_mei','like',$key)
                        ->orwhere('users.name_sei_kana','like',$key)
                        ->orwhere('users.name_mei_kana','like',$key)
                        ->orwhere('points.date_get','like',$key)
                        ->orwhere('points.visit_date','like',$key);
                });
                */
                /*
                $points_histories =$points_histories
                    ->Where(function (Builder $query2) {
                        $query2->where('points.date_get','like',$key_d)
                        ->orwhere('points.visit_date','like',$key_d);
                });
                */
        }
        /*
		if((isset($_POST['target_day']) and $_POST['target_day']<>"") or $backdayly==true){
			$from_place="dayly_rep";
			if(isset($_POST['target_day'])){
			$target_day= $_POST['target_day'];
			}else{
				$target_day=$_SESSION['backmonthday'];
			}
		}
        */
        /*
        $targetSortKey="";
		if(empty(session('sort_key_point'))){
            $targetSortKey=$this->sort_key;
		}else{
			$targetSortKey=session('sort_key_point');
		}
        */
        if($this->sort_key<>''){
			if($this->sort_key=="name_user"){
                $points_histories =$points_histories->orderBy('users.name_sei_kana', session('asc_desc_point'));
            }else{
				$points_histories =$points_histories->orderBy($this->sort_key,  session('asc_desc_point'));
            }
		}
        if(empty($this->target_page)){
			$points_histories=$points_histories->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
		}else{
			$points_histories=$points_histories->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->target_page);
			$this->target_page=null;
		}
        //$points_histories=$points_histories->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        //$points_histories=Point::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.points-list',compact('points_histories','target_day'));
    }
}