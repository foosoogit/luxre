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
if(!isset($_SESSION)){session_start();}
session(['livewire_cnt'=>0]);
class ContractList extends Component
{
    use WithPagination;
	//public $sort_key_p_contract = '',$asc_desc_p_contract="",$serch_key_p_contract="";
	public $targetPage=null;
	public static $statickey="";
	public $serch_key_contract,$sort_key_contract,$sort_type_contract="asc";
	public $livewire_cnt=0;
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
		return view('livewire.contract-list',["target_historyBack_inf_array"=>$this->target_historyBack_inf_array,"userinf"=>$userinf,"contractQuery"=>$this->search_Contract,"UserSerial"=>$UserSerial,"serchKey_contract"=>$this->serch_key_contract]);
    }

	public function search_Contract(){
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
				//->leftjoin('contract_details', 'contracts.serial_keiyaku', '=', 'contract_details.serial_keiyaku')
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
    }
	
}
