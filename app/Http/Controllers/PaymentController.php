<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PaymentService;
use Illuminate\Support\Facades\Auth;

class PaymentController
{
    /*
     * Services
     */
    private $paymentService;

    public function __construct(PaymentService $paymentService)
    {
        $this->paymentService = $paymentService;
    }

    /**
     * Plaid
     * Create link token
     * @return \Illuminate\Http\JsonResponse
     */
    public function plaidCreateLinkToken()
    {
        return response()->json($this->paymentService->plaidCreateLinkToken(), 200);
    }

    /**
     * Plaid link (view)
     * @return \Illuminate\View\View
     */
    public function plaidLink()
    {
        return view('payment.plaid-link');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAccessTokenAndCreateAccount(Request $request)
    {
      
        $publicToken = $request->get('public_token');

        $accountID = $request->get('account_id');
        $accountName = $request->get('account_name');
        if(empty($publicToken) || empty($accountID)) abort(500, 'public_token and account_id is required');

        return response()->json($this->paymentService->getAccessTokenAndCreateAccount($publicToken, $accountID, $accountName), 200);
    }

    /**
     * Just show success information
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function connectSuccess(){
        return view('payment.connect-success');
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */

    public function charge(Request $request)
    {

        $data = $this->paymentService->charge($request->amount);
        if($request->ajax()) {
            return response()->json(['data' => $data, 'message' => 'Success'], 200);
        }else{
            return redirect()->back()->with('message', 'Funds added Successful!');
        }
    }


    /**
     * Transfer
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawal(Request $request){
        $data = $this->paymentService->withdrawal($request->amount);
        if($request->ajax()){
            return response()->json(['data'=>$data,'message' => 'Success'], 200);
        }else{
            return redirect()->back()->with('message', 'Withdraw Successful!');
        }

    }



}