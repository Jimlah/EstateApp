<?php

namespace App\Http\Controllers\User\Auth;

use Auth;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;

class LoginController extends Controller
{
    public function __invoke(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::guard('user')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials',
                'status' => 'error'
            ], 401);
        }

        $user = User::find(auth()->guard('user', ['user'])->user()->id);

        return response()->json([
            'message' => 'Login Successful',
            'status' => 'success',
            'user' => $user,
            'token' => $user->createToken('user')->accessToken,
            'role' => 'user'
            // 'redirect' => route('user.dashboard')
        ]);
    }
}
