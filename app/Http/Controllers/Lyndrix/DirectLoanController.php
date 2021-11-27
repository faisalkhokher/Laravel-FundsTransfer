<?php

namespace App\Http\Controllers\Lyndrix;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DirectLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         $xloans = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->Where('status','=','pending')->where('request_status','=',NULL)->get();
          return view('lyndrix.direct_loan.index',compact('xloans'));
    }

    /**
     * Show the form for creating a new resource.
     * 
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
       dd($id);
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
    public function declineLoanRequestByLyn($id){
        $loan = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->where('id' , $id)->first();
     
        if($loan){
            $loan->request_status = 'declined';
            $loan->save();
            return redirect()->back()->with('success', 'Request Decline');
        }else{
            
            return redirect()->back()->with('success', 'loan not found');
        }
    }
}
