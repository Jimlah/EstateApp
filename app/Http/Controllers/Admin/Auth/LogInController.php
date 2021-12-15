<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\LoginFormRequest;

class LogInController extends Controller
{
    public function __invoke(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');
        if (!Auth::guard('admin')->attempt($credentials)) {
            return response()->json([
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Admin::find(auth()->guard('admin')->user()->id);

        return response()->json([
            'message' => 'Login Successful',
            'status' => 'success',
            'user' => $user,
            'token' => $user->createToken('user', ['admin'])->accessToken,
            'role' => 'admin'
            // 'redirect' => route('user.dashboard')
        ]);
    }
}
