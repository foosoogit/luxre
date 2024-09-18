<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Http\Controllers\OtherFunc;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;

class ContractsReport extends Component
{
    public function render()
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		//OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
		/*
		if(isset($_POST['back_flg'])){
            //log::info('back_fm='.$_POST['back_flg']);
            array_shift($_SESSION['access_history']);
            array_shift($_SESSION['access_history']);
        }
		*/
		//$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		Log::alert("access_history CR=".$_SESSION['access_history'][0]);
		$target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
		Log::info($target_historyBack_inf_array);
		$html_year_slct=OtherFunc::make_html_year_slct($_POST['year']);
		$html_month_slct=OtherFunc::make_html_month_slct($_POST['month']);
		list($htm_month_table, $ruikei_keiyaku_amount ,$ruikei_contract_cnt)=OtherFunc::make_html_contract_report_table($_POST['year'],$_POST['month']);
		$contract_report_table=$htm_month_table;
		//$contract_report_table=OtherFunc::make_html_contract_report_table($_POST['year'],$_POST['month']);
		$targetYear=$_POST['year'];
		$targetMonth=$_POST['month'];
       // return view('livewire.monthly-report',compact('monthly_report_table','targetYear','targetMonth','html_year_slct','html_month_slct'));
		$value=initConsts::TargetContractMoney();
    	$targetmony_array=explode( ',', $value);
		$TargetSales="--";
    	foreach($targetmony_array as $targetmony){
    		$array=explode( '-', $targetmony);
    		if($array[0]==$targetYear and $array[1]==$targetMonth){
    			$TargetSales=$array[2];
    			break;
    		}
    	}
    	$rate="--";
    	if($TargetSales<>0 and is_null($TargetSales)==false and $TargetSales<>"" and $TargetSales<>"--"){
   			$rate=round($ruikei_keiyaku_amount/$TargetSales*100, 1);
   		}

        return view('livewire.contracts-report',compact('target_historyBack_inf_array','contract_report_table','targetYear','ruikei_keiyaku_amount','ruikei_contract_cnt','targetMonth','html_year_slct','html_month_slct','rate','TargetSales'));
    }

        //return view('livewire.contracts-report');
    //}
}
