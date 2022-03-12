<?php

namespace App\Http\Controllers;

use App\DataTables\PackagesDataTable;
use App\Http\Resources\PackageResource;
use App\Models\TrainingPackage;
use App\Http\Requests\StoreTrainingPackageRequest;
use App\Http\Requests\UpdateTrainingPackageRequest;
use App\Models\TrainingSession;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PackagesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PackagesDataTable $dataTable)
    {
        // This method has to return a datatables view that has these columns'
        // package_name | price in dollars | sessions_number

        if (request()->ajax()) {

            $data = PackageResource::collection(TrainingPackage::all());
            return Datatables::of($data)
                ->addIndexColumn()
                ->make(true);
        }

        return $dataTable->render('dashboard.packages.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create(): array
    {
        $users = User::get(['id', 'name'])->toArray();
        $trainingSessions = TrainingSession::get(['id', 'name'])->toArray();
        return [
            'formLable' => 'Package',
            'fields' => [
                [
                    'type' => 'text',
                    'label' => 'Package Name',
                    'name' => 'name',
                    'valueKey' => 'name'
                ],
                [
                    'type' => 'text',
                    'label' => 'Price',
                    'name' => 'price',
                    'valueKey' => 'price'
                ],
                [
                    'type' => 'text',
                    'label' => 'Sessions Number',
                    'name' => 'sessions_number',
                    'valueKey' => 'sessions_number'
                ],
            ]
        ];
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTrainingPackageRequest  $request
     * @return array
     */
    public function store(StoreTrainingPackageRequest $request): array
    {
        $package = TrainingPackage::create([
            'name' =>  $request->validated()['name'],
            'price' => $request->validated()['price'] * 100,
            'sessions_number' => $request->validated()['sessions_number'],
            'admin_id' => Auth::user()->id,
        ]);
        $newPackageData = Datatables::of(PackageResource::collection([$package]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$package->name</b> has been successfully Created",
            'newRowData' => $newPackageData
        ];
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTrainingPackageRequest  $request
     * @param  \App\Models\TrainingPackage  $trainingPackage
     */
    public function update(UpdateTrainingPackageRequest $request, $id): array
    {
        $trainingPackage = TrainingPackage::find($id);
        $trainingPackage->update([
            'name' =>  $request->validated()['name'],
            'price' => $request->validated()['price'] * 100,
            'sessions_number' => $request->validated()['sessions_number'],
        ]);
        $newPackageData = Datatables::of(PackageResource::collection([$trainingPackage]))->make(true);
        return [
            'result' => true,
            'userMessage' => "<b>$trainingPackage->name</b> has been successfully updated",
            'updatedData' => $newPackageData
        ];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TrainingPackage  $trainingPackage
     * @return array
     */
    public function destroy($id)
    {
        $trainingPackage = TrainingPackage::find($id);
        $trainingPackageName = $trainingPackage->name;
        if (count($trainingPackage->purchases)) {
            return [
                'result' => false,
                'userMessage' => "Can't delete <b>$trainingPackageName</b>, package because there is users bought it"
            ];
        } else {
            $trainingPackage->delete();
            return [
                'result' => true,
                'userMessage' => "<b>$trainingPackageName</b> has been successfully deleted"
            ];
        }
    }
}
