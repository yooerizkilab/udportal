<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ToolsOwners;

class ToolsOwnershipController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view tools ownership', ['only' => ['index']]);
        $this->middleware('permission:create tools ownership', ['only' => ['create', 'store']]);
        $this->middleware('permission:update tools ownership', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete tools ownership', ['only' => ['destroy']]);
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
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
        ]);

        // Create a new tool owner
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        DB::beginTransaction();
        try {
            $toolOwner = ToolsOwners::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Tool ' . $toolOwner->owner_name . ' owner created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed ' . $e->getMessage() . ' to create tool owner' . $e->getMessage());
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
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'address' => 'required|string|max:255',
            'phone' => 'required|numeric',
        ]);

        // Create a new tool owner
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'phone' => $request->phone,
        ];

        DB::beginTransaction();
        try {
            $toolOwner = ToolsOwners::findOrFail($id);
            $toolOwner->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Tool ' . $toolOwner->owner_name . ' owner updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed ' . $e->getMessage() . ' to update tool owner' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $toolOwner =  ToolsOwners::findOrFail($id);
            $toolOwner->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Tool owner ' . $toolOwner->owner_name . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed ' . $e->getMessage() . ' to delete tool owner');
        }
    }
}
