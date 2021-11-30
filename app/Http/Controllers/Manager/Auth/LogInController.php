<?php

namespace App\Http\Controllers\Manager\Auth;

use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginFormRequest;

class LogInController extends Controller
{
    public function __invoke(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::guard('manager')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Manager::find(auth()->guard('manager')->user()->id);

        return response()->json([
            'message' => 'Login Successful',
            'status' => 'success',
            'user' => $user,
            'token' => $user->createToken('user')->accessToken,
            // 'redirect' => route('user.dashboard')
        ]);
    }
}
