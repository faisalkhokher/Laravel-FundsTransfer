<?php

namespace App\Http\Controllers\X;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class RequestLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data = Xloan::where('user_id' , Auth::guard('web')->user()->id)->get();
    
        return view('x.request_loan.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('x.request_loan.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    
        $validator = Validator::make($request->all(), [
            'amount' => 'numeric|min:1|max:500',
            'duration' => 'required',   
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
        $input = $request->all();
        if($request->duration == 7)
        {
          $input['interest_rate'] = 10.00;
          $input['amount_with_interest'] = round($request->amount + ($request->amount * 10.00) / 100, 2);
          $input['start_date'] = Carbon::now()->format('Y/m/d');
          $input['end_date'] = Carbon::now()->addDays(7)->format('Y/m/d');
        }elseif($request->duration == 14)
        {
          $input['interest_rate'] = 15.00;
          $input['amount_with_interest'] = round($request->amount + ($request->amount * 15.00) / 100, 2);
          $input['start_date'] = Carbon::now()->format('Y/m/d');
          $input['end_date'] = Carbon::now()->addDays(14)->format('Y/m/d');
        }if($request->duration == 30)
        {
          $input['interest_rate'] = 20.00;
          $input['amount_with_interest'] = round($request->amount + ($request->amount * 20.00) / 100, 2);
          $input['start_date'] = Carbon::now()->format('Y/m/d');
          $input['end_date'] = Carbon::now()->addDays(30)->format('Y/m/d');
        }if($request->duration == 60)
        {
          $input['interest_rate'] = 25.00;
          $input['amount_with_interest'] = round($request->amount + ($request->amount * 25.00) / 100, 2);
          $input['start_date'] = Carbon::now()->format('Y/m/d');
          $input['end_date'] = Carbon::now()->addDays(60)->format('Y/m/d');
        }
        
        $input['user_id'] = Auth::guard('web')->user()->id;
        $input['status'] = 'pending';
        $data = Xloan::create($input);

       
        return redirect()->route('request_loan.index')->with('success', 'Request Loan is successfully saved');
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
    public function fund_transfer()
    {
      
        $loan = Xloan::where('user_id' , Auth::guard('web')->user()->id)->where('status' , 'accepted')->first();
        // dd($loan);
        if($loan != NULL){
           
            if(Auth::guard('web')->user()->balanceFloat >=  $loan->amount_with_interest)
            {
             
                $lender = User::where('id', $loan->lyn_id)->first();
                $borrower =  Auth::guard('web')->user();
                $borrower->transferFloat($lender , $loan->amount_with_interest);
                $loan->status = 'completed';
               
                $loan->save();
                
                return redirect()->route('request_loan.index')->with('success', 'Amount has been transferred successfully');

            }else{
                
                return redirect()->back()->with('success', 'Balance Not Enough');
           }
        }else{
           
            return redirect()->back()->with('success', 'loan is not found');
        }

    }
 
    
}
