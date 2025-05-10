<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    // public function __invoke(Request $request)
    // {
    //     // Handle the request here
    //     return UserResource::make(auth()->user());
    // }
    public function getUser(Request $request)
    {
        $user = Auth::user();

        // Jika user tidak login, bisa kembalikan error (opsional)
        if (!$user) {
            return response()->json([
                'message' => 'Unauthenticated'
            ], 401);
        }
    
        // Kembalikan data user
        return response()->json($user);
    }
}
