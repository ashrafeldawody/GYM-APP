<?php

namespace App\Http\Controllers;

use App\DataTables\GeneralManagerDataTable;
use App\Http\Requests\StoreGeneralManagerRequest;
use App\Http\Requests\UpdateGeneralManagerRequest;
use App\Http\Resources\GeneralManagerResource;
use App\Models\Manager;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\Facades\DataTables;

class GeneralManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(GeneralManagerDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = GeneralManagerResource::collection(Manager::whereDoesntHave('roles')->get());
            return DataTables::of($data)
                ->addIndexColumn()
                ->rawColumns(['action'])
                ->make(true);
        }
        return $dataTable->render('dashboard.generalManagers.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create(): array
    {
        return [
            'formLable' => 'General Manager',
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
                [
                    'type' => 'file',
                    'label' => 'Avatar Image',
                    'name' => 'avatar',
                    'valueKey' => 'avatar'
                ],
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function store(StoreGeneralManagerRequest $request)
    {
        $avatar = !$request->has('avatar') ? ''
            : $request->file('avatar')->store('images', 'public');
        $manager = Manager::create([
            'name' => $request->validated()['name'],
            'national_id' => $request->validated()['national_id'],
            'email' => $request->validated()['email'],
            'gender' => $request->validated()['gender'],
            'birth_date' => $request->validated()['birth_date'],
            'password' => Hash::make($request->validated()['password']),
            'avatar' => $avatar,
        ]);
        $newManagerData = Datatables::of(GeneralManagerResource::collection([$manager]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$manager->name</b> has been successfully created ",
            'newRowData' => $newManagerData
        ];
    }


    /**
     * Update the specified resource in storage.
     *
     * @return array
     */
    public function update(UpdateGeneralManagerRequest $request, Manager $generalManager)
    {
        $avatar = !$request->has('avatar') ? ''
            : $request->file('avatar')->store('images', 'public');
        $generalManager->update([
            'name' => $request->validated()['name'],
            'national_id' => $request->validated()['national_id'],
            'email' => $request->validated()['email'],
            'gender' => $request->validated()['gender'],
            'birth_date' => $request->validated()['birth_date'],
            'avatar' => $avatar,
        ]);
        $newManagerData = Datatables::of(GeneralManagerResource::collection([$generalManager]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$generalManager->name</b> Data Updated successfully",
            'updatedData' => $newManagerData
        ];
    }
}
