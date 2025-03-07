<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Models\PaymentHistory;
use App\Models\SalesRecord;
use App\Models\Good;
use App\Consts\initConsts;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Log;

class MonthlyReport extends Component
{
    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		$split_year_month_day_array=array();
    	if(isset($_POST['year_month_day'])){
    		$split_year_month_day_array=explode( '-', $_POST['year_month_day'] );
    		$targetYear=$split_year_month_day_array[0];
    		$targetMonth=$split_year_month_day_array[1];
    	}else if(isset($_POST['year'])){
			$targetYear=$_POST['year'];
    		$targetMonth=$_POST['month'];
    	}else{
			$target_year_array=explode("-", $_SESSION['backmonthday']);
    	    $targetYear=$target_year_array[0];
			$targetMonth=$target_year_array[1];
		}
   	
    	$RaitenReason="来店理由 : ".OtherFunc::get_raitenReason($targetYear,$targetMonth);
    	$html_year_slct=OtherFunc::make_html_year_slct($targetYear);
		$html_month_slct=OtherFunc::make_html_month_slct($targetMonth);
    	$monthly_report_table=OtherFunc::make_html_monthly_report_table($targetYear,$targetMonth);
        return view('livewire.monthly-report',compact('target_historyBack_inf_array','monthly_report_table','targetYear','targetMonth','html_year_slct','html_month_slct','RaitenReason'));
    }
}
