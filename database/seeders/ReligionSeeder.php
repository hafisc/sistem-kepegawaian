<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Religion;

class ReligionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $religions = [
            ['name' => 'Islam', 'description' => 'Agama Islam'],
            ['name' => 'Kristen', 'description' => 'Agama Kristen'],
            ['name' => 'Katolik', 'description' => 'Agama Katolik'],
            ['name' => 'Hindu', 'description' => 'Agama Hindu'],
            ['name' => 'Buddha', 'description' => 'Agama Buddha'],
            ['name' => 'Konghucu', 'description' => 'Agama Konghucu'],
        ];

        foreach ($religions as $religion) {
            Religion::create([
                'name' => $religion['name'],
                'description' => $religion['description'],
                'is_active' => true
            ]);
        }
    }
}
