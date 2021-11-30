<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;
use App\Models\Admin;

class LoginController extends Controller
{
    public function __invoke(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->guard('user')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Admin::find(auth()->guard('user')->id);

        return response()->json([
            'message' => 'Login Successful',
            'status' => 'success',
            'user' => $user,
            'token' => $user->createToken('user')->accessToken,
            'redirect' => route('user.dashboard')
        ]);
    }
}
