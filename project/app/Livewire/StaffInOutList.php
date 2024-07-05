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

class StaffInOutList extends Component
{
    use WithPagination;
    public $sort_key_p = '',$asc_desc_p="",$serch_key_p="",$targetPage=null,$target_day="",$sort_type="",$target_staff_serial="",$target_year="",$target_month="";
	public $kensakukey="";
    public static $key="";
    protected $histories;

    public function csv_download(){
        //Log::alert("message");
        $spreadsheet = new Spreadsheet();

        $sheet = $spreadsheet->getActiveSheet();

        $HistoriesQuery = InOutHistory::query();
            if($this->target_staff_serial<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            }else{
                $this->target_staff_serial=""; 
            }
            if($this->target_day<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','=',$this->target_day);
            }else{
                $this->target_day="";
            }
        $sheet->setCellValue('A1', 'Hello-3');
        $sheet->setCellValue('B1', 'World-3 !');

        $writer = new Xlsx($spreadsheet);
        date("Y-m-d"); 
        $fileName = 'WorkingTimeList_'.date("Y_m_d").'.xlsx';
        //Log::alert("fileName=".$fileName);
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
		$this->$target_year=$target_year;
        $this->$target_month=$target_month;
		Log::alert("target_year=".$target_year);
        Log::alert("target_month=".$target_month);
		//session(['serchKey' => $this->kensakukey]);
	}
    public function searchClear(){
		$this->serch_key_p="";
		$this->kensakukey="";
        $this->target_staff_serial="";
		$this->target_page=null;
        $this->$target_year="";
        $this->$target_month="";
        $this->target_day="";
		session(['serchKey' => '']);
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
        $this->search_staff();
        //$html_working_list_year_slct=OtherFunc::make_html_working_list_year_slct();
        //Log::alert("html_working_list_year_slct=".$html_working_list_year_slct);
        //$html_working_list_month_slct=OtherFunc::make_html_working_list_month_slct();
       //$html_staff_inout_slct=OtherFunc::make_html_staff_inout_slct("");
        return view('livewire.staff-in-out-list',[
            'histories'=>$this->histories,
            'target_day'=>'',
            'html_staff_inout_slct'=>OtherFunc::make_html_staff_inout_slct(""),
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
        //log::alert("target=".$target);
        $this->target_day=$target;
    }

    public function set_staff($target){
        //log::alert("target=".$target);
        $this->target_staff_serial=$target;
    }

    public function search_staff(){
        try {
            $HistoriesQuery = InOutHistory::query();
            if($this->target_year<>"" and $this->target_month<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','like',$this->target_year."-".$this->target_month."%");
                Log::alert("like=".$this->target_year."-".$this->target_month."%");
                $this->target_day="";
            }
            
            if($this->target_staff_serial<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_serial','=',$this->target_staff_serial);
            }else{
                $this->target_staff_serial=""; 
            }
            if($this->target_day<>""){
                $HistoriesQuery = $HistoriesQuery->where('target_date','=',$this->target_day);
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
            $this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*']);
            //$this->histories=$HistoriesQuery->paginate($perPage = initConsts::DdisplayLineNumStudentsList(),['*'], 'page',$this->targetPage);
        } catch (QueryException $e) {
            //Log::alert("QueryException=".$e);
            //return redirect('Students.List'); 
        }
        $this->targetPage=null;
    }
}