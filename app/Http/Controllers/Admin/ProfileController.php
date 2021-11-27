<?php

namespace App\Http\Controllers\Admin;

use Validator;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


class ProfileController extends Controller
{
    public function index(){
 
         $user = Auth::user();
         return view('backend.profile.profile', compact('user'));
    }
    public function edit_profile(Request $request){
  
  
        $input = $request->all(); 
        $user = User::where('id',Auth::user()->id)->first();
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->company_name = $request->input('company_name');
        $user->save();
        return redirect()->back()->with('success','Profile Update');
    }
    public function edit_password(Request $request){
   
        $input = $request->all();
        $user = User::where('id',Auth::user()->id)->first();
    
        if($user)
              {
                  if(\Hash::check($request->old_password, $user->password))
                  {       
                     
                          $user->forceFill([
                              'password' => bcrypt($request->password),
                              'remember_token' => Str::random(60),
                       
                          ])->save();
                         
                          return redirect()->back()->with('success','Password Updated');
                        
                  }
                  else
                  {
                      return redirect()->back()->with('success','Incorrect old password');
                     
                  }
              }
              else
              {
                  return redirect()->back()->with('success','user not found');
                  
              }   
       }

 }