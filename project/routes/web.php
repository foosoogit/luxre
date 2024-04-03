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

Route::post('admin/receipt_set_manage', [AdminController::class,'receipt_set_manage'])->name("admin.receipt_set_manage.post");
Route::post('admin/customer_reception_manage', [AdminController::class,'customer_reception_manage'])->name('setting.update');
Route::get('admin/CustomerStandbyDisplay', [AdminController::class,'ShowCustomerStandbyDisplay'])->name("admin.CustomerStandbyDisplay.get");
// 管理ログイン画面
Route::get('/admin-login', [AdminLoginController::class, 'create'])->name('admin.login');
// 管理ログイン
Route::post('/admin-login', [AdminLoginController::class, 'store'])->name('admin.login.store');
// 管理ログアウト
Route::delete('/admin-login', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy');

//Route::get('/user', [AdminController::class,'ShowMenuCustomers'])->name('customer.MyPage.login');
Route::middleware('auth')->group(function () {
        Route::get('/user', [UserController::class,'ShowMyPage']);
});
// 管理ログイン後のみアクセス可
Route::middleware('auth:admin')->group(function () {
    Route::name('admin.')->group(function() {
        //Route::get('admin/get_imagick_info', [OtherFunc::class,'get_imagick_info'])->name("get_imagick_info.get");
        /*
        Route::get('qr-code', function() {
            return response()->streamDownload(function () {
                \QRCode::url('https://laravel.com/')
                    ->setSize(10)
                    ->setMargin(2)
                    ->png();
            }, 'qr-code.png');
        });
        */
        
        Route::post('admin/setting_update', [AdminController::class,'update_setting'])->name('setting.update');
        Route::get('admin/show_setting',[AdminController::class,'show_setting'])->name('show_setting');
        Route::get('QRcode', function () {
            return QrCode::size(300)->generate('A basic example of QR code!');
        })->name("QRcode");

        Route::get('QRcode', function () {
            return QrCode::size(300)->generate('A basic example of QR code!');
        })->name("QRcode");

        Route::post('admin/send_QRcode_to_staff', [AdminController::class,'send_QRcode_to_staff'])->name("SendQRcodeToStaff.post");

        //Route::post('admin/send_QRcode_to_staff', [AdminController::class,'GetQrImage'])->name("SendQRcodeToStaff.post");

        //Route::post('send_mail_in_out', [AdminController::class,'send_mail_in_out'])->name("send_mail_in_out");
        //Route::post('in_out_manage', [AdminController::class,'in_out_manage'])->name("in_out_manage");

        Route::get('admin/InOutStandbyDisplay', [AdminController::class,'ShowInOutStandbyDisplay'])->name("InOutStandbyDisplay.get");

        /*
        Route::get('admin/InOutStandbyDisplay', function(){
            $host_url=$_SERVER['HTTP_REFERER'];
            session(['target_serial' => ""]);
            return view('admin.InOutStandbyDisplayJQ',compact('host_url'));
        })->name('InOutStandbyDisplay.get');
        */
        Route::post('/admin/saveTreatment/', [AdminController::class,'saveTreatment',function(Request $request){}])->name('saveTreatment.post');

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

    //Route::get('/admin/ShowDailyReport', [DailyReport::class])->name("ShowDailyReport");
    /*
    Route::post('/admin/ShowDailyReport', DailyReport::class);
    Route::post('/admin/ShowDailyReport_from_monthly_report', DailyReport::class,function(Request $request){});
    Route::get('/admin/ShowDailyReport_from_customers_List', DailyReport::class);
    Route::post('/admin/ShowDailyReport_from_customers_List', DailyReport::class,function(Request $request){});
    */
    
    Route::controller(AdminController::class)->name('customers.')->group(function() {
        //Route::get('/customers/CustomerInfFromDayly/{target_user_serial}', [CustomersList::class,'search_from_top_menu'],function($target_user_serial){})->name("CustomerInfFromDayly");
    	//Route::post('/customers/ShowCustomersList_livewire_from_top_menu', CustomerSearch::class,function(Request $request){});
	    Route::post('/customers/CustomerInfFromDaylyRep', [CustomersList::class,function(Request $request){}])->name("CustomerInfFromDayly.post");
        
        Route::get('/customers/deleteContract/{serial_contract}/{serial_user}',[AdminController::class,'deleteContract'],function($serial_contract,$serial_user){});
        Route::get('/customers/deleteCustomer/{serial_user}',[AdminController::class,'deleteCustomer'],function($serial_user){});
        Route::post('/ajax_SaveMedicalRecord', [AdminController::class,'ajax_SaveMedicalRecord'])->name("SaveMedicalRecord");
        Route::get('/customers/MakeContractPDF/{ContractSerial}', [AdminController::class,'MakeContractPDF',function($TargetMonth){}])->name("MakeContractPDF");
        Route::get('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){session(['ContractSerial' => $ContractSerial,'UserSerial'=>$UserSerial]);}]);
	    Route::post('/customers/ShowSyuseiContract/{ContractSerial}/{UserSerial}', [AdminController::class,'ShowSyuseiContract',function($ContractSerial,$UserSerial){}]);

        Route::get('/customers/ContractList/{UserSerial}', [AdminController::class,'ShowContractList',function($UserSerial){}])->name("ContractList.get");
	    Route::post('/customers/ContractList/', [AdminController::class,'ShowContractList'])->name("ContractList.post");
        //Route::post('/customers/ContractList/{UserSerial}', [AdminController::class,'ShowContractList',function($UserSerial){}])->name("ContractList.post");
        Route::get('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
        Route::post('/customers/ShowSyuseiCustomer', [AdminController::class,'ShowSyuseiCustomer',function(Request $request){}])->name("ShowSyuseiCustomer");
	    
        Route::get('/customers/CustomersList', function () {
            return view('customers.ListCustomers');
        })->name('CustomersList.show');

        Route::post('/customers/CustomersList', function () {
            return view('customers.ListCustomers');
        })->name('CustomersList.show.post');

        //Route::post('/customers/CustomersList', [CustomerSearch::class,'ShowSyuseiCustomer',function(Request $request){});
        
       //Route::get('livewire/update/all', [AdminController::class,'ShowContractList',function($UserSerial){}])->name("ContractList.get");

        Route::get('livewire/update', function () {
            //Log::info($_SESSION['access_history']);
            if(str_contains($_SESSION['access_history'][0],"ContractList")){
               return view('customers.ListContract');
            }else{
                return view('customers.ListCustomers');
            }
        });


        //Route::post('/customers/CustomersList', [CustomersList::class,function(Request $request){}])->name("CustomersList.show.post");
        /*
        Route::post('/customers/CustomersList', function () {
            return view('customers.ListCustomers');
        })->name('CustomersList.show.post');
        */
        Route::get('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");
	    Route::post('/customers/MedicalRecord', [AdminController::class,'ShowMedicalRecord',function(Request $request){}])->name("ShowMedicalRecord");

        Route::post('/customers/recordVisitPaymentHistory/', [AdminController::class,'recordVisitPaymentHistory',function(Request $request){}])->name("recordVisitPaymentHistory");
        Route::get('/customers/ShowInpRecordVisitPayment/{SerialKeiyaku}/{SerialUser}', [AdminController::class,'ShowInpRecordVisitPayment',function($SerialKeiyaku,$SerialUser){}])->name('ShowInpRecordVisitPayment.get');
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
    //Route::get('/', [AdminController::class,'ShowMenuCustomerManagement'])->name('admin.top.login');
    //Route::get('/', [UserController::class,'ShowMyPage'])->name('admin.top.login');
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
