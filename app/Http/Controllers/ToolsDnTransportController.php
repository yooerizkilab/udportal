<?php

namespace App\Http\Controllers;

use App\Models\Projects;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Services\SAPServices;
use App\Services\QontakSevices;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Tools;
use App\Models\ToolsTransaction;
use App\Models\User;
use App\Models\ToolsStock;
use App\Models\Vehicle;
use Carbon\Carbon;

class ToolsDnTransportController extends Controller
{
    // protected $QontakSevices;
    // protected $SapSevices;

    // public function __construct(QontakSevices $QontakSevices, SAPServices $SapSevices)
    // {
    //     // $this->middleware('auth');
    //     $this->QontakSevices = $QontakSevices;
    //     $this->SapSevices = $SapSevices;
    // }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $trans = ToolsTransaction::with(['tools', 'employee'])
            ->whereIn('type', ['Out', 'In'])
            ->get();

        return view('tools.dntransport', compact('trans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('tools.dntools.pdf');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function dnTransport()
    {
        $projects = Projects::all();
        return view('tools.dntrans', compact('projects'));
    }

    public function dnTransporting(Request $request)
    {
        // $request->validate([
        //     'codeEmploye' => 'required|string',
        //     'delivery_date' => 'required|date',
        //     'driver_name' => 'required|string|max:255',
        //     'driver_phone' => 'required|string|max:15',
        //     'source_project_id' => 'required|exists:projects,id',
        //     'destination_project_id' => 'required|exists:projects,id',
        //     'type_delivery' => 'required|string|in:Delivery Note,Transfer,Return',
        //     'notes' => 'nullable|string',
        //     'items' => 'required|array',
        //     'items.*.qr' => 'required|string', // Validasi QR di dalam array items
        //     'items.*.location' => 'required|string', // Validasi lokasi
        // ]);

        // Generate transaction code based on type and year
        $typeMap = [
            'Delivery Note' => 'DN',
            'Transfer' => 'TR',
            'Return' => 'RT'
        ];
        $transactionCount = ToolsTransaction::where('type', $request->type_delivery)
            ->count() + 1;
        $code = $typeMap[$request->type_delivery] . '/' . date('Y') . '/' . str_pad($transactionCount, 3, '0', STR_PAD_LEFT);

        // Cari user berdasarkan code employe 
        $user = User::whereHas('employe', function ($query) use ($request) {
            $query->where('code', $request->codeEmploye);
        })->with('employe')->firstOrFail();

        foreach ($request->items as $item) {

            // Cari tools berdasarkan QR code
            $tools = Tools::where('code', $item['qr'])->firstOrFail();

            // if qr code not found
            if (!$tools) {
                return response()->json(['message' => 'QR code not found.'], 404);  // 404 Not Found
            }

            if ($tools->condition == 'Broken') {
                return response()->json(['message' => 'Tools ' . $tools->name . ' is broken.'], 400);
            }
            if ($tools->status == 'Maintenance' || $tools->status == 'Inactive') {
                return response()->json(['message' => 'Tools ' . $tools->name . ' is in maintenance or inactive.'], 400);
            }

            $data = [
                'user_id' => $user->id,
                'tool_id' => $tools->id,
                'source_project_id' => $request->source_project_id,
                'destination_project_id' => $request->destination_project_id,
                'document_code' => $code,
                'document_date' => now(),
                'delivery_date' => $request->delivery_date,
                'quantity' => $tools->quantity,
                'unit' => $tools->unit,
                'driver' => $request->driver_name,
                'driver_phone' => $request->driver_phone,
                'last_location' => $item['location'],
                'type' => $request->type_delivery,
                'notes' => $request->notes
            ];
        }

        DB::beginTransaction();
        try {
            // Simpan transaksi
            $transaction = ToolsTransaction::create($data);
            // Update kondisi tools
            $tools->update(['condition' => 'Used',]);
            DB::commit();
            return response()->json([
                'success' => true,
                'message' => 'Data ' . $transaction->document_code . ' berhasil disimpan.',
                'data' => $transaction
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['message' => 'Data ' . $e->getMessage() . ' gagal disimpan.'], 400);
        }
    }

    public function pdf(Request $request)
    {
        $data = $this->dnTransporting($request);
        // $data = [
        //     'document_code' => 'DN/2024/004'
        // ];

        if (!$data) {
            return response()->json(['message' => 'Data not found'], 404);
        }

        $deliveryNote = ToolsTransaction::with(['tools', 'sourceTransactions', 'destinationTransactions'])
            ->where('document_code', $data['document_code'])
            ->get();

        // Generate PDF
        $pdf = PDF::loadView('tools.transaction.dn', compact('deliveryNote'));
        return $pdf->stream('delivery-note.pdf');
    }
}
