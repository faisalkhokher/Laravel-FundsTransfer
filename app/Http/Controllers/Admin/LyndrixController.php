<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Xloan;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LyndrixController extends Controller
{
    public function index()
    {
        $Xloans = Xloan::with('x_user','lyn_user')->get();
        
        return view('backend.Xloans.index',compact('Xloans'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    }
 
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    }
 
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
 
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $Xloan = Xloan::findOrFail($id);
        $users = User::all();
        return view('backend.Xloans.edit', compact('Xloan','users'));
    }
 
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //  dd($request->all());
        $input = $request->all();
        $loan = Xloan::findOrFail($id);
        $loan->update($input);
        return redirect()->route('lynloan.index')->with('success', 'Updated successfully');
    
    }
 
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $Xloan = Xloan::findOrFail($id);
        $Xloan->delete();
        return redirect()->route('lynloan.index')->with('success', 'Xloan deleted successfully');
    }


}
