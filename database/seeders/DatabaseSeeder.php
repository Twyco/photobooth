<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

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
