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
        Schema::create('employe', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->references('id')->on('department');
            $table->string('code', 20)->unique();
            $table->string('nik', 20)->unique();
            $table->string('full_name', 50);
            $table->string('gender', 10);
            $table->string('phone', 20);
            $table->string('address', 100);
            $table->string('position', 50);
            $table->string('age');
            $table->enum('status', ['Active', 'Inactive', 'Retired'])->default('Active');
            $table->string('photo')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employe');
    }
};
