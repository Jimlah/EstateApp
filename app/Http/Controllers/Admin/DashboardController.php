<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Admin;
use App\Models\House;
use App\Models\Estate;
use App\Models\Manager;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $estate_count = Estate::count();
        $user_count = User::count();
        $manager_count = Manager::count();
        $admin_count = Admin::count();

        return response()->json([
            'data' => [
                'estate_count' => $estate_count,
                'user_count' => $user_count,
                'manager_count' => $manager_count,
                'admin_count' => $admin_count,
            ],
        ]);
    }
}
