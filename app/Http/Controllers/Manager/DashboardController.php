<?php

namespace App\Http\Controllers\Manager;

use App\Models\House;
use App\Models\Manager;
use App\Models\Visitor;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $estate_count = request()->user()->estates()->count();
        $houses_count = House::whereHas('estate', function ($query) {
            $query->whereIn('estate_id', request()->user()->estates->pluck('id'));
        })->count();

        $visitors_count = Visitor::with('estate')->whereHas('estate', function ($query) {
            $query->whereIn('estate_id', request()->user()->estates->pluck('id'));
        })->count();

        return response()->json([
            'data' =>
            [
                'houses_count' => $houses_count,
                'visitors_count' => $visitors_count,
                'estate_count' => $estate_count,
            ]
        ]);
    }
}
