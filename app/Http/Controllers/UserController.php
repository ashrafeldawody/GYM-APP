<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\UsersDataTable;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserInfoRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(UsersDataTable $dataTable)
    {
        if (request()->ajax()) {
            $data = UserResource::collection(User::all());
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return $dataTable->render('dashboard.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        return [
            'formLable' => 'User',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'User Name',
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
                    'name' => 'password',
                    'addOnly' => true
                ],
                [
                    'type' => 'password',
                    'label' => 'Confirm Password',
                    'name' => 'password_confirmation',
                    'addOnly' => true
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
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        $avatar = !$request->has('avatar') ? ''
            : $request->file('avatar')->store('images', 'public');
        $user = User::create([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'gender' => $request->validated()['gender'],
            'birth_date' => $request->validated()['birth_date'],
            'password' => Hash::make($request->validated()['password']),
            'avatar' => $avatar,
        ]);
        $newuserData = Datatables::of(UserResource::collection([$user]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$user->name</b> has been successfully created ",
            'newRowData' => $newuserData
        ];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserInfoRequest $request, User $user)
    {
        $avatar = !$request->has('avatar') ? ''
            : $request->file('avatar')->store('images', 'public');
        $user->update([
            'name' => $request->validated()['name'],
            'email' => $request->validated()['email'],
            'gender' => $request->validated()['gender'],
            'birth_date' => $request->validated()['birth_date'],
            'avatar' => $avatar
        ]);
        $newUserData = Datatables::of(UserResource::collection([$user]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$user->name</b> Data Updated successfully",
            'updatedData' => $newUserData
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User  $user)
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $userName = $user->name;
        if ($user->purchases()->count()) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$userName</b>, the user has purchases"
            ];
        } else if ($user->attendances()->count()) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$userName</b>, the user has attendances"
            ];
        } else {
            $user->delete();
            return [
                'result' => true,
                'userMessage' => "<b>$userName</b> successfully deleted"
            ];
        }
    }
}
