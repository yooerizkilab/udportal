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
        Schema::table('vehicle', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable()->after('id');
            $table->date('purchase_date')->nullable()->after('inspected');
            $table->decimal('purchase_price', 15, 2)->nullable()->after('purchase_date');
            $table->foreign('owner_id')->references('id')->on('vehicle_ownership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicle', function (Blueprint $table) {
            $table->dropForeign(['owner_id', 'purchase_date', 'purchase_price']);
            $table->dropColumn('owner_id');
        });
    }
};
