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
        // Create cost_bids table
        Schema::create('cost_bids', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->date('document_date')->DBdefault(DB::raw('CURRENT_DATE'));
            $table->string('for_company', 100);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create cost_bids_vendor table
        Schema::create('cost_bids_vendor', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('phone', 20);
            $table->string('email', 100)->nullable();
            $table->text('address')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Create cost_bids_inventory table
        Schema::create('cost_bids_inventory', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->integer('quantity')->default(0);
            $table->string('uom', 20);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create cost_bids_inventory_vendor table
        Schema::create('cost_bids_inventory_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_bids_id')->constrained('cost_bids')->onDelete('cascade');
            $table->foreignId('cost_bids_vendor_id')->constrained('cost_bids_vendor')->onDelete('cascade');
            $table->foreignId('cost_bids_inventory_id')->constrained('cost_bids_inventory')->onDelete('cascade');
            $table->decimal('price_per_unit', 15, 2)->default(0.00);
            $table->decimal('sub_total', 15, 2)->default(0.00);
            $table->timestamps();
            $table->softDeletes();
        });

        // Create cost_bids_analysis table
        Schema::create('cost_bids_analysis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cost_bids_id')->constrained('cost_bids')->onDelete('cascade');
            $table->foreignId('selected_vendor_id')->nullable()->constrained('cost_bids_vendor')->onDelete('set null');
            $table->decimal('total_price', 15, 2)->default(0.00);
            $table->integer('discount')->default(0);
            $table->decimal('total_after_discount', 15, 2)->default(0.00);
            $table->string('terms_of_payment', 100)->nullable();
            $table->string('lead_time', 100)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to avoid foreign key constraints
        Schema::dropIfExists('cost_bids_analysis');
        Schema::dropIfExists('cost_bids_inventory_vendor');
        Schema::dropIfExists('cost_bids_inventory');
        Schema::dropIfExists('cost_bids_vendor');
        Schema::dropIfExists('cost_bids');
    }
};
