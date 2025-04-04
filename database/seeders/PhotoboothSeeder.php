<?php

namespace Database\Seeders;

use App\Models\Photobooth;
use Illuminate\Database\Seeder;

class PhotoboothSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //Seed default Photobooth
        Photobooth::create([
           'name' => 'Default Photobooth',
            'album_id' => 1,
        ]);
    }
}
