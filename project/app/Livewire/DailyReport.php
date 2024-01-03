<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Contract;
use App\Models\PaymentHistory;
use App\Models\SalesRecord;
use App\Models\Good;
use App\Consts\initConsts;
use App\Library\OtherFunc;
if(!isset($_SESSION)){session_start();}

class DailyReport extends Component
{
    public function sort($sort_key){
        $sort_key_array=array();
        $sort_key_array=explode("-", $sort_key);
        $this->sort_key_p=$sort_key_array[0];
        $this->asc_desc_p=$sort_key_array[1];
        session(['sort_key' =>$sort_key_array[0]]);
        session(['asc_desc' =>$sort_key_array[1]]);
    }
  
    public function render()
        {
        $header="";$slot="";
        $today = date("Y-m-d");
        $from_place="";
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);
        //print_r($_SESSION['access_history']);
        $backmonthly="";
        foreach($_SESSION['access_history'] as $targeturl){
            if(strpos($targeturl, 'ShowMonthlyReport') !== false){
                $backmonthly=true;
                break;
            }else if (strpos($targeturl, 'ShowMenuCustomerManagement') !== false){
                $backmonthly=false;
                break;
            }
        }
        if($backmonthly===true){
            if(isset($_POST['target_date_from_monthly_rep'])){
                $today=$_POST['target_date_from_monthly_rep'];
            }else{
                $today=$_SESSION['backmonthday'];
            }
            $from_place="monthly_rep";
        }else if(isset($_POST['target_date'])){
            $today=$_POST['target_date'];
            //print "test1<br>";
        }else if(isset($_POST['target_date_from_monthly_rep'])){
            //print "test<br>";
            $today=$_POST['target_date_from_monthly_rep'];
            $from_place="monthly_rep";
        }
        
        $PaymentHistories=PaymentHistory::where('date_payment','=',$today)
            ->leftJoin('users', 'payment_histories.serial_user', '=', 'users.serial_user')
            ->paginate(initConsts::DdisplayLineNumCustomerList());
        $subtotal_treatment=PaymentHistory::where('date_payment','=',$today)->sum('amount_payment');
    
        $subtotal_treatment=PaymentHistory::where('date_payment','=',$today)->sum('amount_payment');
        
        $SalesRecords=SalesRecord::where('date_sale','=',$today)
            ->leftJoin('users', 'sales_records.serial_user', '=', 'users.serial_user')
            ->leftJoin('goods', 'sales_records.serial_good', '=', 'goods.serial_good')
            ->paginate(initConsts::DdisplayLineNumCustomerList());
            
        $subtotal_good=SalesRecord::where('date_sale','=',$today)->sum('selling_price');
        $total=$subtotal_treatment+$subtotal_good;
        $Sum=array();
        $Sum['cash']=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('keiyakus', 'payment_histories.serial_keiyaku', '=', 'keiyakus.serial_keiyaku')
                ->where('payment_histories.how_to_pay','=','cash')
                //->where('keiyakus.how_many_pay_genkin','=','1')
                 ->where(function($query) {
                    $query->where('keiyakus.how_many_pay_genkin','=','1')->orWhere('keiyakus.how_many_pay_card','=','1');
                })
            ->sum('amount_payment');
    
        $Sum['card']=PaymentHistory::where('date_payment','=',$today)
                ->where('date_payment','=',$today)
                ->where('how_to_pay','=','card')
            ->sum('amount_payment');
    
        $Sum['paypay']=PaymentHistory::where('date_payment','=',$today)
                ->where('date_payment','=',$today)
                ->where('how_to_pay','=','paypay')
            ->sum('amount_payment');
    
    
        $Sum['CashSplit']=PaymentHistory::where('date_payment','=',$today)
                ->leftJoin('keiyakus', 'payment_histories.serial_keiyaku', '=', 'keiyakus.serial_keiyaku')
                ->where('payment_histories.how_to_pay','=','cash')
                //->where('keiyakus.how_many_pay_genkin','>','1')
                 ->where(function($query) {
                    $query->where('keiyakus.how_many_pay_genkin','>','1')->orWhere('keiyakus.how_many_pay_card','>','1');
                })
    
                //->where('keiyakus.how_many_pay_genkin','>','1')
                ->sum('amount_payment');
        
        $Sum['total_cash']=$Sum['cash']+$Sum['CashSplit'];
        $Sum['total']=$Sum['cash']+$Sum['card']+$Sum['CashSplit']+$Sum['paypay'];
        //if($Sum['CashSplit']<>""){$Sum['CashSplit']=number_format($Sum['CashSplit']);}
        //if($Sum['card']<>""){$Sum['card']=number_format($Sum['card']);}
        //if($Sum['cash']<>""){$Sum['cash']=number_format($Sum['cash']);}
        session(['targetDay' => $today]);
        $_SESSION['backmonthday']=$today;
        return view('livewire.daily-report',compact('PaymentHistories','SalesRecords','header','slot','today','subtotal_treatment','subtotal_good','total','Sum','from_place'));
    }
}
