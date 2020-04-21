<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ProducerloginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:producer')->except('producerlogout',);
    }

    public function showLoginform(){
        return view('auth.producer-login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(Auth::guard('producer')->attempt(['email' =>$request->email,'password'=>$request->password],$request->remember)){
            return redirect()->intended(route('producer.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    public function producerlogout(){
        Auth::guard('producer')->logout();
        return redirect('producerhome/login');
    }
}
