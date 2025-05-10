<?php

use App\Http\Controllers\UserController;
use App\Http\Resources\UserResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    if ($request->user()->email_verified_at === null) {
        return response()->json(['message' => 'Email not verified'], 409);
    }
    return $request->user();
});

// Route::get('/user', function (Request $request) {
//     return UserResource::make(Auth::user());
// });

Route::get('/user',[UserController::class, 'getUser'])
    // ->middleware('auth:sanctum')
    ->name('user');