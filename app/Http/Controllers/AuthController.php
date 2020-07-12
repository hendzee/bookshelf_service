<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
use Throwable;

class AuthController extends Controller
{
    public function login(Request $request) {
        $user = User::where('email', $request->email)->first();

        if ($user) {
            if (Hash::check($request->password, $user->password)) {
                $token = $user->createToken('Laravel Password Grant Client')->accessToken;
                $response = [
                    'id' => $user->id,
                    'token' => $token
                ];

                return response($response, 200);
            } else {
                $response['message'] = 'Password missmatch';
                
                return response()->json($response, 422);
            }

        } else {
            $response['message'] = 'User dont exist';
            return response()->json($response, 422);
        }
    }

    public function register(Request $request) {
        $user = User::where('email', $request->email)->first();

        try {
            if ($user) {
                $response['message'] = 'User already exist';
                return response()->json($response, 400);
            }else {
                $user = new User;
    
                $user->email = $request->email;
                $user->password = $request->password;
                $user->first_name = $request->first_name;
                $user->last_name = $request->last_name;
                $user->phone = '';
                $user->photo = '';
                $user->rating = 5;
    
                $user->save();
    
                return $request;
            }
        } catch (Throwable $th) {
            $response['message'] = 'Create user failed';
            return response()->json($response, 400);
        }
    }
}
