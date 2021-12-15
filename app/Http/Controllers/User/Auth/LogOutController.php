<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Auth;
use Illuminate\Http\Request;

class LogOutController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();
        $user->token()->revoke();
        Auth::guard('user')->logout();

        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 'success',
        ]);
    }
}
