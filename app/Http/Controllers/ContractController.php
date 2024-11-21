<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use App\Services\SAPServices;
use Exception;

class ContractController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     * */
    protected $SAPServices;

    public function __construct(SAPServices $SAPServices)
    {
        $this->middleware('auth');
        $this->SAPServices = $SAPServices;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $cacheKey = 'hr_contracts_data';
        $cacheDuration = 60;
        // Cek apakah data ada di cache sebelum operasi
        $isCached = Cache::has($cacheKey);

        try {
            $response = Cache::remember($cacheKey, $cacheDuration, function () use ($cacheKey) {
                Log::info("Mengambil data dari API karena cache '$cacheKey' kosong");

                $endpoint = 'U_HR_KONTRAK';
                $apiResponse = $this->SAPServices->get($endpoint);

                if (!$apiResponse->successful()) {
                    throw new Exception('Failed to fetch data from SAP');
                }

                $data = $apiResponse->json()['value'] ?? [];

                // Log ketika data berhasil disimpan ke cache
                Log::info("Data berhasil disimpan ke cache '$cacheKey'", [
                    'data_count' => count($data)
                ]);

                return $data;
            });

            // Log status cache setelah operasi
            $statusMessage = $isCached ? 'Data diambil dari cache' : 'Data baru disimpan ke cache';
            Log::info($statusMessage, [
                'cache_key' => $cacheKey,
                'data_count' => count($response)
            ]);

            return view('contracts.index', [
                'response' => $response,
                'fromCache' => $isCached
            ]);
        } catch (Exception $e) {
            Cache::forget($cacheKey);
            Log::error('Error fetching contracts data: ' . $e->getMessage());

            return view('contracts.index', [
                'response' => [],
                'error' => 'Unable to fetch contracts data. Please try again later.'
            ]);
        }
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
        // Validate the request
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'name_company' => 'required|string|max:255',
            'worker_project' => 'required|string|max:255',
            'type_contract' => 'required|string|max:50',
            'currency' => 'required|string|max:3',
            'start_date' => 'required|date',
            'owned_contract' => 'required|string|max:255',
            'type_work' => 'required|string|max:50',
            'price' => 'required|numeric',
            'end_date' => 'required|date',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);

        // Data request
        $data = [
            'Code' => $request->code,
            'Name' => $request->name,
            'U_CardName' => $request->name_company,
            'U_PrjName' => $request->worker_project,
            'U_ContrSts' => $request->type_contract,
            'U_JobTyp' => $request->type_work,
            'U_PrjSts' => $request->status,
            'U_ContrCurr' => $request->currency,
            'U_ContrAmt' => $request->price,
            'U_ContrStart' => $request->start_date,
            'U_ValidPrd' => $request->end_date,
            'U_Company' => $request->owned_contract,
            'U_Remark' => $request->description,
            'U_Memo' => $request->memo
        ];

        try {
            $endpoint = 'U_HR_KONTRAK';
            $response = $this->SAPServices->post($endpoint, $data);
            return redirect()->back()->with('success', 'Contract ' . $response['Code'] . ' created successfully.');
        } catch (\Exception $e) {
            redirect()->back()->with('error', 'An error' . $e->getMessage() . ' occurred while creating the contract.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $originalID = str_replace(' ', '/', $id);
        $endpoint = 'U_HR_KONTRAK';
        $response = $this->SAPServices->getById($endpoint, $originalID)->json();
        return view('contracts.show', compact('response'));
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
        // Get the original ID
        $originalID = str_replace(' ', '/', $id);

        // Validate the request
        $request->validate([
            'code' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'name_company' => 'required|string|max:255',
            'worker_project' => 'required|string|max:255',
            'type_contract' => 'required|string|max:50',
            'currency' => 'required|string|max:3',
            'start_date' => 'required|date',
            'owned_contract' => 'required|string|max:255',
            'type_work' => 'required|string|max:50',
            'price' => 'required|numeric',
            'end_date' => 'required|date',
            'status' => 'required|string|max:50',
            'description' => 'nullable|string',
            'memo' => 'nullable|string',
        ]);

        // Data request
        $data = [
            'Code' => $request->code,
            'Name' => $request->name,
            'U_CardName' => $request->name_company,
            'U_PrjName' => $request->worker_project,
            'U_ContrSts' => $request->type_contract,
            'U_JobTyp' => $request->type_work,
            'U_PrjSts' => $request->status,
            'U_ContrCurr' => $request->currency,
            'U_ContrAmt' => $request->price,
            'U_ContrStart' => $request->start_date,
            'U_ValidPrd' => $request->end_date,
            'U_Company' => $request->owned_contract,
            'U_Remark' => $request->description,
            'U_Memo' => $request->memo
        ];

        try {
            $endpoint = 'U_HR_KONTRAK';
            $response = $this->SAPServices->patch($endpoint, $originalID, $data);
            return redirect()->back()->with('success', 'Contract ' . $response['Code'] . ' updated successfully.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'An error ' . $e->getMessage() . ' occurred while updating the contract.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function someMethod(SAPServices $sapService)
    {
        try {
            $result = $sapService->callStoredProcedure('SomeProcedureName', ['param1', 'param2']);
            return response()->json($result);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
