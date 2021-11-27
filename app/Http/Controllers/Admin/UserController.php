<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserUpdateRequest;
use Illuminate\Support\Facades\Validator;
use Cartalyst\Stripe\Laravel\Facades\Stripe;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $users = User::where('id','!=', Auth::user()->id)->get();
            
            return view('backend.users.index', compact('users'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        try {
            $roles = Role::pluck('name', 'name')->all();
            return view('backend.users.create', compact('roles'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
  
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string',
            'email'    => 'required|string|email|unique:users',
            'password' => 'required|string',
            
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()], 401);
        }
        $stripe = Stripe::make('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');
        $input = $request->all();
        $input['uuid'] = uniqid();
        $input['password'] = bcrypt($input['password']);
        if($file = $request->file('avatar')){
         $name = time() . $file->getClientOriginalName();
         $file->move('public/profile',$name);
         $input['avatar'] = $name;
        }
        if($file = $request->file('license_image')){
            $name = time() . $file->getClientOriginalName();
            $file->move('public/license', $name);  
            $input['license_image'] = $name;
        }
       
        $user = User::create($input);

       
        //! Save Stripe Customer ID
        $customer = $stripe->customers()->create([
            'email' => $user->email,
        ]);
        
        //! Update Cus ID 
        $cus = User::find($user->id);
        $cus->customer_id = $customer['id'];
        $cus->save();
        
        
        $user->depositFloat(0);
        if ($request->role) {
            
            $user->assignRole($request->role);
        }
        return redirect()->route('users.index')->with('success', 'User created successfully');
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
    public function edit(User $user)
    {
        try {
            $roles = Role::pluck('name', 'name')->all();
            $userRole = $user->roles->pluck('name', 'name')->all();
            return view('backend.users.edit', compact('user', 'roles', 'userRole'));
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(UserUpdateRequest $request, User $user)
    {
        try {
            $input = $request->all();
            if (!empty($input['password'])) {
                $input['password'] = Hash::make($input['password']);
            }
            $user->update($input);
            DB::table('model_has_roles')->where('model_id', $user)->delete();
            $user->assignRole($request->input('roles'));
            return redirect()->route('users.index')->with('success', 'User updated successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        try {
            $user->delete();
            return redirect()->route('users.index')->with('success', 'User deleted successfully');
        } catch (\Exception $e) {
            return $e->getMessage();
        }
    }
}