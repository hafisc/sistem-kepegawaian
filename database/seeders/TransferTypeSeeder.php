<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TransferType;

class TransferTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $transferTypes = [
            ['name' => 'Promosi Jabatan', 'code' => 'PROM', 'description' => 'Perpindahan karena kenaikan jabatan', 'is_active' => true],
            ['name' => 'Mutasi Rutin', 'code' => 'RUTIN', 'description' => 'Perpindahan rutin antar desa', 'is_active' => true],
            ['name' => 'Permintaan Sendiri', 'code' => 'REQUEST', 'description' => 'Perpindahan atas permintaan pegawai', 'is_active' => true],
            ['name' => 'Reorganisasi', 'code' => 'REORG', 'description' => 'Perpindahan karena reorganisasi struktur', 'is_active' => true],
            ['name' => 'Pensiun', 'code' => 'PENSION', 'description' => 'Perpindahan karena pensiun', 'is_active' => true],
            ['name' => 'Disiplin', 'code' => 'DISC', 'description' => 'Perpindahan karena tindakan disiplin', 'is_active' => true],
            ['name' => 'Kesehatan', 'code' => 'HEALTH', 'description' => 'Perpindahan karena alasan kesehatan', 'is_active' => true],
            ['name' => 'Keluarga', 'code' => 'FAMILY', 'description' => 'Perpindahan karena alasan keluarga', 'is_active' => true],
        ];

        foreach ($transferTypes as $transferType) {
            TransferType::create($transferType);
        }
    }
}
