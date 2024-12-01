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
            $table->string('code', 50)->unique();
            $table->string('serial_number', 20)->unique()->nullable();
            $table->string('name', 50);
            $table->string('brand')->nullable();
            $table->string('type')->nullable();
            $table->string('model')->nullable();
            $table->year('year')->nullable();
            $table->string('quantity')->nullable();
            $table->string('unit')->nullable();
            $table->enum('condition', ['New', 'Used', 'Broken'])->default('New');
            $table->enum('status', ['Active', 'Maintenance', 'Inactive'])->default('Active');
            $table->text('description')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->default(0)->nullable();
            $table->string('warranty')->nullable();
            $table->date('warranty_start')->nullable();
            $table->date('warranty_end')->nullable();
            $table->string('photo')->nullable();
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
