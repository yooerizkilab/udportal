<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tools;
use App\Models\ToolsCategorie;
use App\Models\ToolsStock;
use App\Models\ToolsOwners;
use App\Models\ToolsTransaction;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $tools = Tools::with('categorie', 'stock')->get();
        $toolsCategories = ToolsCategorie::all();
        $toolsOwnership = ToolsOwners::all();
        return view('tools.index', compact('tools', 'toolsCategories', 'toolsOwnership'));
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
        // Validate request data
        $request->validate([
            'ownership' => 'required|exists:tools_ownership,id',
            'code' => 'required|string|max:255|unique:tools,code',
            'name' => 'required|string|max:255',
            'categories' => 'required|exists:tools_categorie,id', // Pastikan tabel tool_categories ada
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'condition' => 'required|string|in:New,Used,Broken',
            'serial_number' => 'required|string|max:255|unique:tools,serial_number',
            'model' => 'required|string|max:255',
            'year' => 'required|date',
            'origin' => 'required|string|max:256',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|in:Pcs,Set,Rol,Unit',
            'status' => 'required|string|in:Active,Maintenance,In Active',
        ]);

        DB::beginTransaction();
        try {
            $dataTools = [
                'owner_id' => $request->ownership,
                'code' => $request->code,
                'name' => $request->name,
                'categorie_id' => $request->categories,
                'brand' => $request->brand,
                'type' => $request->type,
                'condition' => $request->condition,
                'serial_number' => $request->serial_number,
                'model' => $request->model,
                'year' => date('Y', strtotime($request->year)),
                'origin' => $request->origin,
                'status' => $request->status,
            ];
            $tools =  Tools::create($dataTools);
            $dataStock = [
                'tools_id' => $tools->id,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
            ];
            $toolsStock = ToolsStock::create($dataStock);
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $tools->name . $toolsStock->quantity . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while creating the tools.');
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

        $tools = Tools::findOrFail($id);
        // Validate request data
        $request->validate([
            'ownership' => 'required|exists:tools_ownership,id',
            'name' => 'required|string|max:255',
            'categories' => 'required|exists:tools_categorie,id', // Pastikan tabel tool_categories ada
            'brand' => 'required|string|max:255',
            'type' => 'required|string|max:255',
            'condition' => 'required|string|in:New,Used,Broken',
            'model' => 'required|string|max:255',
            'year' => 'required',
            'origin' => 'required|string|max:256',
            'quantity' => 'required|integer|min:1',
            'unit' => 'required|string|in:Pcs,Set,Rol,Unit',
            'status' => 'required|string|in:Active,Maintenance,In Active',
        ]);

        DB::beginTransaction();
        try {
            $dataTools = [
                'owner_id' => $request->ownership,
                'name' => $request->name,
                'categorie_id' => $request->categories,
                'brand' => $request->brand,
                'type' => $request->type,
                'condition' => $request->condition,
                'model' => $request->model,
                'year' => date('Y', strtotime($request->year)),
                'origin' => $request->origin,
                'status' => $request->status,
            ];
            $tools->update($dataTools);
            $dataStock = [
                'tools_id' => $tools->id,
                'quantity' => $request->quantity,
                'unit' => $request->unit,
            ];
            $toolsStock = ToolsStock::where('tools_id', $tools->id)->first();
            if (!$toolsStock) {
                $toolsStock = ToolsStock::create($dataStock);
            } else {
                $toolsStock->update($dataStock);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $tools->name . ' update successfuly');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Tools ' . $e->getMessage() . ' failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $tools = Tools::findOrFail($id);
            $tools->delete();
            DB::commit();
            return redirect()->back()->with('message', 'Tools ' . $tools->name . 'Successfully delete');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function transfer(Request $request)
    {
        $request->validate([
            'tools_id' => 'required|exists:tools,id',
            'from' => 'required|string|max:255',
            'to' => 'required|string|max:255',
            'quantity' => 'required|integer|min:1',
            // 'location' => 'required|string|max:255',
            // 'activity' => 'required|string|max:255',
            // 'transaction_date' => 'required|date',
            'notes' => 'nullable|string',
        ]);

        $dataTools = [
            'tools_id' => $request->tools_id,
            'user_id' => $request->user()->id,
            'type' => 'Transfer',
            'from' => $request->from,
            'to' => $request->to,
            'quantity' => $request->quantity,

            'location' => 'Transfer',
            'activity' => 'Transfer',

            'notes' => $request->notes,
        ];

        DB::beginTransaction();
        try {
            $tools = ToolsTransaction::create($dataTools);
            $toolsStock = ToolsStock::where('tools_id', $request->tools_id)->first();
            $toolsStock->update(['quantity' => $toolsStock->quantity - $request->quantity]);
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $tools->name . ' ' . $tools->type . ' successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while transfering the tools.');
        }
    }
}
