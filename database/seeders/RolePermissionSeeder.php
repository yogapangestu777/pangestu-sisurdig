<?php

namespace Database\Seeders;

use App\Models\Biography;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role
        $adminRole = Role::create(['name' => 'Admin']);
        $permissions = [];

        // Overview Permissions
        $permissions[] = Permission::create(['name' => 'overview.read']);

        // Category Permissions
        $permissions[] = Permission::create(['name' => 'categories.read']);
        $permissions[] = Permission::create(['name' => 'categories.store']);
        $permissions[] = Permission::create(['name' => 'categories.update']);
        $permissions[] = Permission::create(['name' => 'categories.delete']);

        // Party Permissions
        $permissions[] = Permission::create(['name' => 'parties.read']);
        $permissions[] = Permission::create(['name' => 'parties.store']);
        $permissions[] = Permission::create(['name' => 'parties.update']);
        $permissions[] = Permission::create(['name' => 'parties.delete']);

        // User Permissions
        $permissions[] = Permission::create(['name' => 'users.read']);
        $permissions[] = Permission::create(['name' => 'users.create']);
        $permissions[] = Permission::create(['name' => 'users.update']);
        $permissions[] = Permission::create(['name' => 'users.delete']);
        $permissions[] = Permission::create(['name' => 'users.toggelStatus']);
        $permissions[] = Permission::create(['name' => 'users.resetPassword']);

        // Incoming Letter Permissions
        $permissions[] = Permission::create(['name' => 'incoming_letters.read']);
        $permissions[] = Permission::create(['name' => 'incoming_letters.create']);
        $permissions[] = Permission::create(['name' => 'incoming_letters.update']);
        $permissions[] = Permission::create(['name' => 'incoming_letters.delete']);
        $permissions[] = Permission::create(['name' => 'incoming_letters.show']);
        $permissions[] = Permission::create(['name' => 'incoming_letters.download']);

        // Outgoing Letter Permissions
        $permissions[] = Permission::create(['name' => 'outgoing_letters.read']);
        $permissions[] = Permission::create(['name' => 'outgoing_letters.create']);
        $permissions[] = Permission::create(['name' => 'outgoing_letters.update']);
        $permissions[] = Permission::create(['name' => 'outgoing_letters.delete']);
        $permissions[] = Permission::create(['name' => 'outgoing_letters.show']);
        $permissions[] = Permission::create(['name' => 'outgoing_letters.download']);

        // Account Permissions
        $permissions[] = Permission::create(['name' => 'account.read']);
        $permissions[] = Permission::create(['name' => 'account.update']);

        // Biography Permissions
        $permissions[] = Permission::create(['name' => 'biography.read']);
        $permissions[] = Permission::create(['name' => 'biography.update']);

        // Password Permissions
        $permissions[] = Permission::create(['name' => 'password.read']);
        $permissions[] = Permission::create(['name' => 'password.update']);

        // Assign all permissions to Admin role
        $adminRole->givePermissionTo($permissions);

        // Create Default Admin User
        $user = User::create([
            'username' => 'yoga',
            'email' => 'yoga@developer.com',
            'password' => Hash::make(env('DEFAULT_PASSWORD_USER')),
        ]);

        $user->assignRole($adminRole);

        Biography::create([
            'user_id' => $user->id,
            'full_name' => 'Yoga Pangestu',
            'phone_number' => '082121495806',
            'pob' => 'Subang',
            'dob' => '2005-03-13',
            'gender' => '1',
        ]);
    }
}
