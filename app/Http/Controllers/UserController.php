<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $authenticatedUser = $request->user();

        if (!$authenticatedUser) {
            return response()->json("Usuario no autenticado", 404);
        }

        $users = User::all();
        return response()->json($users);
    }
}
