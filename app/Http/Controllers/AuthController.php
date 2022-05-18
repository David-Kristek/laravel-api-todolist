<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);
        $token = $user->createToken('myapptoken')->plainTextToken; 

        $response = [
            'users' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }
    public function login(Request $request) {
        
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);
        $user = User::where('email', $fields['email'])->first(); 

        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'msg' => 'Bad cred'
            ], 401); 
        }
        $token = $user->createToken('myapptoken')->plainTextToken; 

        $response = [
            'users' => $user,
            'token' => $token
        ];
        return response($response, 201); 

    }

    public function logout(Request $request, ){
        $resp = $request->user()->currentAccessToken()->delete();
        return [
            'msg' => 'Logged out',
            'resp' => $resp
        ]; 
    }
    public function userData(Request $request) {

        return $request->user();
    }
}
