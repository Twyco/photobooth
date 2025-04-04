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
        app(AccountSeeder::class)->run();
        app(AlbumSeeder::class)->run();
        app(PhotoboothSeeder::class)->run();
    }
}
