<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Consts\initConsts;
use Livewire\WithPagination;
use App\Models\User;
use App\Models\Contract;
use App\Http\Controllers\OtherFunc;
if(!isset($_SESSION)){session_start();}

class ContractList extends Component
{
    use WithPagination;
	public $sort_key_p_contract = '',$asc_desc_p_contract="",$serch_key_p_contract="";
	public $kensakukey="";
	public $key="";
	public static $statickey="";
	
	public function searchClear(){
		$this->serch_key_p_contract="";
		$this->kensakukey="";
		session(['serchKey_contract' => '']);
	}
	
	public function search_from_top_menu(Request $request){
		$this->serch_key_p_contract=$request->input('user_serial');
		session(['serchKey_contract' => $request->input('user_serial')]);
	}
	
	public function search(){
		$this->serch_key_p_contract=$this->kensakukey;
		session(['serchKey_contract' => $this->kensakukey]);
	}

	public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key_contract' =>$sort_key_array[0]]);
		session(['asc_desc_contract' =>$sort_key_array[1]]);
	}

	public function ShowManage($userSerial){
		self::render();
	}

    public function render()
    {
        if(isset($_SERVER['HTTP_REFERER'])){
			OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		}
		if(!isset($sort_key_p_contract) and session('sort_key_contract')==null){
			session(['sort_key_contract' =>'']);
		}
		$this->sort_key_p=session('sort_key_contract');

		if(!isset($asc_desc_p) and session('asc_desc_contract')==null){
			session(['asc_desc_contract' =>'ASC']);
		}
		$this->asc_desc_p=session('asc_desc_contract');
		
		$targetSortKey="";
		if(session('sort_key_contract')<>""){
			$targetSortKey=session('sort_key_contract');
		}else{
			$targetSortKey=$this->sort_key_p_contract;
		}
		
		if(isset($_POST['btn_serial'])){
			session(['serchKey_contract' => $_POST['btn_serial']]);
			
		}else if(session('serchKey_contract')==""){
			session(['serchKey_contract' => $this->serch_key_p_contract]);
		}

		$UserSerial=session('targetUserSerial');
        $Contracts="";$userinf="";
		$contractQuery = Contract::query();
		if(null !==session('serchKey_contract')){
			$key="%".session('serchKey_contract')."%";$userinf="";
			self::$statickey="%".session('serchKey_contract')."%";$userinf="";
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
		
		if($this->sort_key_p<>''){
			if($this->sort_key_p=="name_sei"){
				if($this->asc_desc_p=="ASC"){
					$contractQuery =$contractQuery->orderBy('name_sei_kana');
				}else{
					$contractQuery =$contractQuery->orderBy('name_sei_kana', 'desc');
				}
			}else{
				if($this->asc_desc_p=="ASC"){
					$contractQuery =$contractQuery->orderBy($this->sort_key_p, 'asc');
				}else{
					$contractQuery =$contractQuery->orderBy($this->sort_key_p, 'desc');
				}
			}
		}else{
			$contractQuery =$contractQuery->orderBy('keiyaku_bi', 'desc');
		}
		if(session('target_page_for_pager')!==null){
			$targetPage=session('target_page_for_pager');
			session(['target_page_for_pager'=>null]);
		}else{
			session(['target_page_for_pager'=>null]);
		}
		if(session('targetUserSerial')!="all"){
			$targetPage=null;
		}
		$contractQuery=$contractQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',1);
    	$GoBackPlaceName="";
		foreach($_SESSION['access_history'] as $targetHistory){
			if(strpos($targetHistory,"UserList")){
				//$GoBackPlace="/ShowUserList";
                $GoBackPlace="/customers/CustomersList";
				$GoBackPlaceName="戻る";
				break;
			}else if(strpos($targetHistory,"menuStaff")){
				$GoBackPlace="";
			}
		}
		$GoBackPlace="/ShowMenuCustomerManagement/";
		$header="";$slot="";$serchKey_contract=session('serchKey_contract');
        return view('livewire.contract-list',compact("GoBackPlaceName","GoBackPlace","userinf","contractQuery","UserSerial","header","slot","serchKey_contract"));
    }
}
