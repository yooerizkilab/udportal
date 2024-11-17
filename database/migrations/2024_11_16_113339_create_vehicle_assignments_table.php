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
        Schema::create('vehicle_assignment', function (Blueprint $table) {
            // $table->id();
            $table->foreignId('id')->references('id')->on('vehicle')->onDelete('cascade');
            $table->string('assigned_to'); // Can be a person or a department
            $table->date('assignment_date');
            $table->date('return_date')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_assignment');
    }
};
