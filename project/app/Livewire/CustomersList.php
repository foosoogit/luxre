<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\User;
use App\Models\Contract;
use App\Models\PaymentHistory;
use Livewire\WithPagination;
use App\Consts\initConsts;
use Illuminate\Http\Request;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Log;
if(!isset($_SESSION)){session_start();}

class CustomersList extends Component
{
    use WithPagination;
	public $sort_key_p = '',$asc_desc_p="",$serch_key_p="";
	public $kensakukey="";
	public $target_page=null;

	/*
    public $count = 0;
 	public function increment(){
		$this->count++;
	}
    */
    public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
		$this->target_page=null;
		session(['serchKey' => '']);
	}
    
    public function search_from_top_menu(Request $request){
		$this->serch_key_p=$request->input('user_serial');
		session(['serchKey' => $request->input('user_serial')]);
	}
	
	public function search(){
		$this->serch_key_p=$this->kensakukey;
		$this->target_page=1;
		session(['serchKey' => $this->kensakukey]);
	}

	public function zankin_search(){
		$this->serch_key_p="zankin";
		session(['serchKey' => $this->kensakukey]);
	}

	public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}
    public function render()
    {
		/*
		if(empty($REQUEST_URI_array[1])){
			$targetPage=1;
		}else{
			$targetPage=intval($REQUEST_URI_array[1]);
		}
		*/
		//log::alert('kensakukey='.$this->kensakukey);
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		if(!isset($sort_key_p) and session('sort_key')==null){
			session(['sort_key' =>'']);
		}
		$this->sort_key_p=session('sort_key');

		if(!isset($asc_desc_p) and session('asc_desc')==null){
			session(['asc_desc' =>'ASC']);
		}
		$this->asc_desc_p=session('asc_desc');
		/*
		if($this->sort_key_p=="refereecnt"){
			$userQuery = User::query();
		}else{
			$userQuery = User::query();
		}
		*/
		$from_place="";$target_day="";$backdayly=false;
		foreach($_SESSION['access_history'] as $targeturl){
			if(strpos( $targeturl, 'ShowDailyReport') !== false){
				$backdayly=true;
				break;
			}else if (strpos( $targeturl, 'ShowMenuCustomerManagement') !== false){
				$backdayly=false;
				break;
			}
		}
		
		if(isset($_POST['btn_serial'])){
			session(['serchKey' => $_POST['btn_serial']]);
			
		}else if(session('serchKey')==""){
			session(['serchKey' => $this->serch_key_p]);
		}
		if((isset($_POST['target_day']) and $_POST['target_day']<>"") or $backdayly==true){
			$from_place="dayly_rep";
			if(isset($_POST['target_day'])){
			$target_day= $_POST['target_day'];
			}else{
				$target_day=$_SESSION['backmonthday'];
			}
		}
		//Log::alert("target_day=".$_POST['target_day']);
		$userQuery = User::query();
		if($this->kensakukey=='zankin'){
			$userQuery =$userQuery->where('zankin','>','0');
		}else if($this->kensakukey<>""){
			$key="%".$this->kensakukey."%";
			$userQuery =$userQuery->where('serial_user','like',$key)
				->orwhere('name_sei','like',$key)
				->orwhere('name_mei','like',$key)
				->orwhere('name_sei_kana','like',$key)
				->orwhere('name_mei_kana','like',$key)
				->orwhere('birth_year','like',$key)
				->orwhere('birth_month','like',$key)
				->orwhere('birth_day','like',$key)
				->orwhere('email','like',$key)
				->orwhere('phone','like',$key);
		}
		/*
		if(session('serchKey')=='zankin'){
			$userQuery =$userQuery->where('zankin','>','0');
		}else{
			$key="%".session('serchKey')."%";
			$userQuery =$userQuery->where('serial_user','like',$key)
				->orwhere('name_sei','like',$key)
				->orwhere('name_mei','like',$key)
				->orwhere('name_sei_kana','like',$key)
				->orwhere('name_mei_kana','like',$key)
				->orwhere('birth_year','like',$key)
				->orwhere('birth_month','like',$key)
				->orwhere('birth_day','like',$key)
				->orwhere('address_region','like',$key)
				->orwhere('address_locality','like',$key)
				->orwhere('email','like',$key)
				->orwhere('phone','like',$key);
		}
		*/
		$targetSortKey="";
		if(session('sort_key')<>""){
			$targetSortKey=session('sort_key');
		}else{
			$targetSortKey=$this->sort_key_p;
		}

		if($this->sort_key_p<>''){
			if($this->sort_key_p=="name_sei"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei', 'asc');
					$userQuery =$userQuery->orderBy('name_mei', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei', 'desc');
					$userQuery =$userQuery->orderBy('name_mei', 'desc');
				}
			}else if($this->sort_key_p=="name_sei_kana"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('name_sei_kana', 'asc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('name_sei_kana', 'desc');
					$userQuery =$userQuery->orderBy('name_mei_kana', 'desc');
				}
			}else if($this->sort_key_p=="birth_year"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('birth_year', 'asc');
					$userQuery =$userQuery->orderBy('birth_month', 'asc');
					$userQuery =$userQuery->orderBy('birth_day', 'asc');
				}else{
					$userQuery =$userQuery->orderBy('birth_year', 'desc');
					$userQuery =$userQuery->orderBy('birth_month', 'desc');
					$userQuery =$userQuery->orderBy('birth_day', 'desc');
				}
				
			}else if($this->sort_key_p=="zankin"){
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy('zankin');
				}else{
					$userQuery =$userQuery->orderBy('zankin', 'desc');
				}		
			}else if($this->sort_key_p=="refereecnt"){
				if($this->asc_desc_p=="ASC"){
				}else{
					$userQuery =$userQuery->orderBy('referee_num', 'desc');
				}
			}else{
				if($this->asc_desc_p=="ASC"){
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'asc');
				}else{
					$userQuery =$userQuery->orderBy($this->sort_key_p, 'desc');
				}
			}
		}

		//$userQuery =$userQuery->orderByRaw('tpoint');

		/*
		if(session('target_page_for_pager')!==null){
			$targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			$targetPage=null;
		}
		*/
		//log::alert("targetPage=".$targetPage);

		//log::alert('page_history_CustomersList='.session('page_history_CustomersList'));
		if(empty($this->target_page)){
			$users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
		}else{
			$users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->target_page);
			$this->target_page=null;
		}
		/*
		if(!str_contains($_SERVER['HTTP_REFERER'], "CustomersList")){
			$users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList());
		}else{
			$users=$userQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',session('page_history_CustomersList'));
		}
		*/
		$cancelPaied=PaymentHistory::whereIn("serial_keiyaku", function($query){
				$query->from("contracts")
				->select("serial_keiyaku")
				->whereNotNull("cancel");
			})->sum('amount_payment');
		$cancelKeiyakuKingaku=Contract::whereNotNull("cancel")->sum('keiyaku_kingaku');
		$cancelSonkin=$cancelKeiyakuKingaku-$cancelPaied;
		$totalZankin=Contract::sum('keiyaku_kingaku')-PaymentHistory::sum('amount_payment')-$cancelSonkin;

		//$from_place2=OtherFunc::get_goback_url($_SERVER['REQUEST_URI']);
		//$from_place2="";
		$from_place2=$_SESSION['access_history'][0];
        return view('livewire.customers-list',compact('target_historyBack_inf_array','users','totalZankin','from_place','target_day','from_place','from_place2'));
    }
}
