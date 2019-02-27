<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = DB::table('users')->where('role_id', 2 && 'role_id', 3)->get();
        if($users){
            return response()->json($users);
        }
        return response()->json(['error' => 'User not found'], 404);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

       /* $this->validate($request, [
            'full_name' => 'required|string|max:255',
         //   'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6|confirmed',
            'city' => 'required'
        ]);

        $user =  User::create([
            'full_name' => $request->full_name,
          //  'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'city' => $request->city,
            'role_id' => 1
        ]);

        return response()->json($user);*/

    }

    public function logout(Request $request){
        Auth::logout();
    }

    public function login(Request $request){

    }




    public function log(Request $request){
        $this->validate($request,[
            'email' => 'required|email|exists:users',
            'password' => 'required',
        ]);

        if(Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ], $request->has('remember'))) {
            return 'success';
        }
            return 'Failed';
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
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
