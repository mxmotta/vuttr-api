<?php

namespace Database\Seeders;

use App\Models\ToolTag;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        \App\Models\Tool::factory(50)
            ->hasTags(5)
            ->create();
    }
}
