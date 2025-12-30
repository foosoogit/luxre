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
use Illuminate\Support\Facades\DB;
if(!isset($_SESSION)){session_start();}
session(['livewire_cnt'=>0]);
class ContractList extends Component
{
    use WithPagination;
	//public $sort_key_p_contract = '',$asc_desc_p_contract="",$serch_key_p_contract="";
	public $targetPage=null;
	public static $statickey="";
	public $serch_key_contract,$sort_key_contract,$sort_type_contract="asc",$isSubscriptionCheckBox=true,$isCyclicCheckBox=true,$isContractStatusUnderCheckBox=true,$isContractStatusCancellationCheckBox=true;
	public $contract_type,$userinf;
	protected $search_Contract;
	protected $target_historyBack_inf_array;
	public function searchClear(){
		//$this->serch_key_p_contract="";
		$this->serch_key_contract="";
		$this->sort_key_contract="";
		$this->sort_type_contract="asc";
		session(['serch_key_contract' => '']);
		session(['sort_key_contract' => '']);
		session(['sort_type_contract' => 'asc']);
		session(['checked_subscription' => 'checked']);
		session(['checked_cancel' => 'checked']);
	}

	public function select_Under(){
		if($this->isContractStatusUnderCheckBox){
			session(['checked_Under' => true]);
		}else{
			session(['checked_Under' => false]);
		}
	}

	public function select_cyclic(){
		//log::alert("isCyclicCheckBox-2=".$this->isCyclicCheckBox);
		//isSubscriptionCheckBox=false;
		if($this->isCyclicCheckBox){
			session(['check_cyclic' => true]);
        }else{
            session(['check_cyclic' => false]);
        }
	}
	
	public function select_subscription(){
		if($this->isSubscriptionCheckBox){
			session(['checked_subscription' => true]);
        }else{
            session(['checked_subscription' => false]);
        }
		/*
		if(session('checked_subscription')=="checked"){
            session(['checked_subscription' => ""]);
        }else{
            session(['checked_subscription' => "checked"]);
        }
		*/
	}

	public function select_cancel(){
		if($this->isContractStatusCancellationCheckBox){
			session(['checked_cancel' => true]);
		}else{
			session(['checked_cancel' => false]);
		}
	}

	public function search_from_top_menu(Request $request){
		$this->kensakukey_contract=$request->input('user_serial');
		session(['serchKey_contract' => $request->input('user_serial')]);
	}
	
	public function search(){
		session(['serch_key_contract' => $this->serch_key_contract]);
	}

