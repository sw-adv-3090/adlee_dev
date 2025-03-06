<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = [
            [
                'role_id' => UserRole::Admin->value,
                'name' => 'Administrator',
                'email' => 'admin@adlee.io',
                'password' => Hash::make('admin@adlee.io'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => UserRole::Sponsor->value,
                'name' => 'Sponsor',
                'email' => 'sponsor@adlee.io',
                'password' => Hash::make('sponsor@adlee.io'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => UserRole::AdSpaceOwner->value,
                'name' => 'Ad Space Owner',
                'email' => 'pywubyxoz@mailinator.com',
                'password' => Hash::make('pywubyxoz@mailinator.com'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'role_id' => UserRole::Designer->value,
                'name' => 'Designer',
                'email' => 'designer@mailinator.com',
                'password' => Hash::make('designer@mailinator.com'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        User::insert($users);
    }
}
