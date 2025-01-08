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
        // Create the bids table
        Schema::create('bids', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->date('date');
            $table->string('to_company');
            $table->timestamps();
            $table->softDeletes();
        });

        // Create the bids_items table
        Schema::create('bids_items', function (Blueprint $table) {
            $table->id();
            $table->string('description');
            $table->integer('qty');
            $table->string('uom', 10); // Unit of Measurement (e.g., pcs)
            $table->timestamps();
            $table->softDeletes();
        });

        // Create the bids_vendors table
        Schema::create('bids_vendors', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('phone', 20)->nullable();
            $table->decimal('discount', 5, 2)->default(0); // Discount in percentage
            $table->string('lead_time', 10)->nullable(); // Lead time in days
            $table->timestamps();
            $table->softDeletes();
        });

        // Create the bids_vendor_item_prices table
        Schema::create('bids_vendor_item_prices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id')->constrained('bids_vendors')->onDelete('restrict');
            $table->foreignId('item_id')->constrained('bids_items')->onDelete('restrict');
            $table->decimal('price_per_unit', 10, 2)->default(0);
            $table->decimal('total_price', 15, 2);
            $table->decimal('total_price_after_discount', 15, 2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bids_vendor_item_prices');
        Schema::dropIfExists('bids_vendors');
        Schema::dropIfExists('bids_items');
        Schema::dropIfExists('bids');
    }
};
