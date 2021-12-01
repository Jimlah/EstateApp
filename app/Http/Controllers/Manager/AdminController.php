<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Resources\ManagerResource;
use App\Models\Estate;
use App\Models\Manager;
use Auth;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $managers = Manager::whereHas('estates', function ($query) {
            $query->whereIn('estate_id', request()->user()->estates->pluck('id'));
        })->paginate(10);
        return response()->json(ManagerResource::collection($managers)->response()->getData('true'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $manager = Manager::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);

        $estate = Estate::find($request->estate_id);

        $estate->managers()
            ->attach($manager->id, ['is_admin' => false]);

        return response()->json([
            'message' => 'Manager created successfully',
            'status' => 'success',
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Manager $manager)
    {
        return response()->json(new ManagerResource($manager));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Manager $manager)
    {
        $manager->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        return response()->json([
            'message' => 'Manager updated successfully',
            'status' => 'success',
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Manager $manager)
    {
        $manager->delete();

        return response()->json([
            'message' => 'Manager deleted successfully',
            'status' => 'success',
        ], 200);
    }
}
