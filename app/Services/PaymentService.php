<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Stripe\Account;
use Stripe\Customer;
use Stripe\Source;
use Stripe\Stripe;
use TomorrowIdeas\Plaid\Plaid;

class PaymentService
{
    private $plaid;
    private $stripe;


    public function __construct()
    {
        // init Plaid SDK
        $this->plaid = new Plaid(
            config('plaid.client_id'),
            config('plaid.client_secret'),
            null,
            config('plaid.environment')
        );

        // Stripe Set Key
        Stripe::setApiKey('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');
    }

    /**
     * Get link_token from plaid
     * @return object
     */
    public function plaidCreateLinkToken()
    {
        try {
            $clientName = config('app.name');
            $language = 'en';
            $countryCodes = ['US'];
            $clientUserId = 1;// TODO: auth()->id();
            $products = ['auth', 'transactions'];
            return $this->plaid->createLinkToken($clientName, $language, $countryCodes, $clientUserId, $products);
//            [
//            expiration: "2020-09-29T13:15:48Z"
//            link_token: "link-sandbox-f3f67ee1-b925-4df9-9549-9ef8a6f22921"
//            request_id: "3R8Hce2udaORWRy
//            ]
        } catch (\Exception $exception) {
            abort(500, $exception->getMessage());
        }
    }

    /**
     * Plaid - Get access token and create Stripe connect account
     * @param $publicToken
     * @param $accountID - bank account id
     * @param $accountName - bank account name
     * @return object
     */
    public function getAccessTokenAndCreateAccount($publicToken, $accountID, $accountName)
    {
        try {
            $user= '';
            if(Auth::user()==NULL){
                $user = Auth::guard('api')->User();

            }else{
                $user = Auth::user();
            }
            $jsonParsed = $this->plaid->exchangeToken($publicToken);

            // Plaid: need enable Select Account https://dashboard.plaid.com/link/account-select
            $data = $this->plaid->createStripeToken($jsonParsed->access_token, $accountID);

            $customer = '';
            $accountName = '';
            $account = '';



            if($user->stripe_account_id == null)
            {
                $account = Account::create([
                    'country' => 'US',
                    'type' => 'custom',
                    'business_type' => 'individual', //require
                    'individual' => [ //require
                        'email' => $user->email,
                        'first_name' => $user->name,
                        'last_name' => $user->name,
                        // 'business_website' => 'quichef.com'
                    ],
                    'business_profile' => [ //require
                        'url' => 'quichef.com'
                    ],
                    'requested_capabilities' => ['transfers'], //require
                    'email' => $user->email, //require
                    'external_account' => $data->stripe_bank_account_token,
                    'tos_acceptance' => [ //require
                        'date' => time(),
                        'ip' => $_SERVER['REMOTE_ADDR'],
                    ],
                    'default_currency' => 'USD',

                ]);
                $user->update([
                    'bank_account_name' => $accountName, // optional
                    'stripe_account_id' => $account->id, // required
                ]);

                return response()->json(['account' => $account]);
            }

            if ($user->stripe_customer_id == null) {
                $customer = Customer::create(
                    ["email" => $user->email]
                );
                $customer = Customer::retrieve($customer->id);
                $customer->createSource(
                    $customer->id,
                    ['source' => $data->stripe_bank_account_token]
                );

                $user->update([
                    'stripe_customer_id' => $customer->id // required
                ]);

                return response()->json(['customer' => $customer]);
            }




//            $customer->sources->create(['source' => $data->stripe_bank_account_token]);


            // Save account_id ($account->id) and $accountName to user (chef)


            return response()->json(['customer' => $customer]);
            // [
            // request_id: "kiBH0E9WhaAe3ug"
            // stripe_bank_account_token: "btok_1HWewaDcipPMJ2hZVTmHCCYd"
            // ]
        } catch (\Exception $exception) {
//            abort(500, $exception->getMessage());
        }
    }

    /**
     * Rút tiền về tài khoản ngân hàng thông qua plaid - withdrawal
     */
    public function withdrawal($amount)
    {
        $user= '';
        if(Auth::user()==NULL){
            $user = Auth::guard('api')->User();

        }else{
            $user = Auth::user();
        }
        $accountID = $user->stripe_account_id;// TODO: \auth()->user()->stripe_account_id;

//        $stripe = new \Stripe\StripeClient("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");
//        dd($stripe->balance->retrieve(), $amount);
//


        if($user->balanceFloat < $amount){
            abort(500, 'Insufficient Balance!');
        }


//        dd($accountID);
        if (!$accountID) abort(500, 'User not connected to the bank!');

        try {


            // transfer
            $data = \Stripe\Transfer::create([
                'amount' => $amount * 100,
                'currency' => 'usd',
                'destination' => $accountID,
                'transfer_group' => 'TRANSFER_CHEF',
                'source_type' => 'bank_account',
            ]);

            $user->withdrawFloat($amount);


            // save transfer to db

            // return
            return $data;
        } catch (\Exception $exception) {

            abort(500, $exception->getMessage());
        }
    }

    /**
     * Rút tiền về tài khoản ngân hàng thông qua plaid - withdrawal
     */
    public function charge($amount)
    {

        $user= '';
        if(Auth::user()==NULL){

            $user = Auth::guard('api')->User();

        }else{
            $user = Auth::user();
        }

          $customer_id = $user->stripe_customer_id;// TODO: \auth()->user()->stripe_account_id;

        if (!$customer_id) abort(500, 'User not connected to the bank!');

        try {

            $amount_with_tax = $amount + round(($amount * 2)/100, 2);

            // transfer
            $data = \Stripe\Charge::create([

                'amount' => $amount_with_tax * 100,
                'currency' => 'usd',
                'customer' => $customer_id,
//                'application_fee_amount' => round(($amount * 2)/100, 2)
            ]);

            ;
//            dd(json_decode(json_encode($data, true), true));
//            dd();
//            dd($data['message']);
//            if($data['message'] == 'message')
                $user->depositFloat($amount);
            // save transfer to db

            // return
            return $data;
        } catch (\Exception $exception) {

            abort(500, $exception->getMessage());
        }
    }
}