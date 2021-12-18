<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Passport\Passport;
use Illuminate\Support\Facades\Auth;

class ValidateTokenController extends Controller
{
    public function __invoke(Request $request)
    {
        $status = false;

        if (auth()->check()) {
            $status = true;
        }
        return response()->json([
            'status' => true,
        ]);
    }
}
