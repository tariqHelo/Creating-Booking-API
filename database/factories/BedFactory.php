<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bed>
 */
class BedFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            
            'room_id' => rand(1, 10),
            'bed_type_id' => rand(1, 4),
            'name' => $this->faker->word,

        ];
    }
}
