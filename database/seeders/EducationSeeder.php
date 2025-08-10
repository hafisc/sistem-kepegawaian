<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Education;

class EducationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $educations = [
            ['name' => 'Sekolah Dasar', 'level' => 'SD', 'description' => 'Pendidikan dasar 6 tahun', 'is_active' => true],
            ['name' => 'Sekolah Menengah Pertama', 'level' => 'SMP', 'description' => 'Pendidikan menengah pertama 3 tahun', 'is_active' => true],
            ['name' => 'Sekolah Menengah Atas', 'level' => 'SMA', 'description' => 'Pendidikan menengah atas 3 tahun', 'is_active' => true],
            ['name' => 'Sekolah Menengah Kejuruan', 'level' => 'SMK', 'description' => 'Pendidikan menengah kejuruan 3 tahun', 'is_active' => true],
            ['name' => 'Diploma 1', 'level' => 'D1', 'description' => 'Pendidikan diploma 1 tahun', 'is_active' => true],
            ['name' => 'Diploma 2', 'level' => 'D2', 'description' => 'Pendidikan diploma 2 tahun', 'is_active' => true],
            ['name' => 'Diploma 3', 'level' => 'D3', 'description' => 'Pendidikan diploma 3 tahun', 'is_active' => true],
            ['name' => 'Diploma 4', 'level' => 'D4', 'description' => 'Pendidikan diploma 4 tahun', 'is_active' => true],
            ['name' => 'Sarjana', 'level' => 'S1', 'description' => 'Pendidikan sarjana strata 1', 'is_active' => true],
            ['name' => 'Magister', 'level' => 'S2', 'description' => 'Pendidikan magister strata 2', 'is_active' => true],
            ['name' => 'Doktor', 'level' => 'S3', 'description' => 'Pendidikan doktor strata 3', 'is_active' => true],
        ];

        foreach ($educations as $education) {
            Education::create($education);
        }
    }
}
