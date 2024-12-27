<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\ToolsTransaction;
use App\Models\Tools;
use App\Models\Projects;


class ToolsTransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // show all transactions where document_code, if document_code same show one transaction 
        $uniqueDocuments = ToolsTransaction::select('document_code', DB::raw('MAX(id) as id'))
            ->groupBy('document_code')
            ->get();
        $transactions = ToolsTransaction::whereIn('id', $uniqueDocuments->pluck('id'))->get();
        return view('tools.transaction.index', compact('transactions'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $projects = Projects::all();
        return view('tools.transaction.create', compact('projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'type_delivery' => 'required|string|in:Delivery Note,Transfer,Return',
            'driver_name' => 'required|string|max:255',
            'source_project_id' => 'required|exists:projects,id',
            'driver_phone' => 'required|string|max:15',
            'delivery_date' => 'required|date',
            'destination_project_id' => 'required|exists:projects,id|different:source_project_id',
            'notes' => 'nullable|string|max:1000',
            'tools' => 'required|array',
            'tools.*' => 'required|json',
        ]);

        // Generate kode transaksi
        $typeMap = [
            'Delivery Note' => 'DN',
            'Transfer' => 'TR',
            'Return' => 'RT'
        ];

        $romanMonth = [
            'Januari' => 'I',
            'Februari' => 'II',
            'Maret' => 'III',
            'April' => 'IV',
            'Mei' => 'V',
            'Juni' => 'VI',
            'Juli' => 'VII',
            'Agustus' => 'VIII',
            'September' => 'IX',
            'October' => 'X',
            'November' => 'XI',
            'December' => 'XII'
        ];

        $transactionCount = ToolsTransaction::where('type', $request->type_delivery)
            ->count() + 1;
        $code = $typeMap[$request->type_delivery] . '/' . date('Y') . '/' . $romanMonth[date('F')] . '/' . date('d') . '/' . str_pad($transactionCount, 3, '0', STR_PAD_LEFT);

        // Start database transaction
        DB::beginTransaction();
        try {
            // Loop dan simpan setiap tools
            foreach ($request->tools as $tool) {
                $toolData = json_decode($tool, true);

                if (!isset($toolData['code'], $toolData['location'])) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Invalid tool data.');
                }

                $toolCode = Tools::where('code', $toolData['code'])->first();

                if (!$toolCode) {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Tool code ' . $toolData['code'] . ' not found.');
                }

                if ($toolCode->status == 'Maintenance') {
                    DB::rollBack();
                    return redirect()->back()->with('error', 'Tool code ' . $toolData['code'] . ' is in maintenance.');
                }

                ToolsTransaction::create([
                    'user_id' => auth()->user()->id,
                    'tool_id' => $toolCode->id,
                    'source_project_id' => $request->source_project_id,
                    'destination_project_id' => $request->destination_project_id,
                    'document_code' => $code,
                    'document_date' => date('Y-m-d'),
                    'delivery_date' => $request->delivery_date,
                    'quantity' => $toolCode->quantity,
                    'driver' => $request->driver_name,
                    'driver_phone' => $request->driver_phone,
                    'type' => $request->type_delivery,
                    'last_location' => $toolData['location'],
                    'notes' => $request->notes,
                ]);

                if ($request->type_delivery === 'Return') {
                    $toolCode->update([
                        'condition' => 'New'
                    ]);
                }

                $toolCode->update([
                    'condition' => 'Used'
                ]);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Transaction ' . $code . ' created successfully.');
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
        $transactions = ToolsTransaction::findOrFail($id)->document_code;
        $deliveryNote = ToolsTransaction::with(['tools', 'sourceTransactions', 'destinationTransactions'])
            ->where('document_code', $transactions)
            ->get();

        return view('tools.transaction.show', compact('deliveryNote'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $transactions = ToolsTransaction::findOrFail($id)->document_code;
        $transaction = ToolsTransaction::with(['tools', 'sourceTransactions', 'destinationTransactions'])
            ->where('document_code', $transactions)
            ->get();
        $projects = Projects::all();

        return view('tools.transaction.edit', compact('transaction', 'projects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi data input
        $request->validate([
            'type_delivery' => 'required|string|in:Delivery Note,Transfer,Return',
            'driver_name' => 'required|string|max:255',
            'source_project_id' => 'required|exists:projects,id',
            'driver_phone' => 'required|string|max:15',
            'delivery_date' => 'required|date',
            'destination_project_id' => 'required|exists:projects,id|different:source_project_id',
            'notes' => 'nullable|string|max:1000',
            'tools' => 'required|array',
            'tools.*' => 'required|json',
        ]);

        DB::beginTransaction();
        try {
            // Ambil transaksi utama untuk mendapatkan document_code
            $mainTransaction = ToolsTransaction::findOrFail($id);
            $documentCode = $mainTransaction->document_code;

            // Hapus semua transaksi dengan document_code yang sama
            ToolsTransaction::where('document_code', $documentCode)->delete();

            // Buat array untuk menyimpan data transaksi baru
            $transactionsData = [];

            // Loop setiap tool dan siapkan data transaksi
            foreach ($request->tools as $tool) {
                $toolData = json_decode($tool, true);

                if (!isset($toolData['code'], $toolData['location'])) {
                    throw new \Exception('Invalid tool data.');
                }

                $toolCode = Tools::where('code', $toolData['code'])->first();
                if (!$toolCode) {
                    throw new \Exception('Tool code ' . $toolData['code'] . ' not found.');
                }

                if ($toolCode->status == 'Maintenance') {
                    throw new \Exception('Tool code ' . $toolData['code'] . ' is in maintenance.');
                }

                // Tambahkan data transaksi baru ke array
                $transactionsData[] = [
                    'user_id' => auth()->user()->id,
                    'tool_id' => $toolCode->id,
                    'source_project_id' => $request->source_project_id,
                    'destination_project_id' => $request->destination_project_id,
                    'document_code' => $documentCode,
                    'document_date' => $mainTransaction->document_date,
                    'delivery_date' => $request->delivery_date,
                    'quantity' => $toolCode->quantity,
                    'driver' => $request->driver_name,
                    'driver_phone' => $request->driver_phone,
                    'type' => $request->type_delivery,
                    'last_location' => $toolData['location'],
                    'notes' => $request->notes,
                    'created_at' => now(),
                    'updated_at' => now()
                ];

                // Update kondisi tool
                if ($request->type_delivery === 'Return') {
                    $toolCode->update(['condition' => 'New']);
                } else {
                    $toolCode->update(['condition' => 'Used']);
                }
            }

            // Insert semua data transaksi sekaligus
            ToolsTransaction::insert($transactionsData);

            DB::commit();
            return redirect()->back()->with('success', 'Transaction ' . $documentCode . ' updated successfully.');
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
            $documentCode = ToolsTransaction::findOrFail($id)->document_code;
            ToolsTransaction::where('document_code', $documentCode)->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Transaction ' . $documentCode . ' deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error',  $e->getMessage());
        }
    }

    /**
     * Generate Delivery Note
     */
    public function generateDN(String $id)
    {
        // Dapatkan document_code berdasarkan $id
        $documentCode = ToolsTransaction::findOrFail($id)->document_code;
        // Dapatkan data delivery note
        $deliveryNote = ToolsTransaction::with(['tools', 'sourceTransactions', 'destinationTransactions'])
            ->where('document_code', $documentCode)
            ->get();

        // Pass data to the PDF view
        $pdf = Pdf::loadView('tools.transaction.dn', compact('deliveryNote'));

        // Return the PDF stream
        if ($deliveryNote->first()->type === 'Delivery Note') {
            return $pdf->stream('Delivery-Note-' . date('d-m-Y') . '.pdf');
        }

        return $pdf->download('Return-Note-' . date('d-m-Y') . '.pdf');
    }
}
