<?php

namespace App\Http\Controllers\BussinesPartner;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;

class BussinesMasterController extends Controller
{
    protected $sapServices;
    /**
     * Create a new controller instance.
     */
    public function __construct(SAPServices $sapServices)
    {
        $this->middleware('auth');
        $this->sapServices = $sapServices;
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->sapServices->connect();

        $bussinesPartners = $this->sapServices->get('BusinessPartners');
        $bussinesMaster = collect($bussinesPartners);
        return $bussinesMaster;

        // Kirim data ke view
        return view('bussinesPartner.bussinesMaster.index', compact('bussinesPartners'));
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
}
