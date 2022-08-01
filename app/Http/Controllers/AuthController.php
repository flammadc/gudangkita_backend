<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\User;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request){
        $validated = $request->validate([
            "name" => "required|string",
            "email" => "required|string|unique:users,email",
            "password" => "required|string|confirmed",
        ]);
        
        $user = User::create([
            "name" => $validated["name"],
            "email" => $validated["email"],
            "password" => bcrypt($validated["password"]),
        ]);
        
        return response($user, 201);
    }

    public function login(Request $request){
        
        $user = User::where("email", $request->email)->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response("Wrong Email or Password", 401);
        }

        $token = $user->createToken("userToken")->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        
        return response([
            "user" => $user,
            "token" => $token
        ], 201);
    }

    public function logout($id) {
        $user = User::find($id);
        $user->tokens()->delete();

        return response("User has been Logged Out" , 200);
    }
}
