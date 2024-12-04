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
        Schema::create('vehicle_maintenance_record', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('kilometer');
            $table->date('maintenance_date');
            $table->text('description')->nullable();
            $table->decimal('cost', 15, 2);
            $table->date('next_maintenance')->nullable();
            $table->text('notes')->nullable();
            $table->string('photo')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_maintenance_record');
    }
};
