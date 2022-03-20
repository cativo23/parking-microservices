<?php

namespace Database\Factories\V1;

use App\Enums\VehicleTypeEnum;
use App\Models\V1\Vehicle;
use Faker\Provider\Fakecar;
use Illuminate\Database\Eloquent\Factories\Factory;
use Spatie\Enum\Laravel\Faker\FakerEnumProvider;

/**
 * @extends Factory<Vehicle>
 */
class VehicleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $this->faker->addProvider(new FakerEnumProvider($this->faker));
        return [
            'license_plate' => $this->faker->unique()->bothify('#######'),
            'type' => $this->faker->randomEnum(VehicleTypeEnum::class),
        ];
    }
}
