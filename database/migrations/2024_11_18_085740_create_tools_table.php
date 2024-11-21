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
        Schema::create('tools', function (Blueprint $table) {
            $table->id();
            $table->foreignId('categorie_id')->references('id')->on('tools_categorie');
            $table->string('code', 20)->unique();
            $table->string('serial_number', 20)->unique();
            $table->string('name', 50);
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->enum('condition', ['New', 'Good', 'Used', 'Broken'])->default('Good');
            $table->enum('status', ['Active', 'Maintenance', 'Inactive'])->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools');
    }
};