	public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		$this->sort_key_contract=$sort_key_array[0];
		$this->sort_type_contract=$sort_key_array[1];
		session(['sort_key_contract' =>$sort_key_array[0]]);
		session(['sort_type_contract' =>$sort_key_array[1]]);
	}

    public function render()
    {
		session(['target_livewire_page' => "ListContract"]);
		OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		if($this->sort_key_contract<>session('sort_key_contract')){
			//session(['sort_key_contract' =>$this->sort_key_contract]);
			$this->sort_key_contract=session('sort_key_contract');
		}

		if($this->sort_type_contract<>session('sort_type_contract')){
			$this->sort_type_contract=session('sort_type_contract');
		}
		
		if(isset($_POST['btn_serial'])){
			session(['serch_key_contract' => $_POST['btn_serial']]);
		}else if(session('serch_key_contract')<>$this->serch_key_contract){
			session(['serch_Key_contract' => $this->serch_key_contract]);
		}
		if($this->serch_key_contract<>session('sort_type_contract')){
			$this->serch_key_contract=session('serch_key_contract');
		}

		$UserSerial=session('targetUserSerial');
        $Contracts="";$userinf="";
		/*
		$contractQuery = Contract::query();
		//$contractQuery=$contractQuery->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku');
		
		if($this->serch_key_contract<>""){
			$key="%".$this->kensakukey."%";
			self::$statickey="%".$this->serch_key_contract."%";
			$userinf="";
		}else{
			$key="%%";
			self::$statickey="%%";
		}
		if(session('targetUserSerial')=="all"){
			$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->where('contracts.serial_keiyaku','like',$key)
				->orwhere('contracts.serial_user','like',$key)
				->orwhere('users.name_mei','like',$key)
				->orwhere('users.name_sei','like',$key)
				->orwhere('users.name_sei_kana','like',$key)
				->orwhere('users.name_mei_kana','like',$key)
				->orwhere('date_latest_visit','like',$key)
				->orwhere('keiyaku_bi','like',$key)
				->orwhere('keiyaku_kikan_start','like',$key)
				->orwhere('keiyaku_kikan_end','like',$key)
				->orwhere('keiyaku_kingaku','like',$key)
				->orwhere('how_to_pay','like',$key)
				->orwhere('how_many_pay_genkin','like',$key)
				->orwhere('how_many_pay_card','like',$key);
			$GoBackPlace="/top";
		}else{
			$userinf=User::where('serial_user','=',session('targetUserSerial'))->first();
			$contractQuery=$contractQuery->where('contracts.serial_user','=',session('targetUserSerial'))
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku')
				->select('contracts.*', 'users.*')
				->Where(function($query) {
					$query->orwhere('contracts.serial_keiyaku','like',self::$statickey)
					->orwhere('contracts.serial_user','like',self::$statickey)
					->orwhere('users.name_mei','like',self::$statickey)
					->orwhere('users.name_sei','like',self::$statickey)
					->orwhere('users.name_sei_kana','like',self::$statickey)
					->orwhere('users.name_mei_kana','like',self::$statickey)
					->orwhere('date_latest_visit','like',self::$statickey)
					->orwhere('keiyaku_bi','like',self::$statickey)
					->orwhere('keiyaku_kikan_start','like',self::$statickey)
					->orwhere('keiyaku_kikan_end','like',self::$statickey)
					->orwhere('keiyaku_kingaku','like',self::$statickey)
					->orwhere('how_to_pay','like',self::$statickey)
					->orwhere('how_many_pay_genkin','like',self::$statickey)
					->orwhere('how_many_pay_card','like',self::$statickey);
				});
		}

		if(session('checked_subscription')=='checked'){
			$contractQuery=$contractQuery->where('keiyaku_type','subscription');
		}
		if(session('checked_cancel')=='checked'){
			$contractQuery=$contractQuery->where('cancel','<>','');
		}
		
		if($this->sort_key_contract<>''){
			if($this->sort_key_contract=="name_sei"){
				if($this->sort_type_contract=="ASC"){
					$contractQuery =$contractQuery->orderBy('name_sei_kana');
				}else{
					$contractQuery =$contractQuery->orderBy('name_sei_kana', 'desc');
				}
			}else{
				if($this->sort_type_contract=="ASC"){
					$contractQuery =$contractQuery->orderBy($this->sort_key_contract, 'asc');
				}else{
					$contractQuery =$contractQuery->orderBy($this->sort_key_contract, 'desc');
				}
			}
		}else{
			$contractQuery =$contractQuery->orderBy('keiyaku_bi', 'desc');
		}
		if(session('target_page_for_pager')!==null){
			$this->targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			session(['target_page_for_pager'=>null]);
		}
		if(session('targetUserSerial')!="all"){
			$this->targetPage=null;
		}
		
		$contractQuery=$contractQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->targetPage);
    	//$contractQuery=$contractQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
		/*$GoBackPlaceName="";
		foreach($_SESSION['access_history'] as $targetHistory){
			if(strpos($targetHistory,"UserList")){
                $GoBackPlace="/customers/CustomersList";
				$GoBackPlaceName="戻る";
				break;
			}else if(strpos($targetHistory,"menuStaff")){
				$GoBackPlace="";
			}
		}
		//$GoBackPlace="/ShowMenuCustomerManagement/";
		*/
		$this->search_Contract();
		//$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		return view('livewire.contract-list',["target_historyBack_inf_array"=>$this->target_historyBack_inf_array,"userinf"=>$this->userinf,"contractQuery"=>$this->search_Contract,"UserSerial"=>$UserSerial,"serchKey_contract"=>$this->serch_key_contract]);
		//return view('livewire.contract-list',["target_historyBack_inf_array"=>$this->target_historyBack_inf_array,"userinf"=>$userinf,'contractQuery'=>$contractQuery,"UserSerial"=>$UserSerial,"serchKey_contract"=>$this->serch_key_contract]);
		//return view('livewire.contract-list',compact("target_historyBack_inf_array"=>$this->target_historyBack_inf_array,"userinf"=>$userinf,'contractQuery',"UserSerial"=>$UserSerial,"serchKey_contract"=>$this->serch_key_contract));
		//return view('livewire.contract-list',compact("target_historyBack_inf_array","userinf",'contractQuery',"UserSerial","serchKey_contract"));
    }

	public function search_Contract(){
		//DB::enableQueryLog();
		if(session('livewire_cnt')<>0){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
			$this->livewire_cnt=1;
			session(['livewire_cnt'=>0]);
		}else{
			session(['livewire_cnt'=>1]);
		}
		$this->target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		if(isset($target_historyBack_inf_array[3])){
			session(['livewire_page_num_for_back' => $target_historyBack_inf_array[3]]);
		}
		if($this->sort_key_contract<>session('sort_key_contract')){
			$this->sort_key_contract=session('sort_key_contract');
		}

		if($this->sort_type_contract<>session('sort_type_contract')){
			$this->sort_type_contract=session('sort_type_contract');
		}
		
		if(isset($_POST['btn_serial'])){
			session(['serch_key_contract' => $_POST['btn_serial']]);
		}else if(session('serch_key_contract')<>$this->serch_key_contract){
			session(['serch_Key_contract' => $this->serch_key_contract]);
		}
		if($this->serch_key_contract<>session('sort_type_contract')){
			$this->serch_key_contract=session('serch_key_contract');
		}

		$UserSerial=session('targetUserSerial');
        $Contracts="";$userinf="";
		$contractQuery = Contract::query();
		/*
		if(session('checked_subscription')=='checked'){
			log::alert("checked_subscription-4=".session('checked_subscription'));
			$contractQuery=$contractQuery->where('keiyaku_type','subscription');
			//$contractQuery->dd();
		}
		*/
		//$contractQuery=$contractQuery->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku');
		if($this->serch_key_contract<>""){
			$key="%".$this->kensakukey."%";
			self::$statickey="%".$this->serch_key_contract."%";
			$this->userinf="";
		}else{
			$key="%%";
			self::$statickey="%%";
		}
		if(session('targetUserSerial')=="all"){
			$contractQuery=$contractQuery->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				//->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku')
				->Where(function($query) {
					$query->orwhere('contracts.serial_keiyaku','like',self::$statickey)
					->orwhere('contracts.serial_user','like',self::$statickey)
					->orwhere('users.name_mei','like',self::$statickey)
					->orwhere('users.name_sei','like',self::$statickey)
					->orwhere('users.name_sei_kana','like',self::$statickey)
					->orwhere('users.name_mei_kana','like',self::$statickey)
					->orwhere('date_latest_visit','like',self::$statickey)
					->orwhere('keiyaku_bi','like',self::$statickey)
					->orwhere('keiyaku_kikan_start','like',self::$statickey)
					->orwhere('keiyaku_kikan_end','like',self::$statickey)
					->orwhere('keiyaku_kingaku','like',self::$statickey)
					->orwhere('how_to_pay','like',self::$statickey)
					->orwhere('how_many_pay_genkin','like',self::$statickey)
					->orwhere('how_many_pay_card','like',self::$statickey);
				});
				/*
				->where('contracts.serial_keiyaku','like',$key)
				->orwhere('contracts.serial_user','like',$key)
				->orwhere('users.name_mei','like',$key)
				->orwhere('users.name_sei','like',$key)
				->orwhere('users.name_sei_kana','like',$key)
				->orwhere('users.name_mei_kana','like',$key)
				->orwhere('date_latest_visit','like',$key)
				->orwhere('keiyaku_bi','like',$key)
				->orwhere('keiyaku_kikan_start','like',$key)
				->orwhere('keiyaku_kikan_end','like',$key)
				->orwhere('keiyaku_kingaku','like',$key)
				->orwhere('how_to_pay','like',$key)
				->orwhere('how_many_pay_genkin','like',$key)
				->orwhere('how_many_pay_card','like',$key);
				*/
			$GoBackPlace="/top";
		}else{
			log::info("UserSerial-5=".session('targetUserSerial'));
			$this->userinf=User::where('serial_user','=',session('targetUserSerial'))->first();
			$contractQuery=$contractQuery->where('contracts.serial_user','=',session('targetUserSerial'))
				->leftjoin('users', 'contracts.serial_user', '=', 'users.serial_user')
				//->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku')
				->select('contracts.*', 'users.*')
				->Where(function($query) {
					$query->orwhere('contracts.serial_keiyaku','like',self::$statickey)
					->orwhere('contracts.serial_user','like',self::$statickey)
					->orwhere('users.name_mei','like',self::$statickey)
					->orwhere('users.name_sei','like',self::$statickey)
					->orwhere('users.name_sei_kana','like',self::$statickey)
					->orwhere('users.name_mei_kana','like',self::$statickey)
					->orwhere('date_latest_visit','like',self::$statickey)
					->orwhere('keiyaku_bi','like',self::$statickey)
					->orwhere('keiyaku_kikan_start','like',self::$statickey)
					->orwhere('keiyaku_kikan_end','like',self::$statickey)
					->orwhere('keiyaku_kingaku','like',self::$statickey)
					->orwhere('how_to_pay','like',self::$statickey)
					->orwhere('how_many_pay_genkin','like',self::$statickey)
					->orwhere('how_many_pay_card','like',self::$statickey);
				});
		}
		/*
		log::alert("checked_subscription=".session('checked_subscription'));
		log::alert("checked_check_cyclic=".session('checked_check_cyclic'));
		log::alert("checked_cancel=".session('checked_cancel'));
*/
		
		$this->isSubscriptionCheckBox=session('checked_subscription');
		$this->isCyclicCheckBox=session('check_cyclic');

		//log::alert("isSubscriptionCheckBox=".$this->isSubscriptionCheckBox);
		//log::alert("isCyclicCheckBox=".$this->isCyclicCheckBox);
		//log::alert("checked_subscription=".session('checked_subscription'));
		//log::alert("check_cyclic=".session('check_cyclic'));


		if(session('checked_subscription') and !session('check_cyclic')){
			//log::alert("1");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->where('keiyaku_type','=','subscription');
			});
		}else if(!session('checked_subscription') and session('check_cyclic')){
			//log::alert("2");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->where('keiyaku_type','=','cyclic');
			});
		}else if(session('checked_subscription') and session('check_cyclic')){
			//log::alert("3");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->orwhere('keiyaku_type','=','cyclic')->orwhere('keiyaku_type','=','subscription');
			});
		}else if(!session('checked_subscription') and !session('check_cyclic')){
			//log::alert("4");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->where('keiyaku_type','<>','cyclic')->where('keiyaku_type','<>','subscription');
			});
		}

		$this->isContractStatusUnderCheckBox=session('checked_Under');
		$this->isContractStatusCancellationCheckBox=session('checked_cancel');

		if(session('checked_Under') and !session('checked_cancel')){
			//log::alert("1");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->WhereNull('cancel');
			});
		}else if(!session('checked_Under') and session('checked_cancel')){
			//log::alert("2");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->WhereNotNull('cancel');
			});
		}else if(session('checked_Under') and session('checked_cancel')){
			//log::alert("3");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->orWhereNotNull('cancel')->orWhereNull('cancel');
			});
		}else if(!session('checked_Under') and !session('checked_cancel')){
			//log::alert("4");
			$contractQuery=$contractQuery->Where(function($query) {
				$query->WhereNotNull('cancel')->WhereNull('cancel');
			});
		}
