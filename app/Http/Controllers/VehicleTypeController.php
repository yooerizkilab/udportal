<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\VehicleType;

class VehicleTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view vehicle categories', ['only' => ['index']]);
        $this->middleware('permission:create vehicle categories', ['only' => ['create', 'store']]);
        $this->middleware('permission:update vehicle categories', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete vehicle categories', ['only' => ['destroy']]);
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
            return redirect()->back()->with('error', 'Type ' . $e->getMessage() . ' Failed to Create');
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

        $types = VehicleType::findOrFail($id);

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
            $types->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Type ' . $types->name . ' Successfully Updated');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Type ' . $e->getMessage() . ' Failed to Update');
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
            return redirect()->back()->with('success', 'Type ' . $type->name . ' Successfully Deleted');
        } catch (\Throwable $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Type ' . $e->getMessage() . ' Failed to Delete');
        }
    }
}
