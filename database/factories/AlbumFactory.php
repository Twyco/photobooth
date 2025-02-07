<?php

namespace Database\Factories;

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
        $imageUrl = 'https://picsum.photos/3088/2056';

        $slug = $this->faker->slug(2);
        Storage::disk('public')->makeDirectory('albums/' . $slug);

        \Illuminate\Log\log('test');
        for ($i = 0; $i < 16; $i++) {
            $response = Http::get($imageUrl);
            if ($response->successful()) {
                Storage::disk('public')->put('albums/' . $slug . '/' . $this->faker->slug(4) . '.jpg', $response->body());
            }
        }
        return [
            'title' => $this->faker->words(3, true),
            'slug' => $slug,
            'description' => $this->faker->boolean() ? $this->faker->paragraph() : null,
            'event_date' => $this->faker->date(),
        ];
    }
}
