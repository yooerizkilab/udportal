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
        Schema::create('vehicle_ownership', function (Blueprint $table) {
            $table->id();
            $table->foreignId('owner_id')->references('id')->on('vehicle')->onDelete('cascade');
            $table->string('owner');
            $table->date('purchase_date');
            $table->decimal('purchase_price', 15, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_ownership');
    }
};
