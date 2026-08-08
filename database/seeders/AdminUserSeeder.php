<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Default admin seeder - only for local development
        // In production, create admin users through the admin panel
        if (app()->environment('local')) {
            \App\Models\User::updateOrCreate(
                ['email' => 'admin@htdc.edu.bd'],
                [
                    'name' => 'Admin',
                    'password' => bcrypt('Change-Me-123!'),
                    'role' => \App\Models\User::ROLE_ADMIN,
                ]
            );
        }
    }
}
