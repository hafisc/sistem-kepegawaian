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
        Schema::table('users', function (Blueprint $table) {
            // Add missing file fields
            $table->string('scan_ktp')->nullable()->after('sk_file');
            $table->string('scan_kk')->nullable()->after('scan_ktp');
            $table->string('scan_sk')->nullable()->after('scan_kk');
            $table->string('tanda_tangan_sk')->nullable()->after('scan_sk');
            $table->unsignedBigInteger('village_id')->nullable()->after('tanda_tangan_sk');
            
            // Add foreign key constraint for village_id
            $table->foreign('village_id')->references('id')->on('villages')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['village_id']);
            $table->dropColumn(['scan_ktp', 'scan_kk', 'scan_sk', 'tanda_tangan_sk', 'village_id']);
        });
    }
};
