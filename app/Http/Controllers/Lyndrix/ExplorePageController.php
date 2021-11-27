<?php

namespace App\Http\Controllers\Lyndrix;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Bavix\Wallet\Exceptions\BalanceIsEmpty;

class ExplorePageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $xloans = Xloan::where('lyn_id' , NULL)->where('user_id' , '!=', Auth::guard('web')->user()->id)->get();
       
        // $xloans = Xloan::where('lyn_id' , Auth::guard('web')->user()->id)->Where('status','=','pending')->get();
        
        return view('lyndrix.explore_page.index',compact('xloans'));
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
       
        try {
            $loan = Xloan::where('id' , $id)->where('status' , 'pending')->first();
         
            $loan_user = User::where('id', $loan->user_id)->first();
             
          if ($loan) {
             $user = User::where('id' , Auth::guard('web')->user()->id)->first();
             $user->transferFloat($loan_user , $loan->amount);
             $loan->status = 'accepted';
             $loan->lyn_id = Auth::guard('web')->user()->id;
             $loan->save();
             return redirect()->route('explore_page.index')->with('success', 'Loan accepted successfully');
 
            
             
          }
          else
          {
              
          }
          } catch(BalanceIsEmpty $e)
          {
              return redirect()->route('explore_page.index')->with('success', $e->getMessage() );
          }

        
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
