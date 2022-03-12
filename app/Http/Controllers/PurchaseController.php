<?php

namespace App\Http\Controllers;

use App\DataTables\PurchasesDataTable;
use App\Http\Resources\PurchaseResource;
use App\Models\Gym;
use App\Models\Purchase;
use App\Http\Requests\UpdatePurchaseRequest;
use App\Models\TrainingPackage;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Facades\DataTables;
use Stripe;

class PurchaseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(PurchasesDataTable $dataTable)
    {
        if (request()->ajax()) {
            return Datatables::of(PurchaseController::getData())
                ->addIndexColumn()
                ->make(true);
        }
        return $dataTable->render(
            'dashboard.purchases.index',
            [
                'weekly_revenue' => Auth::user()->revenue(7),
                'monthly_revenue' => Auth::user()->revenue(30),
                'yearly_revenue' => Auth::user()->revenue(365),
            ]
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request, Response $response)
    {
        $packages = TrainingPackage::select('id', 'name', 'price')->orderBy('name')->get();
        $users = User::select('id', 'name')->orderBy('name')->get();

        if (Auth::user()->hasRole('city_manager'))
            $gyms = Auth::user()->city->gyms;
        else if (Auth::user()->hasRole('gym_manager'))
            $gyms = Auth::user()->gym;
        else
            $gyms = Gym::select('id', 'name')->orderBy('name')->get();

        return view('dashboard.purchases.buy', compact('packages', 'users', 'gyms'));
    }

    public function pay($status)
    {
        $purchase_id = DB::table("purchases")->where('is_paid', 0)->where('manager_id', Auth::user()->id)->max('id');
        if ($purchase_id) {
            $purchase = DB::table("purchases")->where('id',$purchase_id);
            if ($status == 'success') {
                $purchase->update(['is_paid' => true]);
                Session::flash('message', 'Payment Finished Successfully');
                Session::flash('alert-class', 'alert-success');
                return redirect()->route('dashboard.purchases.create');
            } else {
                $purchase->delete();
            }
        }

        Session::flash('message', 'Payment Canceled!');
        Session::flash('alert-class', 'alert-danger');
        return redirect()->route('dashboard.purchases.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \App\Http\Requests\StorePurchaseRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'gym' => 'sometimes|exists:gyms,id',
            'user' => 'required|exists:users,id',
            'package' => 'required|exists:training_packages,id',
        ]);

        $package_id = $request->package;
        $user_id = $request->user;
        $gym_id = Auth::user()->hasRole('gym_manager') ? Auth::user()->gym->id : $request->gym;

        $package = TrainingPackage::find($request->package);

        Purchase::create([
            'user_id' => $user_id,
            'training_package_id' => $package_id,
            'amount_paid' => $package->price,
            'sessions_number' => $package->sessions_number,
            'manager_id' => Auth::user()->id,
            'gym_id' => $gym_id,
        ]);
        Stripe\Stripe::setApiKey(env('STRIPE_SECRET'));
        $session = \Stripe\Checkout\Session::create([
            'line_items' => [[
                'price_data' => [
                    'currency' => 'usd',
                    'product_data' => [
                        'name' => $package->name . ' Training Package',
                    ],
                    'unit_amount' => $package->price,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => URL::to('/dashboard/purchases/finish/success'),
            'cancel_url' => URL::to('/dashboard/purchases/finish/cancel'),
        ]);
        return redirect($session->url, 303);
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function show(Purchase $purchase)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function edit(Purchase $purchase)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Http\Requests\UpdatePurchaseRequest $request
     * @param \App\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePurchaseRequest $request, Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Purchase $purchase
     * @return \Illuminate\Http\Response
     */
    public function destroy(Purchase $purchase)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * a method that return the data object according to the logged-in user
     */
    private static function getData(): \Illuminate\Http\Resources\Json\AnonymousResourceCollection
    {
        if (Auth::user()->hasRole('gym_manager')) {
            return PurchaseResource::collection(Auth::user()->gym->purchases);
        } else if (Auth::user()->hasRole('city_manager')) {
            return PurchaseResource::collection(Auth::user()->city->purchases);
        } else {
            return PurchaseResource::collection(Purchase::with('trainingPackage', 'user', 'gym', 'gym.city')->get());
        }
    }
}
