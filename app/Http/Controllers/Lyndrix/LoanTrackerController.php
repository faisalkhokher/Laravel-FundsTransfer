<?php

namespace App\Http\Controllers\Lyndrix;

use App\Models\Xloan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class LoanTrackerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       
        $new_transactions = [];
        $transactions = auth()->guard('web')->user()->transfers()->get();
    
         foreach($transactions as $key => $transaction){
          
            $new_transactions[$key]['transaction'] = $transaction;
            $new_transactions[$key]['transfer'] = Transaction::where('id',$transaction->deposit_id)->first();
            // dd($new_transactions[$key]['transfer']);
            $loan_id = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->where('status','accepted')->pluck('id');
           
            $new_transactions[$key]['loan_details'] = Xloan::where('id', $loan_id)->first();
          }
  
        return view('lyndrix.loan_tracker.index',compact('new_transactions'));

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
