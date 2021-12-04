<?php

namespace App\Http\Controllers\Manager;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    public function __invoke()
    {
        $vehicle = Vehicle::with('user')->whereHas('user', function ($query) {

            $houses = request()->user()->estates->map(function ($estate) {
                return $estate->houses()->with('users')->get();
            })->flatten();

            $users = $houses->map(function ($house) {
                return $house->users;
            })->flatten();

            $query->whereIn('id', $users->pluck('id'));
        })->paginate(10);

        return response()->json(VehicleResource::collection($vehicle)->response()->getData(true));
    }
}
