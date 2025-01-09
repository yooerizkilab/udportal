<?php

namespace App\Http\Controllers;

use App\Models\IncomingInventory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\IncomingShipments;
use App\Models\IncomingSupplier;
use App\Models\Branch;
use App\Models\Warehouses;

class IncomingInventoryController extends Controller
{
    /**
     * Create a new controller instance. 
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $incomings = IncomingShipments::with('branch', 'drop')->get();
        return view('incomings.inventory.index', compact('incomings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $branches = Branch::select('id', 'name')->get();
        $warehouses = Warehouses::select('id', 'name')->get();
        $suppliers = IncomingSupplier::select('id', 'name')->get();

        return view('incomings.inventory.create', compact('branches', 'warehouses', 'suppliers'));
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
            $incoming = IncomingShipments::create([
                'code' => $code,
                'branch_id' => $request->branch_id,
                'supplier_id' => $request->supplier_id,
                'eta' => $request->eta,
                'drop_site_id' => $request->warehouse_id,
            ]);

            foreach ($request->items as $item) {
                IncomingInventory::create([
                    'shipment_id' => $incoming->id,
                    'item_name' => $item['item_name'],
                    'quantity' => $item['quantity'],
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
        $incomings = IncomingShipments::with('item', 'branch', 'drop', 'supplier')->findOrFail($id);
        return view('incomings.inventory.show', compact('incomings'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $branches = Branch::select('id', 'name')->get();
        $warehouses = Warehouses::select('id', 'name')->get();
        $suppliers = IncomingSupplier::select('id', 'name')->get();
        $incomings = IncomingShipments::with('item', 'branch', 'drop', 'supplier')->findOrFail($id);

        return view('incomings.inventory.edit', compact('incomings', 'branches', 'warehouses', 'suppliers'));
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
            // Temukan data transaksi
            $incoming = IncomingShipments::findOrFail($id);

            // Update data transaksi
            $incoming->update([
                'branch_id' => $request->branch_id,
                'supplier_id' => $request->supplier_id,
                'eta' => $request->eta,
                'drop_site_id' => $request->warehouse_id,
            ]);

            // Ambil item yang ada di database untuk transaksi ini
            $existingItems = IncomingInventory::where('shipment_id', $incoming->id)
                ->pluck('id', 'item_name')
                ->toArray();

            // Data item baru dari request
            $newItems = collect($request->items)->mapWithKeys(function ($item) {
                return [$item['item_name'] => $item['quantity']];
            });

            // Hapus item yang tidak ada di data baru
            foreach ($existingItems as $itemName => $itemId) {
                if (!$newItems->has($itemName)) {
                    IncomingInventory::find($itemId)->delete();
                }
            }

            // Tambah atau update item baru
            foreach ($newItems as $itemName => $quantity) {
                IncomingInventory::updateOrCreate(
                    [
                        'shipment_id' => $incoming->id,
                        'item_name' => $itemName,
                        'quantity' => $quantity
                    ],
                );
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
            $getIncomingId = IncomingShipments::find($id);
            $getItem = IncomingInventory::where('shipment_id', $getIncomingId->id)->get();
            foreach ($getItem as $item) {
                $item->delete();
            }
            $getIncomingId->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Incoming ' . $getIncomingId->code . ' deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function printPdf(string $id)
    {
        $incomings = IncomingShipments::with('item', 'branch', 'drop', 'supplier')->findOrFail($id);
        $pdf = PDF::loadView('incomings.inventory.pdf', compact('incomings'));
        return $pdf->stream('incomings.pdf');
    }
}
