<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $user = request()->user()->load(['houses', 'vehicles', 'visitors']);

        $houses_count = $user->houses->count();
        $vehicles_count = $user->vehicles->count();
        $visitors_count = $user->visitors->count();

        return response()->json(['data' => [
            'houses_count' => $houses_count,
            'vehicles_count' => $vehicles_count,
            'visitors_count' => $visitors_count,
        ]]);
    }
}
