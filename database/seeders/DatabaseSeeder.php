<?php

namespace Database\Seeders;

use App\Models\Album;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
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

        Storage::disk('public')->deleteDirectory('albums');
        Storage::disk('public')->deleteDirectory('qrCodes');
        $this->command->info('Generating images...');
        Album::factory(5)->create();
    }
}
