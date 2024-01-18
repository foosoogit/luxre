<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\TreatmentContent;
use App\Consts\initConsts;
use App\Http\Controllers\OtherFunc;

class TreatmentList extends Component
{
    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        if(isset($_POST['back_flg'])){
            array_shift($_SESSION['access_history']);
            array_shift($_SESSION['access_history']);
        }
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $treatment_contents=TreatmentContent::paginate(initConsts::DdisplayLineNumCustomerList());
		return view('livewire.treatment-list',compact('target_historyBack_inf_array','treatment_contents'));
    }
}
