<?php

namespace Database\Seeders;

use App\Models\CoreCategory;
use Illuminate\Database\Seeder;

class CoreCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        CoreCategory::factory()->count(10)->create();
    }
}
