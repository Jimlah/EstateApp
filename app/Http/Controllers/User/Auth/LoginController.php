<?php

namespace App\Http\Controllers\User\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\LoginFormRequest;

class LoginController extends Controller
{
    public function __invoke(LoginFormRequest $request)
    {
        $credentials = $request->only('email', 'password');

        if (!auth()->guard('user')->attempt($credentials)) {
            return redirect()->route('user.dashboard');
        }

        return response()->json([
            'message' => 'Login Successful',
            'status' => 'success',
            'redirect' => route('user.dashboard')
        ]);
    }
}
