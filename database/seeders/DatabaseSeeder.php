<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            VillageSeeder::class,
            UserSeeder::class,
            EducationSeeder::class,
            TransferTypeSeeder::class,
            GradeSeeder::class,
            RankSeeder::class,
            ReligionSeeder::class,
        ]);
    }
}
