<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Room>
 */
class RoomFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
            //add random apartment_id from 1 to 10
            'apartment_id' => rand(1, 10),
            //add random room_type_id from 1 to 3
            'room_type_id' => rand(1, 2),
            

        ];
    }
}
