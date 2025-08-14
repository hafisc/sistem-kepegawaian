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
        Schema::table('transfers', function (Blueprint $table) {
            // Make village foreign keys nullable to allow entries without specifying village
            $table->unsignedBigInteger('from_village_id')->nullable()->change();
            $table->unsignedBigInteger('to_village_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->unsignedBigInteger('from_village_id')->nullable(false)->change();
            $table->unsignedBigInteger('to_village_id')->nullable(false)->change();
        });
    }
};
