<?php

namespace Database\Seeders\V1;

use App\Models\V1\Registration;
use Illuminate\Database\Seeder;

class RegistrationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Registration::factory(10000)->create();
    }
}
