<?php

namespace App\Http\Controllers;

use App\Models\Tools;
use App\Models\ToolsTransaction;
use Illuminate\Http\Request;
use App\Services\QontakSevices;

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
        //     'to_number' => 6285559623398,
        //     'to_name' => 'Virdha Dwi',
        //     'message_template_id' => '162a7076-f58b-49e4-87ae-b427de082f85',
        //     'channel_integration_id' => '0a62d1f1-bfc6-4d82-8197-9dbfda6ba41a',
        //     'language' => [
        //         'code' => 'id',
        //     ],
        //     'parameters' => [
        //         'body' => [],
        //     ],
        // ];

        // try {
        //     $response = $this->QontakSevices->sendMessage($data);
        //     return redirect()->back()->with('success', 'Message ' . $response['status'] . ' sent successfully.');
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
        return view('tools.dntrans');
    }

    public function dnTransporting(Request $request)
    {

        $toolsTrack = ToolsTransaction::with('tools')
            ->whereHas('tools', function ($query) use ($request) {
                $query->where('code', $request->code);
            })->get();

        $user = ToolsTransaction::with('user')
            ->whereHas('user', function ($query) use ($request) {
                $query->where('name', $request->name);
            })->get();

        return response()->json(['success' => true, 'data' => $toolsTrack, 'user' => $user]);
    }
}
