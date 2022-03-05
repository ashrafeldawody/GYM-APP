<?php

namespace App\Http\Controllers;

use App\DataTables\GymsDataTable;
use App\Http\Resources\CoachResource;
use App\Http\Resources\GymResource;
use App\Models\Coach;
use App\Models\Gym;
use App\Http\Requests\StoreGymRequest;
use App\Http\Requests\UpdateGymRequest;
use Yajra\DataTables\Facades\DataTables;

class GymController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GymsDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = GymResource::collection(Gym::with('city','city.manager')->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.gyms.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGymRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGymRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Gym  $gym
     * @return \Illuminate\Http\Response
     */
    public function show(Gym $gym)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Gym  $gym
     * @return \Illuminate\Http\Response
     */
    public function edit(Gym $gym)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateGymRequest  $request
     * @param  \App\Models\Gym  $gym
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateGymRequest $request, Gym $gym)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gym  $gym
     * @return \Illuminate\Http\Response
     */
    public function destroy(Gym $gym)
    {
        //
    }
}
