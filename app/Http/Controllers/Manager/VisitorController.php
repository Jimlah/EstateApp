<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Http\Requests\VisitorRequest;
use App\Http\Resources\VisitorResource;
use App\Models\Visitor;
use App\Notifications\RequestVisitorApproval;
use App\Notifications\VisitorDataUpdated;
use App\Services\VisitorServices;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public $visitorServices;

    public function __construct(VisitorServices $visitorServices)
    {
        $this->visitorServices = $visitorServices;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $visitors = Visitor::with('estate')->whereHas('estate', function ($query) {
            $query->whereIn('estate_id', request()->user()->estates->pluck('id'));
        })->paginate(10);

        return response()->json(VisitorResource::collection($visitors)->response()->getData(true));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(VisitorRequest $request)
    {
        $this->visitorServices
            ->create($request->validated())
            ->getUser()
            ->getManagers()
            ->notify(RequestVisitorApproval::class);

        return response()->json([
            'message' => 'Visitor created successfully',
            'status' => 'success'
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function show(Visitor $visitor)
    {
        return response()->json(new VisitorResource($visitor));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function update(VisitorRequest $request, Visitor $visitor)
    {
        $this->visitorServices->update($visitor, $request->validated())
            ->getUser()
            ->getManagers()
            ->notify(VisitorDataUpdated::class);

        return response()->json([
            'message' => 'Visitor updated successfully',
            'status' => 'success'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Visitor  $visitor
     * @return \Illuminate\Http\Response
     */
    public function destroy(Visitor $visitor)
    {
        $visitor->delete();

        return response()->json([
            'message' => 'Visitor deleted successfully',
            'status' => 'success'
        ]);
    }
}
