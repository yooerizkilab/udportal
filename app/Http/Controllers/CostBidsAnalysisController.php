<?php

namespace App\Http\Controllers;

use App\Models\CostBids;
use Illuminate\Http\Request;

class CostBidsAnalysisController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bids = CostBids::all();
        return view('bids.analysis.index', compact('bids'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('bids.analysis.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return $request->all();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $bids = CostBids::with('items.costBidsAnalysis', 'vendors')->find($id);
        return $bids;
        return view('bids.analysis.show', compact('bids'));
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
