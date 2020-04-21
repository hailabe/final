<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;

class ArtistloginController extends Controller
{
    public function __construct(){
        $this->middleware('guest:artist')->except('artistlogout',);
    }

    public function showLoginform(){
        return view('auth.artist-login');
    }

    public function login(Request $request){
        $this->validate($request,[
            'email'=>'required|email',
            'password'=>'required|min:6'
        ]);
        if(Auth::guard('artist')->attempt(['email' =>$request->email,'password'=>$request->password],$request->remember)){
            return redirect()->intended(route('artist.dashboard'));
        }
        return redirect()->back()->withInput($request->only('email','remember'));
    }
    public function artistlogout(){
        Auth::guard('artist')->logout();
        return redirect('artisthome/login');
    }
}
