<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\UserController;
use App\Http\Requests\InpCustomerRequest;
use App\Http\Controllers\OtherFunc;
use App\Http\Livewire\CustomersList;
use App\Http\Livewire\ContractList;
use App\Http\Livewire\DailyReport;
use App\Http\Livewire\MonthlyReport;
use App\Http\Livewire\ContractsReport;
use App\Http\Livewire\YearlyReport;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

if(!isset($_SESSION)){session_start();}
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
/*
Route::get('/login_customer', function () {
    return view('customer.LoginProtector');
})->name('customer.login');
*/
// 顧客受付
Route::get('admin/StaffStandbyDisplay', [AdminController::class,'ShowStaffStandbyDisplay'])->name("admin.StaffStandbyDisplay.get");
Route::post('admin/receipt_set_manage', [AdminController::class,'receipt_set_manage'])->name("admin.receipt_set_manage.post");
Route::post('admin/customer_reception_manage', [AdminController::class,'customer_reception_manage'])->name('customer_reception_manage.post');
Route::get('admin/CustomerStandbyDisplay', [AdminController::class,'ShowCustomerStandbyDisplay'])->name("admin.CustomerStandbyDisplay.get");
// 管理ログイン画面
Route::get('/admin-login', [AdminLoginController::class, 'create'])->name('admin.login');
// 管理ログイン
Route::post('/admin-login', [AdminLoginController::class, 'store'])->name('admin.login.store');
// 管理ログアウト
Route::delete('/admin-login', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy');

Route::get('/user', [UserController::class,'ShowMyPage']);
Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class,'ShowMyPage']);
    Route::get('/user', [UserController::class,'ShowMyPage']);
});
// 管理ログイン後のみアクセス可
Route::middleware('auth:admin')->group(function () {
    
    Route::name('admin.')->group(function() {
        Route::post('admin/ajax_get_customer_slct_option_for_HandOver',[AdminController::class,'ajax_get_customer_slct_option_for_HandOver'])->name('ajax_get_customer_slct_option_for_HandOver');
        Route::post('admin/ajax_make_customer_list_for_HandOver',[AdminController::class,'ajax_make_customer_list_for_HandOver'])->name('ajax_make_customer_list_for_HandOver');
        Route::post('admin/ajax_upsert_HandOver',[AdminController::class,'ajax_upsert_HandOver'])->name('ajax_upsert_HandOver');
        Route::get('/admin/HandOver', function () {
            return view('admin.HandOver');
        })->name('show_handover.get');
        Route::post('admin/html_make_select_summary_ajax', [OtherFunc::class,'html_make_select_summary_ajax'])->name('html_make_select_summary_ajax');
        Route::get('/set_balance_to_CashBookDb', [OtherFunc::class,'set_balance_to_CashBookDb'])->name('set_balance_to_CashBookDb.get');
        Route::get('/select_branch', [AdminController::class,'ShowSelectBranch'])->name('select_branch');
        Route::post('admin/ajax_upsert_CashBook',[AdminController::class,'ajax_upsert_CashBook'])->name('ajax_upsert_CashBook');

        Route::post('admin/CashBookList', function () {
            if(null ===session('serch_payment_flg')){
                session(['serch_payment_flg' => "checked"]);
            }
            if (null ===session('serch_deposit_flg')){
                session(['serch_deposit_flg' => "checked"]);
            }
            if (null ===session('sort_key_cashbook')){
                session(['sort_key_cashbook' => "target_date"]);
            }
            if (null ===session('asc_desc_cashbook')){
                session(['asc_desc_cashbook' => "Desc"]);
            }
            session(['target_livewire_page' => "CashBookList"]);
            return view('admin.CashBookList');
        })->name('CashBookList.post');

        Route::get('/admin/CashBookList', function () {
            if (null ===session('serch_payment_flg')){
                session(['serch_payment_flg' => "checked"]);
            }
            if (null ===session('serch_deposit_flg')){
                session(['serch_deposit_flg' => "checked"]);
            }
            if (null ===session('sort_key')){
                session(['sort_key' => "target_date"]);
            }
            if (null ===session('asc_desc')){
                session(['asc_desc' => "Desc"]);
            }
            session(['target_livewire_page' => "CashBookList"]);
            return view('admin.CashBookList');
        })->name('CashBookList.get');

        Route::post('admin/ajax_staff_dell_time_card',[AdminController::class,'ajax_staff_dell_time_card'])->name('ajax_staff_dell_time_card');
        Route::post('admin/ajax_staff_change_time_card',[AdminController::class,'ajax_staff_change_time_card'])->name('ajax_staff_change_time_card');
        Route::get('admin/ContractCancellation/{targetContract}/{UserSerial}', [AdminController::class,'ContractCancellation'],function($targetContract,$UserSerial){});
        Route::post('admin/ajax_digestion_point',[AdminController::class,'ajax_digestion_point'])->name('ajax_digestion_point');
        Route::post('admin/ajax_change_point',[AdminController::class,'ajax_change_point'])->name('ajax_change_point');

        Route::get('/show_staff_in_out_rireki', function () {
            session(['target_livewire_page' => "ListStaffInOut"]);
            return view('admin.ListStaffInOutHistories');
        })->name('show_staff_in_out_rireki.get');

        Route::get('/admin/show_point_list', function () {
            session(['target_livewire_page' => "ListPoints"]);
            if(empty(session('state_validity_checked'))){
                session(['state_validity_checked'=> "checked"]);
            }
            if(empty(session('state_used_checked'))){
                session(['state_used_checked'=> "checked"]);
            }
            return view('admin.ListPoints');
        })->name('ListPoints.get');
        Route::get('/admin/GetEncryption', function () {
            return view('admin.GetEncryption');
        })->name('GetEncryption.get');

        Route::post('admin/setting_update', [AdminController::class,'update_setting'])->name('setting.update');
        Route::get('admin/show_setting',[AdminController::class,'show_setting'])->name('show_setting');
        Route::get('QRcode', function () {
            return QrCode::size(300)->generate('A basic example of QR code!');
        })->name("QRcode");

        Route::get('QRcode', function () {
            return QrCode::size(300)->generate('A basic example of QR code!');
        })->name("QRcode");
        Route::post('admin/send_QRcode_to_staff', [AdminController::class,'send_QRcode_to_staff'])->name("SendQRcodeToStaff.post");

        Route::get('admin/InOutStandbyDisplay', [AdminController::class,'ShowInOutStandbyDisplay'])->name("InOutStandbyDisplay.get");
        Route::post('/admin/saveTreatment/', [AdminController::class,'saveTreatment',function(Request $request){}])->name('saveTreatment.post');

        Route::get('/admin/deleteTreatmentContent/{serial_TreatmentContent}',[AdminController::class,'deleteTreatmentContent'],function($serial_TreatmentContent){});
        
        Route::get('/admin/InpTreatment/{TreatmentContentSerial}', [AdminController::class,'InpTreatment',function($TreatmentSerial){}])->name('InpTreatment.get');

        Route::get('/admin/TreatmentList', function () {
            return view('admin.TreatmentList');
        })->name('TreatmentList.get');
       
        Route::post('/admin/TreatmentList', function () {
            return view('admin.TreatmentList');
        })->name('TreatmentList.post');

        Route::get('/admin/YearlyReport', function () {
            return view('admin.YearlyReport');
        })->name('YearlyReport.get');

        Route::get('/admin/YearlyReport', function () {
            return view('admin.YearlyReport');
        })->name('YearlyReport.get');

        Route::post('/admin/YearlyReport', function () {
            return view('admin.YearlyReport');
        })->name('YearlyReport.post');
        
        Route::get('/admin/ContractsReport', function () {
            return view('admin.ContractReport');
        })->name('ContractReport.get');

        Route::post('/admin/ContractsReport', function () {
            return view('admin.ContractReport');
        })->name('ContractReport.post');

        Route::get('/admin/MonthlyReport', function () {
            return view('admin.MonthlyReport');
        })->name('MonthlyReport.get');
        
        Route::post('/admin/MonthlyReport', function () {
            return view('admin.MonthlyReport');
        })->name('MonthlyReport.post');
        
        Route::get('/admin/DailyReport', function () {
            return view('admin.DailyReport');
        })->name('DailyReport.get');
        
        Route::post('/admin/DailyReport', function () {
            return view('admin.DailyReport');
        })->name('DailyReport.post');
    });

    Route::controller(AdminController::class)->name('customers.')->group(function() {
        Route::get('/customers/ShowPaymentRegistrationIflame/{SerialKeiyaku}/{SerialUser}',[AdminController::class,'ShowPaymentRegistrationIflame',function($SerialKeiyaku,$SerialUser){}])->name('ShowPaymentRegistrationIflame');
        Route::get('/customers/ShowVisitHistory', function () {
            return view('customers.ListVisit');
        })->name('VisitHistory.get');
        Route::post('/customers/ShowVisitHistory', function () {
            return view('customers.ListVisit');
        })->name('VisitHistory.post');
        Route::get('/customers/ShowPaymentHistory', function () {
            return view('customers.ListPayment');
        })->name('PaymentHistory.get');
        Route::post('/customers/ShowPaymentHistory', function () {
            return view('customers.ListPayment');
        })->name('PaymentHistory.post');

        Route::post('/customers/CustomersList/ajax_save_yoyaku_time',[AdminController::class,'ajax_save_yoyaku_time'])->name('ajax_save_yoyaku_time');
        Route::get('/customers/ContractCancellation/{targetContract}/{UserSerial}', [AdminController::class,'ContractCancellation'],function($targetContract,$UserSerial){});
        Route::post('/customers/ContractCancellation/{targetContract}/{UserSerial}', [AdminController::class,'ContractCancellation'],function($targetContract,$UserSerial){});

        Route::post('/customers/CustomerInfFromDaylyRep', [CustomersList::class,function(Request $request){}])->name("CustomerInfFromDayly.post");
        
        Route::get('/customers/deleteContract/{serial_contract}/{serial_user}',[AdminController::class,'deleteContract'],function($serial_contract,$serial_user){});
        Route::get('/customers/deleteCustomer/{serial_user}',[AdminController::class,'deleteCustomer'],function($serial_user){});
        Route::post('/ajax_SaveMedicalRecord', [AdminController::class,'ajax_SaveMedicalRecord'])->name("SaveMedicalRecord");
        Route::get('/customers/MakeContractPDF/{ContractSerial}', [AdminController::class,'MakeContractPDF',function($TargetMonth){}])->name("MakeContractPDF");
        Route::get('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){session(['ContractSerial' => $ContractSerial,'UserSerial'=>$UserSerial]);}]);
	    Route::post('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){}]);

        Route::post('/customers/ContractList/', [AdminController::class,'ShowContractList'])->name("ContractList.post");
        Route::get('/customers/ContractList/{UserSerial}', [AdminController::class,'ShowContractList',function($UserSerial){}])->name("ContractList.get");
        Route::get('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
        Route::post('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
	    
        Route::get('/customers/CustomersList', function () {
            session(['target_livewire_page' => "ListCustomers"],['sort_key'=>'']);
            return view('customers.ListCustomers');
        })->name('CustomersList.show');

        Route::post('/customers/CustomersList', function () {
            session(['target_livewire_page' => "ListCustomers"],['sort_key'=>'']);
            return view('customers.ListCustomers');
        })->name('CustomersList.show.post');

        Route::get('livewire/update', function () {
            //Log::alert("target_livewire_page=".session('target_livewire_page'));
            if(session('target_livewire_page')=="ListPoints"){
                return view('admin.ListPoints');
            }else if(session('target_livewire_page')=="ListContract"){
                return view('customers.ListContract');
             }else if(session('target_livewire_page')=="ListCustomers"){
                 return view('customers.ListCustomers');
             }else if(session('target_livewire_page')=="ListStaffInOut"){
                return view('admin.ListStaffInOutHistories');
             } else if(session('target_livewire_page')=="CashBookList"){
                return view('admin.CashBookList');
            }
        });
        Route::post('/customers/MedicalRecordIflame', [AdminController::class,'ShowMedicalRecordFromIframe',function(Request $request){}])->name("ShowMedicalRecordIflame");
        Route::get('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");
	    Route::post('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");
        Route::post('/customers/recordVisitPaymentHistory/', [AdminController::class,'recordVisitPaymentHistory',function(Request $request){}])->name("recordVisitPaymentHistory");
        Route::get('/customers/ShowInpRecordVisitPayment/{SerialKeiyaku}/{SerialUser}', [AdminController::class,'ShowInpRecordVisitPayment',function($SerialKeiyaku,$SerialUser){}])->name('ShowInpRecordVisitPayment.get');
	    Route::post('/customers/ShowInpRecordVisitPayment', [AdminController::class,'ShowInpRecordVisitPayment']);
        Route::get('/customers/insertContract', [AdminController::class,'insertContract'])->name('insertContract');
        Route::post('/customers/insertContract', [AdminController::class,'insertContract'])->name('insertContract');
        Route::get('/customers/ShowInpContract/{serial_user}', [AdminController::class,'ShowInpKeiyaku'],function($serial_user){})->name('ShowInpKeiyaku');
        Route::post('/customers/getCustomerInf', [OtherFunc::class,'get_customer_inf'],function(Request $request){})->name('getCustomerInf');
        //https://salon-ge.com/nagano-01/sys/project
        //https://salon-ge.com/nagano-01/sys/project/public
        //nagano-01/sys/project/public
        //Route::domain('https://salon-ge.com/nagano-01/sys/project/public')->group(function () {
            Route::get('/customers/insertCustomer', [AdminController::class,'insertCustomer'],function(Request $request){})->name('insertCustomer');
            Route::post('/customers/insertCustomer', [AdminController::class,'insertCustomer'],function(Request $request){})->name('insertCustomer');
        //});
        
        Route::get('customers/ShowInputNewCustomer', [AdminController::class,'ShowInputNewCustomer'])->name('ShowInpNewCustomer');
        Route::post('/customers/ShowInputCustomer', [AdminController::class,'ShowInputCustomer',function(Request $request){}])->name('ShowInpCustomer');
    });
    
    Route::post('/customers/ContractList/ajax_get_Medical_records_file_name',[AdminController::class,'ajax_get_Medical_records_file_name'])->name('ajax_get_Medical_records_file_name');
    Route::post('/customers/ajax_get_Medical_records_file_name',[AdminController::class,'ajax_get_Medical_records_file_name'])->name('ajax_get_Medical_records_file_name_VH');
    Route::get('/customers/ajax_get_Medical_records_file_name',[AdminController::class,'ajax_get_Medical_records_file_name'])->name('get.ajax_get_Medical_records_file_name');
    Route::post('/customers/save_payment_history_ajax', [OtherFunc::class,'save_payment_history_ajax'])->name('save_payment_history_ajax');
    Route::post('/customers/make_htm_get_payment_method_slct_ajax', [OtherFunc::class,'make_htm_get_payment_method_slct_ajax'])->name('make_htm_get_payment_method_slct_ajax');
    Route::post('/customers/save_visit_data_ajax', [OtherFunc::class,'save_visit_data_ajax'])->name('save_visit_data_ajax');
    Route::post('/customers/make_htm_get_treatment_slct_ajax', [OtherFunc::class,'make_htm_get_treatment_slct_ajax'])->name('make_htm_get_treatment_slct_ajax');
    Route::post('make_htm_get_treatment_slct_ajax', [OtherFunc::class,'make_htm_get_treatment_slct_ajax'])->name('make_htm_get_treatment_slct_ajax');
    Route::get('/send_attendance_card/{TargetStaffSerial}',[OtherFunc::class,'send_attendance_card'],function($TargetStaffSerial){});
    Route::get('/deleteStaff/{TargetStaffSerial}',[AdminController::class,'deleteStaff'],function($TargetStaffSerial){});
    Route::post('/saveStaff', [AdminController::class,'SaveStaff',function(Request $request){}])->name("saveStaff.post");
    Route::get('ShowInputStaff/{TargetStaffSerial}', [AdminController::class,'ShowInpStaff',function($TargetStaffSerial){}])->name('ShowInpStaff');
    Route::get('ShowStaffList', function () {
        return view('admin.ListStaffs');
    })->name('StaffsList.show');
    Route::get('/top', [AdminController::class,'ShowMenuCustomerManagement'])->name('admin.top');
    Route::post('/top', [AdminController::class,'ShowMenuCustomerManagement'])->name('admin.top.post');
    Route::get('/select_branch', [AdminController::class,'ShowSelectBranch'])->name('admin.select_branch');
    Route::post('ajax_get_coming_soon_user',[AdminController::class,'ajax_get_coming_soon_user'])->name('ajax_staff_dell_time_card');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', [UserController::class,'ShowMyPage']);
});
