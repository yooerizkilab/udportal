<?php

namespace App\Http\Controllers\BussinesPartner;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

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
    public function index(Request $request)
    {
        $this->sapServices->connect();

        // Siapkan parameter untuk filter, top (limit), dan skip (offset)
        $params = [
            '$select' => 'CardCode,CardName, CardType',
            '$filter' => 'CardType eq \'C\'',
        ];

        // Ambil data Business Partners dengan parameter filter, pagination, dan pencarian
        $response = $this->sapServices->get('BusinessPartners', $params);

        return $response;

        // Kirim data ke view untuk pertama kali load halaman (non-AJAX)
        return view('bussinesPartner.bussinesMaster.index');
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
