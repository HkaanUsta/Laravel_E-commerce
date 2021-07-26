<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\user;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class authController extends Controller
{
    public function login(Request $request){
        $user = User::where('email', $request->email)->first();
        if(!$user || !Hash::check($request->password, $user->password)){
            return response([
                'message' => 'Geçersiz bilgi',
            ], 404);
        }
        $token = $user->createToken('userToken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response, 201);
    }

    public function register(Request $request){

        $request->validate([
            'phone'=>'required|min:10|max:10'
        ]);

        $user = new User;

        $user->name = $request->name;
        $user->email = $request->email;
        $user->address = $request->address;
        $user->postCode = $request->postCode;
        $user->city = $request->city;
        $user->phone = $request->phone;
        $user->password = hash::make($request->password);

        $user->save();

        $response = [
            'message' => "kayıt başarılı"
        ];

        return $response;

    }
}
