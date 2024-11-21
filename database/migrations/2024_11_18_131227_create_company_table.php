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
        Schema::create('company', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->string('company', 50);
            $table->string('name', 50);
            $table->string('password', 50);
            $table->string('full_name', 50);
            $table->string('email', 50);
            $table->string('address', 100);
            $table->string('phone', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company');
    }
};
