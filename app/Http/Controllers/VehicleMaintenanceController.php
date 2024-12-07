<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Vehicle;
use App\Models\VehicleMaintenance;

class VehicleMaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view vehicle maintenance', ['only' => ['index']]);
        $this->middleware('permission:create vehicle maintenance', ['only' => ['create', 'store']]);
        $this->middleware('permission:update vehicle maintenance', ['only' => ['edit', 'update']]);
        $this->middleware('permission:complete vehicle maintenance', ['only' => ['completeMaintenance']]);
        $this->middleware('permission:cancel vehicle maintenance', ['only' => ['cancelMaintenance']]);
        $this->middleware('permission:delete vehicle maintenance', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = VehicleMaintenance::with('vehicle')->get();
        // return $maintenances;
        return view('vehicles.maintenance.maintenances', compact('maintenances'));
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
        // Validate the request data
        $request->validate([
            'vehicle_code' => 'required|exists:vehicle,code',
            'maintenances_date' => 'required|date',
            'maintenances_description' => 'nullable|string',
            'maintenances_cost' => 'required|numeric',
            'next_maintenances' => 'required|date',
        ]);

        // Create a new vehicle maintenance record
        $vehicles = Vehicle::where('code', $request->vehicle_code)->first();
        $data = [
            'vehicle_id' => $vehicles->id,
            'maintenance_date' => $request->maintenances_date,
            'description' => $request->maintenances_description,
            'cost' => $request->maintenances_cost,
            'next_maintenance' => $request->next_maintenances,
        ];

        DB::beginTransaction();
        try {
            VehicleMaintenance::create($data);
            $vehicles->update(['status' => 'Maintenance']);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance ' . $vehicles->code . ' Succes fully created');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Maintenance ' . $e->getMessage() . ' Failed to create');
        }
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
        // Validate the request data
        $request->validate([
            'maintenances_date' => 'required|date',
            'maintenances_description' => 'nullable|string',
            'maintenances_cost' => 'required|numeric',
            'next_maintenances' => 'required|date',
        ]);

        // Update the vehicle maintenance record
        $maintenance = VehicleMaintenance::find($id);
        $data = [
            'maintenance_date' => $request->maintenances_date,
            'description' => $request->maintenances_description,
            'cost' => $request->maintenances_cost,
            'next_maintenance' => $request->next_maintenances,
        ];

        DB::beginTransaction();
        try {
            $maintenance->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance ' . $maintenance->vehicle->name . ' Succes fully updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Maintenance ' . $e->getMessage() . ' Failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function completeMaintenance(Request $request, string $id)
    {
        $vehicle = VehicleMaintenance::find($id);
        DB::beginTransaction();
        try {
            $vehicle->update(['status' => 'Completed']);
            $vehicle->vehicle->update(['status' => 'Active']);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance ' . $vehicle->vehicle->name . ' Succes fully completed');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Maintenance ' . $e->getMessage() . ' Failed to complete');
        }
    }

    public function cancelMaintenance(Request $request, string $id)
    {
        $vehicle = VehicleMaintenance::find($id);
        // $vehicle->update(['status' => 'Maintenance']);
        // return redirect()->back()->with('success', 'Maintenance ' . $vehicle->vehicle->code . ' Succes fully canceled');
    }

    public function exportPdf($id)
    {
        $vehicles = VehicleMaintenance::with('vehicle')->findOrFail($id);
        $pdf = PDF::loadView('vehicles.maintenance.pdf', compact('vehicles'));
        return $pdf->stream('maintenance.pdf');
    }
}
