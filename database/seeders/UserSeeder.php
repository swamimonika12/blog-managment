<?php

namespace Database\Seeders;

use App\Models\User;
use Database\Factories\UserFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       User::create([
            'name' => 'admin',
            'email' => 'admin@gmmail.com',
            'password' => bcrypt('password'),
       ]);
       $users = User::factory(10)->create();
    }
}
