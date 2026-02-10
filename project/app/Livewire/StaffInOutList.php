<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Http\Request;
use App\Http\Controllers\OtherFunc;
use App\Models\InOutHistory;
use App\Consts\initConsts;
use Illuminate\Support\Facades\Log;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Models\Staff;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Url;
use DateTime;

class StaffInOutList extends Component
{
    use WithPagination;
    public $sort_key_p = '',$asc_desc_p="",$targetPage=null,$target_day,$sort_type="",$search_sbj="month";
    public $target_staff_serial; 
    public string $searchDay = '';
    public $year_slct_id; 
    public $month_slct_id; 
    protected $download_sql;
    public function __construct(){
        $working_list_year_slct = OtherFunc::make_html_working_list_year_slct();
        $working_list_month_slct = OtherFunc::make_html_working_list_month_slct();
        //session(['target_year_StaffInOutList' => ""]);
        //session(['target_month_StaffInOutList' => ""]);
        //session(['serch_flg' => "false"]);
    }

    public function updatedSearchDay($value)
    {
        //log::alert("検索ワードが変わったDay: $value");    
        $this->target_day=$value;    
        $this->search_sbj="day";
        $this->target_year="";
        $this->target_month="";
        $this->target_page=1;
        session(['search_sbj_StaffInOutList' => "day"]);
        session(['target_year_StaffInOutList' => ""]);
        session(['target_month_StaffInOutList' => ""]);
        session(['target_day_StaffInOutList' => $this->target_day]);
        //session(['serch_flg' => "true"]);
    }

    public function del_rec($id){
        $todo = InOutHistory::find($id);
		$todo->delete();
    }
    
    static function getTime($DtTime){
        $time_array=explode(" ", $DtTime);
        $minute_array=explode(":", $time_array[1]);
        return $minute_array[0].":".$minute_array[1];
    }

    public function searchClear(){
        $this->target_staff_serial="";
		$this->target_page=null;
        $this->year_slct_id="";
        $this->month_slct_id="";
        $this->target_staff_serial="";
        $this->search_sbj="";
        $this->target_day="";
        session(['search_sbj_StaffInOutList' => ""]);
        session(['target_staff_serial_StaffInOutList' => ""]);
        session(['target_year_StaffInOutList' => ""]);
        session(['target_month_StaffInOutList' => ""]);
        session(['target_day_StaffInOutList' => ""]);
	}

    public function search_month(){
        $this->search_sbj="month";
        session(['search_sbj_StaffInOutList' => "month"]);
        session(['serch_flg_StaffInOutList' => true]);
		//$this->target_page=1;
        session(['target_year_StaffInOutList' => $this->year_slct_id]);
        session(['target_month_StaffInOutList' => $this->month_slct_id]);
        session(['target_staff_serial_StaffInOutList' => $this->target_staff_serial]);
        $this->target_day="";
        $this->target_page=1;
        session(['target_day_StaffInOutList' => ""]);
        //Log::alert("target_year-search_month=".session('target_year_StaffInOutList'));
	}

