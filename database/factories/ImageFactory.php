<?php

namespace Database\Factories;

use App\Models\Gallery;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'gallery_id' => Gallery::inRandomOrder()->first()->id,
            'url' => $this->faker->imageUrl(800, 600)
        ];
    }
}