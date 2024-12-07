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

class ToolsDnTransportController extends Controller
{
    protected $QontakSevices;

    public function __construct(QontakSevices $QontakSevices)
    {
        // $this->middleware('auth');
        $this->QontakSevices = $QontakSevices;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $trans = ToolsTransaction::with(['tools', 'employee'])
            ->whereIn('type', ['Out', 'In'])
            ->get();
        // return $trans;
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
        // $payload = [
        //     'to_number' => '62895341341001',
        //     'to_name' => 'Rizki',
        //     'message_template_id' => 'a61a84b8-2e50-4590-a1a8-cdf3c5c2ddba',
        //     'channel_integration_id' => '0a62d1f1-bfc6-4d82-8197-9dbfda6ba41a',
        //     'language' => [
        //         'code' => 'id',
        //     ],
        //     'parameters' => [
        //         'body' => [
        //             [
        //                 'key' => '1',
        //                 'value_text' => 'test',
        //                 'value' => 'proyek'
        //             ],
        //             [
        //                 'key' => '2',
        //                 'value_text' => 'test',
        //                 'value' => 'namaperusahaan'
        //             ],
        //             [
        //                 'key' => '3',
        //                 'value_text' => 'test',
        //                 'value' => 'tanggal'
        //             ],

        //         ],
        //     ],
        // ];
        $hp = ['62895341341001', '6285904253752'];
        foreach ($hp as $value) {
            $phone = $value;
            $name = 'Rizki';
            $templateId = 'a61a84b8-2e50-4590-a1a8-cdf3c5c2ddba';
            $body = [
                [
                    'key' => '1',
                    'value_text' => 'test',
                    'value' => 'proyek'
                ],
                [
                    'key' => '2',
                    'value_text' => 'test',
                    'value' => 'namaperusahaan'
                ],
                [
                    'key' => '3',
                    'value_text' => 'test',
                    'value' => 'tanggal'
                ],
            ];
            $response =  $this->QontakSevices->sendMessage($phone, $name, $templateId, $body);
        }
        return redirect()->back()->with('success', 'Success' . $response);
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
        $code = 'USR01';
        // $filteredUser = User::whereHas('employe', function ($query) use ($code) {
        //     $query->where('code', $code);
        // })->with('employe')->first();
        // return $filteredUser;
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
