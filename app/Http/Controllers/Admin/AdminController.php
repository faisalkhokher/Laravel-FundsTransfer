<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $Xloans = Xloan::with('x_user','lyn_user')->paginate(5);
        $users = User::where('id','!=', Auth::user()->id)->paginate(5);
        $loan_trackers = Xloan::where('user_id' , Auth::guard('web')->user()->id)->paginate(5);
        $deposits = \auth()->user()->transactions(['type'=>'deposit'])->paginate(5);
            $total_user = User::count();
            $transactions = DB::table('transactions')->sum('amount');
            $wallet = DB::table('wallets')->sum('balance');
            $loan = Xloan::where('status', 'pending')->count();
            $loan_accepted = Xloan::where('status', 'accepted')->count();
            // x user 
            $xloan = Xloan::where('user_id' , Auth::guard('web')->user()->id)->count();
            
            // dd($transactions);
            return view('backend.index' , compact('total_user','transactions','wallet','loan','loan_accepted','xloan','deposits','loan_trackers','users','Xloans'));
        
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
