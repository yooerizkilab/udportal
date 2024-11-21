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
        Schema::table('tools', function (Blueprint $table) {
            $table->unsignedBigInteger('owner_id')->nullable()->after('id');
            $table->string('origin')->after('year')->nullable();
            $table->foreign('owner_id')->references('id')->on('tools_ownership');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tools', function (Blueprint $table) {
            $table->dropForeign(['owner_id']);
            $table->dropColumn(['owner_id', 'origin']);
        });
    }
};
