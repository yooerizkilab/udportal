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
        // Tabel companies
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('code', 50)->unique();
            $table->string('company', 50)->nullable();
            $table->string('name', 50)->nullable();
            $table->string('password', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->string('phone', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel departments
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->string('code', 50)->unique();
            $table->string('name', 50);
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel branches
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->string('code', 50)->unique();
            $table->enum('type', ['Head Office', 'Branch Office'])->default('Head Office');
            $table->string('name', 50);
            $table->string('phone', 50)->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('description')->nullable();
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel Warehouses
        Schema::create('warehouses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->foreignId('branch_id')
                ->constrained('branches')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->string('code', 50)->unique();
            $table->string('name', 50);
            $table->string('phone', 20)->nullable();
            $table->string('address')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('description')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel users
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->string('name');
            $table->string('username')->unique();
            $table->string('last_name')->nullable();
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
            $table->softDeletes();
        });

        // Tabel employees
        Schema::create('employees', function (Blueprint $table) {
            $table->bigIncrements('id')->index();
            $table->foreignId('user_id')
                ->constrained('users')
                ->onDelete('cascade') // Hapus user menghapus employee
                ->onUpdate('cascade');
            $table->foreignId('company_id')
                ->constrained('companies')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->foreignId('branch_id')
                ->nullable()
                ->constrained('branches')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->foreignId('department_id')
                ->constrained('departments')
                ->onDelete('restrict') // Tidak menggunakan cascade
                ->onUpdate('cascade');
            $table->string('code', 50)->unique();
            $table->string('nik', 50);
            $table->string('full_name', 100);
            $table->enum('gender', ['Male', 'Female']);
            $table->integer('age');
            $table->string('phone', 50)->nullable();
            $table->string('position', 50);
            $table->string('address')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('photo')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('employees');
        Schema::dropIfExists('users');
        Schema::dropIfExists('branches');
        Schema::dropIfExists('departments');
        Schema::dropIfExists('warehouses');
        Schema::dropIfExists('companies');

        Schema::enableForeignKeyConstraints();
    }
};
