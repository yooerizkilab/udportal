<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\ToolsTransaction;
use App\Models\User;
use App\Models\ToolsStock;
use Illuminate\Http\Request;
use App\Services\QontakSevices;
use Illuminate\Support\Facades\DB;

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
        // $endpoint = 'integrations';
        // $params = [
        //     'target_channel' => 'wa',
        //     'limit' => 10,
        // ];

        // try {
        //     $response = $this->QontakSevices->channel($endpoint, $params);
        //     return response()->json($response->json()); // Kirimkan JSON ke browser
        // } catch (\Exception $e) {
        //     return response()->json(['error' => $e->getMessage()], 500); // Kirimkan error
        // }

        return view('tools.dntransport');
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
        // $data = [
        //     'to_number' => 62895341341001,
        //     // 'to_number' => 6285904253752,
        //     'to_name' => 'Virdha Dwi',
        //     'message_template_id' => '76d15145-0688-4ea7-81a7-4effe440cd77',
        //     'channel_integration_id' => '0a62d1f1-bfc6-4d82-8197-9dbfda6ba41a',
        //     'language' => [
        //         'code' => 'id',
        //     ],
        //     'parameters' => [
        //         'body' => [
        //             'key' => '1',
        //             'value_text' => 'K 5',
        //             'value' => 'abc def',
        //         ],
        //     ],
        // ];

        // try {
        //     $response = $this->QontakSevices->sendMessage($data);
        //     return redirect()->back()->with('success', 'Message ' . $response['status']['data'] . ' sent successfully.');
        // } catch (\Exception $e) {
        //     return redirect()->back()->with('error', $e->getMessage());
        // }
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
            'codeEmploye' => 'required|string|exists:employe,code',
            'qrCode' => 'required|string|exists:tools,code',
            'from' => 'required|string',
            'to' => 'required|string',
            'qty' => 'required|integer|min:1',
            'note' => 'nullable|string',
        ]);

        // Ambil data dari request dan validasi
        $tools = Tools::where('code', $request->qrCode)->firstOrFail();
        $user = User::whereHas('employe', function ($query) use ($request) {
            $query->where('code', $request->codeEmploye);
        })->with('employe')->firstOrFail();

        $data = [
            'tools_id' => $tools->id,
            'user_id' => $user->id,
            'type' => 'Out',
            'from' => $request->from,
            'to' => $request->to,
            'quantity' => $request->qty,
            'location' => $request->location ?? null,
            'activity' => $request->activity ?? null,
            'notes' => $request->note ?? null,
        ];

        DB::beginTransaction();
        try {
            // Simpan transaksi
            $toolsTransaction = ToolsTransaction::create($data);

            // Perbarui stok alat
            $toolsStock = ToolsStock::where('tools_id', $tools->id)->firstOrFail();
            if ($toolsStock->stock < $data['quantity']) {
                throw new \Exception('Stok alat tidak mencukupi.');
            }
            $toolsStock->update(['stock' => $toolsStock->stock - $data['quantity']]);
            DB::commit();

            // return respon json
            return response()->json(['message' => 'Transaksi ' . $toolsTransaction->id . ' berhasil disimpan.']);
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }
}
