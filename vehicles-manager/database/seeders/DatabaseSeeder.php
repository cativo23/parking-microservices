<?php

namespace Database\Seeders;

use Database\Seeders\V1\VehicleSeeder;
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
        $this->call(
            [
                VehicleSeeder::class
            ]
        );
    }
}
