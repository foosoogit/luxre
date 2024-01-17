<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Http\Controllers\OtherFunc;
use App\Consts\initConsts;

class YearlyReport extends Component
{
    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $yearly_report_table=OtherFunc::make_html_yearly_Report_table($_POST['year'],$_POST['kesan_month']);
        $target_year_array[0]=$_POST['year'];
        $target_year_array[1]=$_POST['year']-1;
        $target_year_array[2]=$_POST['year']-2;
        return view('livewire.yearly-report',compact('target_year_array','target_historyBack_inf_array','yearly_report_table'));
    }
}
