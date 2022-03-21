<?php

namespace Database\Seeders\V1;

use App\Models\V1\Payment;
use Illuminate\Database\Seeder;

class PaymentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Payment::factory(10000)->create();
    }
}