    public function sort($sort_key){
		$sort_key_array=array();    
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function render(){
        $HistoriesQuery = InOutHistory::query();
        $workListQuery = InOutHistory::query();
        //Log::alert("target_year-1=".session('target_year_StaffInOutList'));
        //if($this->search_sbj=="month"){
        if(session('search_sbj_StaffInOutList')=="month"){  
            if(empty(session('target_year_StaffInOutList'))){
                session(['target_year_StaffInOutList' => date('Y')]);
                $this->year_slct_id=date('Y');
                //Log::alert("target_year-5=".session('target_year_StaffInOutList'));
            }else{
                $this->year_slct_id=session('target_year_StaffInOutList');
            }
            //Log::alert("target_year-2=".session('target_year_StaffInOutList'));
            //session(['target_year_StaffInOutList' => $this->year_slct_id]);
            if(empty(session('target_month_StaffInOutList'))){  
                session(['target_month_StaffInOutList' => date('m')]);
                $this->month_slct_id=date('m');
            }else{
                $this->month_slct_id=session('target_month_StaffInOutList');
            }
            //session(['target_month_StaffInOutList' => $this->month_slct_id]);
            if(!empty(session('target_staff_serial_StaffInOutList'))){
                //session(['target_staff_serial_StaffInOutList' => $this->target_staff_serial]);
            }
            
            if(session('target_year_StaffInOutList')!="" and session('target_month_StaffInOutList')!=""){
                $sk=session('target_year_StaffInOutList')."-".session('target_month_StaffInOutList')."%";
                $HistoriesQuery = $HistoriesQuery->where('target_date','like',$sk);
                $workListQuery = $workListQuery->where('target_date','like',$sk);
                session(['target_day_StaffInOutList' => ""]);
            }else if(session('target_month_StaffInOutList')==""){
                $sk=session('target_year_StaffInOutList')."-%";
                $HistoriesQuery = $HistoriesQuery->where('target_date','like',$sk);
                $workListQuery = $workListQuery->where('target_date','like',$sk);
            }
            //Log::alert("target_year-3=".session('target_year_StaffInOutList'));
        }else if(session('search_sbj_StaffInOutList')=="day"){
            $HistoriesQuery = $HistoriesQuery->where('target_date',$this->target_day);
            $workListQuery = $workListQuery->where('target_date',$this->target_day);
            //$HistoriesQuery = $HistoriesQuery->where('target_date',session('target_day_StaffInOutList'));
            //$workListQuery = $workListQuery->where('target_date',session('target_day_StaffInOutList'));
        }
        if($this->target_staff_serial!="" ){
            $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            $workListQuery = $workListQuery->where('target_serial','=',$this->target_staff_serial);
        }
        if($this->sort_type<>""){
            $HistoriesQuery = $HistoriesQuery->orderBy('time_in',$this->sort_type); 
        }else{
            $HistoriesQuery = $HistoriesQuery->orderBy('time_in','desc');
        }
        //log::alert("target_year-4=".session('target_year_StaffInOutList'));
        $workListQuery = $workListQuery->orderBy('time_in','asc');
        $list_res=$workListQuery->get();
        session(['work_records' => $list_res]);
        //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page')->withQueryString();
        //$HistoriesQueryRes = $HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page')->withQueryString();
        $histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page')->withQueryString();
        //return view('livewire.staff-in-out-list',compact('histories','html_working_list_year_slct','html_working_list_month_slct'));
        return view('livewire.staff-in-out-list',compact('histories'));
            //'target_day'=>'',
            //'html_staff_inout_slct'=>OtherFunc::make_html_staff_inout_slct(session('target_staff_serial')),
            //'html_working_list_year_slct'=>OtherFunc::make_html_working_list_year_slct(),
            //'html_working_list_year_slct'=>$working_list_year_slct
            //'html_working_list_month_slct'=>OtherFunc::make_html_working_list_month_slct()
        //]);
        /*
        return view('livewire.staff-in-out-list',[
            'histories'=>$this->histories,
            //'target_day'=>'',
            //'html_staff_inout_slct'=>OtherFunc::make_html_staff_inout_slct(session('target_staff_serial')),
            //'html_working_list_year_slct'=>OtherFunc::make_html_working_list_year_slct(),
            'html_working_list_year_slct'=>$working_list_year_slct
            //'html_working_list_month_slct'=>OtherFunc::make_html_working_list_month_slct()
        ]);
        */
    }

    public function sort_day($target){
        $sort_array=explode("-", $target);
        $this->sort_type=$sort_array[1];
    }

    public function set_staff($target){
        //$this->target_staff_serial=$target;
        //session(['target_staff_serial' => $this->target_staff_serial]);
    }

    public function csv_download(){
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
        $cnt=1;
        foreach($TargetStaffSerialArray as $TargetStaffSerial){
            $staff_inf=Staff::where("serial_staff","=",$TargetStaffSerial)->first();
            if($cnt==1){
                $sheet = $spreadsheet->getActiveSheet();
            }else{
                $spreadsheet->createSheet();
                $sheet = $spreadsheet->getSheet(1);
                $sheet->setTitle('2枚目のシート');
            }
            $sheet->setTitle($staff_inf->last_name_kanji.$staff_inf->first_name_kanji);
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
            $cnt=3;
            $work_records_array=session('work_records');
            $serch_year_month=$this->year_slct_id."-".$this->month_slct_id;
            foreach ($work_records_array as $work_record) {
                if($work_record->target_serial==$TargetStaffSerial && str_contains($work_record->target_date, $serch_year_month)){
                    $sheet->setCellValue('A'.$cnt, $work_record->target_date);
                    $sheet->getStyle( 'A'.$cnt )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    $sheet->setCellValue('B'.$cnt, $work_record->time_in);
                    $sheet->getStyle( 'B'.$cnt )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    if(!empty($work_record->time_out)){
                        $sheet->setCellValue('C'.$cnt, $work_record->time_out);
                        $sheet->getStyle( 'C'.$cnt )->getAlignment()->setHorizontal('center');  // 中央寄せ
                        $sheet->setCellValue('D'.$cnt, OtherFunc::getStaffDiffAttribute($work_record->time_in,$work_record->time_out));
                        $sheet->getStyle( 'D'.$cnt )->getAlignment()->setHorizontal('center');  // 中央寄せ
                    }
                    $sheet->setCellValue('E'.$cnt, $work_record->reason_late);
                    $sheet->setCellValue('F'.$cnt, $work_record->remarks);
                    $cnt++;
                }
            }
            
            $sheet->getStyle( 'B1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getStyle( 'C1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getStyle( 'D1' )->getAlignment()->setHorizontal('center');  // 中央寄せ
            $sheet->getColumnDimension( 'A' )->setWidth( 13 );
            $sheet->getColumnDimension( 'B' )->setWidth( 20 );
            $sheet->getColumnDimension( 'C' )->setWidth( 20 );
            $sheet->getColumnDimension( 'D' )->setWidth( 10 );
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
        return response()->download($fileName);
    }
}