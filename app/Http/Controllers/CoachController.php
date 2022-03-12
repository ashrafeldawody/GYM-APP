<?php

namespace App\Http\Controllers;

use App\DataTables\CoachesDataTable;
use App\Http\Resources\CityGymResource;
use App\Http\Resources\CoachResource;
use App\Models\City;
use App\Models\Coach;
use App\Http\Requests\StoreCoachRequest;
use App\Http\Requests\UpdateCoachRequest;
use Yajra\DataTables\Facades\DataTables;

class CoachController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(CoachesDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = CoachResource::collection(Coach::with('gym', 'gym.city')->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.coaches.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $data  = CityGymResource::collection(City::with('gyms')->get());
        return [
            'formLable' => 'Coach',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Coach Name',
                    'name' => 'name',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'nestedSelect',
                    'cities' => $data,
                    'levels' => [
                        [
                            'key' => 'cities',
                            'label' => 'City',
                            'text' => 'name',
                        ],
                        [
                            'key' => 'gyms',
                            'label' => 'Gym',
                            'text' => 'name',
                            'valueKey' => 'id',
                            'inputName' => 'gym_id'
                        ],
                    ],
                ]
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCoachRequest  $request
     * @return array
     */
    public function store(StoreCoachRequest $request)
    {
        $coach = Coach::create($request->validated());
        $newCoachData = Datatables::of(CoachResource::collection([$coach]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$coach->name</b> is created successfully",
            'newRowData' => $newCoachData
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoachRequest  $request
     * @param  \App\Models\Coach  $coach
     * @return array
     */
    public function update(UpdateCoachRequest $request, $id)
    {
        $coach = Coach::find($id);
        $coachName = $coach->name;
        $trainingSessionsCount = $coach->trainingSessions->count();

        if ($request->validated()['gym_id'] == 'Select Gym') {
            $coach->update([
                'name' =>  $request->validated()['name'],
            ]);
        } else {
            if ($trainingSessionsCount) {
                return [
                    'result' => false,
                    'userMessage' => "Can't Change <b>$coachName</b> Gym Becase he is assigned to $trainingSessionsCount training Sessions"
                ];
            } else {
                $coach->update($request->validated());
            }
        }
        $newCoachData = Datatables::of(CoachResource::collection([$coach]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$coachName</b> Data Updated successfully",
            'updatedData' => $newCoachData
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Coach  $coach
     * @return array
     */
    public function destroy($id)
    {
        $coach = Coach::find($id);
        $coachName = $coach->name;
        $trainingSessionsCount = $coach->trainingSessions->count();
        if ($trainingSessionsCount) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$coachName</b> Becase he is assigned to $trainingSessionsCount training Sessions"
            ];
        } else {
            $coach->delete();
            return [
                'result' => true,
                'userMessage' => "<b>$coachName</b> has been successfully deleted"
            ];
        }
    }
}
