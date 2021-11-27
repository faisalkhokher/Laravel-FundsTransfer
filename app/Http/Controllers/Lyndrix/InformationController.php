<?php

namespace App\Http\Controllers\Lyndrix;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class InformationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        return view('lyndrix.information.profile',compact('user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
    public function edit_profile(Request $request){
     
 
        $input = $request->all();
          
          $user = User::where('id',Auth::user()->id)->first();
          $user->name = $request->input('name');
          $user->save();
    
            if($user)
                {
                    if(\Hash::check($request->old_password, $user->password))
                    {       
                            $user->forceFill([
                                'password' => bcrypt($request->password),
                                'remember_token' => Str::random(60),
                         
                            ])->save();
                           
                            return redirect()->back()->with('error','Profile Update');
                          
                    }
                    else
                    {
                        return redirect()->back()->with('error','Incorrect old password');
                       
                    }
                }
                else
                {
                    return redirect()->back()->with('error','user not found');
                    
                }
   
              
       }
    
}
