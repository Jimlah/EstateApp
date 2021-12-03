<?php

namespace App\Http\Controllers\User;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\VehicleRequest;
use App\Http\Resources\VehicleResource;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $vehicles = request()->user()->vehicles;

        return response()->json(VehicleResource::collection($vehicles)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VehicleRequest $request)
    {
        request()->user()->vehicles()->create($request->validated());

        return response()->json([
            'message' => 'Vehicle created successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function show(Vehicle $vehicle)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function update(VehicleRequest $request, Vehicle $vehicle)
    {
        $vehicle->update($request->validated());

        return response()->json([
            'message' => 'Vehicle updated successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Vehicle  $vehicle
     * @return \Illuminate\Http\Response
     */
    public function destroy(Vehicle $vehicle)
    {
        $vehicle->delete();

        return response()->json([
            'message' => 'Vehicle deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
