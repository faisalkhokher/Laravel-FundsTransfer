<?php

namespace App\Http\Controllers\X;

use App\Http\Controllers\Controller;
use Bavix\Wallet\Models\Transaction;
use Illuminate\Http\Request;

class FundController extends Controller
{
    public function index()
    {
        $deposits = \auth()->user()->transactions(['type'=>'deposit'])->get();


        return view('x.add_funds.index', compact('deposits'));
    }

    public function withdraw()
    {
        $withdrawls  = \auth()->user()->transactions()
            ->where('type', Transaction::TYPE_WITHDRAW)
            ->get();
//        $withdrawls = \auth()->user()->transactions(['type'=>'withdraw'])->get();
        return view('x.add_funds.withdraw', compact('withdrawls'));
    }
}
