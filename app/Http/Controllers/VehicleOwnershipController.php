<?php

namespace App\Http\Controllers;

use App\Models\VehicleOwnership;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class VehicleOwnershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view vehicle ownership', ['only' => ['index']]);
        $this->middleware('permission:create vehicle ownership', ['only' => ['create', 'store']]);
        $this->middleware('permission:update vehicle ownership', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete vehicle ownership', ['only' => ['destroy']]);
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
        $request->validate([
            'name' => 'required|string'
        ]);

        $data = [
            'name' => $request->name
        ];

        DB::beginTransaction();
        try {
            $owner = VehicleOwnership::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Owner ' . $owner->name . ' Successfully Created');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Owner ' . $e->getMessage() . ' Failed to Create');
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
        $owner = VehicleOwnership::find($id);

        $request->validate([
            'name' => 'required|string'
        ]);

        $data = [
            'name' => $request->name
        ];

        DB::beginTransaction();
        try {
            $owner->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Owner' . $owner->name . ' Successfully Updated');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Owner' . $e->getMessage() . ' Failed to Update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $owner = VehicleOwnership::find($id);
            $owner->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Owner' . $owner->name . ' Successfully Deleted');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Owner' . $e->getMessage() . ' Failed to Delete');
        }
    }
}
