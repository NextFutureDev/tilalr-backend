<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TestUsersSeeder extends Seeder
{
    public function run(): void
    {
        // Get role IDs
        $executiveRole = Role::where('name', 'executive_manager')->first();
        $consultantRole = Role::where('name', 'consultant')->first();
        $superAdminRole = Role::where('name', 'super_admin')->first();

        // Executive Manager user
        $exec = User::updateOrCreate(
            ['email' => 'executive@tilalr.com'],
            [
                'name' => 'Executive Manager',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );
        if ($executiveRole) {
            $exec->roles()->sync([$executiveRole->id]);
        }

        // Consultant user
        $consultant = User::updateOrCreate(
            ['email' => 'consultant@tilalr.com'],
            [
                'name' => 'Consultant',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );
        if ($consultantRole) {
            $consultant->roles()->sync([$consultantRole->id]);
        }

        // Super Admin user - has access to EVERYTHING
        $superAdmin = User::updateOrCreate(
            ['email' => 'superadmin@tilalr.com'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'is_admin' => true,
            ]
        );
        if ($superAdminRole) {
            $superAdmin->roles()->sync([$superAdminRole->id]);
        }

        echo "✅ Test users created!\n";
    }
}
