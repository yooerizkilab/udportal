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
        Schema::create('tools_maintenance', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_id')->references('id')->on('tools');
            $table->string('code', 50)->unique();
            $table->date('maintenance_date');
            $table->decimal('cost', 15, 2);
            $table->date('completion_date')->nullable();
            $table->enum('status', ['Completed', 'In Progress', 'Cancelled',])->default('In Progress');
            $table->string('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools_maintenance');
    }
};
