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
use App\Models\PaymentHistory;
if(!isset($_SESSION)){session_start();}

class PaymentHistoryList extends Component
{
    use WithPagination;
	public $targetPage=null;
	public $dynamic_key,$serch_key,$sort_key,$sort_type="desc";
	public $livewire_cnt=0;
	public $kensakukey="";
	
	public function del_payment_history($target_Psirial){
		Log::alert("target_Vsirial=".$target_Psirial);
		PaymentHistory::where('payment_history_serial',$target_Psirial)
			->update(['payment_history_serial' => "del_".$target_Psirial]);
		PaymentHistory::where('payment_history_serial',"del_".$target_Psirial)->delete();
	}

	public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		$this->sort_key=$sort_key_array[0];
		//log::alert("sort_key=".$this->sort_key);
		$this->sort_type=$sort_key_array[1];
		session(['sort_key_PH' =>$sort_key_array[0]]);
		session(['sort_type_PH' =>$sort_key_array[1]]);
	}

	public function searchClear(){
		$this->kensakukey="";
		$this->sort_key="payment_history_serial";
		$this->sort_type="desc";
		session(['serch_key_PH' => '']);
		session(['sort_key_PH' => 'payment_history_serial']);
		session(['sort_type_PH' => 'desc']);
	}
    
	public function search(){
		//Log::alert("kensakukey=".$this->kensakukey);
		//$this->serch_key_p=$this->kensakukey;
		//$this->target_page=1;
		//session(['serchKey_VH' => $this->kensakukey]);
	}

    public function render()
    {
		if($this->sort_key<>session('sort_key_PH')){
			$this->sort_key=session('sort_key_PH');
		}else{
			$this->sort_key='payment_history_serial';
		}

		if(empty(session('sort_type_PH'))){
			session(['sort_type_PH' => 'desc']);
		}
		if($this->sort_type<>session('sort_type_PH')){
			$this->sort_type=session('sort_type_PH');
		}

		if($this->kensakukey<>session('serch_key_PH')){
			session(['serch_key_PH' => $this->kensakukey]);
		}

		$PaymentHistoryQuery = PaymentHistory::query();

		if($this->kensakukey<>""){
			$this->dynamic_key="%".$this->kensakukey."%";
			$PaymentHistoryQuery=$PaymentHistoryQuery->where('serial_keiyaku','=',session('targetKeiyakuSerial'))
				->where(function($q){
					$q->where('date_payment','like',$this->dynamic_key)
					->orWhere('amount_payment','like',$this->dynamic_key)
					->orWhere('how_to_pay','like',$this->dynamic_key);
			});
		}
		$PaymentHistoryQuery=$PaymentHistoryQuery->orderBy("payment_history_serial", "desc");
		$PaymentHistoryQuery=$PaymentHistoryQuery->where('serial_keiyaku','=',session('targetKeiyakuSerial'));

		$newPaymentHistorySerial=PaymentHistory::where('serial_keiyaku','=',session('targetKeiyakuSerial'))->max('payment_history_serial');
		if(empty($newPaymentHistorySerial)){
			$newPaymentHistorySerial=str_replace('K', 'P', session('targetKeiyakuSerial')).'-01';
		}else{
			$newPaymentHistorySerial=++$newPaymentHistorySerial;
		}
		$visit_history_serial_array=explode('-', session('targetKeiyakuSerial'));
		$UserSerial=str_replace('K_', '', $visit_history_serial_array[0]);
		$UserInf=User::where('serial_user','=',$UserSerial)->first();
		//$VisitHistoryQuery=$VisitHistoryQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->targetPage);
		$PaymentHistoryQuery=$PaymentHistoryQuery->paginate($perPage = 10,['*'], 'page',$this->targetPage);
        return view('livewire.payment-history-list',compact('PaymentHistoryQuery','UserInf','newPaymentHistorySerial'));
    }
}
