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
    public $state_used_checked="true";
    public array $RedeemingMultiplePointsCbox = [];
    public array $selected_state_validity = [];

    public function mount()
    {
        // 初期でチェックを入れたい場合
        $this->selected_state_validity = ['Valid', 'Digestion'];   // ここに入れる
        //$this->selected_state_validity = ['Digestion'];
    }
    public function searchClear(){
		$this->serch_key_point="";
        $this->sort_key="";
        $this->serch_date_key="";
        $this->asc_desc="";
        $this->serch_date_key_point="";
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
        /*
        if(empty($value)){
            session(['state_validity_checked' => null]);
        }else{
            session(['state_validity_checked' => "checked"]);
        }
        */
    }

    public function state_used($value){
        /*    
        if(empty($value)){
            session(['state_used_checked' => null]);
        }else{
            session(['state_used_checked' => "checked"]);
        }
        */
   }

    public function change_point($point_id){
        Point::where('id','=',$point_id)->update([
            'time_out' => date('Y-m-d H:i:s'),
            'updated_at'=> date('Y-m-d H:i:s'),
        ]);
    }

    public function RedeemingMultiplePoints(){
        //log::info($this->RedeemingMultiplePointsCbox);
        foreach($this->RedeemingMultiplePointsCbox as $point_id)
        {
            Point::where('id','=',$point_id)->update([
                'digestion_flg' => "true"
            ]);
        }
        //$this->RedeemingMultiplePointsCbox = []; // Clear the array after processing
    }    

    public function render()
    {
        $points_histories = Point::query();
        /*
        foreach($this->selected_state_validity as $state){
            //session(['state_validity_checked' => "checked"]);
            //session(['state_used_checked' => "checked"]);
            if($state=="Valid"){
                session(['state_used_checked' => ""]);
            }else if($state=="Digestion"){
                session(['state_validity_checked' => ""]);
            }
        }
        */
        $target_day = null;
        if(session('serch_key_point')<>""){
			$this->serch_key_point=session('serch_key_point');
		}
       
       // $points_histories = $points_histories->select("points.id AS points_id")->select("*")->join('users', 'points.serial_user', '=', 'users.serial_user');
        $points_histories = $points_histories->select('*', 'points.id as points_id')->join('users', 'points.serial_user', '=', 'users.serial_user');

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
        if(session('state_validity_checked')!==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','false');
        }else if(session('state_validity_checked')==null && session('state_used_checked')!==null){
            $points_histories = $points_histories->where('digestion_flg','=','true');
        }else if(session('state_validity_checked')==null && session('state_used_checked')==null){
            $points_histories = $points_histories->where('digestion_flg','=','none');
        }
        */
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


        $points_histories = Point::query()
    ->select('points.*', 'points.id as points_id')
    ->join('users', 'points.serial_user', '=', 'users.serial_user')
    ->whereNull('points.deleted_at');

// キーワード検索
if ($this->serch_key_point !== "") {
    $key = '%' . $this->serch_key_point . '%';

    $points_histories->where(function ($query) use ($key) {
        $query->where('points.serial_user', 'like', $key)
              ->orWhere('users.name_sei', 'like', $key)
              ->orWhere('users.name_mei', 'like', $key)
              ->orWhere('users.name_sei_kana', 'like', $key)
              ->orWhere('users.name_mei_kana', 'like', $key)
              ->orWhere('points.date_get', 'like', $key)
              ->orWhere('points.visit_date', 'like', $key);
    });
}

// 日付検索
if ($this->serch_date_key_point !== "") {
    $key_d = '%' . $this->serch_date_key_point . '%';

    $points_histories->where(function ($query) use ($key_d) {
        $query->where('points.date_get', 'like', $key_d)
              ->orWhere('points.visit_date', 'like', $key_d);
    });
}

// 有効・消化済み
if (count($this->selected_state_validity) === 1) {
    if (in_array('Valid', $this->selected_state_validity)) {
        $points_histories->where('digestion_flg', 'false');
    }
    if (in_array('Digestion', $this->selected_state_validity)) {
        $points_histories->where('digestion_flg', 'true');
    }
}


        /*
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
            //Log::alert("message");
            $points_histories =$points_histories
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
                ->where(function ($query) use ($key_d) {
                    $query
                    ->where('points.date_get','like',$key_d)
                    ->orwhere('points.visit_date','like',$key_d);
                });
        }
         if (in_array('Digestion', $this->selected_state_validity) and in_array('Valid', $this->selected_state_validity)) {
        }else if (in_array('Valid', $this->selected_state_validity)) {
                $points_histories = $points_histories->where('digestion_flg','=','false');
        }else if(in_array('Digestion', $this->selected_state_validity)) {
                $points_histories = $points_histories->where('digestion_flg','=','true');
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