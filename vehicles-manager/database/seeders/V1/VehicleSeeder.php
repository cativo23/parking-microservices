<?php

namespace Database\Seeders\V1;

use App\Models\V1\Vehicle;
use Illuminate\Database\Seeder;

class VehicleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Vehicle::factory(100)->create();
    }
}
