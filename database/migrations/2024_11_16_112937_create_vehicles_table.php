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
        Schema::create('vehicle', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('type_id');
            $table->string('code')->unique();
            $table->string('brand');
            $table->string('model', 50)->nullable();
            $table->string('color', 20)->nullable();
            $table->year('year')->nullable();
            $table->string('license_plate', 10)->unique();
            $table->date('tax_year')->nullable();
            $table->date('tax_five_year')->nullable();
            $table->date('inspected')->nullable();
            $table->enum('status', ['Active', 'Maintenance', 'Inactive'])->default('Active');
            $table->timestamps();

            $table->foreign('type_id')->references('id')->on('vehicle_type');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle');
    }
};
