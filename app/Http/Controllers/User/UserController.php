<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Controllers\Controller;
use App\Http\Resources\UserResource;
use App\Jobs\UserRegisteredJob;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::whereHas('Houses', function ($query) {
            $query->whereIn('house_id', request()->user()->houses->pluck('id'));
        })->paginate(10);

        return response()->json(UserResource::collection($users)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(UserRequest $request)
    {
        $password = Str::random(6);
        $data = array_merge($request->validated(), ['password' => $password]);
        $user = User::create($data);

        dispatch(new UserRegisteredJob($user, $password));

        request()->user()->houses()->findOrFail($request->house_id)->users()->attach($user->id);

        return response()->json([
            'message' => 'User created successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return response()->json(new UserResource($user));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(UserRequest $request, User $user)
    {
        $user->update($request->validated());

        return response()->json([
            'message' => 'User updated successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, User $user)
    {
        if (!$request->house_id) {
            return response()->json([
                'message' => 'House id is required',
                'status' => 'error',
            ], 422);
        }

        request()->user()->houses()->findOrFail($request->house_id)->users()->detach($user->id);

        response()->json([
            'message' => 'User detached successfully',
            'status' => 'success',
        ], 200);
    }
}
