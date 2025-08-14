<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Administrator',
            'username' => 'admin',
            'email' => 'admin@kepegawaian.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'is_active' => true,
        ]);

        // Create Regular User
        User::create([
            'name' => 'User Demo',
            'username' => 'user',
            'email' => 'user@kepegawaian.com',
            'password' => Hash::make('user123'),
            'role' => 'user',
            'is_active' => true,
            'employee_type' => 'PNS',
            'position' => 'Staff',
            'nip' => '198501012010011001',
        ]);



        // Create additional sample employees
        User::create([
            'name' => 'Budi Santoso',
            'username' => 'budi',
            'email' => 'budi@kepegawaian.com',
            'password' => Hash::make('budi123'),
            'role' => 'user',
            'is_active' => true,
            'employee_type' => 'PPPK',
            'position' => 'Analis',
            'nip' => '199001012020021001',
        ]);

        User::create([
            'name' => 'Siti Rahayu',
            'username' => 'siti',
            'email' => 'siti@kepegawaian.com',
            'password' => Hash::make('siti123'),
            'role' => 'user',
            'is_active' => false,
            'employee_type' => 'PNS',
            'position' => 'Sekretaris',
            'nip' => '198803152010012001',
        ]);

        User::create([
            'name' => 'Ahmad Wijaya',
            'username' => 'ahmad',
            'email' => 'ahmad@kepegawaian.com',
            'password' => Hash::make('ahmad123'),
            'role' => 'user',
            'is_active' => true,
            'employee_type' => 'NON ASN',
            'position' => 'Tenaga Harian',
        ]);
    }
}
