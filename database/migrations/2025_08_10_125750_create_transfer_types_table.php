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
        Schema::create('transfer_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama jenis mutasi
            $table->string('code')->unique(); // Kode jenis mutasi
            $table->text('description')->nullable();
            $table->boolean('requires_approval')->default(true); // Perlu persetujuan
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['is_active', 'requires_approval']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_types');
    }
};
