<?php

namespace App\Http\Controllers\Lyndrix;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LyndrixController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $deposits = \auth()->user()->transactions(['type'=>'deposit'])->paginate(5);
            $total_user = User::count();
            $direct_loans = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->Where('status','=','pending')->where('request_status','=',NULL)->paginate(5);
            $xloans = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->count();
            $transactions = auth()->guard('web')->user()->transfers()->count();
        
            return view('lyndrix.index',compact('total_user','xloans','transactions','direct_loans','deposits'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
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
}
