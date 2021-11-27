<?php

namespace App\Http\Controllers\Api\Plaid;

use Illuminate\Http\Request;
use TomorrowIdeas\Plaid\Plaid;
use App\Http\Controllers\Controller;
use TomorrowIdeas\Plaid\Resources\Sandbox;
use TomorrowIdeas\Plaid\PlaidRequestException;
use Illuminate\Support\Facades\Auth;
use TomorrowIdeas\Plaid\Entities\User;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PlaidController extends Controller
{
  public function plaid()
  {
    //    dd(
    //        env('PLAID_CLIENT_ID'),
    //        env('PLAID_CLIENT_SECRET'),
    //        env('PLAID_ENVIRONMENT')
    //    );


      try {
          $plaid = new Plaid(
              env('PLAID_CLIENT_ID'),
              env('PLAID_CLIENT_SECRET'),
              env('PLAID_ENVIRONMENT')
          );
           
          $token_user = new User((string)Auth::user()->id, Auth::user()->name); 
          $client_name = env('APP_NAME', 'Lyndrx');
          $language = 'en';
          $user_id = 1;
          $token = $plaid->tokens->create($client_name, $language, ["US", "CA"], $token_user, ['transactions', 'auth', 'identity']);
          $link = $plaid->tokens->get($token->link_token);
            
      } catch (PlaidRequestException $plaidRequestException) {
          dd($plaidRequestException->getResponse());
      }
      return view('backend.plaid.index', compact('link'));
  }


  public function redirect(Request $request)
  {
      $data = $request->all();

      try {
          $plaid = new Plaid(
              env('PLAID_CLIENT_ID'),
              env('PLAID_CLIENT_SECRET'),
              env('PLAID_ENVIRONMENT')
          );

          $access_token = $plaid->items->exchangeToken($data['public_token']);
          $user = \App\Models\User::find(Auth::user()->id)->fill(['paddle_access_token' => $access_token->access_token]);
          $user->paddle_access_token = $access_token->access_token;
          $user->save();
          dd($access_token,  $access_token->access_token);
//            $plaid->sandbox->($data['accounts']['institution']['institution_id'],['transactions', 'auth', 'identity']);

      } catch (PlaidRequestException $plaidRequestException) {
          dd($plaidRequestException->getResponse());
      }
  }


  public function test()
  {


      try {
          $plaid = new Plaid(
              env('PLAID_CLIENT_ID'),
              env('PLAID_CLIENT_SECRET'),
              env('PLAID_ENVIRONMENT')
          );

          $accounts = $plaid->accounts->list(Auth::user()->paddle_access_token);
          $bank_transfers = $plaid->bank_transfers->list();

          dd($bank_transfers);

      } catch (PlaidRequestException $plaidRequestException) {
          dd($plaidRequestException->getResponse());
      }
  }
  // public function payment(Type $var = null)
  // {
  //    return view('backend.plaid.index');
  // }


  // public function createUser()
  // {
  //     $plaid = new \TomorrowIdeas\Plaid\Plaid("60e72908232f3200103f70ef", "81add34cb906de523c1964a7c8fae0", "sandbox");
      
  //    /* Create Public Token */  
  //    $arr =  $plaid->user->createPublicToken(
  //        $request->institution_id,
  //        ["auth" , "identity" , "transactions" , "balance"],
  //        ['webhook' => "https://www.genericwebhookurl.com/webhook"]
  //      );
 
  //      dd($arr);
  // }


 

  
  public function fetchInstitutions()
  {
    $plaid = new \TomorrowIdeas\Plaid\Plaid("60e72908232f3200103f70ef", "81add34cb906de523c1964a7c8fae0", "sandbox");
     
    /* Create Public Token */  
    $ins =  $plaid->Institutions->list(
        "200",
        "0",
        ["US"],
      );
      return response()->json($ins, 200, );
  }
  
  public function Instantiate(Request $request)
   {
    $curl = curl_init();

    curl_setopt_array($curl, array(
      CURLOPT_URL => 'https://sandbox.plaid.com/link/token/create',
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => '',
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => 'POST',
      CURLOPT_POSTFIELDS =>'{
      "client_id": "60e72908232f3200103f70ef",
      "secret": "81add34cb906de523c1964a7c8fae0",
      "client_name": "LYNDrX",
      "country_codes": ["US"],
      "language": "en",
      "user": {
        "client_user_id": "1"
      },
      "products": ["auth", "identity" , "transactions" ]
    }',
      CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json'
      ),
    ));
    
    $response = curl_exec($curl);
    
    curl_close($curl);
    return $response;

    // $plaid = new \TomorrowIdeas\Plaid\Plaid("60e72908232f3200103f70ef", "81add34cb906de523c1964a7c8fae0", "sandbox"); 
    // dd($plaid->user);
    // /* Create link Token */  
    // $arr =  $plaid->Tokens->create(
    //     "LYNDrX",
    //     "en",
    //     ["US"],
    //     "21",
    //     ["auth"],
    //   );
    
  }

    // public function Instantiate(Request $request)
    // {
    //  $plaid = new \TomorrowIdeas\Plaid\Plaid("60e72908232f3200103f70ef", "81add34cb906de523c1964a7c8fae0", "sandbox");
      
    //  /* Create Public Token */  
    //  $arr =  $plaid->sandbox->createPublicToken(
    //      $request->institution_id,
    //      ["auth" , "identity" , "transactions" , "balance"],
    //      ['webhook' => "https://www.genericwebhookurl.com/webhook"]
    //    );
 
    //    dd($arr);
    //  /* Create access token */
 
    //  $token =  $plaid->items->exchangeToken(
    //    $arr->public_token,
    //  );
 
    //  dd($token);
    //  }


    public function qr()
    {
     $user = Auth::guard('api')->user();
     $qr =  (QrCode::format('png')->size(250)->backgroundColor(255,255,204)->generate($user->uuid));
     return response($qr)->header('Content-type','image/png');
    }

    public function link_token(Request $request)
    {
       
         try {
         
          $plaid = new Plaid(
           dd(
           
            env('PLAID_CLIENT_ID'),
            env('PLAID_CLIENT_SECRET'),
            env('PLAID_ENVIRONMENT')
           ),
              env('PLAID_CLIENT_ID'),
              env('PLAID_CLIENT_SECRET'),
              env('PLAID_ENVIRONMENT')
          );
          dd($plaid);
          $client_name = 'lydrx';
          $language = 'en';
          $token_user = new User((string)Auth::guard('api')->user()->id, Auth::guard('api')->user()->name); 
          $token = $plaid->tokens->create($client_name, $language, ["US", "CA"], $token_user, ['identity']);
           $link = $plaid->tokens->get($token->link_token);

      } catch (PlaidRequestException $plaidRequestException) {
          dd($plaidRequestException->getResponse());
      }
      $res = [
        'data'    =>   $link,
        'message' =>  'link token generated successfully',
        'status'  =>   true,
    ];
     return response()->json($res); 
    }
    
    public function api_redirect(Request $request)
    {
      $data = $request->all();

      try {
          $plaid = new Plaid(
              env('PLAID_CLIENT_ID'),
              env('PLAID_CLIENT_SECRET'),
              env('PLAID_ENVIRONMENT')
          );

          $access_token = $plaid->items->exchangeToken($data['public_token']);
          $user = \App\Models\User::find(Auth::guard('api')->user()->id)->fill(['paddle_access_token' => $access_token->access_token]);
          $user->paddle_access_token = $access_token->access_token;
          $user->save();
          
          return response()->json(['data' => $access_token,'msg' => 'access token', 'status' => true],200);
//            $plaid->sandbox->($data['accounts']['institution']['institution_id'],['transactions', 'auth', 'identity']);

      } catch (PlaidRequestException $plaidRequestException) {
        
          return response()->json(['data' => $plaidRequestException,'msg' => 'Expired Public Token', 'status' => true],404);
      }
      $res = [
        'data'    =>   $user,
        'message' =>  'Save Token',
        'status'  =>   true,
    ];
     return response()->json($res); 

    }
}
