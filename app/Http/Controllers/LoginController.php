<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(LoginRequest $request)
    {
        $credentials = $request->validated();

        $attempt = Auth::attempt($credentials);

        if (($attempt)) {
            $request->session()->regenerate();

            return response()->json($request->user());
        }

        return response()->json([
            'message' => 'The provided credentials do not match our records.',
            'errors' => [
                'email' => ['The provided credentials do not match our records.'],
            ],
        ], 422);
    }

    public function logout(Request $request)
    {
        Auth()->guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
