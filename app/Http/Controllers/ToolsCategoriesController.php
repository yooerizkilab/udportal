<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\ToolsCategorie;

class ToolsCategoriesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
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
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Create a new tool category
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
        ];

        // Save the tool category
        DB::beginTransaction();
        try {
            $toolCategory = ToolsCategorie::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Tool category' . $toolCategory->name_categorie . ' created successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while creating the tool category');
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
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        // Update the tool category
        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'description' => $request->description,
        ];

        DB::beginTransaction();
        try {
            $toolCategory = ToolsCategorie::findOrFail($id);
            $toolCategory->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Tool category' . $toolCategory->name_categorie . ' updated successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while updating the tool category');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the tool category
        DB::beginTransaction();
        try {
            $toolCategory = ToolsCategorie::findOrFail($id);
            $toolCategory->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Tool category' . $toolCategory->name_categorie . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while deleting the tool category');
        }
    }
}
