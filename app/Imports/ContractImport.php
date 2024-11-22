<?php

namespace App\Imports;

use App\Models\contract;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ContractImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new contract([
            'code' => $row['Code'],
            'name' => $row['Name'],
            'nama_perusahaan' => $row['Nama Perusahaan'],
            'nama_pekerjaan' => $row['Nama Pekerjaan'],
            'status_kontrak' => $row['Status Kontrak'],
            'jenis_pekerjaan' => $row['Jenis Pekerjaan'],
            'nominal_kontrak' => $row['Nominal Kontrak'],
            'tanggal_kontrak' => $row['Tanggal Kontrak'] ? Carbon::createFromFormat('Y-m-d', $row['Tanggal Kontrak']) : null,
            'masa_berlaku' => $row['Masa Berlaku'],
            'status_kontrak' => $row['Status Kontrak'],
            'retensi' => $row['Retensi'],
            'masa_retensi' => $row['Masa Retensi'],
            'status_retensi' => $row['Status Retensi'],
            'pic_sales' => $row['PIC Sales'],
            'pic_pc' => $row['PIC PC'],
            'pic_customer' => $row['PIC Customer'],
            'mata_uang' => $row['Mata Uang'],
            'bast_1' => $row['Bast 1'],
            'bast_1_nomor' => $row['Tanggal Bast 1'] ? Carbon::createFromFormat('Y-m-d', $row['Tanggal Bast 1']) : null,
            'bast_2' => $row['Bast 2'],
            'bast_2_nomor' => $row['Tanggal Bast 2'] ? Carbon::createFromFormat('Y-m-d', $row['Tanggal Bast 2']) : null,
            'overall_status' => $row['Overall Status'],
            'kontrak_milik' => $row['Kontrak Milik'],
            'keterangan' => $row['Keterangan'],
            'memo' => $row['Memo'],
        ]);
    }
}
