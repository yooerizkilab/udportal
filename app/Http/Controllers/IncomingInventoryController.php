<?php

namespace App\Http\Controllers;

use App\Models\IncomingInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\IncomingShipments;
use App\Models\IncomingSupplier;
use App\Models\Branch;
use App\Models\Warehouses;

class IncomingInventoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomings = IncomingShipments::select('code', DB::raw('MAX(id) as id'), DB::raw('MAX(branch_id) as branch_id'), DB::raw('MAX(eta) as eta'), DB::raw('MAX(status) as status'),)
            ->groupBy('code')
            ->get();
        $incomings->load('branch');

        return view('incomings.inventory.index', compact('incomings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::all();
        $warehouses = Warehouses::all();
        $suppliers = IncomingSupplier::all();
        $items = IncomingInventory::all();

        return view('incomings.inventory.create', compact('branches', 'warehouses', 'suppliers', 'items'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'required|exists:incoming_suppliers,id',
            'eta' => 'required|date',
            'items' => 'required|array',
            'items.*' => 'required',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|string',
        ]);

        // Create default code for incoming ex: PO-001
        $lastCode = IncomingShipments::lockForUpdate()->max('code');
        if ($lastCode) {
            $number = (int) substr($lastCode, 3);
            $code = 'PO-' . str_pad($number + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $code = 'PO-001';
        }

        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                $items = IncomingInventory::create([
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                ]);
                $incoming = IncomingShipments::create([
                    'code' => $code,
                    'branch_id' => $request->branch_id,
                    'supplier_id' => $request->supplier_id,
                    'item_id' => $items->id,
                    'eta' => $request->eta,
                    'drop_site_id' => $request->warehouse_id,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Incoming ' . $incoming->code . ' created successfully');
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
        $getId = IncomingShipments::find($id)->code;
        $incomings = IncomingShipments::with('item', 'branch', 'drop', 'supplier')
            ->where('code', $getId)
            ->get();

        return view('incomings.inventory.show', compact('incomings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branches = Branch::all();
        $warehouses = Warehouses::all();
        $suppliers = IncomingSupplier::all();
        $items = IncomingInventory::all();

        $getId = IncomingShipments::find($id)->code;
        $incomings = IncomingShipments::with('item', 'branch', 'drop', 'supplier')
            ->where('code', $getId)
            ->get();

        return view('incomings.inventory.edit', compact('incomings', 'branches', 'warehouses', 'suppliers', 'items'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'branch_id' => 'required|exists:branches,id',
            'warehouse_id' => 'required|exists:warehouses,id',
            'supplier_id' => 'required|exists:incoming_suppliers,id',
            'eta' => 'required|date',
            'items' => 'required|array',
            'items.*' => 'required',
            'items.*.item_name' => 'required|string',
            'items.*.quantity' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Hapus data incoming dan inventory sebelumnya dengan code yang sama
            $getId = IncomingShipments::find($id)->code;
            $getItems = IncomingInventory::where('id', IncomingShipments::find($id)->item_id)->first();
            IncomingShipments::where('code', $getId)->delete();
            IncomingInventory::where('id', $getItems->id)->delete();

            // Simpan data transaksi baru
            foreach ($request->items as $item) {
                $items = IncomingInventory::create([
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
                ]);
                $incoming = IncomingShipments::find($id);
                $incoming->create([
                    'branch_id' => $request->branch_id,
                    'supplier_id' => $request->supplier_id,
                    'item_id' => $items->id,
                    'eta' => $request->eta,
                    'drop_site_id' => $request->warehouse_id,
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Incoming ' . $incoming->code . ' updated successfully');
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
            $incomingShipment = IncomingShipments::find($id);
            $getIncomingCode = $incomingShipment->code;
            IncomingShipments::where('code', $getIncomingCode)->delete();
            IncomingInventory::where('id', $incomingShipment->item_id)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Incoming ' . $getIncomingCode . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
