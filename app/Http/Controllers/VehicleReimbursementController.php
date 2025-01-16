<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\VehicleReimbursement;
use App\Models\User;

class VehicleReimbursementController extends Controller
{
    /**
     *  Create a new controller instance. 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with(['employe:id,user_id,full_name'])->get();
        $reimbursements = VehicleReimbursement::all();
        return view('vehicles.reimbursement.index', compact('reimbursements', 'users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reimbursements = VehicleReimbursement::with('vehicle.assigned')
            ->whereHas('vehicle.assigned', function ($query) {
                $query->where('user_id', auth()->user()->id);
            })
            ->get();

        return view('vehicles.reimbursement.create', compact('reimbursements'));
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
        $reimbursement = VehicleReimbursement::with('vehicle.assigned')->find($id);
        return view('vehicles.reimbursement.show', compact('reimbursement'));
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
        DB::beginTransaction();
        try {
            $reimbursement = VehicleReimbursement::find($id);
            $reimbursement->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Reimbursement Deleted Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function approved(Request $request)
    {
        DB::beginTransaction();
        try {
            $reimbursement = VehicleReimbursement::find($request->id);
            $reimbursement->update([
                'status' => 'Approved'
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Reimbursement Approved Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function rejected(Request $request)
    {
        DB::beginTransaction();
        try {
            $reimbursement = VehicleReimbursement::find($request->id);
            $reimbursement->update([
                'status' => 'Rejected'
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Reimbursement Rejected Successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
