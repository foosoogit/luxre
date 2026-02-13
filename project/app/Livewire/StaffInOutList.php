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
    private static bool $initialized = false;
    public $sort_key_p = '',$asc_desc_p="",$targetPage=null,$target_day,$sort_type="",$search_sbj,$csv_manage=false;
    public $target_staff_serial; 
    public string $searchDay = '';
    public $year_slct_id; 
    public $month_slct_id;
    
    public $html_working_list_year_slct;
    public $html_working_list_month_slct;
    public $html_staff_inout_slct;

    //public $workListQuery;
    //public $HistoriesQuery;
    
    protected $download_sql;

    public function __construct(){
        $this->html_working_list_year_slct = OtherFunc::make_html_working_list_year_slct('');
        $this->html_working_list_month_slct = OtherFunc::make_html_working_list_month_slct('');
        $this->html_staff_inout_slct = OtherFunc::make_html_staff_inout_slct("");
        if (empty(session('int_flg_StaffInOutList')) || session('int_flg_StaffInOutList') === false) {
            session(['target_month_StaffInOutList' => "now"],['target_year_StaffInOutList' => "now"],['search_sbj_StaffInOutList' => "month"]);
            $this->month_slct_id = (int)date('m');
            $this->year_slct_id = (int)date('Y');
            session(['int_flg_StaffInOutList' => true]);
            return;
        }else{
            if(empty(session('search_sbj_StaffInOutList'))){
                $this->month_slct_id = "";
                $this->year_slct_id = "";
            }else{
                $this->month_slct_id = (int)session('target_month_StaffInOutList');
                $this->year_slct_id = (int)session('target_year_StaffInOutList');
            }
            return;
        }
    }
    public function search_day(){
        $this->search_sbj="day";
        $this->target_year="";
        $this->target_month="";
        session(['search_sbj_StaffInOutList' => "day"]);
        session(['target_year_StaffInOutList' => ""]);
        session(['target_month_StaffInOutList' => ""]);
        session(['target_day_StaffInOutList' => $this->target_day]);
        $this->resetPage();
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
        $this->resetPage();
	}

    public function search_month(){
        $this->search_sbj="month";
        session(['search_sbj_StaffInOutList' => "month"]);
        session(['target_year_StaffInOutList' => $this->year_slct_id]);
        session(['target_month_StaffInOutList' => $this->month_slct_id]);
        session(['target_staff_serial_StaffInOutList' => $this->target_staff_serial]);
        $this->target_day="";
        session(['target_day_StaffInOutList' => ""]);
        $this->resetPage();
	}

    public function sort($sort_key){
		$sort_key_array=array();    
		$sort_key_array=explode("-", $sort_key);
		session(['sort_key' =>$sort_key_array[0]]);
		session(['asc_desc' =>$sort_key_array[1]]);
	}

    public function get_query_string($key){
        //$query_string="";
        $this->HistoriesQuery = InOutHistory::query();
        $this->workListQuery = InOutHistory::query();
        if(session('search_sbj_StaffInOutList')=="month"){  
            if(empty(session('target_year_StaffInOutList'))){
                session(['target_year_StaffInOutList' => date('Y')]);
                $this->year_slct_id=date('Y');
            }else{
                //session(['target_year_StaffInOutList' => date('Y')]);
                //$this->year_slct_id=session('target_year_StaffInOutList');
                //Log::alert("year_slct_id-2=".$this->year_slct_id);
            }
            
            if(empty(session('target_month_StaffInOutList'))){
                session(['target_month_StaffInOutList' => date('m')]);
                $this->month_slct_id=str_replace("0", "", date('m'));
            }else{
                //log::alert("target_month-2=".session('target_month_StaffInOutList'));  
                //$this->month_slct_id=session('target_month_StaffInOutList');
                //Log::alert("month_slct_id-2=".$this->month_slct_id);
            }
            if(!empty(session('target_staff_serial_StaffInOutList'))){
                //session(['target_staff_serial_StaffInOutList' => $this->target_staff_serial]);
            }
            $sk=session('target_year_StaffInOutList')."-".sprintf('%02d', session('target_month_StaffInOutList'))."%";
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_date','like',$sk);
            if($this->csv_manage){$this->workListQuery = $this->workListQuery->where('target_date','like',$sk);}
            session(['target_day_StaffInOutList' => ""]);$this->target_day="";
        }else if(session('search_sbj_StaffInOutList')=="day"){
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_date',session('target_day_StaffInOutList'));
            if($this->csv_manage){$this->workListQuery = $this->workListQuery->where('target_date',session('target_day_StaffInOutList'));}
        }
        if($this->target_staff_serial!="" ){
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            if($this->csv_manage){$this->workListQuery = $this->workListQuery->where('target_serial','=',$this->target_staff_serial);}
        }
        if($this->sort_type<>""){
            $this->HistoriesQuery = $this->HistoriesQuery->orderBy('time_in',$this->sort_type); 
        }else{
            $this->HistoriesQuery = $this->HistoriesQuery->orderBy('time_in','desc');
        }
        //return $query_string;
    }

    public function render(){
        //$this->HistoriesQuery = InOutHistory::query();
        //$this->workListQuery = InOutHistory::query();
        //Log::alert("target_year=".session('target_year_StaffInOutList'));
        //Log::alert("target_month=".session('target_month_StaffInOutList'));
        //log::alert("m=".date('m'));
        self::get_query_string("");
        /*

        if(session('search_sbj_StaffInOutList')=="month"){  
            if(empty(session('target_year_StaffInOutList'))){
                session(['target_year_StaffInOutList' => date('Y')]);
                $this->year_slct_id=date('Y');
            }else{
                //session(['target_year_StaffInOutList' => date('Y')]);
                //$this->year_slct_id=session('target_year_StaffInOutList');
                //Log::alert("year_slct_id-2=".$this->year_slct_id);
            }
            
            if(empty(session('target_month_StaffInOutList'))){
                session(['target_month_StaffInOutList' => date('m')]);
                $this->month_slct_id=str_replace("0", "", date('m'));
            }else{
                //log::alert("target_month-2=".session('target_month_StaffInOutList'));  
                //$this->month_slct_id=session('target_month_StaffInOutList');
                //Log::alert("month_slct_id-2=".$this->month_slct_id);
            }
            if(!empty(session('target_staff_serial_StaffInOutList'))){
                //session(['target_staff_serial_StaffInOutList' => $this->target_staff_serial]);
            }
            $sk=session('target_year_StaffInOutList')."-".sprintf('%02d', session('target_month_StaffInOutList'))."%";
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_date','like',$sk);
            $this->workListQuery = $this->workListQuery->where('target_date','like',$sk);
            session(['target_day_StaffInOutList' => ""]);$this->target_day="";
        }else if(session('search_sbj_StaffInOutList')=="day"){
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_date',session('target_day_StaffInOutList'));
            $this->workListQuery = $this->workListQuery->where('target_date',session('target_day_StaffInOutList'));
        }
        */
        /*
        if($this->target_staff_serial!="" ){
            $this->HistoriesQuery = $this->HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            $this->workListQuery = $this->workListQuery->where('target_serial','=',$this->target_staff_serial);
        }
        if($this->sort_type<>""){
            $this->HistoriesQuery = $this->HistoriesQuery->orderBy('time_in',$this->sort_type); 
        }else{
            $this->HistoriesQuery = $this->HistoriesQuery->orderBy('time_in','desc');
        }
       
        */
        /*
        if($this->manage_type=="csv_download"){
            log::alert("manage_type=".$this->manage_type);
            $work_records_array = $this->workListQuery->orderBy('time_in','asc')->get();
            session(['work_records' => $work_records_array]);
            $this->manage_type="";
        }
        */
        $histories=$this->HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page')->withQueryString();
        return view('livewire.staff-in-out-list',compact('histories'));
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
        Log::info($TargetStaffSerialArray);
        
        $cnt=1;
        foreach($TargetStaffSerialArray as $TargetStaffSerial){
            Log::alert("cnt=".$cnt);
            $staff_inf=Staff::where("serial_staff","=",$TargetStaffSerial)->first();
            log::info($staff_inf);
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
            //$work_records_array = session('work_records', []);
            //$work_records_array=$this->workListQuery->get();
            //$work_records_array = $this->workListQuery->orderBy('time_in','asc')->get();
            $serch_year_month=$this->year_slct_id."-".sprintf("%02d", $this->month_slct_id);
            //Log::alert("serch_year_month=".$serch_year_month);
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