<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Tools;
use App\Models\ToolsCategorie;
use App\Models\ToolsOwners;
use App\Models\ToolsTransaction;

class ToolsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // generate default code
        $tools = Tools::all();
        $categories = ToolsCategorie::all();
        $ownerships = ToolsOwners::all();
        return view('tools.index', compact('tools', 'categories', 'ownerships'));
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
            'categories' => 'required|exists:tools_categorie,id',
            'serial_number' => 'nullable|string|max:255',
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'origin' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|in:ROL,PCS,SET,UNIT,METER,LITER,KG',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'warranty' => 'nullable|string|max:255',
            'warranty_start' => 'nullable|date',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Generate default code where category is selected
        $getCategory = ToolsCategorie::where('id', $request->categories)->first();
        // Ambil 3 huruf pertama nama kategori
        $prefix = strtoupper(substr($getCategory->name, 0, 4));
        // Cari item terakhir yang memiliki prefix sama
        $lastItem = Tools::where('code', 'LIKE', $prefix . '%')->latest('id')->first();
        // Ambil angka terakhir dari kode, jika ada
        $lastNumber = $lastItem ? intval(substr($lastItem->code, strlen($prefix))) : 0;
        // Tambahkan 1 ke angka terakhir
        $newNumber = str_pad($lastNumber + 1, 4, '0', STR_PAD_LEFT);
        // Gabungkan prefix dengan angka baru
        $code = $prefix . $newNumber;

        // image upload
        $photoFile = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = $request->name . '-' . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('img/tools'), $photoFile);
        }

        $tools = [
            'owner_id' => $request->ownership,
            'categorie_id' => $request->categories,
            'code' => $code,
            'serial_number' => $request->serial_number,
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
            'model' => $request->model,
            'year' => $request->year,
            'origin' => $request->origin,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'warranty' => $request->warranty,
            'warranty_start' => $request->warranty_start,
            'warranty_end' => $request->warranty_end,
            'photo' => $photoFile,
        ];

        DB::beginTransaction();
        try {
            $tools = Tools::create($tools);
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $tools->name . ' created successfully.');
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
        $tools = Tools::with('categorie', 'owner')->findOrFail($id);
        return view('tools.show', compact('tools'));
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
        // Validate request data
        $request->validate([
            'name' => 'required|string|max:255',
            'brand' => 'nullable|string|max:255',
            'type' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'origin' => 'nullable|string|max:255',
            'quantity' => 'nullable|integer|min:1',
            'unit' => 'nullable|in:ROL,PCS,SET,UNIT,METER,LITER,KG',
            'description' => 'nullable|string',
            'purchase_date' => 'nullable|date',
            'purchase_price' => 'nullable|numeric|min:0',
            'warranty' => 'nullable|string|max:255',
            'warranty_start' => 'nullable|date',
            'warranty_end' => 'nullable|date|after_or_equal:warranty_start',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // image upload update file exists
        $photoFile = null;
        if ($request->hasFile('photo')) {
            $photo = $request->file('photo');
            $photoFile = $request->name . '-' . '.' . $photo->getClientOriginalExtension();
            $photo->move(public_path('img/tools'), $photoFile);
        }

        $data = [
            'name' => $request->name,
            'brand' => $request->brand,
            'type' => $request->type,
            'model' => $request->model,
            'year' => $request->year,
            'origin' => $request->origin,
            'quantity' => $request->quantity,
            'unit' => $request->unit,
            'description' => $request->description,
            'purchase_date' => $request->purchase_date,
            'purchase_price' => $request->purchase_price,
            'warranty' => $request->warranty,
            'warranty_start' => $request->warranty_start,
            'warranty_end' => $request->warranty_end,
            'photo' => $photoFile,
        ];

        DB::beginTransaction();
        try {
            $tools = Tools::findOrFail($id);
            $tools->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $tools->name . ' update successfuly');
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
            'notes' => 'nullable|string',
        ]);

        // generate default code transaction combination. Ex : UD/TF/2024/XII/SEM001/TF001
        $codeTools = Tools::where('id', $request->tools_id)->first();
        $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $defaultCode = 'UD/TF/' . now()->format('Y') . '/' . $roman[now()->month - 1] . '/' . $codeTools->code . '/TF' . str_pad($codeTools->id, 4, '0', STR_PAD_LEFT);

        $dataTools = [
            'tools_id' => $request->tools_id,
            'user_id' => $request->user()->id,
            'code' => $defaultCode,
            'type' => 'Transfer',
            'from' => $request->from,
            'to' => $request->to,
            'quantity' => $request->quantity,

            'location' => 'Transfer',
            'activity' => 'Transfer',

            'notes' => $request->notes,
        ];

        $tool = Tools::findOrFail($request->tools_id);

        if ($tool->quantity < $request->quantity) {
            return redirect()->back()->with('error', 'Quantity exceeds the available quantity.');
        }

        if ($tool->condition == 'Broken' || $tool->status == 'Maintenance' || $tool->status == 'Inactive') {
            return redirect()->back()->with('error', 'Tools is broken or under maintenance or inactive, cannot be transfer.');
        }

        $toolsUpdate = [
            'condition' => 'Used',
            'quantity' => $tool->quantity - $request->quantity
        ];

        DB::beginTransaction();
        try {
            $transaction = ToolsTransaction::create($dataTools);
            $tool->update($toolsUpdate);
            DB::commit();
            return redirect()->back()->with('success', 'Tools ' . $transaction->name . ' Transfer successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while transfering the tools.');
        }
    }
}
