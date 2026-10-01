<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use App\Enums\UserRole;
use App\Http\Resources\UserResource;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $credentials = $request->validated();

        $user = User::create([
            'first_name' => $credentials['first_name'],
            'last_name' => $credentials['last_name'],
            'email' => $credentials['email'],
            'password' => Hash::make($credentials['password']),
            'role' => UserRole::USER,
        ]);

        event(new Registered($user));

        Auth::login($user);

        $request->session()->regenerate();

        return new UserResource($user);
    }
}
