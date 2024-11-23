<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ContractExport;
use App\Imports\ContractImport;
use App\Models\Contract;
use Carbon\Carbon;

class ContractController extends Controller
{
    /**
     * Create a new controller instance.
     * 
     * @return void
     * */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // notification contaract min 21 14 7 3 0 -3 -7 -14 -21
        $now = Carbon::now(); // Waktu sekarang
        // $contract = Contract::whereDate('masa_berlaku', '<=', $now->addDays(21))
        //     ->whereDate('masa_berlaku', '>=', $now)
        //     ->get();
        // foreach ($contract as $item) {
        //     $day
        // }


        $contracts = Contract::all();
        return view('contracts.index', compact('contracts'));
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
        // Validasi input
        $request->validate([
            'code' => 'required|string|unique:contract,code',
            'name' => 'required|string',
        ]);

        $data = [
            'code' => $request->code,
            'name' => $request->name,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'status_kontrak' => $request->stattus_kontrak,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'nominal_kontrak' => $request->nominal_kontrak,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'masa_berlaku' => $request->masa_berlaku,
            'status_proyek' => $request->status_proyek,
            'retensi' => $request->retensi,
            'masa_retensi' => $request->masa_retensi,
            'status_retensi' => $request->status_retensi,
            'pic_sales' => $request->pic_sales,
            'pic_pc' => $request->pic_pc,
            'pic_customer' => $request->pic_customer,
            'mata_uang' => $request->mata_uang,
            'bast_1' => $request->bast_1,
            'bast_1_nomor' => $request->bast_1_nomor,
            'bast_2' => $request->bast_2,
            'bast_2_nomor' => $request->bast_2_nomor,
            'overall_status' => $request->overall_status,
            'kontrak_milik' => $request->kontrak_milik,
            'keterangan' => $request->keterangan,
            'memo' => $request->memo,
        ];

        DB::beginTransaction();
        try {
            $contracts = Contract::create($data);
            DB::commit();
            return redirect()->back()->with('success', 'Data ' . $contracts->name . ' berhasil disimpan.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data ' . $e->getMessage() . ' gagal disimpan.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $contract = Contract::findOrFail($id);
        return view('contracts.show', compact('contract'));
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
        // Cari kontrak berdasarkan ID
        $contract = Contract::findOrFail($id);

        // Validasi input
        $request->validate([
            // 'code' => 'required|string|unique:contract,code',
            'name' => 'required|string',
        ]);

        $data = [
            // 'code' => $request->code,
            'name' => $request->name,
            'nama_perusahaan' => $request->nama_perusahaan,
            'nama_pekerjaan' => $request->nama_pekerjaan,
            'status_kontrak' => $request->status_kontrak,
            'jenis_pekerjaan' => $request->jenis_pekerjaan,
            'nominal_kontrak' => $request->nominal_kontrak,
            'tanggal_kontrak' => $request->tanggal_kontrak,
            'masa_berlaku' => $request->masa_berlaku,
            'status_proyek' => $request->status_proyek,
            'retensi' => $request->retensi,
            'masa_retensi' => $request->masa_retensi,
            'status_retensi' => $request->status_retensi,
            'pic_sales' => $request->pic_sales,
            'pic_pc' => $request->pic_pc,
            'pic_customer' => $request->pic_customer,
            'mata_uang' => $request->mata_uang,
            'bast_1' => $request->bast_1,
            'bast_1_nomor' => $request->bast_1_nomor,
            'bast_2' => $request->bast_2,
            'bast_2_nomor' => $request->bast_2_nomor,
            'overall_status' => $request->overall_status,
            'kontrak_milik' => $request->kontrak_milik,
            'keterangan' => $request->keterangan,
            'memo' => $request->memo,
        ];

        DB::beginTransaction();
        try {
            $contract->update($data);
            DB::commit();
            return redirect()->back()->with('success', 'Data ' . $contract->name . ' berhasil diperbarui.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data ' . $e->getMessage() . ' gagal diperbarui.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        DB::beginTransaction();
        try {
            $contract = Contract::findOrFail($id);
            $contract->delete();
            DB::commit();
            return redirect()->back()->with('success', 'Data ' . $contract->name . ' berhasil dihapus.');
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Data ' . $e->getMessage() . ' gagal dihapus.');
        }
    }

    public function export($id)
    {
        $contract = Contract::findOrFail($id);
        $pdf = PDF::loadView('contracts.detailpdf', compact('contract'));
        return $pdf->stream('contracts.pdf');
    }

    public function exportPdf(Request $request)
    {
        $startDate = Carbon::parse($request->start_date)->startOfDay();
        $endDate = Carbon::parse($request->end_date)->endOfDay();

        if (!$startDate || !$endDate) {
            return redirect()->back()->withErrors(['error' => 'Start date and end date are required.']);
        }

        // Fetch data sesuai kebutuhan
        $contracts = Contract::whereBetween('created_at', [$startDate, $endDate])->get();

        // Data untuk PDF
        $data = [
            'start_date' => $startDate,
            'end_date' => $endDate,
            'contracts' => $contracts,
        ];

        // return $data;
        // Generate PDF
        $pdf = PDF::loadView('contracts.pdf', compact('data'))->setPaper('a4', 'landscape');
        return $pdf->stream('contracts.pdf');
        // return $pdf->download('contracts.pdf');
    }

    public function exportExcel(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        // Validasi parameter
        if (!$startDate || !$endDate) {
            return redirect()->back()->withErrors(['error' => 'Start date and end date are required.']);
        }

        return Excel::download(new ContractExport($startDate, $endDate), 'contracts.xlsx');
    }

    public function importContract(Request $request)
    {
        $file = $request->file('file');
        if (!$file) {
            return redirect()->back()->with('error', 'File not found.');
        }
        Excel::import(new ContractImport, $file);

        return redirect()->back()->with('success', 'Data berhasil diimport.');
    }

    public function exportStatusContract(Request $request)
    {
        // 
    }

    public function exportStatusProject(Request $request)
    {
        // 
    }
}
