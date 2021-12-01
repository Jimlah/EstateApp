<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreHouseRequest;
use App\Http\Requests\UpdateHouseRequest;
use App\Http\Resources\HouseResource;
use App\Models\Estate;
use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $houses = House::whereHas('estate', function ($query) {
            $query->whereIn('estate_id', request()->user()->estates->pluck('id'));
        })->paginate(10);

        return response()->json(HouseResource::collection($houses)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreHouseRequest $request)
    {
        House::create($request->validated());

        return response()->json([
            'message' => 'House created successfully',
            'status' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function show(House $house)
    {
        return response()->json(new HouseResource($house));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateHouseRequest $request, House $house)
    {
        $house->update($request->validated());

        return response()->json([
            'message' => 'House updated successfully',
            'status' => 'success'
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\House  $house
     * @return \Illuminate\Http\Response
     */
    public function destroy(House $house)
    {
        $house->delete();

        return response()->json([
            'message' => 'House deleted successfully',
            'status' => 'success'
        ], 200);
    }
}
