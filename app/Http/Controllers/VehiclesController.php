<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Models\Employe;
use App\Models\Vehicle;
use App\Models\VehicleType;
use App\Models\VehicleAssignment;

class VehiclesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view vehicle', ['only' => ['index']]);
        $this->middleware('permission:create vehicle', ['only' => ['create', 'store']]);
        $this->middleware('permission:create vehicle transaction', ['only' => ['assign']]);
        $this->middleware('permission:update vehicle', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete vehicle', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicleTypes = VehicleType::all();
        $vehicleOwnerships = Company::all();
        $vehicles = Vehicle::with('type', 'ownership', 'assigned')->get();
        $users = User::all();
        return view('vehicles.index', compact('vehicles', 'vehicleTypes', 'vehicleOwnerships', 'users'));
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
            'ownership' => 'required|exists:vehicle_ownership,id',
            'license_plate' => 'required|string|max:20',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:50',
            'vehicle_type' => 'required|exists:vehicle_type,id',
            'fuel' => 'required|in:Gasoline,Diesel',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'transmission' => 'required|in:Automatic,Manual',
            'tax_year' => 'required|date',
            'tax_five_year' => 'required|date',
            'inspected' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Get default code where vehicle type is selected
        $getVehicleType = VehicleType::where('id', $request->vehicle_type)->first();
        // Ambil 4 huruf pertama nama kategori
        $prefix = strtoupper(substr($getVehicleType->name, 0, 4));
        // Cari item terakhir yang memiliki prefix sama
        $lastItem = Vehicle::where('code', 'LIKE', $prefix . '%')->latest('id')->first();
        // Ambil angka terakhir dari kode, jika ada
        $lastNumber = $lastItem ? intval(substr($lastItem->code, strlen($prefix))) : 0;
        // Tambahkan 1 ke angka terakhir
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        // Gabungkan prefix dengan angka baru
        $code = $prefix . $newNumber;

        // Proses upload gambar
        $photoFile = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = time() . '-' . $photo->getClientOriginalName();
            $photo->move(public_path('img/vehicles'), $photoFile);
        }

        $data = [
            'code' => $code,
            'type_id' => $request->vehicle_type,
            'brand' => $request->brand,
            'model' => $request->model,
            'owner_id' => $request->ownership,
            'license_plate' => $request->license_plate,
            'year' => $request->year,
            'color' => $request->color,
            'fuel' => $request->fuel,
            'transmission' => $request->transmission,
            'tax_year' => $request->tax_year,
            'tax_five_year' => $request->tax_five_year,
            'inspected' => $request->inspected,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'description' => $request->description,
            'origin' => $request->origin,
            'photo' => $photoFile,
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
        $vehicle = Vehicle::with('type', 'ownership', 'assigned', 'maintenanceRecords')->findOrFail($id);
        // return $vehicle;
        return view('vehicles.show', compact('vehicle'));
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
        // Validate the form data   
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'ownership' => 'required|exists:vehicle_ownership,id',
            'license_plate' => 'required|string|max:20',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'color' => 'required|string|max:50',
            'vehicle_type' => 'required|exists:vehicle_type,id',
            'fuel' => 'required|in:Gasoline,Diesel',
            'purchase_price' => 'nullable|numeric|min:0',
            'purchase_date' => 'nullable|date',
            'transmission' => 'required|in:Automatic,Manual',
            'tax_year' => 'required|date',
            'tax_five_year' => 'required|date',
            'inspected' => 'required|date',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Proses upload gambar
        $photoFile = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = time() . '-' . $photo->getClientOriginalName();
            $photo->move(public_path('img/vehicles'), $photoFile);
        }

        $data = [
            'type_id' => $request->vehicle_type,
            'owner_id' => $request->ownership,
            'brand' => $request->brand,
            'model' => $request->model,
            'color' => $request->color,
            'transmission' => $request->transmission,
            'fuel' => $request->fuel,
            'year' => $request->year,
            'license_plate' => $request->license_plate,
            'tax_year' => $request->tax_year,
            'tax_five_year' => $request->tax_five_year,
            'inspected' => $request->inspected,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'description' => $request->description,
            'origin' => $request->origin,
            'photo' => $photoFile,
        ];

        DB::beginTransaction();
        try {
            $vehicle = Vehicle::findOrFail($id);
            $vehicle->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Vehicle ' . $vehicle->model . ' updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error updating vehicle ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function assign(Request $request)
    {
        $request->validate([
            'employee' => 'required|exists:employe,id',
            'assignment_date' => 'required|date',
            'return_date' => 'nullable|date',
        ]);

        // Generate default code Assignment Ex : UD/SIGN/2024/VHE0001/ASGN0001++
        $getVehicle = Vehicle::where('id', $request->vehicle_id)->first();
        $getAssign = VehicleAssignment::count();
        $number = $getAssign + 1;
        $defaultCode = 'UD/SIGN' . '/' . 'VHE' . str_pad($getVehicle->code, 4, '0', STR_PAD_LEFT) . '/ASGN' . str_pad($number, 4, '0', STR_PAD_LEFT);
        $user = Employe::where('id', $request->employee)->first();

        // Check if vehicle is inactive
        if ($getVehicle->status == 'Inactive') {
            return redirect()->back()->with('error', 'Failed to assign vehicle: Vehicle is inactive.');
        }

        $data = [
            'user_id' => $request->employee,
            'vehicle_id' => $request->vehicle_id,
            'code' => $defaultCode,
            'assignment_date' => $request->assignment_date,
            'notes' => $request->notes
        ];

        DB::beginTransaction();
        try {


            DB::commit();
            return redirect()->back()->with('success', 'Vehicle assigned to ' . $user->name . ' successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error assigning vehicle ' . $e->getMessage());
        }
    }
}
