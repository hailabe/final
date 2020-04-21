<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class SalesstaffloginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:salesstaff')->except('salesstafflogout',);
    }

    public function showLoginform(){
        return view('auth.salesstaff-login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(Auth::guard('salesstaff')->attempt(['email' =>$request->email,'password'=>$request->password],$request->remember)){
            return redirect()->intended(route('salesstaff.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    public function salesstafflogout(){
        Auth::guard('salesstaff')->logout();
        return redirect('salesstaffhome/login');
    }
}
