<?php

namespace App\Http\Controllers\X;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DirectLoanController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $user_id  = array_unique(DB::table('xloans')->where('user_id' , Auth::guard('web')->user()->id)->pluck('lyn_id')->toArray());
        $users =  User::whereIn('id',$user_id)->get();
        return view('x.direct_loan.index',compact('users'));
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
        
        // dd($request->lyn_id);
        $validator = Validator::make($request->all(), [
            // 'amount' => 'required|numeric',  
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


        $user = User::where('id' , Auth::guard('web')->user()->id)->first();
        // dd($user);
        if ($request->has('lyn_id')) {
            $user->xfriend()->attach($request->lyn_id);
        }
       return redirect()->back()->with('success', 'Direct Fund is successfully saved');
       
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
        $user = User::where('uuid', $id)->first();
      
        return view('x.direct_loan.create',compact('user'));

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
