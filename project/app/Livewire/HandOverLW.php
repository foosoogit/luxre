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
    public $kensakukey_ho,$target_date_ho,$remarks_ho,$id_txt_ho,$serch_key_month_ho,$serch_key_date_ho,$serch_key_all_ho,$sort_key_ho ,$asc_desc_ho,$sentence,$staff_slct,$error_flg_hdn;
    
    public function search_all(){
        $this->serch_key_date_ho="";
        $this->serch_key_month_ho="";
    }

    public function search_date(){
        $this->serch_key_month_ho="";
        $this->serch_key_all_ho="";
        //log::alert("serch_key_date_ho=".$this->serch_key_date_ho);
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
        Log::alert("HandOver_DaylyRepo=".$request->HandOver_DaylyRepo_rbn);
        Log::alert("target_date=".$request->target_date);
        Log::info($request->all());
        $validator = Validator::make($request->all(), [
            //'HandOver_DaylyRepo_rbn'=> 'required',
            'components.0.updates.target_date' => 'required',
            'components.0.updates.staff_slct' => 'required',
            'components.0.updates.sentence' => 'required',
            //'components.0.updates.HandOver_DaylyRepo_rbn' => 'required',
            //'components.0.updates.customer_txt'=> 'required_if:HandOver_DaylyRepo_rbn,HandOver',
            //'components.0.updates.handover' => 'required_without:components.0.updates.daily_report',
            //'components.0.updates.daily_report'=> '',
        ]);
        LOG::alert("fails=".$validator->fails());
        if ($validator->fails()) {
           $this->skipRender();
        }
        Log::alert("error_flg_hdn=".$this->error_flg_hdn);
        if($this->error_flg_hdn=='1'){
            $this->skipRender();
        }
        if($this->sentence==""){
             $this->skipRender();
        }
        //$request->error_flg_hdn='0';
    }

    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        $HandOverQuery=HandOver::query();
        $HandOverQuery=$HandOverQuery->leftJoin('staff', 'hand_overs.serial_staff', '=', 'staff.serial_staff')->select('target_customaer_serial','staff.id as id_staff','target_date','hand_overs.serial_staff','sentence','type_flag','hand_overs.remarks','hand_overs.id as id','staff.last_name_kanji','staff.first_name_kanji');
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