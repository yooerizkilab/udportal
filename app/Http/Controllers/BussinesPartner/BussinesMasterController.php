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

        // Business Partners
        // $params = [
        //     '$select' => 'CardCode,CardName,CardType',
        //     '$orderby' => 'CardCode asc',
        //     '$skip' => 0,
        //     '$top' => 500,
        // ];

        // $businessPartners = $this->sapServices->get('BusinessPartners', $params);

        // Items
        // $params = [
        //     '$select' => 'ItemCode, ItemName, ItemsGroupCode, SalesVATGroup, PurchaseVATGroup, ItemType, ItemClass, MaterialType, CreateDate',
        //     '$orderby' => 'CreateDate asc',
        //     '$skip' => 0,
        //     '$top' => 10
        // ];
        // $items = $this->sapServices->get('Items', $params);

        // SO
        // $params = [
        //     // '$orderby' => 'DocEntry asc',
        //     '$skip' => 0,
        //     '$top' => 10
        // ];

        // $orders = $this->sapServices->get('Orders', $params);

        // return $businessPartners;
        // return $items;
        // return $orders;

        return view('bussinesPartner.bussinesMaster.index', compact('businessPartners'));
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
        $this->sapServices->connect();
        $params = [
            '$select' => 'CardCode,CardName,CardType,CreditLimit,MaxCommitment,Currency,Cellular,Country,CardForeignName,DebitorAccount,BPAddresses',
        ];

        $businessPartners = $this->sapServices->getById('BusinessPartners', $id, $params);

        return $businessPartners;

        return view('bussinesPartner.bussinesMaster.show', compact('businessPartners'));
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
