<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Rank;

class RankSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $ranks = [
            // Golongan I
            ['code' => 'JM', 'name' => 'Juru Muda', 'grade_code' => 'I/a'],
            ['code' => 'JMT', 'name' => 'Juru Muda Tingkat I', 'grade_code' => 'I/b'],
            ['code' => 'JR', 'name' => 'Juru', 'grade_code' => 'I/c'],
            ['code' => 'JRT', 'name' => 'Juru Tingkat I', 'grade_code' => 'I/d'],
            
            // Golongan II
            ['code' => 'PM', 'name' => 'Pengatur Muda', 'grade_code' => 'II/a'],
            ['code' => 'PMT', 'name' => 'Pengatur Muda Tingkat I', 'grade_code' => 'II/b'],
            ['code' => 'PG', 'name' => 'Pengatur', 'grade_code' => 'II/c'],
            ['code' => 'PGT', 'name' => 'Pengatur Tingkat I', 'grade_code' => 'II/d'],
            
            // Golongan III
            ['code' => 'PNM', 'name' => 'Penata Muda', 'grade_code' => 'III/a'],
            ['code' => 'PNMT', 'name' => 'Penata Muda Tingkat I', 'grade_code' => 'III/b'],
            ['code' => 'PN', 'name' => 'Penata', 'grade_code' => 'III/c'],
            ['code' => 'PNT', 'name' => 'Penata Tingkat I', 'grade_code' => 'III/d'],
            
            // Golongan IV
            ['code' => 'PB', 'name' => 'Pembina', 'grade_code' => 'IV/a'],
            ['code' => 'PBT', 'name' => 'Pembina Tingkat I', 'grade_code' => 'IV/b'],
            ['code' => 'PUM', 'name' => 'Pembina Utama Muda', 'grade_code' => 'IV/c'],
            ['code' => 'PUMD', 'name' => 'Pembina Utama Madya', 'grade_code' => 'IV/d'],
            ['code' => 'PU', 'name' => 'Pembina Utama', 'grade_code' => 'IV/e'],
        ];

        foreach ($ranks as $rank) {
            Rank::create([
                'code' => $rank['code'],
                'name' => $rank['name'],
                'grade_code' => $rank['grade_code'],
                'description' => 'Pangkat ' . $rank['name'],
                'is_active' => true
            ]);
        }
    }
}
