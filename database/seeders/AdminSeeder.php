<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    
    public function run(): void
    {
        User::updateOrCreate(
            [
                "email" => "info@tilalr.com"
            ],
            [
                "name" => "Admin",
                "password" => bcrypt("password123"),
                "is_admin" => true,
            ]
        );
    }
}
