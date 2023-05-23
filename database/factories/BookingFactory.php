<?php

namespace Database\Factories;

use App;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Booking>
 */
class BookingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'start_date' => now()->addDay()->toDateString(),
            'end_date' => now()->addDays(2)->toDateString(),
            'guests_adults' => 2,
            'guests_children' => 0,
             //random number between 100 and 1000
            'total_price' => rand(100, 1000),
            'user_id' => App\Models\User::inRandomOrder()->first()->id,
            //get a random apartment id form Apartment table
            'apartment_id' => \App\Models\Apartment::inRandomOrder()->first()->id,
        ];
    }
}
