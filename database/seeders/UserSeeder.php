<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Spatie\Permission\Models\Role;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ensure roles exist
        $superAdminRole = Role::firstOrCreate([
            'id' => 1, // Explicitly set the role ID to 1 for super_admin
            'name' => 'super_admin',
            'guard_name' => 'web',
        ]);

        $adminRole = Role::firstOrCreate([
            'id' => 2, // Explicitly set the role ID to 2 for admin
            'name' => 'admin',
            'guard_name' => 'web',
        ]);

        // Create SuperAdmin user
        $superAdmin = User::create([
            'name' => 'SuperAdmin',
            'email' => 'superadmin@gmail.com',
            'password' => bcrypt('ccis capstone members'), // Hash the password securely
            'role_id' => 1, // Set the role_id explicitly
        ]);

        $superAdmin->assignRole($superAdminRole->name);

        // Create Admin user
        $admin = User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => bcrypt('adminpassword'), // Replace with a secure password
            'role_id' => 2, // Set the role_id explicitly
        ]);

        $admin->assignRole($adminRole->name);
    }
}