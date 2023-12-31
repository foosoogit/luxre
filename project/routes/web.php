<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Requests\InpCustomerRequest;
use App\Http\Controllers\OtherFunc;
use App\Http\Livewire\CustomersList;
use App\Http\Livewire\ContractList;
use App\Http\Livewire\DailyReport;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
/*
Route::get('/', function () {
    redirect ('/top');
});
*/
// 管理ログイン画面
Route::get('/admin-login', [AdminLoginController::class, 'create'])->name('admin.login');
// 管理ログイン
Route::post('/admin-login', [AdminLoginController::class, 'store'])->name('admin.login.store');
// 管理ログアウト
Route::delete('/admin-login', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy');

// 管理ログイン後のみアクセス可
Route::middleware('auth:admin')->group(function () {
   
    //Route::get('admin/ShowDailyReport', DailyReport::class);
    Route::name('admin.')->group(function() {
        Route::get('/admin/ShowDailyReport', function () {
            return view('admin.DailyReport');
        })->name('admin.DailyReport');
    });

    //Route::get('/admin/ShowDailyReport', [DailyReport::class])->name("ShowDailyReport");
    /*
    Route::post('/admin/ShowDailyReport', DailyReport::class);
    Route::post('/admin/ShowDailyReport_from_monthly_report', DailyReport::class,function(Request $request){});
    Route::get('/admin/ShowDailyReport_from_customers_List', DailyReport::class);
    Route::post('/admin/ShowDailyReport_from_customers_List', DailyReport::class,function(Request $request){});
    */
    
    Route::controller(AdminController::class)->name('customers.')->group(function() {
        Route::post('/ajax_SaveMedicalRecord', [AdminController::class,'ajax_SaveMedicalRecord'])->name("SaveMedicalRecord");
        Route::get('/customers/MakeContractPDF/{ContractSerial}', [AdminController::class,'MakeContractPDF',function($TargetMonth){}])->name("MakeContractPDF");
        Route::get('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){session(['ContractSerial' => $ContractSerial,'UserSerial'=>$UserSerial]);}]);
	    Route::post('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminControllerr::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){}]);

        Route::get('/customers/ContractList/{UserSerial}', [AdminController::class,'ShowContractList',function($UserSerial){}]);
	    Route::post('/customers/ContractList/{UserSerial}', [AdminController::class,'ShowContractList',function($UserSerial){}]);
        Route::get('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
        Route::post('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
	    Route::get('/customers/CustomersList', function () {
            return view('customers.ListCustomers');
        })->name('CustomersList.show');

        Route::get('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");
	    Route::post('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");

        Route::post('/customers/recordVisitPaymentHistory/', [AdminController::class,'recordVisitPaymentHistory',function(Request $request){}])->name("recordVisitPaymentHistory");
        Route::get('/customers/ShowInpRecordVisitPayment/{SerialKeiyaku}/{SerialUser}', [AdminController::class,'ShowInpRecordVisitPayment',function($SerialKeiyaku,$SerialUser){}]);
	    Route::post('/customers/ShowInpRecordVisitPayment', [AdminController::class,'ShowInpRecordVisitPayment']);
        Route::get('/customers/insertContract', [AdminController::class,'insertContract'])->name('insertContract');
        Route::post('/customers/insertContract', [AdminController::class,'insertContract'])->name('insertContract');
        Route::get('/customers/ShowInpContract/{serial_user}', [AdminController::class,'ShowInpKeiyaku'],function($serial_user){})->name('ShowInpKeiyaku');
        //Route::get('/customers/insertCustomer', [AdminController::class,'insertCustomer'],function(Request $request){})->name('insertCustomer');
        Route::post('/customers/getCustomerInf', [OtherFunc::class,'get_customer_inf'],function(Request $request){})->name('getCustomerInf');
        Route::get('/customers/insertCustomer', [AdminController::class,'insertCustomer'],function(Request $request){})->name('insertCustomer');
        Route::post('/customers/insertCustomer', [AdminController::class,'insertCustomer'],function(Request $request){})->name('insertCustomer');
        Route::get('/customers/ShowInputNewCustomer', [AdminController::class,'ShowInputNewCustomer'])->name('ShowInpNewCustomer');
        Route::post('/customers/ShowInputCustomer', [AdminController::class,'ShowInputCustomer',function(Request $request){}])->name('ShowInpCustomer');
    });

    Route::get('/deleteStaff/{TargetStaffSerial}',[AdminController::class,'deleteStaff'],function($TargetStaffSerial){});
    Route::post('/saveStaff', [AdminController::class,'SaveStaff',function(Request $request){}])->name("saveStaff.post");
    Route::get('ShowInputStaff/{TargetStaffSerial}', [AdminController::class,'ShowInpStaff',function($TargetStaffSerial){}])->name('ShowInpStaff');
    Route::get('ShowStaffList', function () {
        return view('admin.ListStaffs');
    })->name('StaffsList.show');
    Route::get('/top', [AdminController::class,'ShowMenuCustomerManagement'])->name('admin.top');
    //Route::get('/', [AdminController::class,'ShowMenuCustomerManagement']);
    /*
    Route::get('/admin', function () {
        return view('admin.menu_top');
        //return view('admin.top');
    })->name('admin.top');
    */
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
});
