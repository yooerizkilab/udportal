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
            $table->foreignId('department_id')->references('id')->on('department')->onDelete('cascade');
            $table->string('employe_code')->unique();
            $table->string('nik')->unique();
            $table->string('full_name');
            $table->string('gender');
            $table->string('phone');
            $table->string('address');
            $table->string('position');
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
