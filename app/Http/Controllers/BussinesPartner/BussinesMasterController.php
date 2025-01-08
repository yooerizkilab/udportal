<?php

namespace App\Http\Controllers\BussinesPartner;

use App\Http\Controllers\Controller;
use App\Services\SAPServices;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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
        // $this->middleware('EnsureCompanyDbIsSet');
    }


    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $bussinesPartner = $this->sapServices->get('BusinessPartners');
        return $bussinesPartner;
        // $test = Session::get('company_db');

        // return $test;
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
