<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        //add factory for Property
         //\App\Models\Property::factory(10)->create();
        //add factory for Apartment
        //\App\Models\Apartment::factory(10)->create();
        //add factory for ApartmentType
        // \App\Models\ApartmentType::factory(3)->create();
        //add factory for Room
       //  \App\Models\Room::factory(10)->create();
         //add beds factory
       // \App\Models\Bed::factory(10)->create();

        // $this->call(RoleSeeder::class);
        // $this->call(AdminUserSeeder::class);
        // $this->call(PermissionSeeder::class);
 
        // $this->call(CountrySeeder::class);
        // $this->call(CitySeeder::class);
        // $this->call(GeoobjectSeeder::class);

       // $this->call(FacilityCategorySeeder::class);
        $this->call(FacilitySeeder::class);
    }
}
