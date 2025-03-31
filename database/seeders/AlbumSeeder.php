<?php

namespace Database\Seeders;

use App\Models\Album;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class AlbumSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Storage::disk('public')->deleteDirectory('album');
        Storage::disk('public')->deleteDirectory('qrCodes');
        Storage::disk('public')->deleteDirectory('cover');
        Album::factory(5)->create();
    }
}
