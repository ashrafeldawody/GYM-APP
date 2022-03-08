<?php

namespace App\Http\Controllers;

use App\DataTables\CoachesDataTable;
use App\Http\Resources\CityManagersResource;
use App\Http\Resources\CoachResource;
use App\Models\Coach;
use App\Http\Requests\StoreCoachRequest;
use App\Http\Requests\UpdateCoachRequest;
use App\Models\Manager;
use App\Models\TrainingSession;
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
            $data = CoachResource::collection(Coach::with('gym','gym.city')->get());
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
        return [
            'formLable' => 'Coach Manager',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Manager Name',
                    'name' => 'name',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'email',
                    'label' => 'Email',
                    'name' => 'email',
                    'valueKey' => 'email'
                ],
                [
                    'type' => 'password',
                    'label' => 'Password',
                    'name' => 'password'
                ],
                [
                    'type' => 'password',
                    'label' => 'Confirm Password',
                    'name' => 'password_confirmation'
                ],
                [
                    'type' => 'text',
                    'label' => 'National Id',
                    'name' => 'national_id',
                    'valueKey' => 'national_id'
                ],
                [
                    'type' => 'radio',
                    'label' => 'Gender',
                    'name' => 'gender',
                    'valueKey' => 'gender',
                    'options' => [
                        ['value' => 'male', 'text' => 'Male'],
                        ['value' => 'female', 'text' => 'Female'],
                    ]
                ],
                [
                    'type' => 'date',
                    'label' => 'Birth Date',
                    'name' => 'birth_date',
                    'valueKey' => 'birth_date'
                ],
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCoachRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCoachRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function show(Coach $coach)
    {
        //

        echo "

                <h1> I'm here </h1>
        ";
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function edit(Coach $coach)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCoachRequest  $request
     * @param  \App\Models\Coach  $coach
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCoachRequest $request, Coach $coach)
    {
        //
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
