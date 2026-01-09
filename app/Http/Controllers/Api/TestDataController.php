<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class TestDataController extends Controller
{
    /**
     * Create test users for RBAC testing
     */
    public function createTestUsers()
    {
        try {
            $testUsers = [
                [
                    'name' => 'Executive Manager',
                    'email' => 'executive@example.com',
                    'password' => 'password123',
                    'role_name' => 'executive_manager'
                ],
                [
                    'name' => 'Consultant',
                    'email' => 'consultant@example.com',
                    'password' => 'password123',
                    'role_name' => 'consultant'
                ],
                [
                    'name' => 'Administration',
                    'email' => 'admin@example.com',
                    'password' => 'password123',
                    'role_name' => 'administration'
                ],
            ];

            $created = [];

            foreach ($testUsers as $testUser) {
                // Find role
                $role = Role::where('name', $testUser['role_name'])->first();
                
                if (!$role) {
                    throw new \Exception("Role '{$testUser['role_name']}' not found");
                }

                // Create or update user
                $user = User::updateOrCreate(
                    ['email' => $testUser['email']],
                    [
                        'name' => $testUser['name'],
                        'password' => Hash::make($testUser['password']),
                        'is_admin' => false,
                    ]
                );

                // Sync role
                $user->roles()->sync([$role->id]);

                $created[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $testUser['role_name'],
                    'password' => $testUser['password'],
                ];
            }

            return response()->json([
                'message' => 'Test users created successfully',
                'users' => $created,
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
            ], 400);
        }
    }
}
