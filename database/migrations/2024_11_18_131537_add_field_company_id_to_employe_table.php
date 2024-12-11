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
        Schema::table('employe', function (Blueprint $table) {
            $table->unsignedBigInteger('company_id')->after('id');
            $table->unsignedBigInteger('branch_id')->after('department_id');

            $table->foreign('branch_id')->references('id')->on('branch');
            $table->foreign('company_id')->references('id')->on('company');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employe', function (Blueprint $table) {
            $table->dropColumn('company_id', 'branch_id');
            $table->dropForeign(['company_id', 'branch_id']);
        });
    }
};
