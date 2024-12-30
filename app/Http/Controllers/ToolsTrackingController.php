<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ToolsTransaction;

class ToolsTrackingController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }
    /**
     * Display a listing of the resource from backend.
     */
    public function index()
    {
        $trackings = ToolsTransaction::with('tools', 'sourceTransactions', 'destinationTransactions')->get();
        return view('tools.trackings.index', compact('trackings'));
    }

    /**
     * Display a listing of the resource from frontend.
     */
    public function indexFrontend()
    {
        return view('tools.trackings.trackfront');
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
        $code = $id;
        $toolsTracking = ToolsTransaction::with('tools', 'sourceTransactions', 'destinationTransactions')
            ->whereHas('tools', function ($query) use ($code) {
                $query->where('code', $code);
            })
            ->get();

        if ($toolsTracking->isEmpty()) {
            return response()->json(['success' => false, 'message' => 'Data not found']);
        }

        return response()->json(['success' => true, 'data' => $toolsTracking]);
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
}
