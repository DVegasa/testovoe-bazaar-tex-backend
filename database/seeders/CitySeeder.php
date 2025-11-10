<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = fake();

        for ($i = 0; $i < 100; $i++) {
            City::query()->create([
                'name' => $faker->unique()->city(),
            ]);
        }

        $faker->unique(true);
    }
}
