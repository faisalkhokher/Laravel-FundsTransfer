<?php

namespace App\Http\Controllers\Api\Stripe;

use App\Models\User;
use Cartalyst\Stripe\Stripe;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class StripeController extends Controller
{
    public function paymentMethod(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'payment_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $user_cusID = User::where('id' , auth()->guard('api')->user()->id)->value('customer_id');

        $stripe = Stripe::make('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');

        $paymentMethod = $stripe->paymentMethods()->attach($request->payment_id , $user_cusID);

        return response()->json(['meg' => 'Payment Method Attached' , 'status' => true], 200);
        
    }

    
    public function paymentIntent(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'amount' => 'required',
            'payment_method_id' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }

        $stripe = Stripe::make('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');

        $user_cusID = User::where('id' , auth()->guard('api')->user()->id)->value('customer_id');
       
        $paymentIntent = $stripe->paymentIntents()->create([
            'amount' => $request->amount,
            'customer' => $user_cusID,
            'currency' => 'usd',
            'payment_method' => $request->payment_method_id,
            'off_session' => true,
            'confirm' => true,
        ]);

        $user_id = User::where('id' , auth()->guard('api')->user()->id)->first();
        $user_id->depositFloat($paymentIntent['amount']/100);

        $paymentIntent['balance'] = Auth::guard('api')->user()->balanceFloat;

        return response()->json($paymentIntent);
       
    }


    public function fetchCards(Request $request)
    {
        $user_cusID = User::where('id' , auth()->guard('api')->user()->id)->value('customer_id');
        $stripe = Stripe::make('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');
        $paymentMethods = $stripe->paymentMethods()->all([
            'type' => 'card',
            'customer' => $user_cusID,
        ]);
        
        return response()->json($paymentMethods, 200);
    }
}