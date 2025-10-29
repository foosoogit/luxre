<?php

namespace App\Livewire;

use Livewire\Component;
use App\Http\Controllers\OtherFunc;
use App\Models\HandOver;
use Livewire\WithPagination;
use App\Consts\initConsts;
use Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class HandOverLW extends Component
{
    use WithPagination;
    public $kensakukey_ho,$target_date_ho,$remarks_ho,$id_txt_ho,$serch_key_month_ho,$serch_key_date_ho,$serch_key_all_ho,$sort_key_ho ,$asc_desc_ho,$handover,$daily_report,$staff_slct;
    
    public function search_all(){
        $this->serch_key_date_ho="";
        $this->serch_key_month_ho="";
    }

    public function search_date(){
        $this->serch_key_month_ho="";
        $this->serch_key_all_ho="";
        log::alert("serch_key_date_ho=".$this->serch_key_date_ho);
    }

    public function search_month(){
        $this->serch_key_date="";
        $this->serch_key_all="";
        $this->serch_key_all="";
    }

    public function searchClear(){
        $this->serch_key_month_ho="";
		$this->serch_key_all_ho="";
		$this->serch_key_date_ho="";
        session(['serchKey_handover'=>''],['asc_desc_handover' =>'Desc'],['sort_key_handover' =>'target_date']);
	}

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key_handover' =>$sort_key_array[0]]);
		session(['asc_desc_handover' =>$sort_key_array[1]]);
	}

    public function del_handover_rec($target_sirial){
		HandOver::where('id',$target_sirial)->delete();
	}

    public function submitForm(Request $request){
        $validator = Validator::make($request->all(), [
            'components.0.updates.target_date' => 'required',
            'components.0.updates.staff_slct' => 'required',
            'components.0.updates.handover' => 'required_without:components.0.updates.daily_report',
            'components.0.updates.daily_report'=> '',
        ]);
        if ($validator->fails()) {
           $this->skipRender();
        }
    }

    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $HandOverQuery=HandOver::query();
        $HandOverQuery=$HandOverQuery->leftJoin('staff', 'hand_overs.serial_staff', '=', 'staff.serial_staff')->select('staff.id as id_staff','target_date','hand_overs.serial_staff','daily_report','hand_overs.remarks','hand_overs.id as id','staff.last_name_kanji','staff.first_name_kanji','hand_overs.handover');
        if($this->serch_key_month_ho<>""){
            $key="%".$this->serch_key_month_ho."%";
            $HandOverQuery=$HandOverQuery->where('target_date','like',$key);
        }else if($this->serch_key_date_ho<>""){
            $key="%".$this->serch_key_date_ho."%";
            $HandOverQuery=$HandOverQuery->where('target_date','like',$key);
        }else if($this->serch_key_all_ho<>""){
            $key="%".$this->serch_key_all_ho."%";
            $HandOverQuery=$HandOverQuery
				->where('target_date','like',$key)
				->orwhere('handover','like',$key)
				->orwhere('daily_report','like',$key)
				->orwhere('remarks','like',$key)
				->orwhere('last_name_kanji','like',$key)
                ->orwhere('first_name_kanji','like',$key);
        }

        if(session('sort_key_handover')==null){
            session(['sort_key_handover' =>'target_date']);
        }
        $this->sort_key_ho=session('sort_key_handover');
        
		if(!isset($asc_desc_ho) and session('asc_desc_handover')==null){
			session(['asc_desc_handover' =>'desc']);
		}
		$this->asc_desc_handover=session('asc_desc_handover');

        $htm_staff_select=OtherFunc::make_html_staff_slct('');
                
        $HandOverQuery =$HandOverQuery->orderBy($this->sort_key_ho, $this->asc_desc_handover);
        //Log::alert("asc_desc_handover=".$this->asc_desc_handover);
        //Log::alert("sort_key_ho=".$this->sort_key_ho);
        $HandOverQuery=$HandOverQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        return view('livewire.hand-over-l-w',compact('htm_staff_select','HandOverQuery'));
    }}