<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Staff;
use App\Consts\initConsts;
use Livewire\WithPagination;
use Illuminate\Support\Facades\DB;

class StaffList extends Component
{
    use WithPagination;

    public function render()
    {
        $targetPage="";
		$staffs=Staff::paginate($perPage = initConsts::DdisplayLineNumCustomerList(),['*'], 'page',$targetPage);
        return view('livewire.staff-list',compact('staffs'));
    }
}
