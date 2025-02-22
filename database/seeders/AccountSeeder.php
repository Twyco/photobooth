<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('test'),
        ]);

        User::factory()->create([
            'name' => 'Test Admin',
            'email' => 'admin@example.com',
            'password' => bcrypt('test'),
            'is_admin' => true,
        ]);
    }
}
