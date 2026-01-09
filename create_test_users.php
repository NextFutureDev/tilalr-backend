<?php
require 'vendor/autoload.php';
$app = require 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;

echo "=== CREATING TEST USERS ===\n\n";

// Create Executive Manager user
$execUser = User::updateOrCreate(
    ['email' => 'executive@example.com'],
    [
        'name' => 'Executive Manager',
        'email' => 'executive@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => false,
    ]
);

// Assign executive_manager role
$execUser->roles()->sync([1]); // executive_manager is ID 1

echo "✅ EXECUTIVE MANAGER\n";
echo "   Email: executive@example.com\n";
echo "   Password: password123\n";
echo "   Can Access:\n";
echo "     • International Destinations (view, create, edit, delete)\n";
echo "     • International Flights (view, create, edit, delete)\n";
echo "     • International Hotels (view, create, edit, delete)\n";
echo "     • International Packages (view, create, edit, delete)\n";
echo "     • Island Destinations (view, create, edit, delete)\n";
echo "     • Contacts (view, manage)\n";
echo "     • Reservations (view, manage)\n";
echo "     • Bookings (view, manage)\n";
echo "   Total Permissions: 26\n\n";

// Create Consultant user
$consultUser = User::updateOrCreate(
    ['email' => 'consultant@example.com'],
    [
        'name' => 'Consultant',
        'email' => 'consultant@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => false,
    ]
);

// Assign consultant role
$consultUser->roles()->sync([2]); // consultant is ID 2

echo "✅ CONSULTANT\n";
echo "   Email: consultant@example.com\n";
echo "   Password: password123\n";
echo "   Can Access:\n";
echo "     • Island Destinations (view, create, edit, delete)\n";
echo "     • Offers (view, create, edit, delete)\n";
echo "     • Services (view, create, edit, delete)\n";
echo "     • Trips (view, create, edit, delete)\n";
echo "     • Contacts (view, manage)\n";
echo "     • Reservations (view, manage)\n";
echo "     • Bookings (view, manage)\n";
echo "   Total Permissions: 22\n\n";

// Create Administration user
$adminUser = User::updateOrCreate(
    ['email' => 'admin@example.com'],
    [
        'name' => 'Administration',
        'email' => 'admin@example.com',
        'password' => Hash::make('password123'),
        'is_admin' => false,
    ]
);

// Assign administration role
$adminUser->roles()->sync([3]); // administration is ID 3

echo "✅ ADMINISTRATION\n";
echo "   Email: admin@example.com\n";
echo "   Password: password123\n";
echo "   Can Access:\n";
echo "     • Contacts (view, manage)\n";
echo "   Total Permissions: 2\n\n";

echo "=== LOGIN ENDPOINT RESPONSE ===\n\n";
echo "POST /api/login\n";
echo "{\n";
echo "  \"email\": \"executive@example.com\",\n";
echo "  \"password\": \"password123\"\n";
echo "}\n\n";
echo "Response will include:\n";
echo "{\n";
echo "  \"user\": {...user data...},\n";
echo "  \"roles\": [\"executive_manager\"],\n";
echo "  \"permissions\": [\n";
echo "    \"view_international_destinations\",\n";
echo "    \"create_international_destinations\",\n";
echo "    \"edit_international_destinations\",\n";
echo "    \"delete_international_destinations\",\n";
echo "    ...26 total permissions...\n";
echo "  ],\n";
echo "  \"token\": \"YOUR_BEARER_TOKEN\"\n";
echo "}\n\n";

echo "✅ Test users created successfully!\n";
