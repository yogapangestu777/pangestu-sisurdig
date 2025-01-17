<?php

namespace Database\Seeders;

use App\Models\Biography;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = User::create([
            'username' => 'yoga',
            'email' => 'yoga@developer.com',
            'password' => Hash::make(env('DEFAULT_PASSWORD_USER')),
        ]);

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
