<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\artist;
use Illuminate\Support\Facades\Hash;

class ArtistController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return artist::latest()->paginate(10);
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
            'email' =>'required|string|email|max:255|unique:artists',
            'password' =>'required|string|min:8',
            'phoneNo' =>'required',
        ]);
        //return $request->all();
        return artist::create([
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
        $artist=artist::findOrFail($id);
        
        $this->validate($request,[
            'name' =>'required|string|max:255',
            'email' =>'required|string|email|max:255|unique:artists,email,'.$artist->id,
            'password' =>'sometimes|string|min:8',
            'phoneNo' =>'required',
        ]);
        $artist->update($request->all());

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
        $artist=artist::findOrFail($id);
        $artist->delete();
    }
    public function search(){
        if($search = \Request::get('q')){
            $artists=artist::where(function($query)use($search){
                $query->where('name','LIKE',"%$search%")
                      ->orWhere('email','LIKE',"%$search%")
                      ->orWhere('phoneNo','LIKE',"%$search%")
                      ->orWhere('id','LIKE',"%$search%")
                      ->orWhere('created_at','LIKE',"%$search%")
                      ->orWhere('updated_at','LIKE',"%$search%");
                      
                     
            })->paginate(20);
        }else{
            $artists=artist::latest()->paginate(10);
        }
        return $artists;
    }
}
