<?php

namespace Database\Seeders;

use App\Models\Application;
use App\Models\City;
use App\Models\Status;
use App\Models\User;
use Illuminate\Database\Seeder;

class ApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cities = City::query()->pluck('id');
        $statuses = Status::query()->pluck('id');
        $users = User::query()->pluck('id');

        if ($cities->isEmpty() || $statuses->isEmpty() || $users->isEmpty()) {
            return;
        }

        $faker = fake();

        for ($i = 0; $i < 50; $i++) {
            Application::query()->create([
                'name' => $faker->unique()->sentence(3),
                'description' => $faker->paragraph(),
                'status_id' => $statuses->random(),
                'city_id' => $cities->random(),
                'created_by' => $users->random(),
            ]);
        }

        $faker->unique(true);
    }
}
