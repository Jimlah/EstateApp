<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Models\UserHouse;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function __invoke()
    {
        $manager = request()->user()->load('estates.houses');

        $users = $manager->estates->map(function ($estate) {
            return $estate->houses->map(function ($house) {
                return $house->users;
            });
        });
        $users = $users->flatten();

        return response()->json(UserResource::collection($users)->response()->getData(true));
    }
}
