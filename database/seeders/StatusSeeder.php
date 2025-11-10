<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            ['name' => 'Новая', 'color' => '#2563EB'],
            ['name' => 'В обработке', 'color' => '#F59E0B'],
            ['name' => 'Одобрена', 'color' => '#16A34A'],
            ['name' => 'Отклонена', 'color' => '#DC2626'],
            ['name' => 'На паузе', 'color' => '#7C3AED'],
            ['name' => 'Завершена', 'color' => '#0F172A'],
        ];

        foreach ($items as $item) {
            Status::query()->create($item);
        }
    }
}
