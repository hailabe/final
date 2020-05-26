<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\album;
use Illuminate\Support\Facades\Hash;

class albumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return album::latest()->paginate(10);
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
            'email' =>'required|string|email|max:255|unique:albums',
            'password' =>'required|string|min:8',
            'phoneNo' =>'required',
        ]);
        //return $request->all();
        return album::create([
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
        $album=album::findOrFail($id);
        
        $this->validate($request,[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:albums,email,'.$album->id,
            'password' =>'sometimes|string|min:8',
            'phoneNo' =>'required',
        ]);
        $album->update($request->all());

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
        $album=album::findOrFail($id);
        $album->delete();
    }
    public function search(){
        if($search = \Request::get('q')){
            $albums=album::where(function($query)use($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('phoneNo','LIKE',"%$search%")
                      ->orWhere('id','LIKE',"%$search%")
                      ->orWhere('created_at','LIKE',"%$search%")
                      ->orWhere('updated_at','LIKE',"%$search%");
                      
                     
            })->paginate(20);
        }else{
            $albums=album::latest()->paginate(10);
        }
        return $albums;
    }
}
