<?php

namespace App\Http\Controllers\Api;
use Validator;
use Carbon\Carbon;
use App\Models\User;
use App\Models\Xloan;
use Illuminate\Support\Str;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Password;


class AuthController extends Controller
{
    public $successStatus = 200;
    /**
     * Create user
     *
     * @param  [string] name
     * @param  [string] email
     * @param  [string] password
     * @param  [string] password_confirmation
     * @return [string] message
     */
    public function signup(Request $request)
    {
       
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string|confirmed',
            'role'     => 'required|integer'
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        // ! Stripe Intigration
     

        $input = $request->all();
        $input['uuid'] = uniqid();
       
        unset($input['role']);
        $input['password'] = bcrypt($input['password']);

        // Image Upload
        if ($file = $request->file('avatar')) {

            $name = time() . $file->getClientOriginalName();
            $file->move('profile', $name);
            $input['avatar'] = $name;
        }
        if($file = $request->file('license_image')){
            $name = time() . $file->getClientOriginalName();
            $file->move('license', $name);  
            $input['license_image'] = $name;
        }

       
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->accessToken;
        $success['name'] =  $user->name;

        //! Save Stripe Customer ID
       
    

        $user->sendEmailVerificationNotification();
    

        $user->depositFloat(0);
        if ($request->role) {
            
            $user->assignRole($request->role);
        }
         
         $profile = 
         [
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar,
            'uuid' => $user->uuid,
            'company_name' => $user->company_name,
            'social_code' => $user->social_code,
            'swiss_code' => $user->swiss_code,
            'license_image' => $user->license_image,
         ];

            return response()->json(
            [
            'success' => $success, 
            'profile' => $profile,
            'role' => $user->getRoleNames(),
            ]
            , $this->successStatus);
    }
    /**
     * Login user and create token
     *
     * @param  [string] email
     * @param  [string] password
     * @param  [boolean] remember_me
     * @return [string] access_token
     * @return [string] token_type
     * @return [string] expires_at
     */
    public function login(Request $request)
    {
        
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json([
                'message' => 'Unauthorized'
            ], 401);
        $user = $request->user();

        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        if ($request->remember_me)
            $token->expires_at = Carbon::now()->addWeeks(1);
         $token->save();
        // If user has not exist UUID 
        if ($user->uuid === null) {
            $uuid = User::find($user->id);
            $uuid->uuid = uniqid();
            $uuid->save();
        }
        
        

        return response()->json([
            'name'  => $user->name,
            'email' => $user->email,
            'uuid'  => $user->uuid,
            'avatar' => $user->avatar,
            'role' => $user->getRoleNames(),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
             $tokenResult->token->expires_at
            )->toDateTimeString()
        ]);
    }

    /**
     * Logout user (Revoke the token)
     *
     * @return [string] message
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    /**
     * Get the authenticated User
     *
     * @return [json] user object
     */
    public function user(Request $request)
    {
        return response()->json(
        [
            'data' => $request->user(),
            // 'role' => $request->user()->getRoleNames()
        ]
        );
    }

    public function change_password(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'password' => ['required', 'string', 'min:8', 'same:confirm-password'],

        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

      
      $id = Auth::guard('api')->user()->id;

      $user = User::where('id',$id)-> first();
      //$request->old_password = bcrypt($request->old_password);
      if($user)
      {
          if(\Hash::check($request->old_password, $user->password))
          {
            $user->password = bcrypt($request->password);
            $user->save();
            return response()->json(['message'=>'Password changed successfully','status' => 'true'], 201);
          }
          else
          {
              return response()->json(['message'=>'Incorrect old password','status'=>'false'], 400);
          }
     }

    }
    
    public function forgot_password(Request $request)
    {
        $user = User::where('email', request()->input('email'))->first();
          
        $token = Password::getRepository()->create($user);
        $user->sendPasswordResetNotification($token);   
        return response()->json(["msg" => 'Reset password link sent on your email id.']);
    }

    
    public function userBalance(Request $request)
    {
        $bln = auth()->guard('api')->user()->balanceFloat;
        return response()->json(['balance' => $bln]);
    }

    public function profileEdit(Request $request)
    {
        
        $user = User::where('id',Auth::guard('api')->user()->id)->first();
       
        $image_path = public_path("profile/".$user->avatar);
        if ($request->hasFile('avatar'))
        if (File::exists($image_path)) {
            File::delete($image_path);
        }

           $input = $request->all();
          if ($file = $request->file('avatar')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('profile', $name);
            $input['avatar'] = $name;
          }
          if ($file = $request->file('license_image')) {
            $name = time() . $file->getClientOriginalName();
            $file->move('profile', $name);
            $input['license_image'] = $name;
          }

          $user->update($input);

            return response()->json([
                'success' => true, 
                'message' => 'Your profile has been updated successfully'
                ]  
                , 200
            );
    }

    public function updateUserRole(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'role' => 'required',
        ]);
        if ($validator->fails()) {
           return response()->json(['error' => $validator->errors()], 401);
        }

       $user_role = User::where('id' , Auth::guard('api')->user()->id)->first();

       DB::table('model_has_roles')->where('model_id', $user_role->id)->delete();
       $user_role->assignRole($request->role);
       $arr = Auth::user()->roles->pluck('name');
        $res = [
            'message' => 'Role updated' .' '. $user_role->name,
            'status' => true,
            'role' =>  $arr
        ];
        return response()->json($res);
    }    
    
     public function device_token(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'device_token' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        
       // Save    
       $user = User::where('id' , Auth::guard('api')->user()->id)->first();
       $user->device_token = $request->device_token;
       $user->save();
       return response()->json("Device Token Saved.$user->name");
    } 
    public function send_verified_link(Request $request)
    {
        $user = Auth::guard('api')->user();
        $user->sendEmailVerificationNotification();
        $res = [
            'message' => 'Link send Successfully',
            'status' => true,
           
        ];
        return response()->json($res);

    }
    public function send_users_mail(Request $request)
    {
 
    $validator = Validator::make($request->all(), [

        'users' => ['required'],

    ]);
     if ($validator->fails()) {
        return response()->json(['error' => $validator->errors()], 401);
    }
    $users = User::whereIn('id', $request->users)->pluck('email')->toArray();
     foreach ($users as $mail)    
     {
        $promo_code = Auth::guard('api')->user()->promo_code; 
       
        $data = [
            'email'=>$mail,
            'promo_code' =>$promo_code,
         ];            
        Mail::send('mail.emailtemplate',$data, function($message)use($data) {
            $message->to($data['email'])
                    ->subject(Auth()->user()->name . " has send promo code");
        }); 
       
     }
    }


    public function promo_code(Request $request){
        $promo_code = Auth::guard('api')->user()->promo_code;
        if($promo_code == null){
            $promo_code = substr(md5(mt_rand()), 0, 6);
            $user = Auth::guard('api')->user();
            $user->promo_code = $promo_code;
            $user->save();
   }
    $res = [
        'status' => true,
        'promo_code' =>$promo_code
    ];
    return response()->json($res);
}    
    
    
}
