<?php

namespace Database\Seeders;

use App\Models\ItemInformation;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ItemInformationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ItemInformation::factory()->count(1000)->create();
    }
}
