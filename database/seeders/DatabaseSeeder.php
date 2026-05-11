<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Admin User
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'admin',
            'is_premium' => true,
        ]);
        $admin->profile()->create([
            'gender' => 'Male',
            'dob' => '1990-01-01',
            'city' => 'Nanded',
            'occupation' => 'Admin',
            'phone_number' => '1234567890',
        ]);

        // 2. Krishna (Test User)
        $krish = User::create([
            'name' => 'KRISHNA EKNATHRAC SHRANGARE',
            'email' => 'krishnashrangare@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_premium' => true,
        ]);
        $krish->profile()->create([
            'gender' => 'Male',
            'dob' => '2003-05-15',
            'city' => 'Nanded',
            'occupation' => 'Software Developer',
            'phone_number' => '9876543210',
            'marital_status' => 'Never Married',
        ]);

        // 3. Shweta (Test User)
        $shweta = User::create([
            'name' => 'Shweta',
            'email' => 'sheweta@gmail.com',
            'password' => bcrypt('password'),
            'role' => 'user',
            'is_premium' => true,
        ]);
        $shweta->profile()->create([
            'gender' => 'Female',
            'dob' => '2000-10-20',
            'city' => 'Pune',
            'occupation' => 'Designer',
            'phone_number' => '1122334455',
            'marital_status' => 'Never Married',
        ]);
    }
}
