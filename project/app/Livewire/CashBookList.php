<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Consts\initConsts;
use Livewire\WithPagination;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Log;
use App\Models\CashBook;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
if(!isset($_SESSION)){session_start();}

class CashBookList extends Component
{
    use WithPagination;
    public $test,$kensakukey,$target_date,$payment_deposit_rdo,$payment,$deposit,$summary,$amount,$remarks,$id_txt,$serch_key_month,$serch_key_date,$serch_key_all,$serch_key_payment,$serch_key_deposit;

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function search_all(){
        $this->serch_key_date="";
        $this->serch_key_month="";
    }

    public function searchClear(){
		$this->serch_key_month="";
		$this->serch_key_all="";
		$this->serch_key_date="";
        session(['serch_payment_flg'=>'checked'],['serch_deposit_flg'=>'checked'],['serchKey'=>''],['serch_payment_flg'=>'target_date'],['asc_desc' =>'Desc']);
        //Log::alert("searchClear");
	}

    public function serch_payment(){
        if(session('serch_payment_flg')=="checked"){
            session(['serch_payment_flg' => ""]);
        }else{
            session(['serch_payment_flg' => "checked"]);
        }
    }
    
    public function serch_deposit(){
        if(session('serch_deposit_flg')=="checked"){
            session(['serch_deposit_flg' => ""]);
        }else{
            session(['serch_deposit_flg' => "checked"]);
        }
    }

    public function search_month(){
        $this->serch_key_date="";
        $this->serch_key_all="";
    }

    public function search_date(){
        $this->serch_key_month="";
        $this->serch_key_all="";
    }

    public function del($id){
        $CashBook = CashBook::find($id);
        $CashBook->delete();
    }
    public function submitForm(Request $request){
        $validator = Validator::make($request->all(), [
            'components.0.updates.target_date' => 'required',
            'components.0.updates.payment_deposit_rdo' => 'required',
            'components.0.updates.summary' => 'required',
            'components.0.updates.amount'=> 'required',
        ]);
        if ($validator->fails()) {
           $this->skipRender();
        }
    }

    public function render(Request $request)
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);

        $balance=CashBook::select(DB::raw('SUM(deposit -  payment) as balance'))
            ->value('balance');
        $CashBookQuery=CashBook::query();
        if($this->serch_key_month<>""){
            $key="%".$this->serch_key_month."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
        }else if($this->serch_key_date<>""){
            $key="%".$this->serch_key_date."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
        }else if($this->serch_key_all<>""){
            $key="%".$this->serch_key_all."%";
            $CashBookQuery=$CashBookQuery
				->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
        }

        if(session('serch_payment_flg')=="checked" &&  empty(session('serch_deposit_flg'))){
            $CashBookQuery=$CashBookQuery->where('in_out','=','payment');
        }else if(empty(session('serch_payment_flg')) && session('serch_deposit_flg')=="checked"){
            $CashBookQuery=$CashBookQuery->where('in_out','=','deposit');
        }
        
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";
        //orderByRaw('CAST(book_code as SIGNED) ASC')
        $CashBookQuery =$CashBookQuery->orderBy(session('sort_key'), session('asc_desc'));
        //$CashBookQuery =$CashBookQuery->sortBy(session('sort_key'));
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        $serch_payment_sum=$CashBookQuery->sum('IntPayment');
        $serch_deposit_sum=$CashBookQuery->sum('IntDeposit');
        $serch_balance=$serch_deposit_sum-$serch_payment_sum;
        //$st='CAST('.session("sort_key").' AS SIGNED) '.session('asc_desc');
        //$CashBookQuery =$CashBookQuery->orderByRaw($st);
        return view('livewire.cash-book-list',compact('serch_balance','serch_deposit_sum','serch_payment_sum','balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));
    }
}