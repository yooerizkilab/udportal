<?php

namespace App\Http\Controllers;

use App\Models\ToolsTransaction;
use Illuminate\Http\Request;

class ToolsTrackingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $toolsTracking = ToolsTransaction::with('tools')->get();
        return view('tools.tracking', compact('toolsTracking'));
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

    public function track(Request $request)
    {
        return view('tools.track');
    }

    public function tracking(Request $request)
    {
        $code = $request->qrCodeData;
        $toolsTracking = ToolsTransaction::with('tools')
            ->whereHas('tools', function ($query) use ($code) {
                $query->where('code', $code);
            })
            ->get();

        if ($toolsTracking->isEmpty()) {
            return response()->json(['error' => true, 'message' => 'Data not found']);
        }

        return response()->json(['success' => true, 'data' => $toolsTracking]);
    }
}
