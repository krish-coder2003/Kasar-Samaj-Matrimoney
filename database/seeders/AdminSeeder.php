<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = User::updateOrCreate(
            ['email' => 'admin@example.com'],
            [
                'name' => 'Main Admin',
                'role' => 'admin',
                'is_premium' => true,
                'password' => \Illuminate\Support\Facades\Hash::make('admin123')
            ]
        );

        \App\Models\Profile::updateOrCreate(
            ['user_id' => $admin->id],
            [
                'phone_number' => '1234567890',
                'gender' => 'Male',
                'dob' => '1990-01-01'
            ]
        );
    }
}
