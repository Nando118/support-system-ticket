<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::query()->create([
           "name" => "Super Admin",
           "email" => "super.admin@gmail.com",
           "password" => Hash::make("password"),
           "role" => "super_admin"
        ]);

        User::query()->create([
           "name" => "Fernando Verdy Sunata",
           "email" => "fernandoverdysunata18@gmail.com",
           "password" => Hash::make("password"),
           "role" => "super_admin"
        ]);

        User::query()->create([
           "name" => "Engineer",
           "email" => "engineer@gmail.com",
           "password" => Hash::make("password"),
           "role" => "engineer"
        ]);

        User::query()->create([
           "name" => "Engineer 2",
           "email" => "engineer2@gmail.com",
           "password" => Hash::make("password"),
           "role" => "engineer"
        ]);

        User::query()->create([
           "name" => "Engineer 3",
           "email" => "engineer3@gmail.com",
           "password" => Hash::make("password"),
           "role" => "engineer"
        ]);

        User::query()->create([
           "name" => "Regular User",
           "email" => "regular.user@gmail.com",
           "password" => Hash::make("password"),
           "role" => "regular_user"
        ]);

        User::query()->create([
           "name" => "Regular User 2",
           "email" => "regular.user2@gmail.com",
           "password" => Hash::make("password"),
           "role" => "regular_user"
        ]);

        User::query()->create([
           "name" => "Regular User 3",
           "email" => "regular.user3@gmail.com",
           "password" => Hash::make("password"),
           "role" => "regular_user"
        ]);
    }
}
