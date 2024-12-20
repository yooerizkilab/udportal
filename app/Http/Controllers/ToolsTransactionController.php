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
        $tools = Tools::select('id', 'code', 'name', 'quantity', 'unit')->where('status', 'Active')->get();
        $projects = Projects::all();
        return view('tools.transaction.create', compact('tools', 'projects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'tools' => 'required|array',
            'tools.*' => 'required|exists:tools,id',
            'type_delivery' => 'required|string|in:Delivery Note,Transfer,Return',
            'source_project_id' => 'required|exists:projects,id',
            'destination_project_id' => 'required|exists:projects,id',
            'delivery_date' => 'required|date',
            'quantities' => 'required|array',
            'quantities.*' => 'required|integer|min:1',
            'driver_name' => 'required|string|max:255',
            'driver_phone' => 'required|string|max:15',
            'notes' => 'nullable|string',
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

        // get last location
        // if last location in request is empty, get last location from proyek address
        if (empty($request->last_location)) {
            $lastLocation = Projects::where('id', $request->destination_project_id)->value('address');
        } else {
            $lastLocation = $request->last_location;
        }

        // Start database transaction
        DB::beginTransaction();
        try {
            foreach ($request->tools as $index => $toolId) {
                // Create each transaction
                ToolsTransaction::create([
                    'user_id' => auth()->user()->id,
                    'tool_id' => $toolId,
                    'source_project_id' => $request->source_project_id,
                    'destination_project_id' => $request->destination_project_id,
                    'document_code' => $code,
                    'document_date' => date('Y-m-d'),
                    'delivery_date' => $request->delivery_date,
                    'quantity' => $request->quantities[$index],
                    'driver' => $request->driver_name,
                    'driver_phone' => $request->driver_phone,
                    'type' => $request->type_delivery,
                    'last_location' => $lastLocation,
                    'notes' => $request->notes,
                ]);
                // Update tool condition if necessary (optional)
                if ($request->type_delivery == 'Return') {
                    Tools::where('id', $toolId)->update(['condition' => 'New']);
                }
                Tools::where('id', $toolId)->update(['condition' => 'Used']);
            }
            DB::commit();
            return redirect()->back()->with('success', 'Transaction ' . $code . ' created successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'An error occurred while creating the transaction: ' . $e->getMessage());
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
        //
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
