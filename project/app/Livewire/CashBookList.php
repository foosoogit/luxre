<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Consts\initConsts;
use Livewire\WithPagination;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Log;
use App\Models\CashBook;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Support\Facades\DB;
if(!isset($_SESSION)){session_start();}

class CashBookList extends Component
{
    use WithPagination;

    public $test,$kensakukey,$target_date,$payment,$deposit,$summary,$amount,$remarks,$id_txt,$serch_key_month,$serch_key_date,$serch_key_all,$serch_key_payment,$serch_key_deposit,$asc_desc_p;

    public function del_cash_book_rec($target_sirial){
		CashBook::where('id',$target_sirial)->delete();
	}

    public function sort($sort_key){
		$sort_key_array=array();
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key_cashbook' =>$sort_key_array[0]]);
		session(['asc_desc_cashbook' =>$sort_key_array[1]]);
	}

    public function search_all(){
        $this->serch_key_date="";
        $this->serch_key_month="";
        //session(['sort_key_cashbook' =>'target_date']);
        //session(['asc_desc_cashbook' =>'desc']);
        //session(['serch_key_all_cashbook' => $this->serch_key_all]);

        session([
            'asc_desc_cashbook' =>'Desc',
            'sort_key_cashbook' =>'target_date',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>'',
            'serch_key_all_cashbook' =>$this->serch_key_all
        ]);
    }

    public function searchClear(){
		session(['sort_key_cashbook' =>'target_date']);
        session(['asc_desc_cashbook' =>'desc']);
        $this->serch_key_month="";
        $this->serch_key_date="";
		$this->serch_key_all="";
		$this->serch_key_date="";
        session([
            'serch_payment_flg'=>'checked',
            'serch_deposit_flg'=>'checked',
            'asc_desc_cashbook' =>'Desc',
            'sort_key_cashbook' =>'target_date',
            'serch_key_month_CashBook' =>'',
            'serch_key_date_CashBook' =>'',
            'serch_key_all_cashbook' =>''
        ]);
	}

    public function serch_payment(){
        if(session('serch_payment_flg')=="checked"){
            session(['serch_payment_flg' => ""]);
        }else{
            session(['serch_payment_flg' => "checked"]);
        }
    }
    
    public function serch_deposit(){
        if(session('serch_deposit_flg')=="checked"){
            session(['serch_deposit_flg' => ""]);
        }else{
            session(['serch_deposit_flg' => "checked"]);
        }
    }

