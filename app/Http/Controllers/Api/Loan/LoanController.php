<?php

namespace App\Http\Controllers\Api\Loan;

use Carbon\Carbon;
use App\Models\Loan;
use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class LoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
        $user_id =  auth()->guard('api')->user()->id;
        if(User::where('id' , $user_id)->where('status' , 'pending')->exists())
        {
            return response()->json("User's already exists loan");
        }
        else
        {
            $input = $request->all();
            $input['issuer_id'] = auth()->guard('api')->user()->id;
            $loan = Loan::create($input);
        }

        $response = [
            'message' => 'Loan created',
            'status'  => true,
            'data'    => $loan
        ];
        
        return response()->json(
            $response, 
            200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       
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

    
    public function loanDeposit(Request $request)
    {
   
        // dd(auth()->guard('api')->user()->balanceFloat);   

        $bln = DB::table('wallets')->where('holder_id', auth()->guard('api')->user()->id)->first();

        $user = auth()->guard('api')->user();

        $loan = Loan::findOrFail($request->loan_id);
        

        if (auth()->guard('api')->user()->balanceFloat >= $request->amount) {


            $user->transferFloat($loan, $request->amount);

            return response()->json(['status'=> true, 'loan_balance' => $loan->balanceFloat , 'user_balance' => auth()->guard('api')->user()->balanceFloat], 200);

            }else{
            
            return response()->json(['status'=> false,'balance' => $loan->balanceFloat], 200);

        }
    }


    public function loanHistory(Request $request)
    {
        # code...
        $user_id =  auth()->guard('api')->user()->id;
        $loan = User::where('id', $user_id)
        ->with('loans')
        ->get();

        // Previous user loan history
        $date = Carbon::now();
        $users = User::
        where('id', $user_id)->
        where('created_at', '<', $date)
        ->with('loans')
        ->get();
  
        return response()->json( [
            'loan_history' => $loan,
            'past_history' =>$users,
            ] ,  200);

    }

  public function transaction(Request $request)
    {
            $new_transactions = [];
            $transactions = auth()->guard('api')->user()->transfers()->get();
            // foreach($transactions as $key => $transaction){
        // dd($transactions);
       
            
        //     $new_transactions[$key]['transaction'] = $transaction;
        //     $new_transactions[$key]['transfer'] = Transaction::where('id',$transaction->deposit_id)->first();
        //     // dd($new_transactions[$key]['transfer']);
        //     $loan_id = Xloan::where('lyn_id' , Auth::guard('api')->user()->id)->where('status','accepted')->pluck('id');
        //     // dd($loan_id);
        //     $new_transactions[$key]['loan_details'] = Xloan::where('id', $loan_id)->first();

        // }
      
        $loans = Xloan::where('lyn_id' , Auth::guard('api')->user()->id)->where('status','accepted')->get();
            
        
        return response()->json(['data' => $loans], 200);
        
    }

    
}
