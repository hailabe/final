<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\salesstaff;
use Illuminate\Support\Facades\Hash;

class SalesstaffController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return salesstaff::latest()->paginate(10);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:salesstaffs',
            'password' =>'required|string|min:8',
            'phoneNo' =>'required',
        ]);
        //return $request->all();
        return salesstaff::create([
            'name'=>$request['name'],
            'email'=>$request['email'],
            'password'=>Hash::make($request['password']),
            'phoneNo'=>$request['phoneNo'],
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $salesstaff=salesstaff::findOrFail($id);
        
        $this->validate($request,[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:salesstaffs,email,'.$salesstaff->id,
            'password' =>'sometimes|string|min:8',
            'phoneNo' =>'required',
        ]);
        $salesstaff->update($request->all());

        return ['message'=>'updated sales info'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $salesstaff=salesstaff::findOrFail($id);
        $salesstaff->delete();
    }
    public function search(){
        if($search = \Request::get('q')){
            $salesstaffs=salesstaff::where(function($query)use($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('phoneNo','LIKE',"%$search%")
                      ->orWhere('id','LIKE',"%$search%")
                      ->orWhere('created_at','LIKE',"%$search%")
                      ->orWhere('updated_at','LIKE',"%$search%");
                      
                     
            })->paginate(20);
        }else{
            $salesstaffs=salesstaff::latest()->paginate(10);
        }
        return $salesstaffs;
    }
}
