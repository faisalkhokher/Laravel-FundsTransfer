<?php

namespace App\Http\Controllers\Api\Xloan;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Bavix\Wallet\Exceptions\BalanceIsEmpty;
use Bavix\Wallet\Exceptions\InsufficientFunds;
use Illuminate\Pagination\LengthAwarePaginator;

class XloanController extends Controller
{
    public function storeXLoan(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'amount' => 'required|numeric',
            'duration' => 'required'
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
   
        $input['user_id'] = Auth::guard('api')->user()->id;
        $input['status'] = 'pending';
        $data = Xloan::create($input);

        // Direct Friend Request Added 
        $user = User::where('id' , Auth::guard('api')->user()->id)->first();
        // dd($user);
        if ($request->has('lyn_id')) {
            $user->xfriend()->attach($request->lyn_id);
        
        
        
        //notification start
        $user = User::where('id' , $data->lyn_id)->first();
            		    $token = $user->device_token;
            		  //  dd($token);
        $data = [
                    "to" => $token,
                    "notification" =>
                        [
                            "title" => 'Direct Request',
                            "body" => "Apply for direct request",
                            
                        ],
                        
                        "data" =>
                        [
                                "title" => 'Direct Request',
                            "body" => "Apply for direct request",
                            
                        ],
                ];
                $dataString = json_encode($data);
            
                $headers = [
                    'Authorization: key=AAAAvl8L-Xs:APA91bFw_F1lIAJAWWq_6v2rfSL4YIGgXbNIGkgUNwFDt_vMA2-n-m9Oh3fSNfep8uU7Bpy1_cWcMijbSg673q1hUBrL3Fn5f272DTursJercw_0ZWsnsZkj23a0SN2Z_j24tAqXwSEi',
                    'Content-Type: application/json',
                ];
            
                $ch = curl_init();
            
                curl_setopt($ch, CURLOPT_URL, 'https://fcm.googleapis.com/fcm/send');
                curl_setopt($ch, CURLOPT_POST, true);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_POSTFIELDS, $dataString);
            
                curl_exec($ch); 
                
            //notification ended
        }

