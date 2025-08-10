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
            // Personal Information
            $table->string('nip')->nullable()->after('is_active');
            $table->string('nik')->nullable()->after('nip');
            $table->enum('gender', ['L', 'P'])->nullable()->after('nik');
            $table->string('place_of_birth')->nullable()->after('gender');
            $table->date('date_of_birth')->nullable()->after('place_of_birth');
            $table->string('religion')->nullable()->after('date_of_birth');
            $table->enum('marital_status', ['Belum Menikah', 'Menikah', 'Cerai Hidup', 'Cerai Mati'])->nullable()->after('religion');
            $table->text('address')->nullable()->after('marital_status');
            $table->string('phone')->nullable()->after('address');
            
            // Employment Information
            $table->string('employee_id')->nullable()->after('phone');
            $table->enum('employee_type', ['PNS', 'PPPK', 'NON ASN'])->nullable()->after('employee_id');
            $table->string('position')->nullable()->after('employee_type');
            $table->string('rank')->nullable()->after('position');
            $table->string('grade')->nullable()->after('rank');
            $table->string('work_unit')->nullable()->after('grade');
            $table->date('start_date')->nullable()->after('work_unit');
            $table->date('appointment_date')->nullable()->after('start_date');
            
            // Education Information
            $table->unsignedBigInteger('education_id')->nullable()->after('appointment_date');
            $table->string('education_major')->nullable()->after('education_id');
            $table->year('graduation_year')->nullable()->after('education_major');
            
            // Documents and Files
            $table->string('photo')->nullable()->after('graduation_year');
            $table->string('sk_file')->nullable()->after('photo');
            $table->json('documents')->nullable()->after('sk_file');
            
            // Status and Metadata
            $table->enum('employment_status', ['Aktif', 'Cuti', 'Pensiun', 'Berhenti'])->default('Aktif')->after('documents');
            $table->text('notes')->nullable()->after('employment_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            //
        });
    }
};
