<?php

namespace App\Http\Controllers;

use App\Models\Employe;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\VehicleOwnership;

class VehiclesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // generate default code vehicle
        $defaultCode = 'A' . date('Ym') . sprintf('%04d', Vehicle::count() + 1);
        $vehicles = Vehicle::with('type', 'ownership')->get();
        return $vehicles;
        $vehicleTypes = VehicleType::all();
        $vehicleOwnerships = VehicleOwnership::all();
        $users = User::all();
        return view('vehicles.index', compact('vehicles', 'vehicleTypes', 'vehicleOwnerships', 'defaultCode', 'users'));
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
        // Validate the form data
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'status' => 'required|in:Active,Maintenance,Inactive',
            'vehicle_type' => 'required|exists:vehicle_type,id',
            'license_plate' => 'required|string|max:255|unique:vehicle,license_plate',
            'year' => 'required',
            'ownership' => 'required|exists:vehicle_ownership,id',
            'purchase_price' => 'required|numeric|min:0',
            'purchase_date' => 'required|date',
            'tax_year' => 'required|date',
            'tax_five_years' => 'required|date',
            'inspected' => 'required|date',
            // 'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048', // Max 2MB
        ]);

        // Proses upload gambar
        // if ($request->hasFile('image')) {
        //     $image = $request->file('image');
        //     $imagePath = $image->store('vehicles', 'public'); // Simpan di storage/public/vehicles
        // }

        $data = [
            'owner_id' => $request->ownership,
            'type_id' => $request->vehicle_type,
            'code' => $request->code,
            'brand' => $request->brand,
            'status' => $request->status,
            'model' => $request->model,
            'color' => $request->color,
            'year' => date('Y', strtotime($request->year)),
            'license_plate' => $request->license_plate,
            'tax_year' => $request->tax_year,
            'tax_five_year' => $request->tax_five_year,
            'inspected' => $request->inspected,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'status' => $request->status,
            // 'image' => $imagePath,
        ];

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Vehicle ' . $vehicle->model . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error creating vehicle ' . $e->getMessage());
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
