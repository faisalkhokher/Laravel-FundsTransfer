<?php

namespace App\Http\Controllers\Lyndrix;

use Illuminate\Http\Request;
use Bavix\Wallet\Models\Transaction;
use App\Http\Controllers\Controller;

class FundController extends Controller
{
    public function index()
    {
        $deposits = \auth()->user()->transactions(['type'=>'deposit'])->get();

        return view('lyndrix.add_funds.index',compact('deposits'));
    }
    public function withdraw()
    {

        $withdrawls  = \auth()->user()->transactions()
            ->where('type', Transaction::TYPE_WITHDRAW)
            ->get();
//        $withdrawls = \auth()->user()->transactions(['type'=>'withdraw'])->get();
        return view('lyndrix.add_funds.withdraw', compact('withdrawls'));
    }

}
