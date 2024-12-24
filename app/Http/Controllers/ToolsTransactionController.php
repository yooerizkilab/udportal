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

        // Generate transaction code based on type and year
        $typeMap = [
            'Delivery Note' => 'DN',
            'Transfer' => 'TR',
            'Return' => 'RT'
        ];

        $transactionCount = ToolsTransaction::where('type', $request->type_delivery)
            ->count() + 1;
        $code = $typeMap[$request->type_delivery] . '/' . date('Y') . '/' . str_pad($transactionCount, 3, '0', STR_PAD_LEFT);

        // Prepare data
        foreach ($request->tools as $tool) {
            // Decode JSON data
            $toolData = json_decode($tool, true);
            // Periksa apakah decoding berhasil
            if (!isset($toolData['code'], $toolData['location'])) {
                return response()->json(['error' => true, 'message' => 'Data not found']);
            }
            // get code from tool
            $toolCode = Tools::where('code', $toolData['code'])->first();

            $data = [
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
            ];
        }

        return $data;

        // Start database transaction
        // DB::beginTransaction();
        // try {
        //     DB::commit();
        //     return redirect()->back()->with('success', 'Transaction ' . $code . ' created successfully.');
        // } catch (\Exception $e) {
        //     DB::rollBack();
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
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
        $deliveryNote = ToolsTransaction::with(['tools', 'sourceTransactions', 'destinationTransactions'])
            ->where('document_code', $transactions)
            ->get();

        return view('tools.transaction.edit', compact('deliveryNote'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
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

        // update transaction
        $transaction = ToolsTransaction::findOrFail($id);
        $transaction->type = $request->type_delivery;
        $transaction->driver = $request->driver_name;
        $transaction->driver_phone = $request->driver_phone;
        $transaction->delivery_date = $request->delivery_date;
        $transaction->source_project_id = $request->source_project_id;
        $transaction->destination_project_id = $request->destination_project_id;
        $transaction->notes = $request->notes;
        $transaction->save();

        // update tools
        foreach ($request->tools as $index => $toolId) {
            $tool = Tools::findOrFail($toolId);
            $tool->condition = 'Used';
            $tool->save();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $documentCode = ToolsTransaction::findOrFail($id)->document_code;
        DB::beginTransaction();
        try {
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

        // return $deliveryNote;

        // Pass data to the PDF view
        $pdf = Pdf::loadView('tools.transaction.dn', compact('deliveryNote'));

        // Return the PDF stream
        return $pdf->stream('surat-jalan' . '.pdf');
    }
}
