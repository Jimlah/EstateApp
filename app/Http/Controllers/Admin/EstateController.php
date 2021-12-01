<?php

namespace App\Http\Controllers\Admin;

use App\Models\Estate;
use App\Models\Manager;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\EstateResource;
use App\Http\Requests\StoreEstateRequest;
use App\Http\Requests\UpdateEstateRequest;

class EstateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $estates = Estate::with(['managers'])->paginate(10);

        return response()->json(EstateResource::collection($estates)->response()->getData());
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreEstateRequest $request)
    {
        $estate = Estate::create($request->only('name', 'address', 'logo', 'code'));
        $manager = Manager::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Str::random(8),
        ]);

        $estate->managers()->sync($manager->id, ['is_admin' => true]);

        return response()->json([
            'message' => 'Estate created successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Estate $estate)
    {
        return response()->json(new EstateResource($estate->load(['managers'])));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateEstateRequest $request, Estate $estate)
    {
        $estate->update($request->only('name', 'address', 'logo', 'code'));

        return response()->json([
            'message' => 'Estate updated successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Estate $estate)
    {
        $estate->delete();

        return response()->json([
            'message' => 'Estate deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
