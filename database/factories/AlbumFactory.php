<?php

namespace Database\Factories;

use App\Models\Album;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Album>
 */
class AlbumFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->words(3, true),
            'description' => $this->faker->boolean() ? $this->faker->paragraph() : null,
            'event_date' => $this->faker->date(),
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Album $album) {
            $uuid = $album->uuid;

            $imageUrl = 'https://picsum.photos/3088/2056';

            Storage::disk('public')->makeDirectory('album/' . $uuid);
            for ($i = 0; $i < 16; $i++) {
                $response = Http::get($imageUrl);
                if ($response->successful()) {
                    Storage::disk('public')->put('album/' . $uuid . '/' . $this->faker->slug(4) . '.jpg', $response->body());
                }
            }
        });
    }
}
