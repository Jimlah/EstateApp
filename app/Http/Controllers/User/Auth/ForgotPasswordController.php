<?php

namespace App\Http\Controllers\User\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ForgotPasswordController extends Controller
{
    public function __invoke()
    {
        return response()->json([
            'message' => 'Forgot Password Page',
        ]);
    }
}
