<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SalesBasiccontroller extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:salesstaff');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('salesstaff');
    }
}
