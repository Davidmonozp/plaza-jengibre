<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class AuthController extends Controller
{
    public function register(Request $request) 
    {
        try {
            $request->validate([
                'name' => ['required', 'string', 'max:255', 'unique:users'],
                'email' =>  ['required', 'email', 'unique:users,email'],
                'password' => ['required', 'confirmed', Password::defaults()],
            ]);
        
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => $request->role,
            ]);
        
            $token = $user->createToken('Token')->accessToken;
        
            return response()->json(['token' => $token], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
        
    }

   

    public function login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->password
        ];
    
        if (auth()->attempt($credentials)) {
            $user = auth()->user();
            $token = $user->createToken('Token')->accessToken;
    
            return response()->json(['token' => $token, 'role' => $user->role], 200);
        } else {
            return response()->json(['error' => 'credenciales incorrectas'], 401);
        }
    }
    
    

    public function logout(){
        $token = auth()->user()->token();

        $token->revoke();

        return response()->json(['succes' => 'Logout successfuly']);
    }

    public function perfil(Request $request)
    {
        $user = $request->user();
        return response()->json($user);
    }
}
