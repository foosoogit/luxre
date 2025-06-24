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

class CashBookList extends Component
{
    use WithPagination;
    public $test,$kensakukey,$target_date,$payment_deposit_rdo,$payment,$deposit,$summary,$amount,$remarks,$id_txt,$serch_key_month,$serch_key_date,$serch_key_all,$serch_key_payment,$serch_key_deposit;

    public function serch_payment(){
        Log::alert("serch_payment_flg 1=".session('serch_payment_flg'));
        if(session('serch_payment_flg')=="checked"){
            session(['serch_payment_flg' => ""]);
        }else{
            session(['serch_payment_flg' => "checked"]);
        }
        Log::alert("serch_payment_flg=".session('serch_payment_flg'));
    }
    
    public function serch_deposit(){
        Log::alert("serch_deposit_flg 1=".session('serch_deposit_flg'));
        if(session('serch_deposit_flg')=="checked"){
            session(['serch_deposit_flg' => ""]);
        }else{
            session(['serch_deposit_flg' => "checked"]);
        }
        Log::alert("serch_deposit_flg=".session('serch_deposit_flg'));
    }

    public function search_month(){
        //Log::alert("serch_key_month=".$this->serch_key_month);
        $this->serch_key_date="";
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
        /*
        else{
            $deposit_amount="";
            $payment_amount=$this->amount;
            if($payment_amount==""){
                $deposit_amount=$this->amount;
            }
            $rec = [
                ['id' => $this->id_txt,'target_date' => $this->target_date, 'in_out' => $this->payment_deposit_rdo, 'summary' => $this->summary,'payment'=> $payment_amount,'deposit'=> $deposit_amount,'inputter'=> Auth::id(),'remarks'=>$this->remarks ],
            ];
        }
        */
    }

    public function render(Request $request)
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        //$checked_payment_cbox='checked="checked"';$checked_deposit_cbox='checked="checked"';
        $balance=CashBook::select(DB::raw('SUM(deposit -  payment) as balance'))
            ->value('balance');
        $CashBookQuery=CashBook::query();
        if($this->serch_key_month<>""){
            $key="%".$this->serch_key_month."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
        }else if($this->serch_key_month<>""){
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
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        Log::alert("serch_payment_flg render=".session('serch_payment_flg'));
        Log::alert("serch_deposit_flg render=".session('serch_deposit_flg'));
        //$checked_deposit_cbox='checked';
        //$checked_payment_cbox='checked';
        return view('livewire.cash-book-list',compact('balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));
    }
}
