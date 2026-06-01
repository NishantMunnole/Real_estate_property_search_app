<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \App\Models\User::updateOrCreate(
            ['email' => 'munnolenishant@gmail.com'], // unique identifier
            [
                'name' => 'Admin User',
                'password' => \Illuminate\Support\Facades\Hash::make('Admin@123'), // change to secure password
                'is_admin' => true, // if you have an is_admin column
            ]
        );
    }
}
