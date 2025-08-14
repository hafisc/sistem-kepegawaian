<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grade;

class GradeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = [
            ['code' => 'I/a', 'name' => 'Golongan I/a', 'description' => 'Juru Muda'],
            ['code' => 'I/b', 'name' => 'Golongan I/b', 'description' => 'Juru Muda Tingkat I'],
            ['code' => 'I/c', 'name' => 'Golongan I/c', 'description' => 'Juru'],
            ['code' => 'I/d', 'name' => 'Golongan I/d', 'description' => 'Juru Tingkat I'],
            ['code' => 'II/a', 'name' => 'Golongan II/a', 'description' => 'Pengatur Muda'],
            ['code' => 'II/b', 'name' => 'Golongan II/b', 'description' => 'Pengatur Muda Tingkat I'],
            ['code' => 'II/c', 'name' => 'Golongan II/c', 'description' => 'Pengatur'],
            ['code' => 'II/d', 'name' => 'Golongan II/d', 'description' => 'Pengatur Tingkat I'],
            ['code' => 'III/a', 'name' => 'Golongan III/a', 'description' => 'Penata Muda'],
            ['code' => 'III/b', 'name' => 'Golongan III/b', 'description' => 'Penata Muda Tingkat I'],
            ['code' => 'III/c', 'name' => 'Golongan III/c', 'description' => 'Penata'],
            ['code' => 'III/d', 'name' => 'Golongan III/d', 'description' => 'Penata Tingkat I'],
            ['code' => 'IV/a', 'name' => 'Golongan IV/a', 'description' => 'Pembina'],
            ['code' => 'IV/b', 'name' => 'Golongan IV/b', 'description' => 'Pembina Tingkat I'],
            ['code' => 'IV/c', 'name' => 'Golongan IV/c', 'description' => 'Pembina Utama Muda'],
            ['code' => 'IV/d', 'name' => 'Golongan IV/d', 'description' => 'Pembina Utama Madya'],
            ['code' => 'IV/e', 'name' => 'Golongan IV/e', 'description' => 'Pembina Utama'],
        ];

        foreach ($grades as $grade) {
            Grade::create([
                'code' => $grade['code'],
                'name' => $grade['name'],
                'description' => $grade['description'],
                'is_active' => true
            ]);
        }
    }
}