        return $this->success('Lyndrix loan created and attach friendList' , $data);
    }
    // 
    public function exploreLoans(Request $request)
    {
     
        $lynID_null = Xloan::where('lyn_id' ,'=', NULL)->where('user_id', '!=',Auth::guard('api')->user()->id)->get();
        $loan_against_lynID = Xloan::where('user_id' ,'!=', Auth::guard('api')->user()->id)->with('user')->where('lyn_id' ,'!=',NULL)->where('status','=','pending')->get();
                             
        $res = [
            'all_loan' => $lynID_null,
            'loan_against_lynID' => $loan_against_lynID,
        ];
        return $this->success('Explore loan list' , $res);
    }

    // ! Trash 
    public function addFriend(Request $request)
    {
       $user = User::where('id' , Auth::guard('api')->user()->id)->first();
       $user->xfriend()->attach($request->xfriend_id);
       return response()->json(['msg' => 'Friend List Added' , 'status' => true]);
    }

    // ! Trash
    public function friendList(Request $request)
    {
        $user_id  = array_unique(DB::table('user_xuser')->where('user_id' , Auth::guard('api')->user()->id)->pluck('xfriend_id')->toArray());
        $users =  User::whereIn('id',$user_id)->get();
        return $this->success('X User Friend List' , $users);
    }
    
    
    public function lynFriendList(Request $request)
    {
        $x_friend  = array_unique(DB::table('user_xuser')->where('xfriend_id' , Auth::guard('api')->user()->id)->pluck('user_id')->toArray());
        $users =  User::whereIn('id',$x_friend)->get();
        return $this->success('Lyndrix Friend List' , $users);
    }

    public function acceptLoanRequestByLyn(Request $request)
    {
        // dd(Auth::guard('api')->user()->balanceFloat);

        try {
               
              $loan = Xloan::where('id' , $request->loan_id)->where('status' , 'pending')->first();
              
              
               
                if ($loan) {
                    $loan_user = User::where('id', $loan->user_id)->first();
                    $user = User::where('id' , Auth::guard('api')->user()->id)->first();
                
                    if($user->balanceFloat >= $loan->amount){
                    
                    $user->transferFloat($loan_user , $loan->amount);
                    $loan->status = 'accepted';
                    $loan->lyn_id = Auth::guard('api')->user()->id;
                    $loan->save();
                   return $this->success('Loan Accepted' , $loan);
                    }else{
                        return $this->failure('Insufficient Balance !');
                    }
                    
                }
                else
                {
                    return $this->failure('No Pending Loan Found...!');
                }
            }
            catch(BalanceIsEmpty $e)
            {
                return $e->getMessage();
            }
    }


    public function uuid_exists(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $user = User::where('uuid' , $request->uuid)->first();
        if ($user != null) {
            $res = [
                'data'    =>   $user,
                'message' =>  'User exist',
                'status'  =>   true,
            ];
            return response()->json($res, 200);
        }
        else {
            $res = [
                'message' =>  'User not exist this uuid',
                'status'  =>   false,
            ];
            return response()->json($res);
        }
    }

    public function xLoanHistory(Request $request)
    {
     
        $data = Xloan::where('user_id' , Auth::guard('api')->user()->id)->get();
        $res = [
            'data'   =>  $data,
            'message' =>  'User not exist this uuid',
            'status'  =>   false,
        ];
        return response()->json($res);
    }

    
   
    public function notificationList(Request $request)
    {
        $user = array_unique(DB::table('user_xuser')->where('xfriend_id' , Auth::guard('api')->user()->id)->pluck('user_id')->toArray());
        // dd($user);
         $users = User::whereIn('id', $user)->get();
        //  dump($loans);
         $data = [];
        
         foreach($users as $user)
         {
           $array = "Direct request send by"." ".$user->name;
           $data[] = $array;
         }
         return $this->success('Notifications' , $data);
       
    }
    public function transfer(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'uuid' => 'required',
            'amount' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        try {
            if (Hash::check($request->password , Auth::guard('api')->user()->password)) {
                $first_user = User::find(Auth::guard('api')->user()->id);
    
                if($first_user->balance/100 > $request->amount )
                {
                    $uuid_user = User::where('uuid' , $request->uuid)->first();
                   
                    $first_user->forceTransfer($uuid_user, $request->amount);
                    return response()->json(['msg' => 'Amount Transfer to'. ' '.$uuid_user->name, 'status' => true]);
                }
                else
                {
                    return response()->json(['msg' => 'User amount is less then required amount', 'status' => false]);
                }
            }
            else {
                return response()->json(['msg' => 'password not match, please try again !', 'status' => false]);
            }
        } catch(InsufficientFunds $e)
        {
            return $e->getMessage();
        }

       
    }
    public function declineLoanRequestByLyn(Request $request)
    {
        // dd(Auth::guard('api')->user()->balanceFloat);

        try {
              $loan = Xloan::where('id' , $request->loan_id)->where('status' , 'pending')->first();
              $loan_user = User::where('id', $loan->user_id)->first();
          
            if ($loan) {
               
               $loan->status = 'declined';
               $loan->lyn_id = Auth::guard('api')->user()->id;
               $loan->save();
               return $this->success('loan declined' , $loan);
            }
            else
            {
                return $this->failure('Loan Already Decline !');
            }
            } catch(BalanceIsEmpty $e)
            {
                return $e->getMessage();
            }
    }
    public function refund(Request $request)
    {
        
        $loan = Xloan::where('user_id' , Auth::guard('api')->user()->id)->where('status' , 'accepted')->first();
        if($loan != NULL){
            if(Auth::guard('api')->user()->balanceFloat >=  $loan->amount_with_interest)
            {
             
                $lender = User::where('id', $loan->lyn_id)->first();
                $borrower =  Auth::guard('api')->user();
                $borrower->transferFloat($lender , $loan->amount_with_interest);
                $loan->status = 'completed';
                $loan->save();
               
                return response()->json(['msg' => 'loan transferred'. ' '.$loan, 'status' => true]);
            }else
            {
                return response()->json(['msg' => 'Balance Not Enough', 'status' => false],400);
                
            }
        }else{
           
            return response()->json(['msg' => 'loan not found !', 'status' => false],404);
        }

    }
    public function edit_xloan(Request $request)
    {
       
        $loan = Xloan::where('
        ' , Auth::guard('api')->user()->id)->where('status' , 'accepted')->where('user_id', $request->loan_id)->first();
        if($loan)
        {
            if($loan->dur_revisions < $loan->dur_revisions_limit){ 
                  $loan->dur_revisions = $loan->dur_revisions+1;
                  $new_date = new Carbon($loan->end_date);
                 $loan->end_date = $new_date->addDays($loan->duration)->format('Y/m/d');
                $loan->save();
                 $res = [
                    'data'    =>   $loan,
                    'message' =>  'edit loan successfully',
                    'status'  =>   true,
                ];
                 return response()->json($res); 
            }else{
                return response()->json(['msg' => 'Limit Cross !', 'status' => false],404);
            }
        }else{
            return response()->json(['msg' => 'loan not found !', 'status' => false],404);
        }

    }
    public function pending_request(Request $request){
     
        $loan = Xloan::where('user_id' , Auth::guard('api')->user()->id)->where('id' , $request->loan_id)->first();

        if($loan)
        {
            if($loan->request_status != 'pending'){
                    if($loan->dur_revisions < $loan->dur_revisions_limit){ 
                        $loan->dur_revisions = $loan->dur_revisions + 1;     
                        $loan->request_status = 'pending'; 
                        $loan->request_date = Carbon::now()->format('Y/m/d');
                        $loan->save();
                    $res = [
                        'data'    =>   $loan,
                        'message' =>  'send request for date extend',
                        'status'  =>   true,
                        ];
                    return response()->json($res);   
                    }
            else{
                return response()->json(['msg' => 'Limit Cross !', 'status' => false],404);
            }
        }else{
            return response()->json(['msg' => 'Your Already Applied', 'status' => false],404);
        }
        }
        else{
            return response()->json(['msg' => 'loan not found !', 'status' => false],404);
        }
     
    }
    public function accept_request(Request $request){
        $loan = Xloan::where('lyn_id' , Auth::guard('api')->user()->id)->where('id' , $request->loan_id)->first();
        if($loan)
        {
            if($loan->dur_revisions <= $loan->dur_revisions_limit){ 
               
                $new_date = new Carbon($loan->end_date);
                $loan->end_date = $new_date->addDays($loan->duration)->format('Y/m/d');
                $loan->request_status = 'accepted';
                $loan->request_date = NULL;
                $loan->interest_rate =  $loan->interest_rate + 5;
                $loan->save();  
                $res = [
                  'data'    =>   $loan,
                  'message' =>  'edit loan successfully',
                  
                  'status'  =>   true,
              ];
               return response()->json($res); 
          }
          else{
              return response()->json(['msg' => 'Limit Cross !', 'status' => false],404);
          }
        }else{
            return response()->json(['msg' => 'loan not found !', 'status' => false],404);
        }
     
    }
    public function decline_request(Request $request)
    {
        $loan = Xloan::where('lyn_id' , Auth::guard('api')->user()->id)->where('id' , $request->loan_id)->first();
        if($loan){
            $loan->request_status = 'declined';
            $loan->save();
        }else{
            return response()->json(['msg' => 'loan not found !', 'status' => false],404);
        }
    }





}
