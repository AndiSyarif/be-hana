<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function register(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email:dns|unique:users,email',
            'password' => 'required|min:6',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(),422);
        }

        $register = User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ]);

        if ($register) {
            return response()->json([
                'success' => true,
                'message' => 'Register Successfully !',
                'data' => $register
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Register Failed !',
                'data' => ''
            ], 400);
        }
    }

    public function login(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        $user = User::where('email', $email)->first();

        if ($user && Hash::check($password, $user->password)) {
            $apiToken = base64_encode(Str::random(40));
    
            $user->update([
                'api_token' => $apiToken
            ]);
    
            return response()->json([
                'success' => true,
                'message' => 'Login Successfully !',
                'data' => [
                    'user' => $user,
                    'api_token' => $apiToken
                ]
            ], 201);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Login Failed !', 
                'data' => ''
            ], 400);
        }
    }
}
