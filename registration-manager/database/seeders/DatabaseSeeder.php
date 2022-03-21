<?php

namespace Database\Seeders;

use Database\Seeders\V1\RegistrationSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
                RegistrationSeeder::class
            ]
        );
    }
}
