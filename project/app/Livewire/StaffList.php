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
	}

    public function render()
    {
        $targetPage="";
		$staffs=Staff::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
        return view('livewire.staff-list',compact('staffs'));
    }
}
