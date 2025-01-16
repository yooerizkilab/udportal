<?php

namespace Database\Seeders;

use App\Models\Contract;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContractSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Contract::insert([
            [
                'code' => '166/PPB/B21004/XII/2021/AMD1',
                'name' => '166/PPB/B21004/XII/2021/AMD1',
                'nama_perusahaan' => 'WIJAYA KARYA REKAYASA KONSTRUKSI, PT',
                'nama_pekerjaan' => 'PABRIK MINYAK GORENG 250 TPD BATULICIN KALIMANTAN SELATAN',
                'status_kontrak' => 'KONTRAK',
                'jenis_pekerjaan' => 'PEMASANGAN',
                'nominal_kontrak' => 100000000,
                'tanggal_kontrak' => '2025-01-01',
                'masa_berlaku' => '2025-01-31',
                'status_proyek' => 'OPEN',
                'retensi' => '5%',
                'masa_retensi' => '2022-01-01',
                'status_retensi' => 'CLOSED',
                'pic_sales' => 'A',
                'pic_pc' => 'B',
                'pic_customer' => 'C',
                'mata_uang' => 'IDR',
                'bast_1' => '2022-01-01',
                'bast_1_nomor' => 'A',
                'bast_2' => '2022-01-01',
                'bast_2_nomor' => 'B',
                'overall_status' => 'OPEN',
                'kontrak_milik' => 'UJASI',
                'keterangan' => 'PABRIK MINYAK GORENG 250 TPD BATULICIN KALIMANTAN SELATAN',
                'memo' => 'TESTING',
                'created_at' => now(),
                'updated_at' => now()
            ]
        ]);
    }
}
