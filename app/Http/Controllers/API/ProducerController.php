<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\producer;
use Illuminate\Support\Facades\Hash;

class ProducerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return producer::latest()->paginate(10);
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
            'email' =>'required|string|email|max:255|unique:producers',
            'password' =>'required|string|min:8',
            'phoneNo' =>'required',
        ]);
        //return $request->all();
        return producer::create([
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
        $producer=producer::findOrFail($id);
        
        $this->validate($request,[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:producers,email,'.$producer->id,
            'password' =>'sometimes|string|min:8',
            'phoneNo' =>'required',
        ]);
        $producer->update($request->all());

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
        $producer=producer::findOrFail($id);
        $producer->delete();
    }
    public function search(){
        if($search = \Request::get('q')){
            $producers=producer::where(function($query)use($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('phoneNo','LIKE',"%$search%")
                      ->orWhere('id','LIKE',"%$search%")
                      ->orWhere('created_at','LIKE',"%$search%")
                      ->orWhere('updated_at','LIKE',"%$search%");
                      
                     
            })->paginate(20);
        }else{
            $producers=producer::latest()->paginate(10);
        }
        return $producers;
    }
}
