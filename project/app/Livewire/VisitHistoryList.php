<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Consts\initConsts;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Contract;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Log;
use App\Models\VisitHistory;
use App\Models\TreatmentContent;
if(!isset($_SESSION)){session_start();}

class VisitHistoryList extends Component
{
    use WithPagination;
	public $targetPage=null;
	public $Vtarget_treatment="",$Vdynamic_key,$Vserch_key,$Vsort_key,$Vsort_type="desc";
	public $livewire_cnt=0;
	public $delTargetVisitHistorySerial;
	//protected $search;
	public $Vkensakukey="";
	public function target_sejyutu($treatment){
		$this->$Vtarget_treatment=$treatment;
	}

	public function del_visit_history($target_Vsirial){
		//$this->delTargetVisitHistorySerial;
		Log::alert("delTargetVisitHistorySerial=".$this->delTargetVisitHistorySerial);
		Log::alert("target_Vsirial=".$target_Vsirial);

		VisitHistory::where('visit_history_serial',$target_Vsirial)
			->update(['visit_history_serial' => "del_".$target_Vsirial]);
		VisitHistory::where('visit_history_serial',"del_".$target_Vsirial)->delete();

	}
	public function Vsort($Vsort_key){
		$Vsort_key_array=array();
		$Vsort_key_array=explode("-", $Vsort_key);
		$this->Vsort_key=$Vsort_key_array[0];
		$this->Vsort_type=$Vsort_key_array[1];
		session(['sort_key_VH' =>$Vsort_key_array[0]]);
		session(['sort_type_VH' =>$Vsort_key_array[1]]);
	}

	public function searchClear(){
		$this->Vsort_key="visit_history_serial";
		$this->Vsort_type="desc";
		$this->Vkensakukey="";
		session(['serch_key_VH' => '']);
		session(['sort_key_VH' => 'visit_history_serial']);
		session(['sort_type_VH' => 'desc']);
	}
    
	public function Vsearch(){
		//Log::alert("Vkensakukey=".$this->Vkensakukey);
		//$this->serch_key_p=$this->Vkensakukey;
		//$this->target_page=1;
		//session(['serchKey_VH' => $this->Vkensakukey]);
	}
	
    public function render()
    {
		if($this->Vsort_key<>session('sort_key_VH')){
			//session(['sort_key_contract' =>$this->sort_key_contract]);
			$this->Vsort_key=session('sort_key_VH');
		}else{
			$this->Vsort_key='visit_history_serial';
		}

		if(empty(session('sort_type_VH'))){
			session(['sort_type_VH' => 'desc']);
		}
		if($this->Vsort_type<>session('sort_type_VH')){
			$this->Vsort_type=session('sort_type_VH');
		}

		if($this->Vkensakukey<>session('serch_key_VH')){
			session(['serch_key_VH' => $this->Vkensakukey]);
		}
		
		$VisitHistoryQuery = VisitHistory::query();
		$VisitHistoryQuery=$VisitHistoryQuery->where('serial_keiyaku','=',session('targetKeiyakuSerial'));
		if($this->Vkensakukey<>""){
			$this->Vdynamic_key="%".$this->Vkensakukey."%";
			$VisitHistoryQuery=$VisitHistoryQuery->where('serial_keiyaku','=',session('targetKeiyakuSerial'))
				->where(function($q){
					$q->where('date_visit','like',$this->Vdynamic_key)
					->orWhere('treatment_dtails','like',$this->Vdynamic_key);
			});
		}
		//$VisitHistoryQuery=$VisitHistoryQuery->leftJoin('users', 'visit_histories.serial_user', '=', 'users.serial_user');
		$VisitHistoryQuery=$VisitHistoryQuery->leftJoin('staff', 'visit_histories.serial_staff', '=', 'staff.serial_staff');
		//$VisitHistoryQuery=$VisitHistoryQuery->orderBy($this->Vsort_key, $this->Vsort_type);
		$VisitHistoryQuery=$VisitHistoryQuery->orderBy("visit_history_serial", "desc");
		
		$newVisitHistorySerial=VisitHistory::where('serial_keiyaku','=',session('targetKeiyakuSerial'))->max('visit_history_serial');
		if(empty($newVisitHistorySerial)){
			$newVisitHistorySerial=str_replace('K', 'V', session('targetKeiyakuSerial')).'-01';
		}else{
			$newVisitHistorySerial=++$newVisitHistorySerial;
		}
		//Log::info($newVisitHistorySerial);
		
		$visit_history_serial_array=explode('-', session('targetKeiyakuSerial'));
		$UserSerial=str_replace('K_', '', $visit_history_serial_array[0]);
		//Log::alert("UserSerial=".$UserSerial);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		$User_name=$UserInf->name_sei." ".$UserInf->name_mei;
		//Log::info($newVisitHistorySerial);
		//$newVisitHistorySerial;
		//$newVisitHistorySerial=$VisitHistoryArray->visit_history_serial;
        //$VisitHistoryQuery=$VisitHistoryQuery->where('contracts.serial_user','=',session('targetUserSerial'));
		//$VisitHistoryQuery=$VisitHistoryQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->targetPage);
		$VisitHistoryQuery=$VisitHistoryQuery->paginate($perPage = 10,['*'], 'page',$this->targetPage);
        return view('livewire.visit-history-list',compact('VisitHistoryQuery','newVisitHistorySerial','User_name'));
    }
}
