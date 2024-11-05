<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Cause;
use App\Models\CauseDonation;
use App\Models\User;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\View;

class CauseDonationController extends Controller
{
    public function __construct(CauseDonation $model)
    {
        $this->moduleName = "Cause Donation";
        $this->model = $model;
        $this->moduleRoute = url('admin/cause-donation');
        $this->moduleView = "admin.main.cause";

        View::share('module_name', $this->moduleName);
        View::share('module_route', $this->moduleRoute);
        View::share('module_view', $this->moduleView);

    }

    public function donations($id)
    {
        $cause = Cause::find($id);
        return view('admin.main.cause.donations', compact('cause'));
    }

    public function getDataTable(Request $request)
    {
        $causeId = $request->input('cause_id'); 
        $result = $this->model->where('cause_id', $causeId)
                    ->select('cause_donations.*', 'users.name as user_name')
                    ->where('payment_status','Completed')
                    ->leftjoin('users','cause_donations.user_id', '=', 'users.id');
    
        $result = $result->orderBy("cause_donations.created_at", "DESC");

        return DataTables::of($result)
            ->editColumn('created_at', function ($result) {
                return date("d-m-Y h:i A", strtotime($result->created_at));
            })->escapeColumns([])->addIndexColumn()->make(true);
    }

    public function donationInvoice(string $id)
    {
        $cause_donation = CauseDonation::find($id);
        $user_data = User::find($cause_donation->user_id);
        return view('admin.main.cause.invoice', compact('cause_donation', 'user_data'));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
