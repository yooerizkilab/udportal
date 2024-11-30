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
        Schema::create('vehicle_insurance_policie', function (Blueprint $table) {
            $table->id();
            $table->string('insurance_provider', 100);
            $table->string('policy_number', 50);
            $table->date('coverage_start');
            $table->date('coverage_end');
            $table->decimal('premium', 15, 2);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_insurance_policie');
    }
};
