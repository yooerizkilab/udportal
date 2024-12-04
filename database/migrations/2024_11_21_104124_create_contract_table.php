<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('contract', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('name');
            $table->string('nama_perusahaan');
            $table->string('nama_pekerjaan');
            $table->string('status_kontrak')->nullable();
            $table->string('jenis_pekerjaan')->nullable();
            $table->decimal('nominal_kontrak', 15, 2)->default(0);
            $table->date('tanggal_kontrak')->nullable();
            $table->date('masa_berlaku')->nullable();
            $table->string('status_proyek')->default('OPEN');
            $table->string('retensi')->nullable();
            $table->date('masa_retensi')->nullable();
            $table->string('status_retensi')->nullable();
            $table->string('pic_sales')->nullable();
            $table->string('pic_pc')->nullable();
            $table->string('pic_customer')->nullable();
            $table->string('mata_uang')->default('IDR');
            $table->date('bast_1')->nullable();
            $table->string('bast_1_nomor')->nullable();
            $table->date('bast_2')->nullable();
            $table->string('bast_2_nomor')->nullable();
            $table->string('overall_status')->nullable();
            $table->string('kontrak_milik')->nullable();
            $table->text('keterangan')->nullable();
            $table->text('memo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('contract');
    }
};
