<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        User::updateOrCreate(
            ['email' => 'admin@college.local'],
            [
                'name' => 'Admin',
                'major' => 'Administration',
                'student_no' => 'ADMIN-001',
                'phone' => '776785244',

                'role' => 'admin',
                'status' => 'approved',
                'approved_at' => now(),
                'email_verified_at' => now(),

                'password' => Hash::make('Admin@12345'),
            ]
        );
    }
}
