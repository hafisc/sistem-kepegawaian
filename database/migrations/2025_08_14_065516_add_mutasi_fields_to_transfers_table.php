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
            $table->string('from_unit')->nullable()->after('to_village_id');
            $table->string('to_unit')->nullable()->after('from_unit');
            $table->string('sk_number')->nullable()->after('effective_date');
            $table->date('sk_date')->nullable()->after('sk_number');
            $table->string('position_before')->nullable()->after('sk_date');
            $table->string('position_after')->nullable()->after('position_before');
            $table->string('transfer_type')->nullable()->after('status'); // masuk, riwayat, regular
            $table->string('sk_file')->nullable()->after('transfer_type');
            $table->string('supporting_docs')->nullable()->after('sk_file');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transfers', function (Blueprint $table) {
            $table->dropColumn([
                'from_unit',
                'to_unit', 
                'sk_number',
                'sk_date',
                'position_before',
                'position_after',
                'transfer_type',
                'sk_file',
                'supporting_docs'
            ]);
        });
    }
};
