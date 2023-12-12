<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminLoginController;
use App\Http\Controllers\AdminController;

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

Route::get('/', function () {
    return view('welcome');
});

// 管理ログイン画面
Route::get('/admin-login', [AdminLoginController::class, 'create'])->name('admin.login');
// 管理ログイン
Route::post('/admin-login', [AdminLoginController::class, 'store'])->name('admin.login.store');
// 管理ログアウト
Route::delete('/admin-login', [AdminLoginController::class, 'destroy'])->name('admin.login.destroy');

// 管理ログイン後のみアクセス可
Route::middleware('auth:admin')->group(function () {
    Route::post('/saveStaff', [AdminController::class,'SaveStaff',function(Request $request){}])->name("saveStaff.post");
    Route::get('ShowInputStaff/{TargetStaffSerial}', [AdminController::class,'ShowInpStaff',function($TargetStaffSerial){}])->name('ShowInpStaff');
    Route::get('ShowStaffList', function () {
        return view('admin.ListStaffs');
    })->name('StaffsList.show');
    Route::get('/top', [\App\Http\Controllers\AdminController::class,'ShowMenuCustomerManagement'])->name('admin.top');
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
