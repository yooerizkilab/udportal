<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\CostBids;
use App\Models\CostBidsItems;
use App\Models\CostBidsVendor;
use App\Models\CostBidsAnalysis;

class CostBidsAnalysisController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view bids analysis', ['only' => ['index']]);
        $this->middleware('permission:show bids analysis', ['only' => ['show']]);
        $this->middleware('permission:create bids analysis', ['only' => ['create', 'store']]);
        $this->middleware('permission:update bids analysis', ['only' => ['edit', 'update']]);
        $this->middleware('permission:print bids analysis', ['only' => ['exportPdf']]);
        $this->middleware('permission:delete bids analysis', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bids = CostBids::all();
        return view('bids.analysis.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bids.analysis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request->all();
        $request->validate([
            'project_name' => 'nullable|string|max:255',
            'bid_date' => 'required|date',
            'vendor_names' => 'required|array',
            'vendor_emails' => 'required|array',
            'vendor_phones' => 'required|array',
            'items' => 'required|array',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'nullable|integer',
            'items.*.uom' => 'required|string',
        ]);

        $romanMonths = [
            'January' => 'I',
            'February' => 'II',
            'March' => 'III',
            'April' => 'IV',
            'May' => 'V',
            'June' => 'VI',
            'July' => 'VII',
            'August' => 'VIII',
            'September' => 'IX',
            'October' => 'X',
            'November' => 'XI',
            'December' => 'XII',
        ];
        DB::beginTransaction();
        try {
            $costbid = CostBids::create([
                'code' => 'UD/BIDS/' . date('Y') . '/' . $romanMonths[date('F')] . '/' . str_pad(CostBids::count() + 1, 4, '0', STR_PAD_LEFT),
                'project_name' => $request->project_name,
                'document_date' => now(),
                'bid_date' => $request->bid_date,
            ]);

            // Simpan data vendor
            $vendorIds = [];
            foreach ($request->vendor_names as $index => $vendorName) {
                if ($vendorName || $request->vendor_emails[$index] || $request->vendor_phones[$index]) {
                    $vendor = CostBidsVendor::create([
                        'cost_bids_id' => $costbid->id,
                        'name' => $vendorName,
                        'email' => $request->vendor_emails[$index],
                        'phone' => $request->vendor_phones[$index],
                        'grand_total' => $request->input("vendor{$index}_grand_total", 0),
                        'discount' => $request->input("vendor{$index}_discount", 0),
                        'final_total' => $request->input("vendor{$index}_final_total", 0),
                        'terms_of_payment' => $request->input("terms_of_payment_vendor{$index}"),
                        'lead_time' => $request->input("lead_time_vendor{$index}"),
                    ]);
                    $vendorIds[$index] = $vendor->id;
                }
            }

            // Simpan data items
            foreach ($request->items as $itemIndex => $item) {
                if ($item['description'] || $item['quantity']) {
                    $costBidItem = CostBidsItems::create([
                        'cost_bids_id' => $costbid->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'uom' => $item['uom'],
                    ]);

                    // Simpan harga setiap vendor untuk item ini
                    for ($i = 0; $i < $request->vendor_count; $i++) {
                        if (isset($vendorIds[$i]) && isset($item["vendor{$i}_price"])) {
                            CostBidsAnalysis::create([
                                'cost_bids_item_id' => $costBidItem->id,
                                'cost_bids_vendor_id' => $vendorIds[$i],
                                'price' => $item["vendor{$i}_price"] ?? 0,
                            ]);
                        }
                    }
                }
            }

            DB::commit();
            return redirect()->back()->with('success', 'Bid ' . $costbid->code . ' created successfully');
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
        $costbid = CostBids::with('items.costBidsAnalysis', 'vendors')->find($id);
        return view('bids.analysis.show', compact('costbid'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $bidAnalysis = CostBids::with('items.costBidsAnalysis', 'vendors')->findOrFail($id);
        return view('bids.analysis.edit', compact('bidAnalysis'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $request->all();
        $request->validate([
            'project_name' => 'nullable|string|max:255',
            'bid_date' => 'required|date',
            'vendor_names' => 'required|array',
            'vendor_emails' => 'required|array',
            'vendor_phones' => 'required|array',
            'items' => 'required|array',
            'items.*.description' => 'nullable|string',
            'items.*.quantity' => 'nullable|integer',
            'items.*.uom' => 'required|string',
        ]);

        DB::beginTransaction();
        try {
            // Cari cost bid berdasarkan ID
            $costBid = CostBids::findOrFail($id);

            // Update data cost bid
            $costBid->update([
                'project_name' => $request->project_name,
                'bid_date' => $request->bid_date,
            ]);

            // Update atau tambah vendor
            $existingVendorIds = $costBid->vendors->pluck('id')->toArray();
            $updatedVendorIds = [];
            foreach ($request->vendor_names as $index => $vendorName) {
                if ($vendorName || $request->vendor_emails[$index] || $request->vendor_phones[$index]) {
                    $vendorData = [
                        'cost_bids_id' => $costBid->id,
                        'name' => $vendorName,
                        'email' => $request->vendor_emails[$index],
                        'phone' => $request->vendor_phones[$index],
                        'grand_total' => $request->input("vendor{$index}_grand_total", 0),
                        'discount' => $request->input("vendor{$index}_discount", 0),
                        'final_total' => $request->input("vendor{$index}_final_total", 0),
                        'terms_of_payment' => $request->input("terms_of_payment_vendor{$index}"),
                        'lead_time' => $request->input("lead_time_vendor{$index}"),
                    ];

                    if (isset($existingVendorIds[$index])) {
                        $vendor = CostBidsVendor::find($existingVendorIds[$index]);
                        $vendor->update($vendorData);
                        $updatedVendorIds[] = $vendor->id;
                    } else {
                        $vendor = CostBidsVendor::create($vendorData);
                        $updatedVendorIds[] = $vendor->id;
                    }
                }
            }

            // Hapus vendor yang tidak digunakan
            $vendorsToDelete = array_diff($existingVendorIds, $updatedVendorIds);
            CostBidsVendor::destroy($vendorsToDelete);

            // Update atau tambah items
            $existingItemIds = $costBid->items->pluck('id')->toArray();
            $updatedItemIds = [];
            foreach ($request->items as $itemIndex => $item) {
                if ($item['description'] || $item['quantity']) {
                    $itemData = [
                        'cost_bids_id' => $costBid->id,
                        'description' => $item['description'],
                        'quantity' => $item['quantity'],
                        'uom' => $item['uom'],
                    ];

                    if (isset($existingItemIds[$itemIndex])) {
                        $costBidItem = CostBidsItems::find($existingItemIds[$itemIndex]);
                        $costBidItem->update($itemData);
                        $updatedItemIds[] = $costBidItem->id;
                    } else {
                        $costBidItem = CostBidsItems::create($itemData);
                        $updatedItemIds[] = $costBidItem->id;
                    }

                    // Update harga vendor untuk item ini
                    for ($i = 0; $i < $request->vendor_count; $i++) {
                        $price = $item["vendor{$i}_price"] ?? 0;
                        $vendorId = $updatedVendorIds[$i] ?? null;

                        if ($vendorId && $costBidItem) {
                            $analysis = CostBidsAnalysis::where('cost_bids_item_id', $costBidItem->id)
                                ->where('cost_bids_vendor_id', $vendorId)
                                ->first();

                            if ($analysis) {
                                $analysis->update(['price' => $price]);
                            } else {
                                CostBidsAnalysis::create([
                                    'cost_bids_item_id' => $costBidItem->id,
                                    'cost_bids_vendor_id' => $vendorId,
                                    'price' => $price,
                                ]);
                            }
                        }
                    }
                }
            }

            // Hapus items yang tidak digunakan
            $itemsToDelete = array_diff($existingItemIds, $updatedItemIds);
            CostBidsItems::destroy($itemsToDelete);

            DB::commit();
            return redirect()->back()->with('success', 'Bid ' . $costBid->code . ' updated successfully');
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
            $costbid = CostBids::find($id);
            $costbid->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Bid deleted successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Generate Pdf Costbids Analysis 
     */
    public function exportPdf($id)
    {
        $costbid = CostBids::with('items.costBidsAnalysis', 'vendors')->findOrFail($id);
        return $costbid;
        $pdf = PDF::loadView('bids.analysis.pdf', compact('costbid'));
        $newFilename = 'costbids-' . str_replace('/', '-', $costbid->code) . '.pdf';
        return $pdf->stream($newFilename);
    }
}
