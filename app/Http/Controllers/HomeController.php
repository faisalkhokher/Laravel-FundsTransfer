<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class HomeController extends Controller 
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
        $user = Auth::user();
        
        $roles = $user->roles->pluck('name')->toArray();
        
        if(sizeof($roles) > 0){
            if(in_array('user',$roles)){
                $user->removeRole('user');
            }
        }else{
            $user->assignRole('x');
        }
        
        
        if ($user->hasRole('admin')) {
           
            return redirect()->intended(route('admin'));
        }
        if($user->hasRole('lyndrx')){
           
            return redirect()->intended(route('lyndrx.dashboard'));  
        }
        if ($user->hasRole('x')) {
            // dd('You');
            return redirect()->intended(route('x.dashboard'));
        }
    }
}
