<?php

namespace App\Http\Controllers;

use App\DataTables\GymsDataTable;
use App\Http\Resources\GymResource;
use App\Models\City;
use App\Models\Gym;
use App\Http\Requests\StoreGymRequest;
use App\Http\Requests\UpdateGymRequest;
use Illuminate\Support\Facades\Auth;
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
            $data = GymResource::collection(Gym::with('city', 'city.manager')->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.gyms.index');
    }


    /*
     *         return [
            'name' => $this->faker->unique()->streetName(),
            'cover_image' => $this->faker->image('public/images',400,300,null, false),
            'city_id' => City::all()->random()->id,
            'creator_id' => Manager::role(['admin', 'city_manager'])->get()->random()->id,
        ];

     *
     *
     * */
    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $formData = [
            'formLable' => 'Gym',
            'fields' => [
                [
                    'label' => 'Gym Name',
                    'name' => 'name',
                    'type' => 'text',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'file',
                    'label' => 'Cover Image',
                    'name' => 'cover_image',
                    'valueKey' => 'cover_image'
                ]
            ]
        ];
        if (Auth::user()->hasRole('admin')) {
            $cities  = City::all();
            $formData['fields'][] = [
                'type' => 'select',
                'label' => 'City',
                'text' => 'name',
                'name' => 'city_id',
                'valueKey' => 'id',
                'compare' => 'city_name',
                'options' => $cities,
                'addOnly' => true
            ];
        }
        return $formData;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreGymRequest  $request
     * @return array
     */
    public function store(StoreGymRequest $request)
    {
        $coverImage = $request->file('cover_image') ?? '';
        $gymData = [
            'name' => $request->validated()['name'],
            'cover_image' => $coverImage,
            'creator_id' => Auth::user()->id,
        ];
        if (Auth::user()->hasRole('admin')) {
            $gymData['city_id'] = $request->validated()['city_id'];
        } else {
            $gymData['city_id'] = Auth::user()->city->id;
        }
        $gym = Gym::create($gymData);

        $newManagerData = Datatables::of(GymResource::collection([$gym]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$gym->name</b> has been successfully created ",
            'newRowData' => $newManagerData
        ];
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
     * @return array
     */
    public function update(UpdateGymRequest $request, $id)
    {
        $gym = Gym::find($id);
        $gymData = [
            'name' => $request->validated()['name'],
            'cover_image' => '',
        ];
        $gym->update($gymData);

        $newGymData = Datatables::of(GymResource::collection([$gym]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$gym->name</b> Data Updated successfully",
            'updatedData' => $newGymData
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Gym  $gym
     * @return array
     */
    public function destroy(Gym $gym)
    {
        $gymName = $gym->name;
        if (count($gym->trainingSessions)) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$gymName</b> Gym because it has training sessions"
            ];
        } else {
            $gym->delete();
            return [
                'result' => true,
                'userMessage' => "<b>$gymName</b> has been successfully deleted"
            ];
        }
    }
}
