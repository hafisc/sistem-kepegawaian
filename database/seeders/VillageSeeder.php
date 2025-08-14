<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Village;

class VillageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $villages = [
            [
                'name' => 'Desa Sukamaju',
                'code' => 'DSA001',
                'district' => 'Kecamatan Sukamaju',
                'regency' => 'Kabupaten Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16710',
                'description' => 'Desa Sukamaju Kecamatan Sukamaju',
                'is_active' => true
            ],
            [
                'name' => 'Desa Makmur',
                'code' => 'DSA002',
                'district' => 'Kecamatan Sukamaju',
                'regency' => 'Kabupaten Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16711',
                'description' => 'Desa Makmur Kecamatan Sukamaju',
                'is_active' => true
            ],
            [
                'name' => 'Desa Sejahtera',
                'code' => 'DSA003',
                'district' => 'Kecamatan Sejahtera',
                'regency' => 'Kabupaten Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16712',
                'description' => 'Desa Sejahtera Kecamatan Sejahtera',
                'is_active' => true
            ],
            [
                'name' => 'Desa Merdeka',
                'code' => 'DSA004',
                'district' => 'Kecamatan Sejahtera',
                'regency' => 'Kabupaten Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16713',
                'description' => 'Desa Merdeka Kecamatan Sejahtera',
                'is_active' => true
            ],
            [
                'name' => 'Desa Pancasila',
                'code' => 'DSA005',
                'district' => 'Kecamatan Pancasila',
                'regency' => 'Kabupaten Bogor',
                'province' => 'Jawa Barat',
                'postal_code' => '16714',
                'description' => 'Desa Pancasila Kecamatan Pancasila',
                'is_active' => true
            ],
        ];

        foreach ($villages as $village) {
            Village::create($village);
        }
    }
}
