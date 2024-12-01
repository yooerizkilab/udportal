<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tools_transaction', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tools_id')->references('id')->on('tools');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->string('code', 50)->unique();
            $table->enum('type', ['Out', 'Transfer', 'In'])->default('Out');
            $table->string('from', 100);
            $table->string('to', 100);
            $table->string('quantity');
            $table->string('location', 100);
            $table->string('activity', 50);
            $table->timestamp('transaction_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tools_transaction');
    }
};
