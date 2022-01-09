<?php

namespace App\Http\Controllers\Manager;

use App\Models\User;
use App\Models\House;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Http\Requests\UserHouseRequest;
use App\Jobs\UserRegisteredJob;

class UserHouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(House $house)
    {
        $users = $house->users()->paginate(10);

        return response()->json(UserResource::collection($users)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserHouseRequest $request, House $house)
    {
        $user = User::create($request->validated());

        dispatch(new UserRegisteredJob($user));

        $house->users()->attach($user->id, ['is_admin' => true]);

        return response()->json([
            'message' => 'User created successfully',
            'status' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function show(House $house, User $user)
    {
        $user = $house->users()->findOrFail($user->id);

        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(UserHouseRequest $request, House $house, User $user)
    {
        $user = $house->users()->findOrFail($user->id);
        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'status' => 'success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house, User $user)
    {
        $house->users()->detach();

        return response()->json([
            'message' => 'User deleted successfully',
            'status' => 'success'
        ], 200);
    }
}