/*
		if($this->isContractStatusCancellationCheckBox and !$this->isContractStatusUnderCheckBox){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->WhereNotNull('cancel');
				});
		}else if(!$this->isContractStatusCancellationCheckBox and $this->isContractStatusUnderCheckBox){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->whereNull('cancel');
				});
		}else if($this->isContractStatusCancellationCheckBox and $this->isContractStatusUnderCheckBox){

		}else if(!$this->isContractStatusCancellationCheckBox and !$this->isContractStatusUnderCheckBox){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->whereNotNull('cancel')->whereNotNull('cancel');
				});
		}
		*/
		/*
		if(!$this->isCyclicCheckBox){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->where('keiyaku_type','<>','cyclic');
				});
		}else{
			$contractQuery=$contractQuery->orWhere(function($query) {
					$query->orwhere('keiyaku_type','cyclic');
				});
		}

		if(!$this->isCancelCheckBox){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->orwhere('cancel','<>','');
				});
			//$contractQuery=$contractQuery->where('cancel','');
		}else{
			$contractQuery=$contractQuery->orWhere(function($query) {
					$query->where('cancel','');
				});
		}
		*/
		/*
		if(session('checked_subscription')!=='checked'){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->where('keiyaku_type','<>','subscription');
				});
		}
		
		if(session('checked_check_cyclic')!=='checked'){
			$contractQuery=$contractQuery->Where(function($query) {
					$query->where('keiyaku_type','<>','cyclic');
				});
		}
	
		if(session('checked_cancel')!=='checked'){
			$contractQuery=$contractQuery->where('cancel','<>','');
		}
		*/
		if($this->sort_key_contract<>''){
			if($this->sort_key_contract=="name_sei"){
				if($this->sort_type_contract=="ASC"){
					$contractQuery =$contractQuery->orderBy('name_sei_kana');
				}else{
					$contractQuery =$contractQuery->orderBy('name_sei_kana', 'desc');
				}
			}else{
				if($this->sort_type_contract=="ASC"){
					$contractQuery =$contractQuery->orderBy($this->sort_key_contract, 'asc');
				}else{
					$contractQuery =$contractQuery->orderBy($this->sort_key_contract, 'desc');
				}
			}	
		}else{
			$contractQuery =$contractQuery->orderBy('keiyaku_bi', 'desc');
		}
		if(session('target_page_for_pager')!==null){
			$this->targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			session(['target_page_for_pager'=>null]);
		}
		if(session('targetUserSerial')!="all"){
			$this->targetPage=null;
		}

		$this->search_Contract=$contractQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$this->targetPage);
		//Log::info($contractQuery->toSql());
		//Log::info($contractQuery->getBindings());
		//dd(DB::getQueryLog());
		//dd($contractQuery->toSql(), $contractQuery->getBindings());
		//dump($contractQuery);
		//dd($contractQuery->toRawSql());
		//$contractQuery->dd($this->search_Contract);
    }
	
}
