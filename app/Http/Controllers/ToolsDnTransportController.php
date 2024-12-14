<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\ToolsTransaction;
use App\Models\User;
use App\Models\ToolsStock;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use App\Services\QontakSevices;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Services\SAPServices;

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
        return view('tools.dntrans');
    }

    public function dnTransporting(Request $request)
    {
        $request->validate([
            'codeEmploye' => 'required|string',
            'from' => 'required|string',
            'to' => 'required|string',
            'activity' => 'required|string',
            'note' => 'nullable|string',
            'items' => 'required|array',
            'items.*.qr' => 'required|string', // Validasi QR di dalam array items
            'items.*.location' => 'required|string', // Validasi lokasi
        ]);

        // Generate default code Dn Transport Ex: UD/DN/2024/DN0001
        $number = ToolsTransaction::count() + 1; // Tambah 1 untuk kode baru
        $transactionCode = 'UD/DN/' . date('Y') . '/' . 'DN' . str_pad($number, 4, '0', STR_PAD_LEFT);

        $user = User::whereHas('employe', function ($query) use ($request) {
            $query->where('code', $request->codeEmploye);
        })->with('employe')->firstOrFail();

        DB::beginTransaction();
        try {
            foreach ($request->items as $item) {
                $tools = Tools::where('code', $item['qr'])->firstOrFail();

                if ($tools->quantity <= 0) {
                    return redirect()->back()->with('error', 'Tools ' . $tools->name . ' is out of stock.');
                }

                if ($tools->condition == 'Broken') {
                    return redirect()->back()->with('error', 'Tools ' . $tools->name . ' is broken.');
                }

                if ($tools->status == 'Maintenance' || $tools->status == 'Inactive') {
                    return redirect()->back()->with('error', 'Tools ' . $tools->name . ' is maintenance or inactive.');
                }

                $existingTransaction = ToolsTransaction::where('tools_id', $tools->id)
                    ->where('location', $item['location'])
                    ->where('type', 'Out')
                    ->exists();

                if ($existingTransaction) {
                    return redirect()->back()->with('error', 'location ' . $item['location'] . ' already used. Please choose another location.');
                }

                // Tentukan tipe transaksi (In/Out) berdasarkan kondisi saat ini
                $currentTransaction = ToolsTransaction::where('tools_id', $tools->id)
                    ->latest('created_at')
                    ->first();

                $newTransactionType = $currentTransaction && $currentTransaction->type === 'Out' ? 'In' : 'Out';

                // Buat transaksi baru
                ToolsTransaction::create([
                    'tools_id' => $tools->id,
                    'user_id' => $user->id,
                    'code' => $transactionCode,
                    'type' => $newTransactionType,
                    'from' => $request->from,
                    'to' => $request->to,
                    'quantity' => $currentTransaction->quantity,
                    'location' => $item['location'],
                    'activity' => $request->activity,
                    'notes' => $request->note
                ]);

                // Update kondisi tools
                $tools->update([
                    'condition' => $newTransactionType === 'Out' ? 'Used' : 'New',
                ]);
            }

            DB::commit();
            return redirect()->back()->with('success', 'Data berhasil disimpan.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