    public function search_month(){
        $this->serch_key_date="";
        $this->serch_key_all="";
        session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook' =>'',
            'serch_key_month_CashBook' => $this->serch_key_month,
            'serch_key_date_CashBook' =>''
        ]);
    }

    public function search_date(){
        $this->serch_key_month="";
        $this->serch_key_all="";
        Session([
            'sort_key_cashbook' =>'target_date',
            'asc_desc_cashbook' =>'desc',
            'serch_key_all_cashbook' =>'',
            'serch_key_month_CashBook' => '',
            'serch_key_date_CashBook' => $this->serch_key_date
        ]);
    }

    public function del($id){
        $CashBook = CashBook::find($id);
        $CashBook->delete();
    }
    public function submitForm(Request $request){
        $validator = Validator::make($request->all(), [
            'components.0.updates.target_date' => 'required',
            'components.0.updates.payment_deposit_rdo' => 'required',
            'components.0.updates.summary' => 'required',
            'components.0.updates.amount'=> 'required',
        ]);
        if ($validator->fails()) {
           $this->skipRender();
        }
    }

    public function render(Request $request)
    {
        OtherFunc::set_access_history($_SERVER['HTTP_REFERER']);

        $balance=CashBook::select(DB::raw('SUM(deposit -  payment) as balance'))
            ->value('balance');
        $CashBookQuery=CashBook::query();
        $balance_Query=CashBook::query();
        $CashBookQuery=$CashBookQuery->where('branch',session('target_branch_serial'));
        $balance_Query=$balance_Query->where('branch',session('target_branch_serial'));
        if(session('serch_key_month_CashBook')<>""){
            $key="%".session('serch_key_month_CashBook')."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if(session('serch_key_date_CashBook')<>""){
            $key="%".session('serch_key_date_CashBook')."%";
            $CashBookQuery=$CashBookQuery->where('target_date','like',$key);
            $balance_Query=$balance_Query->where('target_date','like',$key);
        }else if($this->serch_key_all<>""){
            $key="%".$this->serch_key_all."%";
            $CashBookQuery=$CashBookQuery
				->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
            $balance_Query=$balance_Query
                ->where('target_date','like',$key)
				->orwhere('summary','like',$key)
				->orwhere('payment','like',$key)
				->orwhere('deposit','like',$key)
				->orwhere('remarks','like',$key);
        }

        if(session('serch_payment_flg')=="checked" &&  empty(session('serch_deposit_flg'))){
            $CashBookQuery=$CashBookQuery->where('in_out','=','payment');
            $balance_Query=$balance_Query->where('in_out','=','payment');
        }else if(empty(session('serch_payment_flg')) && session('serch_deposit_flg')=="checked"){
            $CashBookQuery=$CashBookQuery->where('in_out','=','deposit');
            $balance_Query=$balance_Query->where('in_out','=','deposit');
        }
        
        $target_historyBack_inf_array=initConsts::TargetPageInf($_SESSION['access_history'][0]);
        $newCashBookQuerySerial="";
        if(empty(session('asc_desc_cashbook'))){
            session(['asc_desc_cashbook' =>'desc']);
        }
        if(empty(session('sort_key_cashbook'))){
            session(['sort_key_cashbook' =>'target_date']);
        }
        if(session('sort_key_cashbook')=="target_date"){
            $CashBookQuery =$CashBookQuery->orderBy('target_date', session('asc_desc_cashbook'))->orderBy('created_at', session('asc_desc_cashbook'));
        }else{
            $CashBookQuery =$CashBookQuery->orderBy(session('sort_key_cashbook'), session('asc_desc_cashbook'));
        }
        $CashBookQuery=$CashBookQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
        $balance_res=$balance_Query->get();
        $serch_payment_sum=$balance_res->sum('IntPayment');
        $serch_deposit_sum=$balance_res->sum('IntDeposit');
        $serch_balance=$serch_deposit_sum-$serch_payment_sum;
        $this->serch_key_month=session('serch_key_month_CashBook');
        $this->serch_key_date=session('serch_key_date_CashBook');
        $this->serch_key_all=session('serch_key_all_cashbook');
        return view('livewire.cash-book-list',compact('serch_balance','serch_deposit_sum','serch_payment_sum','balance','target_historyBack_inf_array','CashBookQuery','newCashBookQuerySerial'));
    }

    public function csv_download(){
        $this->csv_manage=true;
        self::search_month();
        self::get_query_string("");
        $spreadsheet = new Spreadsheet();
        $TargetStaffSerialArray=array();
        if($this->target_staff_serial==""){
            $staff_array=Staff::get();
            foreach ($staff_array as $staff) {
                $TargetStaffSerialArray[]= $staff->serial_staff;
            }
        }else{
            $TargetStaffSerialArray[]=$this->target_staff_serial;
        }
        //Log::info($TargetStaffSerialArray);
        
        $cnt=1;
        foreach($TargetStaffSerialArray as $TargetStaffSerial){
            //Log::alert("cnt=".$cnt);
            $staff_inf=Staff::where("serial_staff","=",$TargetStaffSerial)->first();
            //log::info($staff_inf);
            if($cnt==1){
                $sheet = $spreadsheet->getActiveSheet()->setTitle($staff_inf->last_name_kanji.$staff_inf->first_name_kanji);
            }else{
                //$sheet=$spreadsheet->createSheet()->setTitle('明細2');
                $sheet = $spreadsheet->createSheet();
                $sheet->setTitle($staff_inf->last_name_kanji.$staff_inf->first_name_kanji);
                //$spreadsheet->createSheet()->setTitle($staff_inf->last_name_kanji.$staff_inf->first_name_kanji);
                //$spreadsheet->addSheet(new Worksheet($spreadsheet, $staff_inf->last_name_kanji.$staff_inf->first_name_kanji));
                //$sheet = $spreadsheet->getActiveSheet($cnt-1);
                //$sheet->setTitle('2枚目のシート');
            }
            //$sheet->setTitle($staff_inf->last_name_kanji.$staff_inf->first_name_kanji);
            $sheet->setCellValue('A1', '氏名');
            $sheet->setCellValue('B1', $staff_inf->last_name_kanji." ".$staff_inf->first_name_kanji);
            $sheet->setCellValue('C1', 'Staff No.');
            $sheet->setCellValue('D1', $staff_inf->serial_staff);
            $sheet->setCellValue('A2', '日付');
            $sheet->getStyle( 'A2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->setCellValue('B2', '入勤時間');
            $sheet->getStyle( 'B2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->setCellValue('C2', '退勤時間');
            $sheet->getStyle( 'C2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->setCellValue('D2', '労働時間(分)');
            $sheet->getStyle( 'D2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->setCellValue('E2', '遅刻理由');
            $sheet->getStyle( 'E2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->setCellValue('F2', '備考');
            $sheet->getStyle( 'F2' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $row=3;
            $work_records_array=$this->workListQuery->orderBy('time_in','asc')->get();
            $serch_year_month=$this->year_slct_id."-".sprintf("%02d", $this->month_slct_id);
            foreach ($work_records_array as $work_record) {
                if($work_record->target_serial==$TargetStaffSerial && str_contains($work_record->target_date, $serch_year_month)){
                    $sheet->setCellValue('A'.$row, $work_record->target_date);
                    $sheet->getStyle( 'A'.$row )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    $sheet->setCellValue('B'.$row, $work_record->time_in);
                    $sheet->getStyle( 'B'.$row )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    if(!empty($work_record->time_out)){
                        $sheet->setCellValue('C'.$row, $work_record->time_out);
                        $sheet->getStyle( 'C'.$row )->getAlignment()->setHorizontal('center');  // 中央寄せ
                        $sheet->setCellValue('D'.$row, OtherFunc::getStaffDiffAttribute($work_record->time_in,$work_record->time_out));
                        $sheet->getStyle( 'D'.$row )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    }
                    $sheet->setCellValue('E'.$row, $work_record->reason_late);
                    $sheet->setCellValue('F'.$row, $work_record->remarks);
                    $row++;
                }
            }
            
            $sheet->getStyle( 'B1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getStyle( 'C1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getStyle( 'D1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getColumnDimension( 'A' )->setWidth( 13 );
            $sheet->getColumnDimension( 'B' )->setWidth( 20 );
            $sheet->getColumnDimension( 'C' )->setWidth( 20 );
            $sheet->getColumnDimension( 'D' )->setWidth( 10 );
            $cnt=$cnt+1;
        }
        $writer = new Xlsx($spreadsheet);
        if(count($TargetStaffSerialArray)==1){
            $fileName = 'WorkingTimeList_'.$staff_inf->last_name_kanji.$staff_inf->first_name_kanji.'_'.date("Y_m_d").'.xlsx';
        }else{
            $fileName = 'WorkingTimeList_all_'.date("Y_m_d").'.xlsx';
        }
        $writer->save($fileName);
        $filePath = $fileName;
        $mimeType = File::mimeType($filePath);
            $headers = [['Content-Type' => $mimeType,
                  'Content-Disposition' => 'attachment; filename*=UTF-8\'\''.rawurlencode($fileName)
            ]];
        $this->csv_manage=false;
        return response()->download($fileName);
    }
}