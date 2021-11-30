<?php

namespace App\Http\Controllers\Manager\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogOutController extends Controller
{
    public function __invoke()
    {
        $user = Auth::user();

        $user->token()->revoke();
        Auth::guard('manager')->logout();

        return response()->json([
            'message' => 'Logged out successfully',
            'status' => 'success',
        ]);
    }
}
