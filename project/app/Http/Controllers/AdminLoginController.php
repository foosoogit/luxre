<?php

namespace App\Http\Controllers;

use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminLoginController extends Controller
{
    //
        /**

     * ログイン画面
     */
     public function create(): View
     {
         return view('admin.login_admin');
     }
     /**
      * ログイン
      */
     public function store(AdminLoginRequest $request): RedirectResponse
     {
         $request->authenticate();
         $request->session()->regenerate();
         return redirect()->intended(route('admin.select_branch'));
         //return redirect()->intended(route('admin.top'));
     }
     /**
      * ログアウト
      */
     public function destroy(Request $request): RedirectResponse
     {
         Auth::guard('admin')->logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         $_SESSION = array();
        if (isset($_COOKIE["PHPSESSID"])) {
            setcookie("PHPSESSID", '', time() - 1800, '/');
        }
        //session_destroy();
        return to_route('admin.login');
        //return to_route('admin.login_admin');
     }
}