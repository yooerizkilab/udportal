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
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('category_id')->references('id')->on('tickets_categories');
            $table->foreignId('assignee_id')->references('id')->on('department');
            $table->foreignId('fixed_by')->nullable()->references('id')->on('users');
            $table->string('code', 20)->unique();
            $table->string('title', 100);
            $table->text('description')->nullable();
            $table->text('solution')->nullable();
            $table->string('attachment')->nullable();
            $table->date('closed_date')->nullable();
            $table->enum('priority', ['Low', 'Medium', 'High'])->default('Low');
            $table->enum('status', ['Open', 'Closed', 'In Progress'])->default('Open');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
