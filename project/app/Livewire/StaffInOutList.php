<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use App\Http\Controllers\OtherFunc;
use App\Models\InOutHistory;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;

class StaffInOutList extends Component
{
    use WithPagination;
    public $sort_key_p = '',$asc_desc_p="",$serch_key_p="",$targetPage=null,$target_day="",$sort_type="";
	public $kensakukey="";
    public static $key="";
    protected $histories;


    public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
		$this->target_page=null;
		session(['serchKey' => '']);
	}

    public function search(){
		$this->serch_key_p=$this->kensakukey;
		$this->target_page=1;
		session(['serchKey' => $this->kensakukey]);
	}

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function render(){
        $this->search_staff();
       //$html_staff_inout_slct=OtherFunc::make_html_staff_inout_slct("");
        return view('livewire.staff-in-out-list',['histories'=>$this->histories,'target_day'=>'','html_staff_inout_slct'=>OtherFunc::make_html_staff_inout_slct("")]);
        //return view('livewire.staff-in-out-list');
    }

    public function sort_day($target){
        $sort_array=explode("-", $target);
        $this->sort_type=$sort_array[1];
    }
    public function search_day($target){
        //log::alert("target=".$target);
        $this->target_day=$target;
    }
    public function search_staff(){
        try {
            $HistoriesQuery = InOutHistory::query();
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->targetPage);
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
            //$HistoriesQuery =$HistoriesQuery->where('staff_serial','=',session('target_stud_inf_array')->serial_student);
            if($this->target_day<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','=',$this->target_day);
            }else{
                $this->target_day="";
            }
            if($this->sort_type<>""){
                $HistoriesQuery = $HistoriesQuery->orderBy('time_in',$this->sort_type); 
            }else{
                $HistoriesQuery = $HistoriesQuery->orderBy('time_in','desc');
            }
            $this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumStudentsList(),['*'], 'page',$this->targetPage);
        } catch (QueryException $e) {
            //Log::alert("QueryException=".$e);
            //return redirect('Students.List'); 
        }
        
        $this->targetPage=null;
        
    }
}