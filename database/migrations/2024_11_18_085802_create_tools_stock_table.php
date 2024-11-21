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
        Schema::create('tools_stock', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_id')->references('id')->on('tools')->onDelete('cascade');
            $table->string('quantity');
            $table->string('unit', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools_stock');
    }
};
