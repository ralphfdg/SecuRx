<?php

namespace Database\Seeders;

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
        // This tells Laravel to run these specific files in this exact order
        $this->call([
            MassiveEntitySeeder::class,
            MassiveUserSeeder::class,
            MassiveWorkflowSeeder::class,
        ]);
    }
}