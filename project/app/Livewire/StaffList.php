<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Consts\initConsts;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\OtherFunc;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;

class StaffList extends Component
{
    use WithPagination;

    public function send_attendance_card($TargetStaffSerial){
        OtherFunc::send_attendance_card($TargetStaffSerial);
        /*
		$staff_inf=Staff::where("serial_staff","=",$TargetStaffSerial)->first();
		if(empty($staff_inf)){
			$target_item_array['msg']='スタッフのご登録が見つかりません。';
			$target_item_array['res']='no serial';
			$json = json_encode( $target_item_array , JSON_PRETTY_PRINT ) ;
		}else{
			OtherFunc::make_QRCode($TargetStaffSerial,storage_path('images/'.$TargetStaffSerial.'.png'));
			$target_item_array=array();
			//Mail::send(new ContactMail($target_item_array));
			$target_item_array['msg']=$staff_inf->last_name_kanji." ".$staff_inf->first_name_kanji." 様<br>出勤用QRコードをお送りします。<br>Luxer";
			$target_item_array['to_email']=$staff_inf->email;
			$target_item_array['subject']='出退記録用QRコード';
			$target_item_array['from_email']=env('MAIL_FROM_ADDRESS');
			$target_item_array['QR_file_path']=storage_path('images/'.$TargetStaffSerial.'.png');
			//Log::info($target_item_array);
			Mail::send(new SendMail($target_item_array));
		}
        */
	}

    public function render()
    {
        $targetPage="";
		$staffs=Staff::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
        return view('livewire.staff-list',compact('staffs'));
    }
}
