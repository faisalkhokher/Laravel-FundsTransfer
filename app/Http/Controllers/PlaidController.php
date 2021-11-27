<?php

namespace App\Http\Controllers;

use TomorrowIdeas\Plaid\Plaid;
use Illuminate\Http\Request;
use TomorrowIdeas\Plaid\PlaidRequestException;
use TomorrowIdeas\Plaid\Resources\Sandbox;
use TomorrowIdeas\Plaid\Entities\User;
use Illuminate\Support\Facades\Auth;

class PlaidController extends Controller
{
    public function plaid()
    {
//        dd(
//            env('PLAID_CLIENT_ID'),
//            env('PLAID_CLIENT_SECRET'),
//            env('PLAID_ENVIRONMENT')
//        );


        try {
            $plaid = new Plaid(
                env('PLAID_CLIENT_ID'),
                env('PLAID_CLIENT_SECRET'),
                env('PLAID_ENVIRONMENT')
            );

            $token_user = new User('1', '2weqwe');


//        $resource = new Resource

            $client_name = 'Usman';
            $language = 'en';
            $user_id = 1;
            $token = $plaid->tokens->create($client_name, $language, ["US", "CA"], $token_user, ['transactions', 'auth', 'identity']);

            $link = $plaid->tokens->get($token->link_token);
//        dd($link);
//        dd($token_user = new User('1', $client_name, $user->phone));
        } catch (PlaidRequestException $plaidRequestException) {
            dd($plaidRequestException->getResponse());
        }
        return view('plaid', compact('link'));
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
}
