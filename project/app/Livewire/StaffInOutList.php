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

class StaffInOutList extends Component
{
    use WithPagination;
    public $sort_key_p = '',
        $asc_desc_p="",
        $serch_key_p="",
        $targetPage=null,
        $target_day="",
        $sort_type="",
        $target_staff_serial="",
        $target_year="",
        $target_month="";
	public $kensakukey="";
    public static $key="";
    protected $histories,
        $download_sql;

    static function getTime($DtTime){
        $time_array=explode(" ", $DtTime);
        $minute_array=explode(":", $time_array[1]);
        return $minute_array[0].":".$minute_array[1];
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
            $cnt=3;
            $work_records_array=session('work_records');
            foreach ($work_records_array as $work_record) {
                if($work_record->target_serial==$TargetStaffSerial){
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
        date("Y-m-d");
        if(count($TargetStaffSerialArray)==1){
            $fileName = 'WorkingTimeList_'.$staff_inf->last_name_kanji.$staff_inf->first_name_kanji.'_'.date("Y_m_d").'.xlsx';
        }else{
            $fileName = 'WorkingTimeList_all_'.date("Y_m_d").'.xlsx';
        }
        $writer->save($fileName);
        //File::copy($fileName, "t-".$fileName);
        //$ext = File::extension($fileName);
        //Log::alert("ext=".$ext);
        $filePath = $fileName;
        //$fileName = 'susr.xlsx';
        //$mimeType = Storage::mimeType($filePath);
        $mimeType = File::mimeType($filePath);
            $headers = [['Content-Type' => $mimeType,
                  'Content-Disposition' => 'attachment; filename*=UTF-8\'\''.rawurlencode($fileName)
            ]];
        //File::download($filePath, $fileName, $headers);
        //File::download($fileName);
        return response()->download($fileName);


        /*
        
        
        response()->download($fileName)->deleteFileAfterSend(true);

        
$filePath = 'app/public/'.$fileName;
$public = Storage::disk('public');
Log::alert("public=".$public);

//$fileName = '$fileName';

//$mimeType = Storage::mimeType($filePath);
//$mimeType = Storage::mimeType($public."/".$fileName);
$mimeType = Storage::mimeType("text/csv");

$headers = [['Content-Type' => $mimeType]];
*/
//Storage::download($public, $fileName, $headers);

        //$writer->save('php://output'); // download file 
        /*
        
        */
    }
    public function search_month($target_year,$target_month){
		$this->target_year=$target_year;
        $this->target_month=$target_month;
        $this->target_day="";

	}
    public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
        $this->target_staff_serial="";
		$this->target_page=null;
        $this->target_year="";
        $this->target_month="";
        $this->target_day="";
		session(['serchKey' => '']);
        session(['target_staff_serial' => ""]);
	}

    public function search(){
		$this->serch_key_p=$this->kensakukey;
		$this->target_page=1;
		session(['serchKey' => $this->kensakukey]);
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
        if($this->target_year<>"" and $this->target_month<>""){
            $HistoriesQuery = $HistoriesQuery->where('target_date','like',$this->target_year."-".$this->target_month."%");
            $workListQuery = $workListQuery->where('target_date','like',$this->target_year."-".$this->target_month."%");
            $this->target_day="";
        }
         
        //if($this->target_staff_serial<>""){
        if(!empty(session('target_staff_serial'))){
            $this->target_staff_serial=session('target_staff_serial');
            $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            $workListQuery = $workListQuery->where('target_serial','=',$this->target_staff_serial);
        }

        if($this->target_day<>""){
            $HistoriesQuery = $HistoriesQuery->where('target_date','=',$this->target_day);
            $workListQuery = $workListQuery->where('target_date','=',$this->target_day);
            $this->target_year="";
            $this->target_month="";
        }else{
            $this->target_day="";
        }
        if($this->sort_type<>""){
            $HistoriesQuery = $HistoriesQuery->orderBy('time_in',$this->sort_type); 
        }else{
            $HistoriesQuery = $HistoriesQuery->orderBy('time_in','desc');
        }
        $workListQuery = $workListQuery->orderBy('time_in','asc');
        //$this->download_sql=$HistoriesQuery;
        $list_res=$workListQuery->get();
        session(['work_records' => $list_res]);
        //$HistoriesQuery->dump();
        //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page',1);
        $this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page');
        return view('livewire.staff-in-out-list',[
            'histories'=>$this->histories,
            'target_day'=>'',
            'html_staff_inout_slct'=>OtherFunc::make_html_staff_inout_slct(session('target_staff_serial')),
            'html_working_list_year_slct'=>OtherFunc::make_html_working_list_year_slct(),
            'html_working_list_month_slct'=>OtherFunc::make_html_working_list_month_slct()
        ]);
        //return view('livewire.staff-in-out-list');
    }

    public function sort_day($target){
        $sort_array=explode("-", $target);
        $this->sort_type=$sort_array[1];
    }
    public function search_day($target){
        $this->target_year="";
        $this->target_month="";
        $this->target_day=$target;
    }

    public function set_staff($target){
        $this->target_staff_serial=$target;
        session(['target_staff_serial' => $this->target_staff_serial]);
    }

    /*
    public function search_staff(){
        $this->target_staff_serial=
        //try {
            //$HistoriesQuery = InOutHistory::query();
            //$workListQuery = InOutHistory::query();
            if($this->target_year<>"" and $this->target_month<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','like',$this->target_year."-".$this->target_month."%");
                $workListQuery = $workListQuery->where('target_date','like',$this->target_year."-".$this->target_month."%");
                $this->target_day="";
            }
            //if($this->target_staff_serial<>"" or !empty(session('target_staff_serial'))){
            
            if($this->target_staff_serial<>"" and !empty(session('target_staff_serial'))){
                session(['target_staff_serial' => $this->target_staff_serial]);
                $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
                $workListQuery = $workListQuery->where('target_serial','=',$this->target_staff_serial);
            }else if($this->target_staff_serial<>"" and empty(session('target_staff_serial'))){
                session(['target_staff_serial' => $this->target_staff_serial]);
                $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
                $workListQuery = $workListQuery->where('target_serial','=',$this->target_staff_serial);
                
            }else if($this->target_staff_serial=="" and !empty(session('target_staff_serial'))){
                $this->target_staff_serial=session('target_staff_serial');
                $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
                $workListQuery = $workListQuery->where('target_serial','=',$this->target_staff_serial);
            }
            if($this->target_day<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','=',$this->target_day);
                $workListQuery = $workListQuery->where('target_date','=',$this->target_day);
                $this->target_year="";
                $this->target_month="";
            }else{
                $this->target_day="";
            }
            if($this->sort_type<>""){
                $HistoriesQuery = $HistoriesQuery->orderBy('time_in',$this->sort_type); 
            }else{
                $HistoriesQuery = $HistoriesQuery->orderBy('time_in','desc');
            }
            $workListQuery = $workListQuery->orderBy('time_in','asc');
            //$this->download_sql=$HistoriesQuery;
            $list_res=$workListQuery->get();
            session(['work_records' => $list_res]);
            //$HistoriesQuery->dump();
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page',1);
            $this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'],'page');
            //$this->histories->dump();
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumStudentsList(),['*'], 'page',1);
        //} catch (QueryException $e) {
            //Log::alert("QueryException=".$e);
            //return redirect('Students.List'); 
        //}
        //$this->targetPage=null;
    }
    */
}