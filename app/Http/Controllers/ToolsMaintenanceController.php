<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolsMaintenance;
use App\Models\Tools;
use Illuminate\Support\Facades\DB;

class ToolsMaintenanceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('permission:view tools maintenance', ['only' => ['index']]);
        $this->middleware('permission:create tools maintenance', ['only' => ['create', 'store']]);
        $this->middleware('permission:update tools maintenance', ['only' => ['edit', 'update']]);
        // $this->middleware('permission:complete tools maintenance', ['only' => ['completeMaintenance']]);
        // $this->middleware('permission:cancel tools maintenance', ['only' => ['cancelMaintenance']]);
        $this->middleware('permission:delete tools maintenance', ['only' => ['destroy']]);
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $maintenances = ToolsMaintenance::with('tools')->get();
        return view('tools.maintenances.index', compact('maintenances'));
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
        // Validasi input form
        $request->validate([
            'code' => 'required|exists:tools,code',
            'maintenance_date' => 'required|date',
            'cost' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Cari tool berdasarkan kode
        $tools = Tools::where('code', $request->code)->first();

        // Jika tool tidak ditemukan (meskipun validasi ada, ini untuk antisipasi edge cases)
        if (!$tools) {
            return redirect()->back()->with('error', 'Tool dengan kode ' . $request->code . ' tidak ditemukan.');
        }

        if ($tools->status == 'Inactive') {
            return redirect()->back()->with('error', 'Failed to create maintenance record: Tool is inactive.');
        }

        if ($tools->status == 'Maintenance') {
            return redirect()->back()->with('error', 'Failed to create maintenance record: Tool is already in maintenance.');
        }

        // Generate code maintenance Ex : UD/MTC/2024/XII/SEM001/MTC001
        $roman = ['I', 'II', 'III', 'IV', 'V', 'VI', 'VII', 'VIII', 'IX', 'X', 'XI', 'XII'];
        $defaultCode = 'UD/MTC/' . now()->format('Y') . '/' . $roman[now()->month - 1] . '/' . $tools->code . '/MTC' . str_pad($tools->id, 4, '0', STR_PAD_LEFT);

        // Cek apakah maintenance dengan code sudah ada
        $existingMaintenance = ToolsMaintenance::where('code', $defaultCode)->first();
        if ($existingMaintenance) {
            return redirect()->back()->with('error', 'Maintenance record with code ' . $defaultCode . ' already exists.');
        }

        // Siapkan data untuk maintenance
        $data = [
            'tool_id' => $tools->id,
            'code' => $defaultCode,
            'maintenance_date' => date('Y-m-d', strtotime($request->maintenance_date)),
            'cost' => $request->cost,
            'completion_date' => null,
            'status' => 'In Progress',
            'description' => $request->description,
        ];

        // Mulai transaksi database
        DB::beginTransaction();
        try {
            // Buat record maintenance
            ToolsMaintenance::create($data);
            // Update status tool menjadi "Maintenance"
            $tools->update(['status' => 'Maintenance', 'condition' => 'Broken']);
            // Commit transaksi
            DB::commit();
            // Redirect dengan pesan sukses
            return redirect()->back()->with('success', 'Tool ' . $tools->name . ' maintenance record created successfully.');
        } catch (\Exception $e) {
            // Rollback jika ada error
            DB::rollBack();
            // Redirect dengan pesan error
            return redirect()->back()->with('error', 'Failed to create tool maintenance record: ' . $e->getMessage());
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
        $request->validate([
            'maintenance_date' => 'required|date',
            'cost' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        $maintenance = ToolsMaintenance::findOrFail($id);

        $data = [
            'maintenance_date' => date('Y-m-d', strtotime($request->maintenance_date)),
            'cost' => $request->cost,
            'description' => $request->description,
        ];
        DB::beginTransaction();
        try {
            $maintenance->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance record updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update maintenance record: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function completeMaintenance($id)
    {
        $maintenance = ToolsMaintenance::findOrFail($id);

        if ($maintenance->tools->status == 'Inactive') {
            return redirect()->back()->with('error', 'Failed to complete maintenance record: Tool ' . $maintenance->tools->name . ' is inactive.');
        }

        DB::beginTransaction();
        try {
            $maintenance->update(['status' => 'Completed', 'completion_date' => now()]);
            $maintenance->tools()->update(['status' => 'Active', 'condition' => 'New']);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance  Tools ' . $maintenance->tools->name . ' record completed successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    public function cancelMaintenance($id)
    {
        $maintenance = ToolsMaintenance::findOrFail($id);

        DB::beginTransaction();
        try {
            $maintenance->update(['status' => 'Canceled']);
            DB::commit();
            return redirect()->back()->with('success', 'Maintenance record canceled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to cancel maintenance record: ' . $e->getMessage());
        }
    }

    // public function pendingMaintenance($id)
    // {
    //     $maintenance = ToolsMaintenance::findOrFail($id);

    //     DB::beginTransaction();
    //     try {
    //         $maintenance->update(['status' => 'Pending']);
    //         DB::commit();
    //         return redirect()->back()->with('success', 'Maintenance record pending successfully.');
    //     } catch (\Exception $e) {
    //         DB::rollBack();
    //         return redirect()->back()->with('error', 'Failed to pending maintenance record: ' . $e->getMessage());
    //     }
    // }
}
