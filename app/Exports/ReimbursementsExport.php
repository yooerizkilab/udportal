<?php

namespace App\Exports;

use App\Models\VehicleReimbursement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class ReimbursementsExport implements FromCollection, WithHeadings, WithMapping
{
    protected $request;

    public function __construct($request)
    {
        $this->request = $request;
    }

    public function collection()
    {
        $query = VehicleReimbursement::with(['vehicle.assigned.employe']);

        if (!empty($this->request->user_name)) {
            $query->where('user_by', $this->request->user_name);
        }

        if (!empty($this->request->start_date) && !empty($this->request->end_date)) {
            $query->whereBetween('date_recorded', [$this->request->start_date, $this->request->end_date]);
        }

        // Add status filter if needed
        if (!empty($this->request->status)) {
            $query->where('status', $this->request->status);
        }

        return $query->get();
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Karyawan',
            'Tipe',
            'Bahan Bakar',
            'Jumlah',
            'Harga',
            'Status',
            'Kendaraan'
        ];
    }
    private $counter = 0;

    public function map($reimbursement): array
    {
        $this->counter++;

        return [
            $this->counter,
            $reimbursement->date_recorded,
            $reimbursement->vehicle->assigned->last()->employe->full_name ?? '-',
            $reimbursement->type,
            $reimbursement->fuel,
            $reimbursement->amount,
            $reimbursement->price,
            $reimbursement->status,
            $reimbursement->vehicle->model ?? '-'
        ];
    }
}
