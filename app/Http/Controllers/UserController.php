<?php

namespace App\Http\Controllers;


use App\Models\Client;
use Illuminate\Http\Request;
use App\Models\Manager;
use App\Http\Resources\ClientResource;
use Yajra\DataTables\Facades\DataTables;
use App\DataTables\ClientsDataTable;

class ClientController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClientsDataTable $dataTable)
    {
        // dd(UserResource::collection(User::with('gym')->get()));
        // dd(UserResource::collection(User::with('gym')->get()));

        if (request()->ajax()) {
            $data = ClientResource::collection(Client::all());
            return  Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actions =
                        '<a href="#" class="btn btn-sm btn-primary">Edit</a>
                    <a href="#" class="btn btn-sm btn-danger">Delete</a>';
                    return $actions;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return $dataTable->render('dashboard.clients.index');
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
