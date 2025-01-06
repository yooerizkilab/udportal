<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Company;
use App\Models\Branch;
use App\Models\Warehouses;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $warehouses = Warehouses::all();
        $companies = Company::all();
        $branches = Branch::all();
        return view('settings.companymanage.warehouse', compact('warehouses', 'companies', 'branches'));
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
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:Raw Material,Finished Goods,Warehouse',
        ]);

        $data = [
            'company_id' => $request->company_id,
            'branch_id' => $request->branch_id,
            'code' => 'W' . str_pad(Warehouses::count() + 1, 3, '0', STR_PAD_LEFT),
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'type' => $request->type
        ];

        DB::beginTransaction();
        try {
            $warehouse = Warehouses::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Warehouse ' . $warehouse->name . ' created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $warehouses = Warehouses::findOrFail($id);
        return view('settings.companymanage.warehouseshow', compact('warehouses'));
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
        $request->validate([
            'company_id' => 'required|exists:companies,id',
            'branch_id' => 'required|exists:branches,id',
            'name' => 'required|string|max:255',
            'phone' => 'required|numeric',
            'address' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'type' => 'required|string|in:Raw Material,Finished Goods,Warehouse',
        ]);

        $data = [
            'company_id' => $request->company_id,
            'branch_id' => $request->branch_id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
            'description' => $request->description,
            'type' => $request->type
        ];

        DB::beginTransaction();
        try {
            $warehouse = Warehouses::findOrFail($id);
            $warehouse->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Warehouse ' . $warehouse->name . ' updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $warehouse = Warehouses::find($id);
            $warehouse->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Warehouse ' . $warehouse->name . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
