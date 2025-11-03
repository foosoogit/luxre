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

    public $test,$kensakukey,$target_date,$payment,$deposit,$summary,$amount,$remarks,$id_txt,$serch_key_month,$serch_key_date,$serch_key_all,$serch_key_payment,$serch_key_deposit,$sort_key_p ,$asc_desc_p;

    public function del_cash_book_rec($target_sirial){
		/*
        CashBook::where('id',$target_Vsirial)
			->update(['visit_history_serial' => "del_".$target_Vsirial]);
        */
		CashBook::where('id',$target_sirial)->delete();
	}

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key_cashbook' =>$sort_key_array[0]]);
		session(['asc_desc_cashbook' =>$sort_key_array[1]]);
	}

    public function search_all(){
        $this->serch_key_date="";
        $this->serch_key_month="";
        //session(['sort_key_cashbook' =>'target_date']);
        //session(['asc_desc_cashbook' =>'desc']);
        //session(['serch_key_all_cashbook' => $this->serch_key_all]);

        session([
            //'serch_payment_flg'=>'checked',
            //'serch_deposit_flg'=>'checked',
            'asc_desc_cashbook' =>'Desc',
            'sort_key_cashbook' =>'target_date',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>'',
            'serch_key_all_cashbook' =>$this->serch_key_all
        ]);
    }

    public function searchClear(){
        //Log::alert("searchClear");
		session(['sort_key_cashbook' =>'target_date']);
        session(['asc_desc_cashbook' =>'desc']);
        $this->serch_key_month="";
        $this->serch_key_date="";
		$this->serch_key_all="";
		$this->serch_key_date="";
        //session(['serch_key_date_CashBook'=>'']);
        session([
            'serch_payment_flg'=>'checked',
            'serch_deposit_flg'=>'checked',
            'asc_desc_cashbook' =>'Desc',
            'sort_key_cashbook' =>'target_date',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>'',
            'serch_key_all_cashbook' =>''
        ]);
        //log::alert('serch_key_date_CashBook 2='.session('serch_key_date_CashBook'));
	}

    public function serch_payment(){
        if(session('serch_payment_flg')=="checked"){
            session(['serch_payment_flg' => ""]);
        }else{
            session(['serch_payment_flg' => "checked"]);
        }
        /*
        session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook_cashbook' =>'',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>''
        ]);
        */
    }
    
    public function serch_deposit(){
        if(session('serch_deposit_flg')=="checked"){
            session(['serch_deposit_flg' => ""]);
        }else{
            session(['serch_deposit_flg' => "checked"]);
        }
        /*
        session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook' =>'',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>''
        ]);
        */
    }

    public function search_month(){
        $this->serch_key_date="";
        $this->serch_key_all="";
        session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook' =>'',
            'serch_key_month_CashBook' => $this->serch_key_month,
            'serch_key_date_CashBook' =>''
        ]);
    }

    public function search_date(){
        $this->serch_key_month="";
        $this->serch_key_all="";
        //Log::alert("serch_key_date 3=".$this->serch_key_date);
        Session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook' =>'',
            'serch_key_month_CashBook' => '',
            'serch_key_date_CashBook' => $this->serch_key_date
        ]);
        //Log::alert("serch_key_date 3=".$this->serch_key_date);
        //Log::alert("serch_key_date 4=".session('serch_key_date_CashBook'));
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
        $balance_Query=CashBook::query();
        $CashBookQuery=$CashBookQuery->where('branch',session('target_branch_serial'));
        $balance_Query=$balance_Query->where('branch',session('target_branch_serial'));
        //log::alert('serch_key_date_CashBook='.session('serch_key_date_CashBook'));
        //if($this->serch_key_month<>""){
        if(session('serch_key_month_CashBook')<>""){
            //log::alert('serch_key_month_CashBook='.session('serch_key_month_CashBook'));
            $key="%".session('serch_key_month_CashBook')."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if(session('serch_key_date_CashBook')<>""){
            //log::alert('serch_key_date_CashBook='.session('serch_key_date_CashBook'));
            $key="%".session('serch_key_date_CashBook')."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if($this->serch_key_all<>""){
            //log::alert('serch_key_all_cashbook='.session('serch_key_all_cashbook'));
            $key="%".$this->serch_key_all."%";
            $CashBookQuery=$CashBookQuery
				->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
            $balance_Query=$balance_Query
                ->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
        }

        if(session('serch_payment_flg')=="checked" &&  empty(session('serch_deposit_flg'))){
            $CashBookQuery=$CashBookQuery->where('in_out','=','payment');
            $balance_Query=$balance_Query->where('in_out','=','payment');
        }else if(empty(session('serch_payment_flg')) && session('serch_deposit_flg')=="checked"){
            $CashBookQuery=$CashBookQuery->where('in_out','=','deposit');
            $balance_Query=$balance_Query->where('in_out','=','deposit');
        }
        
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";
        /*
        if(!isset($sort_key_p) and session('sort_key_cashbook')==null){
			session(['sort_key_cashbook' =>'target_date']);
		}
		$this->sort_key_p=session('sort_key_cashbook');

		if(!isset($asc_desc_p) and session('asc_desc_cashbook')==null){
			session(['asc_desc_cashbook' =>'desc']);
		}
		$this->asc_desc_p=session('asc_desc_cashbook');

        $targetSortKey="";
		if(session('sort_key_cashbook')<>""){
			$targetSortKey=session('sort_key_cashbook');
		}else{
			$targetSortKey=$this->sort_key_p;
		}

        if($this->sort_key_p<>''){
			if($this->asc_desc_p=="ASC"){
				$CashBookQuery =$CashBookQuery->orderBy($this->sort_key_p, 'asc');
			}else{
				$CashBookQuery =$CashBookQuery->orderBy($this->sort_key_p, 'desc');
			}
		}
        */
        if(empty(session('sort_key_cashbook'))){
            session(['sort_key_cashbook' =>'target_date']);
        }
        if(session('sort_key_cashbook')=="target_date"){
            $CashBookQuery =$CashBookQuery->orderBy('target_date', session('asc_desc_cashbook'))->orderBy('created_at', session('asc_desc_cashbook'));
        }else{
            $CashBookQuery =$CashBookQuery->orderBy(session('sort_key_cashbook'), session('asc_desc_cashbook'));
        }
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        //$CashBookQuery->dump();
        /*
        $serch_payment_sum=$CashBookQuery->sum('IntPayment');
        $serch_deposit_sum=$CashBookQuery->sum('IntDeposit');
        $serch_balance=$serch_deposit_sum-$serch_payment_sum;
        */


        //$st='CAST('.session("sort_key").' AS SIGNED) '.session('asc_desc');

        //orderByRaw('CAST(book_code as SIGNED) ASC')
        //$CashBookQuery =$CashBookQuery->orderBy(session('sort_key'), session('asc_desc'));
        //$CashBookQuery =$CashBookQuery->sortBy(session('sort_key'));
        //$balance_Query=$CashBookQuery;
        //$balance_Query=$balance_Query->select(DB::raw('SUM(deposit -  payment) as balance'))->value('balance');
        //$CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        
        $balance_res=$balance_Query->get();
        
        //$balance_Query=$balance_Query->select(DB::raw('SUM(deposit -  payment) as balance'))->value('balance');
        //$balance_Query=$balance_Query->get();
        //$serch_payment_sum=$CashBookQuery->sum('IntPayment');
        $serch_payment_sum=$balance_res->sum('IntPayment');
        //$serch_deposit_sum=$CashBookQuery->sum('IntDeposit');
        $serch_deposit_sum=$balance_res->sum('IntDeposit');
        $serch_balance=$serch_deposit_sum-$serch_payment_sum;
        $this->serch_key_month=session('serch_key_month_CashBook');
        $this->serch_key_date=session('serch_key_date_CashBook');
        $this->serch_key_all=session('serch_key_all_cashbook');
        //$serch_balance=$serch_deposit_sum-$serch_payment_sum;
        //$st='CAST('.session("sort_key").' AS SIGNED) '.session('asc_desc');
        //$CashBookQuery =$CashBookQuery->orderByRaw($st);
        return view('livewire.cash-book-list',compact('serch_balance','serch_deposit_sum','serch_payment_sum','balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));
    }
    /*
    public $test,$kensakukey,$target_date,$payment,$deposit,$summary,$amount,$remarks,$id_txt,$serch_key_month,$serch_key_date,$serch_key_all,$serch_key_payment,$serch_key_deposit,$sort_key_p ,$asc_desc_p;
    
    public function del_cash_book_rec($target_sirial){
		CashBook::where('id',$target_sirial)->delete();
	}
    
   public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key_cashbook' =>$sort_key_array[0]]);
		session(['asc_desc_cashbook' =>$sort_key_array[1]]);
	}

    public function search_all(){
        $this->serch_key_date="";
        $this->serch_key_month="";
    }

    public function searchClear(){
		session(['sort_key_cashbook' =>'target_date']);
        session(['asc_desc_cashbook' =>'desc']);
        $this->serch_key_month="";
		$this->serch_key_all="";
		$this->serch_key_date="";
        session(['serch_payment_flg'=>'checked'],['serch_deposit_flg'=>'checked'],['serchKey'=>''],['serch_payment_flg'=>'target_date'],['asc_desc_cashbook' =>'Desc'],['sort_key_cashbook' =>'']);
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
        $balance_Query=CashBook::query();
        if($this->serch_key_month<>""){
            $key="%".$this->serch_key_month."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if($this->serch_key_date<>""){
            $key="%".$this->serch_key_date."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if($this->serch_key_all<>""){
            $key="%".$this->serch_key_all."%";
            $CashBookQuery=$CashBookQuery
				->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
            $balance_Query=$balance_Query
                ->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
        }

        if(session('serch_payment_flg')=="checked" &&  empty(session('serch_deposit_flg'))){
            $CashBookQuery=$CashBookQuery->where('in_out','=','payment');
            $balance_Query=$balance_Query->where('in_out','=','payment');
        }else if(empty(session('serch_payment_flg')) && session('serch_deposit_flg')=="checked"){
            $CashBookQuery=$CashBookQuery->where('in_out','=','deposit');
            $balance_Query=$balance_Query->where('in_out','=','deposit');
        }
        
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";

        $CashBookQuery =$CashBookQuery->orderBy('target_date', 'desc')->orderBy('created_at', 'desc');
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);

        $balance_res=$balance_Query->get();
        $serch_payment_sum=$balance_res->sum('IntPayment');
        $serch_deposit_sum=$balance_res->sum('IntDeposit');
        $serch_balance=$serch_deposit_sum-$serch_payment_sum;
        return view('livewire.cash-book-list',compact('serch_balance','serch_deposit_sum','serch_payment_sum','balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial')); 
        //return view('livewire.cash-book-list',compact('serch_balance','serch_deposit_sum','serch_payment_sum','balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));
    }
    */
}