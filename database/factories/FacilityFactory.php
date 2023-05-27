<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\Facility;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Facility>
 */
class FacilityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            //
        ];
    }


    public function run(){
        //add fake date for facility_property table

        //add fake date for facility table
        $facility = Facility::create([
            'category_id' => rand(1, 10),
            'name' => 'TV'
        ]);
        //add Bid fac

        //add fake date for facility_property table
      //  $facility->properties()->attach(rand(1, 10));
        //add fake date for facility_category table
       // $facility->facilityCategory()->attach(['name' => $this->faker->randomElement(['TV', 'Internet', 'Parking', 'Kitchen'])

    }
}
