<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
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
        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        DB::beginTransaction();
        try {
            $type = VehicleType::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Type ' . $type->name . ' Succes fully created');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while transfering the tools.');
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
        $type = VehicleType::findOrFail($id);

        $request->validate([
            'name' => 'required|string',
            'description' => 'required|string'
        ]);

        $data = [
            'name' => $request->name,
            'description' => $request->description,
        ];

        DB::beginTransaction();
        try {
            $type->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Type ' . $type->name . ' Succes fully updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error ' . $e->getMessage() . ' occurred while transfering the tools.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $type = VehicleType::findOrFail($id);
            $type->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Type ' . $type->name . ' Succes fully delete');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error ' . $e->getMessage() . ' occurred while transfering the tools.');
        }
    }
}
