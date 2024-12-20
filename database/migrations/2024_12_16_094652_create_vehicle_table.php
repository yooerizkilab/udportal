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
        Schema::create('vehicle_type', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->longText('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vehicle_owner', function (Blueprint $table) {
            $table->id();
            $table->string('name', 50);
            $table->string('address', 100)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('vehicle', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('owner_id');
            $table->unsignedBigInteger('type_id');
            $table->string('code', 50)->unique();
            $table->string('brand', 50)->nullable();
            $table->string('model', 50)->nullable();
            $table->string('color', 50)->nullable();
            $table->string('license_plate', 20)->nullable();
            $table->string('transmission', 50)->nullable();
            $table->string('fuel', 50)->nullable();
            $table->year('year')->nullable();
            $table->date('tax_year')->nullable();
            $table->date('tax_five_year')->nullable();
            $table->date('inspected')->nullable();
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->longText('description')->nullable();
            $table->string('origin')->nullable();
            $table->enum('status', ['Active', 'Maintenance', 'Inactive'])->default('Active');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('owner_id')->references('id')->on('vehicle_owner');
            $table->foreign('type_id')->references('id')->on('vehicle_type');
        });

        Schema::create('vehicle_maintenance_record', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('code', 50)->unique();
            $table->string('kilometer', 50)->nullable();
            $table->date('maintenance_date')->nullable();
            $table->longText('description')->nullable();
            $table->decimal('cost', 15, 2)->nullable();
            $table->date('next_maintenance')->nullable();
            $table->longText('notes')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')->references('id')->on('vehicle');
        });

        Schema::create('vehicle_insurance_policy', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('code', 50)->unique();
            $table->string('insurance_provider', 50)->nullable();
            $table->string('policy_number', 50)->nullable();
            $table->date('coverage_start')->nullable();
            $table->date('coverage_end')->nullable();
            $table->decimal('premium', 15, 2)->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')->references('id')->on('vehicle');
        });

        Schema::create('vehicle_assignment', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->unsignedBigInteger('user_id');
            $table->string('code', 50)->unique();
            $table->date('assignment_date')->nullable();
            $table->date('return_date')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')->references('id')->on('vehicle');
            $table->foreign('user_id')->references('id')->on('users');
        });

        Schema::create('vehicle_transaction', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('vehicle_id');
            $table->string('code', 50)->unique();
            $table->string('type')->nullable();
            $table->string('from', 50)->nullable();
            $table->string('to', 50)->nullable();
            $table->date('transaction_date')->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('vehicle_id')->references('id')->on('vehicle');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicle_transaction');
        Schema::dropIfExists('vehicle_assignment');
        Schema::dropIfExists('vehicle_insurance_policy');
        Schema::dropIfExists('vehicle_maintenance_record');
        Schema::dropIfExists('vehicle');
        Schema::dropIfExists('vehicle_owner');
        Schema::dropIfExists('vehicle_type');
    }
};
