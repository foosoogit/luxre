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

class CashBookList extends Component
{
    use WithPagination;
    public $kensakukey,$target_date,$payment_deposit_rdo,$payment,$deposit,$summary,$amount,$remarks;

    public function del($id){
        log::alert('id='.$id);
        $CashBook = CashBook::find($id);
        $CashBook->delete();
    }
    public function submitForm(Request $request){
        //Log::info($this->all());
        /*
        $validator = Validator::make($this->all(), [
            $this->payment_deposit_rdo => 'required',
            $this->target_date => 'required',
            $this->summary => 'required',
            $this->amount=> 'required|numeric',
        ]);
        Log::info($validator->fails());
        */
        $validator = Validator::make($request->all(), [
            'components.0.updates.payment_deposit_rdo' => 'required',
            'components.0.updates.summary' => 'required',
            'components.0.updates.target_date' => 'required',
            'components.0.updates.amount'=> 'required',
        ]);

        
        //Log::alert("validator_1=".$validator_1->fails());
        /*
        $validated = $this->validate([
            "payment_deposit_rdo" => ['required'],
            "target_date" => ['required'],
            "summary" => ['required'],
            "amount"=> ['required'],
        ]);
        */
        //$validator->fails()
        //Log::info($validated); 

        //Log::info("validated=". $validated);
        if ($validator->fails()) {
            //Log::alert("fails");
           $this->skipRender();
        }else{
            //$PD=$this->payment;
            $deposit_amount="";
            $payment_amount=$this->amount;
            if($payment_amount==""){
                $deposit_amount=$this->amount;
            }
            $rec = [
                ['target_date' => $this->target_date, 'in_out' => $this->payment_deposit_rdo, 'summary' => $this->summary,'payment'=> $payment_amount,'deposit'=> $deposit_amount,'inputter'=> Auth::id(),'remarks'=>$this->remarks ],
            ];
            //Log::info($rec);
            CashBook::upsert($rec, ['id']);
        }
    }

    public function render(Request $request)
    {
        //if($this->summary<>""){
        //Log::info($request);
        //Log::info("summary=".$this->summary);
        //Log::info("target_date=".$this->target_date);
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";
        $CashBookQuery = CashBook::query();
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.cash-book-list',compact('target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));

    }
}
