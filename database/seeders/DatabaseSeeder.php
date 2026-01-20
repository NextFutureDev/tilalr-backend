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
            ContactInfoSeeder::class,
            TrainingSeeder::class,
            AdminSeeder::class,
            // RBAC system - roles and permissions
            \Database\Seeders\RolePermissionSeeder::class,
            \Database\Seeders\CreateCustomPaymentOfferPermissionsSeeder::class,
            \Database\Seeders\TestUsersSeeder::class,
            // Seed offers and international demo data
            \Database\Seeders\OfferSeeder::class,
            \Database\Seeders\InternationalDataSeeder::class,
            \Database\Seeders\WinterEventsSeeder::class,
            // Island destinations
            \Database\Seeders\IslandDestinationSeeder::class,
            \Database\Seeders\IslandDestinationsLocalSeeder::class,
        ]);
    }
}
